<?php
class EditProduct extends Controller {
    private $editProductModel;

    public function __construct() {
        $this->editProductModel = $this->model('M_EditProduct', new Database());
    }

    public function index($id = 0) {
        $product = $this->editProductModel->getProductById($id);

        if (!$product) {
            die("Product not found");
        }

        // If POST, handle update here to avoid separate URL
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->handleUpdate($id, $product);
            return;
        }

        $data = [
            'product' => (array)$product
        ];

        $this->view('seller/editProduct', $data);
    }

    private function handleUpdate($id, $product) {
        // Handle image upload
        $image_url = $product->image_url; // keep old image if not replaced
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            $image_url = basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $image_url;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        }

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

        if ($this->editProductModel->updateProduct($data)) {
            if ($this->editProductModel->updateProduct($data)) {
                // Redirect to manage product page
                header("Location: " . URLROOT . "/manageproduct");
                exit;

            }else {
            $data['error'] = "Something went wrong. Please try again.";
            $this->view('seller/editProduct', $data);
        }
    }
    }
}
?>
