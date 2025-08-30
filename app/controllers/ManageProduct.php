<?php
class ManageProduct extends Controller {
    private $manageProductModel;

    public function __construct() {
        // Pass the Database object to the model
        $this->manageProductModel = $this->model('Product', new Database());
    }

    public function index() {
        $seller_id = 1; // Example seller ID, you can get this from session
        $products = $this->manageProductModel->getProductsBySeller($seller_id);

        $data = ['products' => $products];
        $this->view('seller/manageProduct', $data);
    }
}
?>
