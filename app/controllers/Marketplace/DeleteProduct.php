<?php
class DeleteProduct extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = $this->model('M_Marketplace/M_DeleteProduct', new Database());
    }

        // Add this
    public function index($id = null) {
        if ($id === null) {
            redirect('Marketplace/manageProducts');
        }
        $this->delete_product($id);
    }

    public function delete_product($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productModel->deleteProduct($id)) {
                flash('product_message', 'Product Deleted Successfully ✅');
                redirect('Marketplace/ManageProduct');
            } else {
                flash('product_message', 'Something went wrong ❌');
                redirect('Marketplace/ManageProduct');
            }
        } else {
            // Show confirmation view (delete.php)
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                redirect('Marketplace/ManageProduct');
            }
            $this->view('marketplace/V_deleteProduct', $product);
        }
    }
}

?>