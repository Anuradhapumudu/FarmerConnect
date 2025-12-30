<?php
class ProfileView extends Controller {
    private $profileViewModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if logged-in and correct user type
        if (!isset($_SESSION['user_type'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

            // For admin, make sure they are redirected to admin login if session invalid
        if ($_SESSION['user_type'] === 'admin' && !isset($_SESSION['user_id'])) {
        header('Location: ' . URLROOT . '/admin/adminlogin');
        exit;
        }

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
        $seller_id = $_SESSION['user_id'];
        $sellerProfile = $this->profileViewModel->getSellerProfile($seller_id);

        $data = [
            'seller' => $sellerProfile
        ];

                if (!$sellerProfile) {
    // redirect to admin login instead of dying
    header('Location: ' . URLROOT . '/users/login');
    exit;
}
        $this->view('profile/V_sellerprofile', $data);
    }

public function updateSeller() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . URLROOT . '/profile');
        exit;
    }

    $errors = [];

    $seller_id = $_POST['seller_id'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $company_name = trim($_POST['company_name']);
    $address = trim($_POST['address']);
    $phone_no = trim($_POST['phone_no']);

    // Basic required field validations
    if (empty($first_name)) $errors[] = 'First name is required';
    if (empty($last_name)) $errors[] = 'Last name is required';
    if (empty($company_name)) $errors[] = 'Company name is required';
    if (empty($address)) $errors[] = 'Address is required';
    if (empty($phone_no)) $errors[] = 'Phone number is required';

    // phone number and NIC format validation
    if (!empty($phone_no) && !preg_match('/^[0-9]{10}$/', $phone_no)) {
        $errors[] = 'Phone number must be 10 digits';
    }

    $sellerProfile = $this->profileViewModel->getSellerProfile($seller_id);
    $image_url = $sellerProfile->image_url ?? 'https://cdn-icons-png.flaticon.com/512/847/847969.png';

    // Remove profile picture
    if (isset($_POST['removed_flag']) && $_POST['removed_flag'] == '1') {
        $image_url = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
    }
    // Upload new file
    else if (!empty($_FILES['profile_image']['name'])) {
        $uploadDir = 'uploads/sellers/'; 
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_name = $seller_id . '_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $image_name;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
        $fileSize = $_FILES['profile_image']['size'];

        // Validate file type
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Invalid file type. Only JPG, PNG, GIF allowed.';
        }

        // Validate file size (max 2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            $errors[] = 'File size must be less than 2MB';
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $image_url = $targetFile; // save relative path in DB
            } else {
                $errors[] = 'Error uploading file';
            }
        }
    }

    if (!empty($errors)) {
        // You can store errors in session or return to the form
        $_SESSION['profile_errors'] = $errors;
        header('Location: ' . URLROOT . '/ProfileView/sellerProfileView');
        exit;
    }

    $data = [
        'seller_id'    => $seller_id,
        'first_name'   => $first_name,
        'last_name'    => $last_name,
        'company_name' => $company_name,
        'address'      => $address,
        'phone_no'     => $phone_no,
        'image_url'    => $image_url
    ];

    if ($this->profileViewModel->updateSellerProfile($data)) {
        header('Location: ' . URLROOT . '/ProfileView/sellerProfileView');
        exit;
    } else {
        die('Something went wrong while updating profile');
    }
}

    public function officerProfileView() {
        $officer_id = $_SESSION['user_id'];
        $officerProfile = $this->profileViewModel->getOfficerProfile($officer_id);

        $data = [
            'officer' => $officerProfile
        ];

        if (!$officerProfile) {
    // redirect to admin login instead of dying
    header('Location: ' . URLROOT . '/users/login');
    exit;
}
        $this->view('profile/V_officerprofile', $data);
    }

