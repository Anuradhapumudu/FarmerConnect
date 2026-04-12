<?php
class SellerDashboard extends Controller {

    public function __construct() {
        Auth::checkRole('seller');
    }

    public function index() {
        $this->view('dashboard/seller');
    }
}
?>