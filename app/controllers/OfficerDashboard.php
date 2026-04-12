<?php
class OfficerDashboard extends Controller
{
    public function __construct()
    {
        Auth::checkRole('officer');
    }

    public function index()
    {
        $this->view('dashboard/officer');
    }
}
?>
