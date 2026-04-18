<?php
class ProfileView extends Controller {
    private $profileViewModel;

    public function __construct() {

        require_once APPROOT . '/libraries/Auth.php';
         Auth::check();

        $this->profileViewModel = $this->model('M_ProfileView', new Database());
    }

    public function index() {
        switch($_SESSION['user_type']) {
            case 'seller':
                $this->sellerProfileView();
                break;
            case 'admin':
                $this->adminProfile();
                break;
            case 'officer':
                $this->officerProfileView();
                break;
            default:
                header('Location: ' . URLROOT . '/users/login');
                exit;
        }
    }

    public function sellerProfileView() {
         Auth::checkRole('seller');

        $seller_id = $_SESSION['user_id'];
        $sellerProfile = $this->profileViewModel->getSellerProfile($seller_id);

        $data = [
            'seller' => $sellerProfile,
            'user' => $_SESSION['old_input'] ?? (array)$sellerProfile,
            'errors' => $_SESSION['profile_errors'] ?? []
        ];

        unset($_SESSION['old_input'], $_SESSION['profile_errors']);

        if (!$sellerProfile) {
    header('Location: ' . URLROOT . '/users/login');
    exit;
}
        $this->view('profile/V_sellerprofile', $data);
    }

public function updateSeller()
{
    Auth::checkRole('seller');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . URLROOT . '/ProfileView/sellerProfileView/');
        exit;
    }

    $seller_id = $_SESSION['user_id'];
    $sellerProfile = $this->profileViewModel->getSellerProfile($seller_id);

    // default image
    $image_url = $sellerProfile->image_url ?? '';

//collect input
    $data = [
        'user' => [
            'seller_id' => $seller_id,
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'company_name' => trim($_POST['company_name'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'phone_no' => trim($_POST['phone_no'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
        ],
        'errors' => []
    ];


    if ($data['user']['first_name'] === '') {
        $data['errors']['fname'] = "First name is required.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $data['user']['first_name'])) {
        $data['errors']['fname'] = "Only letters allowed.";
    }

    if ($data['user']['last_name'] === '') {
        $data['errors']['lname'] = "Last name is required.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $data['user']['last_name'])) {
        $data['errors']['lname'] = "Only letters allowed.";
    }

    if ($data['user']['company_name'] === '') {
        $data['errors']['company_name'] = "Company name is required.";
    }

    if ($data['user']['address'] === '') {
        $data['errors']['address'] = "Address is required.";
    }

    if ($data['user']['phone_no'] === '') {
        $data['errors']['phone_no'] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $data['user']['phone_no'])) {
        $data['errors']['phone_no'] = "Phone number must be 10 digits.";
    }

    if ($data['user']['email'] === '') {
        $data['errors']['email'] = "Email is required.";
    } elseif (!filter_var($data['user']['email'], FILTER_VALIDATE_EMAIL)) {
        $data['errors']['email'] = "Invalid email format.";
    } elseif ($this->profileViewModel->sellerEmailExists($data['user']['email'], $seller_id)) {
        $data['errors']['email'] = "Email already in use.";
    }


    // IMAGE DELETE 

    if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {

        $this->profileViewModel->deleteSellerImage($seller_id);

        $image_url = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
    }


    // IMAGE UPLOAD

    else if (!empty($_FILES['profile_image']['name'])) {

        $uploadDir = 'uploads/sellers/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_name = $seller_id . '_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $image_name;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
        $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
        $fileSize = $_FILES['profile_image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $data['errors']['image'] = "Invalid file type.";
        }

        if ($fileSize > 5 * 1024 * 1024) {
            $data['errors']['image'] = "File must be less than 5MB.";
        }

        if (empty($data['errors'])) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $image_url = $targetFile;
            } else {
                $data['errors']['general'] = "Upload failed.";
            }
        }
    }

    // IF ERRORS → RETURN BACK

    if (!empty($data['errors'])) {
        $_SESSION['profile_errors'] = $data['errors'];
        $_SESSION['old_input'] = $data['user'];

        header('Location: ' . URLROOT . '/ProfileView/sellerProfileView');
        exit;
    }


    // FINAL IMAGE ASSIGN

    $data['user']['image_url'] = $image_url;


    // UPDATE DB

    if ($this->profileViewModel->updateSellerProfile($data['user'])) {
        header('Location: ' . URLROOT . '/ProfileView/sellerProfileView');
        exit;
    } else {
        die('Something went wrong while updating profile');
    }
}





