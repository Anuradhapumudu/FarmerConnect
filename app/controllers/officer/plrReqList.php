<?php
class plrReqList extends Controller {

    private $model;

    public function __construct() {
        $this->model = $this->model('plrReqModel');
    }

    public function index() {

        $division = $_SESSION['govi_jana_sewa_division'];
    
        $search = $_GET['search'] ?? null;

        if ($search) {
            $pending = $this->model->searchPending($division, $search);
            $history = $this->model->searchHistory($division, $search);
        } else {
            $pending = $this->model->getPendingRequests($division);
            $history = $this->model->getHistoryRequests($division);
        }
            //var_dump($officerDivision); // Debugging line
       // var_dump($officerID);
        //exit(); // Stop execution after dumping

        $data = [
            'pending' => $pending,
            'history' => $history
        ];

        $this->view('officer/plrReqList', $data);
    }

    public function show($id)
    {
        // Get request by ID
        $request = $this->model->getRequestById($id);

        if (!$request) {
            die("Request not found");
        }

        $data = [
            'request' => $request
        ];

        $this->view('officer/plrReqView', $data);
    }

    // ✅ Approve request
    public function approve($id)
    {
        $result = $this->model->approveRequest($id);

        if ($result['status'] == 'exists') {

            $_SESSION['error'] = "PLR already exists!<br>
            NIC: {$result['nic']}<br>
            Name: {$result['name']}";

            header("Location: " . URLROOT . "/officer/plrReqList/show/$id");
            exit();
        }

        $_SESSION['success'] = "Request approved successfully!";

        header("Location: " . URLROOT . "/officer/plrReqList");
        exit();
    }

    // ✅ Reject request
    public function reject($id)
    {
        $this->model->rejectRequest($id);

        header("Location: " . URLROOT . "/officer/plrReqList");
        exit();
    }
}
?>