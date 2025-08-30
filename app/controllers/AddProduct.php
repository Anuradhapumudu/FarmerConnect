<?php
class AddProduct extends Controller {
    private $addProductModel;

    public function __construct() {
        $this->addProductModel = $this->model('M_AddProduct',new Database());
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
            'success' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get POST data
            $data['name'] = trim($_POST['name']);
            $data['seller_id'] = trim($_POST['seller_id']);
            $data['category'] = trim($_POST['category']);
            $data['description'] = trim($_POST['description']);
            $data['region'] = trim($_POST['region']);
            $data['unit_type'] = trim($_POST['unit_type']);
            $data['price'] = trim($_POST['price']);
            $data['available'] = trim($_POST['available']);
            $data['image'] = '';

            // Check seller exists
            if (!$this->addProductModel->sellerExists($data['seller_id'])) {
                $data['error'] = '⚠ Seller ID not found. Please enter a valid seller.';
            } else {
                // Image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $filename = basename($_FILES['image']['name']);
                    $target = 'uploads/' . $filename;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                        $data['image'] = $filename;
                    } else {
                        $data['error'] = '❌ Failed to upload image.';
                    }
                }

                // Insert product if no errors
                if (empty($data['error'])) {
                    if ($this->addProductModel->addProduct($data)) {
                        $data['success'] = '✅ Product added successfully!';
                        // Reset form
                        foreach($data as $key => $val) {
                            if ($key != 'success' && $key != 'error') $data[$key] = '';
                        }
                    } else {
                        $data['error'] = '❌ Failed to add product.';
                    }
                }
            }
        }

        $this->view('seller/addProduct', $data);
    }
}
?>
