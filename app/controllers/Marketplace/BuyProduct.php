<?php
class BuyProduct extends Controller {
    private $buyProductModel;

    public function __construct() {
        $this->buyProductModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }

    public function index($id = 0) {
        if ($id == 0) {
            die("Invalid product ID");
        }

        $product = $this->buyProductModel->getProductById($id);
        if (!$product) {
            die("Product not found");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'] ?? 1;
            $farmer_id = $_SESSION['farmer_id'] ?? 17; // dummy farmer
            $total_price = $product->price_per_unit * $quantity;

            $this->buyProductModel->createOrder($farmer_id, $id, $quantity, $total_price);

            $newQty = $product->available_quantity - $quantity;
            $this->buyProductModel->updateStock($id, $newQty);

            redirect('myorders'); // helper function for redirect
        }

        $data = [
            'product' => $product
        ];

        $this->view('marketplace/V_buyproduct', $data);
    }
}