////////////////////////////////
//officer
////////////////////////////////

    public function officerProfileView() {
        Auth::checkRole('officer');
        $officer_id = $_SESSION['user_id'];
        $officerProfile = $this->profileViewModel->getOfficerProfile($officer_id);

        $data = [
            'officer' => $officerProfile,
            'user' => $_SESSION['old_input'] ?? (array)$officerProfile,
            'errors' => $_SESSION['profile_errors'] ?? []
        ];

        unset($_SESSION['old_input'], $_SESSION['profile_errors']);

        if (!$officerProfile) {
    // redirect to admin login instead of dying
    header('Location: ' . URLROOT . '/users/login');
    exit;
    }
        $this->view('profile/V_officerprofile', $data);
    }

public function updateOfficer() {

    Auth::checkRole('officer');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . URLROOT . '/ProfileView/officerProfileView/');
        exit;
    }

     $officer_id = $_SESSION['user_id'];
     $officerProfile = $this->profileViewModel->getofficerProfile($officer_id);
     $image_url = $officerProfile->image_url ?? '';

    $data=[
        'user' => [],
        'errors' => []

    ];

    $data = [
        'user' => [
            'officer_id' => $officer_id,
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'phone_no' => trim($_POST['phone_no'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
        ],
        'errors' => []
    ];



        if(strlen($data['user']['first_name']) === 0) {
            $data['errors']['fname'] = "First name is required.";
        } elseif(!preg_match("/^[a-zA-Z]+$/", $data['user']['first_name'])) {
            $data['errors']['fname'] = "Only letters allowed.";
        }


        if(strlen($data['user']['last_name']) === 0) {
            $data['errors']['lname'] = "Last name is required.";
        } elseif(!preg_match("/^[a-zA-Z]+$/", $data['user']['last_name'])) {
            $data['errors']['lname'] = "Only letters allowed.";
        }


        if(strlen($data['user']['phone_no']) === 0) {
            $data['errors']['phone_no'] = "Phone number is required.";
        } elseif(!preg_match("/^[0-9]{10}$/", $data['user']['phone_no'])) {
            $data['errors']['phone_no'] = "Phone number must be 10 digits.";
        }

        if (strlen($data['user']['email']) === 0) {
       $data['errors']['email'] = "Email is required.";
        } elseif (!filter_var($data['user']['email'], FILTER_VALIDATE_EMAIL)) {
            $data['errors']['email'] = "Invalid email format.";
        } elseif ($this->profileViewModel->officerEmailExists($data['user']['email'], $officer_id)) {
            $data['errors']['email'] = "Email already in use.";
        }



    // Remove profile picture


    if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {

        $this->profileViewModel->deleteOfficerImage($officer_id);

        $image_url = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
    }
        
    // Upload new file
    else if (!empty($_FILES['profile_image']['name'])) {
        $uploadDir = 'uploads/officers/'; 
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_name = $officer_id . '_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $image_name;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'  , 'image/webp'];
        $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
        $fileSize = $_FILES['profile_image']['size'];

        // Validate file type
        if (!in_array($fileType, $allowedTypes)) {
            $data['errors']['image'] = 'Invalid file type. Only JPG, JPEG , PNG, GIF , WEBP allowed.';
        }

        // Validate file size (max 2MB)
        if ($fileSize > 5 * 1024 * 1024) {
             $data['errors']['image'] = 'File size must be less than 10MB';
        }





        if (empty($data['errors'])) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $image_url = $targetFile; // save relative path in DB
            } else {
                 $data['errors']['general'] = 'Error uploading file';
            }
        }

    
    }

    //if errors-> go back
        if (!empty($data['errors'])) {
        // You can store errors in session or return to the form
        $_SESSION['profile_errors'] = $data['errors'];
        $_SESSION['old_input'] = $data['user'];

        header('Location: ' . URLROOT . '/ProfileView/officerProfileView');
        exit;
    }

    //save image
    $data['user']['image_url'] = $image_url;

    //update db
        if ($this->profileViewModel->updateOfficerProfile($data['user'])) {
        header('Location: ' . URLROOT . '/ProfileView/officerProfileView');
        exit;
    } else {
        die('Something went wrong while updating profile');
    }

}








