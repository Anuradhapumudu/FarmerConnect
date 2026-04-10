<?php
class officerYellowCase extends Controller {
    
    private $yellowCaseModel;

    public function __construct() {
        $this->yellowCaseModel = $this->model('YellowCaseModel');
    }

    public function index() {
        $cases = $this->yellowCaseModel->getAllCases();
        
        $data = [
            'cases' => $cases
        ];
        
        $this->view('officer/officerYellowCase', $data);
    }
}
?>