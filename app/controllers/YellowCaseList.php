<?php

class YellowCaseList extends Controller {


public function index() {

    $plr = $_POST['plr'] ?? null;
    $nic = $_SESSION['farmer_nic'] ?? null;

    $data = [
        'plr' => $plr,
        'nic' => $nic
    ];

    $this->view('farmer/YellowCaseList', $data);
}
}
?>