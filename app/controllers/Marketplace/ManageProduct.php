<?php
class ManageProduct extends Controller {
    private $manageProductModel;

    public function __construct() {
        // Pass the Database object to the model
        $this->manageProductModel = $this->model('M_Marketplace/M_ManageProduct', new Database());
    }

    public function index() {
        $seller_id = 1; // Example seller ID, you can get this from session

        //getsellerfromsession
        /*   $seller_id = $_SESSION['seller_id'] ?? 0;
    if ($seller_id == 0) {
        die("Unauthorized access");
    }*/
        
        $products = $this->manageProductModel->getProductsBySeller($seller_id);

        $data = ['products' => $products];
        $this->view('marketplace/V_manageProduct', $data);
    }
}
?>
