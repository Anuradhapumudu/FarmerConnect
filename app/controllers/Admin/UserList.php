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


    // List all sellers
    public function sellerlist() {
        $data = [
            'sellers' => $this->adminModel->getAllSellers(),
            'counts'  => $this->adminModel->getCounts()
        ];
        $this->view('admin/V_sellerslist', $data);
    }

    // Delete seller
    public function delete($id) {
        if ($this->adminModel->deleteSeller($id)) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }
        die('Something went wrong while deleting seller.');
    }

    // Show seller details
    public function show($id = null) {
        if (!$id) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }

        $seller = $this->adminModel->getSellerById($id);

        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }

        $this->view('admin/V_sellerview', ['seller' => $seller]);
    }

       public function edit($id = null) {
        // Handle POST request (form submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seller_id = $_POST['seller_id'] ?? null;

            if (!$seller_id) {
                header('Location: ' . URLROOT . '/Admin/SellersList');
                exit;
            }

            $data = [
                'first_name'      => trim($_POST['first_name']),
                'last_name'       => trim($_POST['last_name']),
                'nic'             => trim($_POST['nic']),
                'email'           => trim($_POST['email']),
                'phone_no'        => trim($_POST['phone_no'] ?? ''),
                'address'         => trim($_POST['address'] ?? ''),
                'company_name'    => trim($_POST['company_name'] ?? ''),
                'brn'             => trim($_POST['brn']),
                'approval_status' => $_POST['approval_status'] ?? 'Pending'
            ];

            if ($this->adminModel->updateSeller($seller_id, $data)) {
                // Send email if status changed to approved
                if (strtolower($data['approval_status']) === 'approved') {
                    $seller = $this->adminModel->getSellerById($seller_id);
                    if (!empty($seller->email)) {
                        sendApprovalEmail($seller->email, $seller->seller_id);
                    }
                }
                header('Location: ' . URLROOT . '/Admin/SellersList');
                exit;
            }
            die('Something went wrong while updating seller.');
        }

        // GET request - display form with current values
        if (!$id) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }

        $seller = $this->adminModel->getSellerById($id);
        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }

        $this->view('admin/V_selleredit', ['seller' => $seller]);
    }

    // Approve seller
    public function approve($id) {
        $seller = $this->adminModel->getSellerById($id);
        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }

        // Validation before approval
        $requiredFields = ['brn', 'nic', 'email', 'address', 'phone_no'];
        foreach ($requiredFields as $field) {
            if (empty($seller->$field)) {
                $_SESSION['error'] = "Cannot approve seller: Missing required information ($field).";
                header('Location: ' . URLROOT . '/Admin/SellersList');
                exit;
            }
        }

        if (!filter_var($seller->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Cannot approve seller: Invalid email.";
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }

        $this->adminModel->updateStatus($id, 'Approved');

        // Send approval email
        sendApprovalEmail($seller->email, $seller->seller_id);

        header('Location: ' . URLROOT . '/Admin/SellersList');
        exit;
    }

    // Reject seller
    public function reject($id) {
        $seller = $this->adminModel->getSellerById($id);
        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        }

        $this->adminModel->updateStatus($id, 'Rejected');
        header('Location: ' . URLROOT . '/Admin/SellersList');
        exit;
    }

    // In SellersList controller
        public function update($seller_id) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = [
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'email' => trim($_POST['email']),
            'phone_no' => trim($_POST['phone_no'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'company_name' => trim($_POST['company_name'] ?? ''),
            'brn' => trim($_POST['brn'] ?? ''),
            'approval_status' => $_POST['approval_status'] ?? 'Pending'
        ];

        if($this->adminModel->updateSeller($seller_id, $data)) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit;
        } else {
            die('Error updating seller.');
        }
    }
}


    public function farmerlist() {
        $data = [
            'farmers' => $this->adminModel->getAllFarmers(),
            'counts'  => $this->adminModel->getFarmerCounts()
        ];
        $this->view('admin/V_farmerslist', $data);
    }



        public function officerlist() {
        $data = [
            'officers' => $this->adminModel->getAllOfficers(),
            'counts'  => $this->adminModel->getOfficerCounts()
        ];
        $this->view('admin/V_officerslist', $data);
    }

}