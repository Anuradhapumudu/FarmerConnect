<?php
class DeleteProduct extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = $this->model('M_DeleteProduct');
    }

    public function delete_product($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productModel->deleteProduct($id)) {
                flash('product_message', 'Product Deleted Successfully ✅');
                redirect('Marketplace/manageProducts');
            } else {
                flash('product_message', 'Something went wrong ❌');
                redirect('Marketplace/manageProducts');
            }
        } else {
            // Show confirmation view (delete.php)
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                redirect('Marketplace/manageProducts');
            }
            $this->view('marketplace/deleteProduct', $product);
        }
    }
}

?>