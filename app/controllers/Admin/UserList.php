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
        $data = [
            'sellers' => $this->adminModel->getAllSellers(),
            'counts'  => $this->adminModel->getCounts()
        ];
        $this->view('admin/V_sellerslist', $data);
    }


    // Show seller details
    public function showseller($id = null) {
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
        $seller = $this->adminModel->getSellerById($id);
        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
            exit;
        }

        // Validation before approval
        $requiredFields = ['brn', 'nic', 'email', 'address', 'phone_no'];
        foreach ($requiredFields as $field) {
            if (empty($seller->$field)) {
                $_SESSION['error'] = "Cannot approve seller: Missing required information ($field).";
                header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
                exit;
            }
        }

        if (!filter_var($seller->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Cannot approve seller: Invalid email.";
            header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
            exit;
        }

        $this->adminModel->updateSellerStatus($id, 'Approved');

        // Send approval email
        sendApprovalEmail($seller->email, $seller->seller_id);

        header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
        exit;
    }

    // Reject seller
    public function reject($id) {
        $seller = $this->adminModel->getSellerById($id);
        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
            exit;
        }

        $this->adminModel->updateSellerStatus($id, 'Rejected');
        header('Location: ' . URLROOT . '/Admin/UserList/sellerlist');
        exit;
    }


    


//farmer list
    public function farmerlist() {
        $data = [
            'farmers' => $this->adminModel->getAllFarmers(),
            'counts'  => $this->adminModel->getFarmerCounts()
        ];
        $this->view('admin/V_farmerslist', $data);
    }


        public function showfarmer($id = null) {
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
        $data = [
            'officers' => $this->adminModel->getAllOfficers(),
            'counts'  => $this->adminModel->getOfficerCounts()
        ];
        $this->view('admin/V_officerslist', $data);
    }

            public function showofficer($id = null) {
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