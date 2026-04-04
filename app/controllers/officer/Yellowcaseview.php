<?php
class Yellowcaseview extends Controller {
    
    private $yellowCaseModel;

    public function __construct() {
        $this->yellowCaseModel = $this->model('YellowCaseModel');
    }

    public function index($caseId = null) {
        $this->showCaseDetails($caseId);
    }

    public function show($caseId = null) {
        $this->showCaseDetails($caseId);
    }

    // fallback in case the view href was generated as /officer/Yellowcaseview/view/...
    public function viewAction($caseId = null) {
        $this->showCaseDetails($caseId);
    }

    private function showCaseDetails($caseId) {
        if (!$caseId) {
            header('Location: ' . URLROOT . '/officer/officerYellowCase');
            exit;
        }

        $case = $this->yellowCaseModel->getByCaseId($caseId);

        if (!$case) {
            die('Case not found');
        }

        $data = [
            'case' => $case
        ];

        $this->view('officer/Yellowcaseview', $data);
    }
}
?>