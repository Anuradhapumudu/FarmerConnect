<?php
class YellowCaseList extends Controller {
    
    private $yellowCaseModel;

    public function __construct() {
        $this->yellowCaseModel = $this->model('YellowCaseModel');
    }

    public function index() {
       
        $farmerNIC = $_SESSION['nic'] ?? null; 
        
        if (!$farmerNIC) 
        {
            die('Session expired. Please login again.');
        }

        // Get all yellow cases for this farmer
        $cases = $this->yellowCaseModel->getByFarmer($farmerNIC);

        // Pass data to view
        $data = [
            'cases' => $cases
        ];

        $this->view('farmer/YellowCaseList', $data);
    }
}
?>