/////////////////////////////////////////
//Admin
/////////////////////////////////////////

public function adminProfile() {
        Auth::checkAdmin();
        $admin_id = $_SESSION['user_id'];
        $adminProfile = $this->profileViewModel->getAdminProfile($admin_id);

        $data = [
            'admin' => $adminProfile,
            'user' => $_SESSION['old_input'] ?? (array)$adminProfile,
            'errors' => $_SESSION['profile_errors'] ?? []
        ];

        unset($_SESSION['old_input'], $_SESSION['profile_errors']);

        if (!$adminProfile) {
    // redirect to admin login instead of dying
    header('Location: ' . URLROOT . '/users/login');
    exit;
    }
        $this->view('profile/V_adminprofile', $data);
}

public function updateAdmin() {

    Auth::checkAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . URLROOT . '/ProfileView/adminProfileView/');
        exit;
    }

     $admin_id = $_SESSION['user_id'];
     $adminProfile = $this->profileViewModel->getadminProfile($admin_id);
     $image_url = $adminProfile->image_url ?? '';

    $data=[
        'user' => [],
        'errors' => []

    ];

    $data = [
        'user' => [
            'admin_id' => $admin_id,
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'phone_no' => trim($_POST['phone_no'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
        ],
        'errors' => []
    ];



        if(strlen($data['user']['first_name']) === 0) {
            $data['errors']['fname'] = "First name is required.";
        } elseif(!preg_match("/^[a-zA-Z]+$/", $data['user']['first_name'])) {
            $data['errors']['fname'] = "Only letters allowed.";
        }


        if(strlen($data['user']['last_name']) === 0) {
            $data['errors']['lname'] = "Last name is required.";
        } elseif(!preg_match("/^[a-zA-Z]+$/", $data['user']['last_name'])) {
            $data['errors']['lname'] = "Only letters allowed.";
        }


        if(strlen($data['user']['phone_no']) === 0) {
            $data['errors']['phone_no'] = "Phone number is required.";
        } elseif(!preg_match("/^[0-9]{10}$/", $data['user']['phone_no'])) {
            $data['errors']['phone_no'] = "Phone number must be 10 digits.";
        }

        if (strlen($data['user']['email']) === 0) {
       $data['errors']['email'] = "Email is required.";
        } elseif (!filter_var($data['user']['email'], FILTER_VALIDATE_EMAIL)) {
            $data['errors']['email'] = "Invalid email format.";
        } elseif ($this->profileViewModel->adminEmailExists($data['user']['email'], $admin_id)) {
            $data['errors']['email'] = "Email already in use.";
        }



    // Remove profile picture


    if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {

        $this->profileViewModel->deleteAdminImage($admin_id);

        $image_url = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
    }
        
    // Upload new file
    else if (!empty($_FILES['profile_image']['name'])) {
        $uploadDir = 'uploads/admins/'; 
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_name = $admin_id . '_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $image_name;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'  , 'image/webp'];
        $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
        $fileSize = $_FILES['profile_image']['size'];

        // Validate file type
        if (!in_array($fileType, $allowedTypes)) {
            $data['errors']['image'] = 'Invalid file type. Only JPG, JPEG , PNG, GIF , WEBP allowed.';
        }

        // Validate file size (max 2MB)
        if ($fileSize > 5 * 1024 * 1024) {
             $data['errors']['image'] = 'File size must be less than 10MB';
        }





        if (empty($data['errors'])) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $image_url = $targetFile; // save relative path in DB
            } else {
                 $data['errors']['general'] = 'Error uploading file';
            }
        }

    
    }

    //if errors-> go back
        if (!empty($data['errors'])) {
        // You can store errors in session or return to the form
        $_SESSION['profile_errors'] = $data['errors'];
        $_SESSION['old_input'] = $data['user'];

        header('Location: ' . URLROOT . '/ProfileView/adminProfileView');
        exit;
    }

    //save image
    $data['user']['image_url'] = $image_url;

    //update db
        if ($this->profileViewModel->updateAdminProfile($data['user'])) {
        header('Location: ' . URLROOT . '/ProfileView/adminProfileView');
        exit;
    } else {
        die('Something went wrong while updating profile');
    }
}
  

}
?>