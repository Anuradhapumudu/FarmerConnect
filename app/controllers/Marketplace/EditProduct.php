<?php
class EditProduct extends Controller {
    private $editProductModel;

    public function __construct() {
        // Start session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if seller is logged in
        if (!isset($_SESSION['seller_id'])) {
            header("Location: " . URLROOT . "/Users/login");
            exit();
        }

        // Load model
        $this->editProductModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }

 public function index($id = null) {
        // Validate ID
        if (!$id || !is_numeric($id) || $id <= 0) {
            die("Invalid product ID.");
        }

        $product = $this->editProductModel->getProductById($id);
        if (!$product) {
            die("Product not found.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($id, $product);
            return;
        }

        // GET request: load edit form
        $data = [
            'product' => (array)$product,
            'errors' => []
        ];
        $this->view('marketplace/V_editProduct', $data);
    }

    private function handleUpdate($id, $product) {
        $image_url = $product->image_url;

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $targetDir = APPROOT . "/../public/uploads/";
            $image_url = basename($_FILES['image']['name']);
            $targetFile = $targetDir . $image_url;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                die("Failed to upload image.");
            }
        }

        // Collect POST data
        $productData = [
            'item_id' => $id,
            'item_name' => trim($_POST['item_name'] ?? ''),
            'price_per_unit' => trim($_POST['price_per_unit'] ?? ''),
            'available_quantity' => trim($_POST['available_quantity'] ?? ''),
            'region' => trim($_POST['region'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'image_url' => $image_url,
            'status' => trim($_POST['status'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'unit_type' => trim($_POST['unit_type'] ?? ''),
        ];

        // Validation
        $errors = [];
        if (empty($productData['item_name'])) $errors['name'] = "⚠ Product name is required.";
        if (empty($productData['category'])) $errors['category'] = "⚠ Please select a category.";
        if (empty($productData['status'])) $errors['status'] = "⚠ Please select a status.";
        if (empty($productData['region'])) $errors['region'] = "⚠ Please select a region.";
        if (empty($productData['unit_type'])) $errors['unit_type'] = "⚠ Please select a unit type.";
        if (empty($productData['price_per_unit']) || !is_numeric($productData['price_per_unit']) || $productData['price_per_unit'] <= 0)
            $errors['price'] = "⚠ Price must be a number greater than 0.";
        if (empty($productData['available_quantity']) || !is_numeric($productData['available_quantity']) || $productData['available_quantity'] < 0)
            $errors['available'] = "⚠ Quantity must be a positive number.";

        if (!empty($errors)) {
            // Reload form with errors
            $this->view('marketplace/V_editProduct', [
                'product' => $productData,
                'errors' => $errors
            ]);
            return;
        }

        // Update product
        if ($this->editProductModel->updateProduct($productData)) {
            header("Location: " . URLROOT . "/Marketplace/ManageProduct");
            exit;
        } else {
            die("Failed to update product.");
        }
    }
}
?>