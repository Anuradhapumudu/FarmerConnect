
<?php
class FarmerDashboard extends Controller {

    public function __construct() {
        Auth::checkRole('farmer');
    }

    public function index() {
        $this->view('dashboard/farmer');
    }
}
?>
