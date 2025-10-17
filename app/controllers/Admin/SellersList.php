<?php
class SellersList extends Controller {
    private $sellerModel;

    public function __construct() {
        $this->sellerModel = $this->model('Admin/M_Admin', new Database());
    }

    // List all sellers
    public function index() {
        $data = [
            'sellers' => $this->sellerModel->getAllSellers(),
            'counts'  => $this->sellerModel->getCounts()
        ];
        $this->view('admin/V_sellerslist', $data);
    }

    // Delete seller
    public function delete($id) {
        if ($this->sellerModel->deleteSeller($id)) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit();
        } else {
            die('Something went wrong while deleting seller.');
        }
    }

    // Show seller details
    public function show() {
        if (!isset($_POST['seller_id'])) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit();
        }

        $id = $_POST['seller_id'];
        $seller = $this->sellerModel->getSellerById($id);

        if (!$seller) {
            header('Location: ' . URLROOT . '/Admin/SellersList');
            exit();
        }

        $this->view('admin/V_sellerview', ['seller' => $seller]);
    }

    // Edit seller
    public function edit($id = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $seller_id = $_POST['seller_id'];
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name'  => trim($_POST['last_name']),
                'nic'        => trim($_POST['nic']),
                'email'      => trim($_POST['email']),
                'phone_no'   => trim($_POST['phone_no']),
                'address'    => trim($_POST['address']),
                'company_name' => trim($_POST['company_name']),
                'brn'        => trim($_POST['brn']),
                'approval_status' => $_POST['approval_status']
            ];

            // Update in DB
            if ($this->sellerModel->updateSeller($seller_id, $data)) {
                // If status is "Approved" — send email
                if ($data['approval_status'] == 'Approved') {
                    $seller = $this->sellerModel->getSellerById($seller_id);
                    $this->sendApprovalEmail($seller);
                }

                header('Location: ' . URLROOT . '/Admin/SellersList');
                exit();
            } else {
                die('Something went wrong while updating seller.');
            }
        } else {
            if (!$id) {
                header('Location: ' . URLROOT . '/Admin/SellersList');
                exit();
            }

            $seller = $this->sellerModel->getSellerById($id);
            if (!$seller) {
                header('Location: ' . URLROOT . '/Admin/SellersList');
                exit();
            }

            $this->view('admin/V_selleredit', ['seller' => $seller]);
        }
    }

    private function sendApprovalEmail($seller) {
        $to = $seller->email;
        $subject = "Seller Account Approved - Your Seller ID";
        $sellerId = $seller->seller_id;

        $message = "
        <html>
        <head>
            <title>Seller Account Approved</title>
        </head>
        <body>
            <p>Hi {$seller->first_name},</p>
            <p>Congratulations! Your seller account has been approved 🎉</p>
            <p>Your <strong>Seller ID</strong> is: <strong>{$sellerId}</strong></p>
            <p>You can now login and start listing your products.</p>
            <br>
            <p>Best regards,<br>FarmerConnect Team</p>
        </body>
        </html>
        ";

        // Headers for HTML mail
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: FarmerConnect <no-reply@farmerconnect.lk>" . "\r\n";

        // Send
        if (mail($to, $subject, $message, $headers)) {
            error_log("Approval email sent to $to");
        } else {
            error_log("Failed to send approval email to $to");
        }
    }
}
?>
