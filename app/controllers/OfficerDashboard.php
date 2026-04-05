<?php
class OfficerDashboard extends Controller
{


    public function __construct()
    {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'officer') {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }
    }

    public function index()
    {
        $this->view('dashboard/officer');
    }
}
?>