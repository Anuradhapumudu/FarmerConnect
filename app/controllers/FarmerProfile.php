<?php

class FarmerProfile extends Controller {

    private $farmerModel;
    private $paddyModel;

    public function __construct() {
        $this->farmerModel = $this->model('Farmer');
        $this->paddyModel = $this->model('Paddy');
    }

    // Display Farmer Profile and Paddy List
    public function index() {
        $dummyNIC = '200011223344';
        $dummyName = 'K.R.Aberathna';

        // Get farmer details
        $farmer = $this->farmerModel->getFarmerByNIC($dummyNIC);

        if (!$farmer) {
            $this->farmerModel->updateFarmer([
                'NIC' => $dummyNIC,
                'Address' => '',
                'TelNo' => '',
                'Birthday' => '',
                'Gender' => ''
            ]);
            $farmer = (object)[
                'NIC' => $dummyNIC,
                'Name' => $dummyName,
                'Address' => '',
                'TelNo' => '',
                'Birthday' => '',
                'Gender' => ''
            ];
        } else {
            $farmer->Name = $dummyName;
        }

        // Get all paddy rows for this farmer
        $paddyList = $this->paddyModel->getPaddyByNIC($dummyNIC);

        $data = [
            'farmer' => $farmer,
            'paddyFields' => $paddyList
        ];

        $this->view('farmer/FarmerProfile', $data);
    }

    // Update Farmer Profile
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'NIC' => trim($_POST['NIC']),
                'Address' => trim($_POST['Address']),
                'TelNo' => trim($_POST['TelNo']),
                'Birthday' => trim($_POST['Birthday']),
                'Gender' => trim($_POST['Gender'])
            ];

            $this->farmerModel->updateFarmer($data);
            header('Location: ' . URLROOT . '/farmerprofile/index');
            exit;
        }
    }

    // Save or Update Paddy
    public function savePaddy() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'PLR' => trim($_POST['PLR']),
                'NIC' => trim($_POST['NIC']),
                'OfficerID' => 1111, // constant for now
                'Paddy_Seed_Variety' => trim($_POST['Paddy_Seed_Variety']),
                'Paddy_Size' => trim($_POST['Paddy_Size']),
                'Province' => trim($_POST['Province']),
                'District' => trim($_POST['District']),
                'Govi_Jana_Sewa_Division' => trim($_POST['Govi_Jana_Sewa_Division']),
                'Grama_Niladhari_Division' => trim($_POST['Grama_Niladhari_Division']),
                'Yaya' => trim($_POST['Yaya'])
            ];

            $this->paddyModel->savePaddy($data);
            header('Location: ' . URLROOT . '/farmerprofile/index');
            exit;
        }
    }

    // Fetch Paddy row by PLR for editing
    public function getPaddy($plr) {
        $paddy = $this->paddyModel->getPaddyByPLR($plr);
        echo json_encode($paddy);
    }
}
