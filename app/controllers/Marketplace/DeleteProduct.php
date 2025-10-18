<?php
class DeleteProduct extends Controller {
    private $productModel;

    public function __construct() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if seller is logged in
        if (!isset($_SESSION['seller_id'])) {
            header("Location: " . URLROOT . "/Users/login");
            exit();
        }

        // Load the model
        $this->productModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }

    // Entry point
    public function index($id = null) {
        if ($id === null) {
            header("Location: " . URLROOT . "/Marketplace/ManageProduct");
            exit();
        }
        $this->delete_product($id);
    }

    public function delete_product($id) {
        // Only allow POST for deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productModel->deleteProduct($id)) {
                $_SESSION['product_message'] = "Product deleted successfully ✅";
            } else {
                $_SESSION['product_message'] = "Something went wrong ❌";
            }
            header("Location: " . URLROOT . "/Marketplace/ManageProduct");
            exit();
        } else {
            // Show confirmation view
            $product = $this->productModel->getProductById($id);

            if (!$product) {
                $_SESSION['product_message'] = "Product not found ❌";
                header("Location: " . URLROOT . "/Marketplace/ManageProduct");
                exit();
            }

            $this->view('marketplace/V_deleteProduct', $product);
        }
    }
}
?>
