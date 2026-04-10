<?php
class AdminDashboard extends Controller {

    public function __construct() {
        Auth::checkAdmin();
    }

    public function index() {
        $this->view('dashboard/admin');
    }
}
?>