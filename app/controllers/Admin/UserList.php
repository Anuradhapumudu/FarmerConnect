<?php 
require_once APPROOT . '/helpers/email_helper.php';


class UserList extends Controller {

    private $adminModel;

    public function __construct() {
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    // For admin, make sure they are redirected to admin login if session invalid
        if ($_SESSION['user_type'] === 'admin' && !isset($_SESSION['user_id'])) {
        header('Location: ' . URLROOT . '/admin/adminlogin');
        exit;
        }
        $this->adminModel = $this->model('M_Admin', new Database());
    }

    // Default method so router can call controller without specifying method
    public function index() {
        $this->sellerlist();
    }


    // List all sellers
    public function sellerlist() {
        Auth::checkAdmin();
        $data = [
            'sellers' => $this->adminModel->getAllSellers(),
            'counts'  => $this->adminModel->getCounts()
        ];
        $this->view('admin/V_sellerslist', $data);
    }


    // Show seller details
    public function showseller($id = null) {
        Auth::checkAdmin();
        if (!$id) {
            header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
            exit;
        }

        $seller = $this->adminModel->getSellerById($id);

        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
            exit;
        }

        $this->view('admin/V_sellerview', ['seller' => $seller]);
    }


    // Approve seller
public function approve($id) {
    Auth::checkAdmin();

    $seller = $this->adminModel->getSellerById($id);

    if (!$seller) {
        header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
        exit;
    }

    $errors = [];

    // Validation
    $requiredFields = ['brn', 'nic', 'email', 'address', 'phone_no'];
    foreach ($requiredFields as $field) {
        if (empty($seller->$field)) {
            $errors[$field] = "Missing $field";
        }
    }

    if (!filter_var($seller->email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    //  If errors → DO NOT REDIRECT
    if (!empty($errors)) {

        $data = [
            'seller' => $seller,
            'errors' => $errors,
            'success' => ''
        ];

        // reload SAME page
        $this->view('admin/V_sellerview', $data);
        return;
    }

    // Approve
    $this->adminModel->updateSellerStatus($id, 'Approved');
    sendApprovalEmail($seller->email, $seller->seller_id);

    $data = [
        'seller' => $this->adminModel->getSellerById($id), // refresh data
        'errors' => [],
        'success' => "Seller approved successfully!"
    ];

    $this->view('admin/V_sellerview', $data);
}

    // Reject seller
    public function reject($id) {
        Auth::checkAdmin();
        $seller = $this->adminModel->getSellerById($id);
        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
            exit;
        }

        if($seller->approval_status == 'Approved'){
                    $_SESSION['seller_message'] = "Approved sellers cannot be rejected.";

        header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
        exit;
    }
    

        $this->adminModel->updateSellerStatus($id, 'Rejected');
        sendRejectEmail($seller->email,$seller->seller_id);

        header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
        exit;
    }


    public function updateSeller($id) {
    Auth::checkAdmin();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $data = [
            'email' => trim($_POST['email']),
            'company_name' => trim($_POST['company_name']),
            'brn' => trim($_POST['brn'])
        ];

        $errors = [];

        // validation
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email";
        }

        if (empty($data['company_name'])) {
            $errors['company_name'] = "Company name required";
        }

        if (empty($data['brn'])) {
            $errors['brn'] = "BRN required";
        }

        if (!empty($errors)) {
            $seller = $this->adminModel->getSellerById($id);

            $this->view('admin/V_sellerview', [
                'seller' => $seller,
                'errors' => $errors,
                'success' => ''
            ]);
            return;
        }

        // update DB
        $this->adminModel->updateSeller($id, $data);

        // reload updated data
        $seller = $this->adminModel->getSellerById($id);

        $this->view('admin/V_sellerview', [
            'seller' => $seller,
            'errors' => [],
            'success' => "Seller updated successfully!"
        ]);
    }
}
    


//farmer list
    public function farmerlist() {
        Auth::checkAdmin();
        $data = [
            'farmers' => $this->adminModel->getAllFarmers(),
            'counts'  => $this->adminModel->getFarmerCounts()
        ];
        $this->view('admin/V_farmerslist', $data);
    }


        public function showfarmer($id = null) {
            Auth::checkAdmin();
            // If no ID is provided, redirect back to the farmer list
        if (!$id) {
            header('Location: ' . URLROOT . '/Admin/UserList/farmerlist');
            exit;
        }


        $farmer = $this->adminModel->getFarmerById($id);
        // If the ID is invalid or the farmer was deleted, redirect back
        if (!$farmer) {
            header('Location: ' . URLROOT . '/Admin/UserList/farmerlist');
            exit;
        }

        $paddyDetails = $this->adminModel->getPaddyDetailsById($id);

         $this->view('admin/V_farmerview', [
        'farmer' => $farmer,
        'paddyDetails' => $paddyDetails
    ]);
    }

    
        public function inactivefarmer($id) {
        Auth::checkAdmin();
        $farmer = $this->adminModel->getFarmerById($id);
        if (!$farmer) {
            header('Location: ' . URLROOT . '/Admin/UserList/farmerlist/');
            exit;
        }

        $this->adminModel->updateFarmerStatus($id, 'Inactive');
        header('Location: ' . URLROOT . '/Admin/UserList/farmerlist/');
        exit;
    }

        public function activefarmer($id) {
        Auth::checkAdmin();
        $farmer = $this->adminModel->getFarmerById($id);
        if (!$farmer) {
            header('Location: ' . URLROOT . '/Admin/UserList/farmerlist');
            exit;
        }

        $this->adminModel->updateFarmerStatus($id, 'Active');

        header('Location: ' . URLROOT . '/Admin/UserList/farmerlist');
        exit;
    }





    //officer list
        public function officerlist() {

        Auth::checkAdmin();
        $data = [
            'officers' => $this->adminModel->getAllOfficers(),
            'counts'  => $this->adminModel->getOfficerCounts()
        ];
        $this->view('admin/V_officerslist', $data);
    }

            public function showofficer($id = null) {
        Auth::checkAdmin();
            // If no ID is provided, redirect back to the farmer list
        if (!$id) {
            header('Location: ' . URLROOT . '/Admin/UserList/officerlist');
            exit;
        }


        $officer = $this->adminModel->getOfficerById($id);
        // If the ID is invalid or the officer was deleted, redirect back
        if (!$officer) {
            header('Location: ' . URLROOT . '/Admin/UserList/officerlist');
            exit;
        }



 $this->view('admin/V_officerview', ['officer' => $officer]);
    }


            public function inactiveofficer($id) {
                Auth::checkAdmin();
        $officer = $this->adminModel->getOfficerById($id);
        if (!$officer) {
            header('Location: ' . URLROOT . '/Admin/UserList/officerlist/');
            exit;
        }

        $this->adminModel->updateOfficerStatus($id, 'Inactive');
        header('Location: ' . URLROOT . '/Admin/UserList/officerlist/');
        exit;
    }

        public function activeofficer($id) {
            Auth::checkAdmin();
        $officer = $this->adminModel->getOfficerById($id);
        if (!$officer) {
            header('Location: ' . URLROOT . '/Admin/UserList/officerlist');
            exit;
        }

        $this->adminModel->updateOfficerStatus($id, 'Active');

        header('Location: ' . URLROOT . '/Admin/UserList/officerlist');
        exit;
    }

}