public function updateOfficer() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . URLROOT . '/profile');
        exit;
    }

    $errors = [];

    $officer_id = $_POST['officer_id'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone_no = trim($_POST['phone_no']);

    // Basic required field validations
    if (empty($first_name)) $errors[] = 'First name is required';
    if (empty($last_name)) $errors[] = 'Last name is required';
    if (empty($phone_no)) $errors[] = 'Phone number is required';

    // phone number and NIC format validation
    if (!empty($phone_no) && !preg_match('/^[0-9]{10}$/', $phone_no)) {
        $errors[] = 'Phone number must be 10 digits';
    }

    $officerProfile = $this->profileViewModel->getOfficerProfile($officer_id);
    $image_url = $officerProfile->image_url ?? 'https://cdn-icons-png.flaticon.com/512/847/847969.png';

    // Remove profile picture
    if (isset($_POST['removed_flag']) && $_POST['removed_flag'] == '1') {
        $image_url = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
    }
    // Upload new file
    else if (!empty($_FILES['profile_image']['name'])) {
        $uploadDir = 'uploads/officers/'; 
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_name = $officer_id . '_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $image_name;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
        $fileSize = $_FILES['profile_image']['size'];

        // Validate file type
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Invalid file type. Only JPG, PNG, GIF allowed.';
        }

        // Validate file size (max 2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            $errors[] = 'File size must be less than 2MB';
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $image_url = $targetFile; // save relative path in DB
            } else {
                $errors[] = 'Error uploading file';
            }
        }
    }

    if (!empty($errors)) {
        // You can store errors in session or return to the form
        $_SESSION['profile_errors'] = $errors;
        header('Location: ' . URLROOT . '/ProfileView/officerProfileView');
        exit;
    }

    $data = [
        'officer_id'    => $officer_id,
        'first_name'   => $first_name,
        'last_name'    => $last_name,
        'phone_no'     => $phone_no,
        'image_url'    => $image_url
    ];

    if ($this->profileViewModel->updateOfficerProfile($data)) {
        header('Location: ' . URLROOT . '/ProfileView/officerProfileView');
        exit;
    } else {
        die('Something went wrong while updating profile');
    }
}

public function adminProfile() {
    $admin_id = $_SESSION['user_id'];

    $adminProfile = $this->profileViewModel->getAdminProfile($admin_id);
if (!$adminProfile) {
    // redirect to admin login instead of dying
    header('Location: ' . URLROOT . '/admin/adminlogin');
    exit;
}

    $this->view('profile/V_adminprofile', [
        'admin' => $adminProfile
    ]);
}

public function updateAdmin() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . URLROOT . '/ProfileView/adminProfile');
        exit;
    }

    $admin_id   = $_POST['admin_id'];
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $phone_no   = trim($_POST['phone_no']);

    $errors = [];

    if (!$first_name) $errors[] = 'First name required';
    if (!$last_name)  $errors[] = 'Last name required';
    if (!preg_match('/^[0-9]{10}$/', $phone_no)) {
        $errors[] = 'Phone must be 10 digits';
    }

    $admin = $this->profileViewModel->getAdminProfile($admin_id);
    $image_url = $admin->image_url ??
        'https://cdn-icons-png.flaticon.com/512/847/847969.png';

    if (isset($_POST['removed_flag'])) {
        $image_url = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
    }

    elseif (!empty($_FILES['profile_image']['name'])) {

        $dir = 'uploads/admins/';
        if (!file_exists($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $file = $dir . $admin_id . '_' . time() . '.' . $ext;

        if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Image too large';
        }

        if (empty($errors) &&
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $file)) {
            $image_url = $file;
        }
    }

    if (!empty($errors)) {
        $_SESSION['profile_errors'] = $errors;
        header('Location: ' . URLROOT . '/ProfileView/adminProfile');
        exit;
    }

    $this->profileViewModel->updateAdminProfile([
        'admin_id'   => $admin_id,
        'first_name' => $first_name,
        'last_name'  => $last_name,
        'phone_no'   => $phone_no,
        'image_url'  => $image_url
    ]);

    header('Location: ' . URLROOT . '/ProfileView/adminProfile');
    exit;
}
  

}
?>