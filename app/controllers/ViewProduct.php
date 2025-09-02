<?php
class ViewProduct extends Controller {
    private $viewproductModel;

    public function __construct() {
        $this->viewproductModel = $this->model('M_ViewProduct', new Database());
    }

    public function index() {
        // call the method that exists in your model
        $products = $this->viewproductModel->getFertilizerProducts();

        $data = [
            'category' => 'Fertilizer',
            'products' => $products
        ];

        $this->view('farmer/viewproduct', $data);
    }
}
?>
