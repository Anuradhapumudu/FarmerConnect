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

        // Convert object to array and set defaults
        $product = (array)$product;
        $defaults = [
            'brand' => '',
            'discount' => 0,
            'discount_price' => 0,
            'expiration_date' => ''
        ];
        $product = array_merge($defaults, $product);

        // Handle POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product['item_name'] = trim($_POST['item_name']);
            $product['category'] = trim($_POST['category']);
            $product['brand'] = trim($_POST['brand']);
            $product['price_per_unit'] = trim($_POST['price_per_unit']);
            $product['discount'] = trim($_POST['discount']);
            $product['discount_price'] = trim($_POST['discount_price']);
            $product['description'] = trim($_POST['description']);
            $product['expiration_date'] = trim($_POST['expiration_date']);
            $product['available_quantity'] = trim($_POST['available_quantity']);

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $filename = basename($_FILES['image']['name']);
                $target = 'uploads/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $product['image_url'] = $filename;
                } else {
                    $product['error'] = '❌ Failed to upload image.';
                }
            } else {
                $product['image_url'] = $_POST['current_image'];
            }

            if (empty($product['error'])) {
                if ($this->editProductModel->updateProduct($product)) {
                    header('Location: ' . URLROOT . '/products/manage');
                    exit;
                } else {
                    $product['error'] = '❌ Failed to update product.';
                }
            }
        }

        $this->view('seller/editProduct', ['product' => $product]);
    }
}
?>
