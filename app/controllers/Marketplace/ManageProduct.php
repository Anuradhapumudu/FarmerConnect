<?php


if (!empty($_SESSION['product_message'])) {
    echo '<div class="alert alert-success" style="margin-bottom:15px;">' . $_SESSION['product_message'] . '</div>';
    unset($_SESSION['product_message']);
}


class ManageProduct extends Controller {
    private $manageProductModel;

    public function __construct() {
        // Start the session if not started yet
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // If no seller is logged in, redirect to login
        if (!isset($_SESSION['seller_id'])) {
            header("Location: " . URLROOT . "/Users/login");
            exit();
        }

        // Load model
        $this->manageProductModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }

    public function index() {
        // ✅ Get logged-in seller ID from session
        $seller_id = $_SESSION['seller_id'];

        // ✅ Fetch only that seller’s products
        $products = $this->manageProductModel->getProductsBySeller($seller_id);

        // ✅ Pass data to view
        $data = ['products' => $products];
        $this->view('marketplace/V_manageProduct', $data);
    }
}
?>

