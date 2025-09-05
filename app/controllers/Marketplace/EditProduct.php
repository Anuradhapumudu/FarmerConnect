<?php
class EditProduct extends Controller {
    private $editProductModel;

    public function __construct() {
        $this->editProductModel = $this->model('M_Marketplace/M_EditProduct', new Database());
    }

    public function index($method = null, $id = null) {
        // Handle different parameter scenarios
        if ($method === 'index' && is_numeric($id)) {
            // URL format: /EditProduct/index/2
            $productId = $id;
        } elseif (is_numeric($method)) {
            // URL format: /EditProduct/2 (method treated as ID)
            $productId = $method;
        } else {
            // Try to get ID from GET parameter or other sources
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $productId = $_GET['id'];
            } else {
                die("Invalid product ID. Please check the URL.");
            }
        }

        // Check if ID is valid
        if (!is_numeric($productId) || $productId <= 0) {
            die("Invalid product ID. ID: " . htmlspecialchars($productId));
        }

        // Fetch the product from the database
        $product = $this->editProductModel->getProductById($productId);

        // Check if the product exists
        if (!$product) {
            die("Product not found. ID: " . htmlspecialchars($productId));
        }

        // Check if the form was submitted (POST request)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($productId, $product);
            return; // Stop execution after handling the update
        }

        // If it's a GET request, show the edit form
        $data = [
            'product' => (array)$product
        ];
        $this->view('marketplace/V_editProduct', $data);
    }

    private function handleUpdate($id, $product) {
        // Initialize image_url with the current image
        $image_url = $product->image_url;

        // Check if a new image was uploaded
        if (!empty($_FILES['image']['name'])) {
            $targetDir = APPROOT . "/../public/uploads/";
            $image_url = basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $image_url;

            // Move the uploaded file
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                die("Failed to upload image.");
            }
        }

        // Collect POST data
        $data = [
            'item_id' => $id,
            'item_name' => trim($_POST['item_name']),
            'price_per_unit' => trim($_POST['price_per_unit']),
            'available_quantity' => trim($_POST['available_quantity']),
            'region' => trim($_POST['region']),
            'description' => trim($_POST['description']),
            'image_url' => $image_url,
            'status' => trim($_POST['status']),
            'category' => trim($_POST['category']),
            'unit_type' => trim($_POST['unit_type']),
        ];

        // Attempt to update the product
        if ($this->editProductModel->updateProduct($data)) {
            // Redirect to manage products page on success
            header("Location: " . URLROOT . "/Marketplace/ManageProduct");
            exit;
        } else {
            die("Failed to update product.");
        }
    }
}
?>