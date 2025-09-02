<?php
class ViewProduct extends Controller {
    private $viewproductModel;

    public function __construct() {
        $this->viewproductModel = $this->model('M_ViewProduct', new Database());
    }

    // Index page (fertilizer listing)
    public function index() {
        $products = $this->viewproductModel->getProductsByCategory('fertilizer');

        $data = [
            'products' => $products
        ];

        $this->view('farmer/marketplace', $data);
    }
}
