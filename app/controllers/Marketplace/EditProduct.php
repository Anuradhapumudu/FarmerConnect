<?php
class EditProduct extends Controller {
    private $editProductModel;

    public function __construct() {
        // Load the model from the Marketplace folder
        $this->editProductModel = $this->model('M_Marketplace/M_EditProduct', new Database());
    }

    // Default method called by Core router
    public function index($id = null) {
        // Validate the ID
        if (!$id || !is_numeric($id) || $id <= 0) {
            die("Invalid product ID. ID: " . htmlspecialchars($id));
        }

        // Fetch the product from the database
        $product = $this->editProductModel->getProductById($id);

        // Check if the product exists
        if (!$product) {
            die("Product not found. ID: " . htmlspecialchars($id));
        }

        // Handle POST request for updating the product
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($id, $product);
            return;
        }

        // GET request: show the edit form
        $data = [
            'product' => (array)$product
        ];
        $this->view('marketplace/V_editProduct', $data);
    }

    private function handleUpdate($id, $product) {
        // Default to existing image
        $image_url = $product->image_url;

        // Check if a new image is uploaded
        if (!empty($_FILES['image']['name'])) {
            $targetDir = APPROOT . "/../public/uploads/";
            $image_url = basename($_FILES['image']['name']);
            $targetFile = $targetDir . $image_url;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
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

        // Update product
        if ($this->editProductModel->updateProduct($data)) {
            header("Location: " . URLROOT . "/Marketplace/ManageProduct");
            exit;
        } else {
            die("Failed to update product.");
        }
    }
}
?>
