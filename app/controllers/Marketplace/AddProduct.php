<?php
class AddProduct extends Controller {
    private $addProductModel;

    public function __construct() {
        $this->addProductModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }

    public function index() {
        $data = [
            'name' => '',
            'seller_id' => '',
            'category' => '',
            'description' => '',
            'region' => '',
            'unit_type' => '',
            'price' => '',
            'available' => '',
            'image' => '',
            'status'=> '',
            'errors' => [],
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Trim POST data
            $data['name'] = trim($_POST['name']);
            $data['seller_id'] = trim($_POST['seller_id']);
            $data['category'] = trim($_POST['category']);
            $data['description'] = trim($_POST['description']);
            $data['status'] = trim($_POST['status']);
            $data['region'] = trim($_POST['region']);
            $data['unit_type'] = trim($_POST['unit_type']);
            $data['price'] = trim($_POST['price']);
            $data['available'] = trim($_POST['available']);

            // --- Validation ---
            if(empty($data['name'])) {
                $data['errors']['name'] = "⚠ Product name is required.";
            }

            if(empty($data['seller_id'])) {
                $data['errors']['seller_id'] = "⚠ Seller ID is required.";
            } elseif (!$this->addProductModel->sellerExists($data['seller_id'])) {
                $data['errors']['seller_id'] = "⚠ Seller ID not found.";
            }

            if(empty($data['category'])) {
                $data['errors']['category'] = "⚠ Please select a category.";
            }

            if(empty($data['description'])) {
                $data['errors']['description'] = "⚠ Description cannot be empty.";
            }

            if(empty($data['status'])) {
                $data['errors']['status'] = "⚠ Please select a status.";
            }

            if(empty($data['region'])) {
                $data['errors']['region'] = "⚠ Please select a region.";
            }

            if(empty($data['unit_type'])) {
                $data['errors']['unit_type'] = "⚠ Please select a unit type.";
            }

            if(empty($data['price'])) {
                $data['errors']['price'] = "⚠ Price is required.";
            } elseif(!is_numeric($data['price']) || $data['price'] <= 0) {
                $data['errors']['price'] = "⚠ Price must be a number greater than 0.";
            }

            if(empty($data['available'])) {
                $data['errors']['available'] = "⚠ Quantity is required.";
            } elseif(!is_numeric($data['available']) || $data['available'] < 0) {
                $data['errors']['available'] = "⚠ Quantity must be a positive number.";
            }

            // Image upload validation
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $filename = basename($_FILES['image']['name']);
                $target = 'uploads/' . $filename;
                if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $data['image'] = $filename;
                } else {
                    $data['errors']['image'] = "❌ Failed to upload image.";
                }
            } else {
                $data['errors']['image'] = "⚠ Please upload an image.";
            }

            // --- Add product if no errors ---
            if(empty($data['errors'])) {
                if($this->addProductModel->createProduct($data)) {
                    header("Location: " . URLROOT . "/marketplace/addsuccess");
                    exit();
                } else {
                    $data['errors']['general'] = "❌ Something went wrong. Please try again.";
                }
            }
        }

        $this->view('marketplace/V_addProduct', $data);
    }
}
?>
