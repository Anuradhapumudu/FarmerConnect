<?php
class FarmerProfile extends Controller {

    private $farmerModel;
    private $paddyModel;

    public function __construct() {
        $this->farmerModel = $this->model('Farmer');
        $this->paddyModel = $this->model('Paddy');
    }

public function show()
{
    //  If POST → save to session and REDIRECT
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $_SESSION['view_farmer_nic'] = $_POST['nic'];
        $_SESSION['selected_plr'] = $_POST['selected_plr'] ?? null;

        header("Location: " . URLROOT . "/officer/FarmerProfile/show");
        exit();
    }

    //  Now ONLY GET requests reach here
    $nic = $_SESSION['view_farmer_nic'] ?? null;

    if (!$nic) {
        die("NIC missing");
    }

    $farmer = $this->farmerModel->getFarmerByNIC($nic);
    $paddies = $this->paddyModel->getPaddyByNIC($nic);

    $selectedPLR = $_SESSION['selected_plr'] ?? ($paddies[0]->PLR ?? null);

    $data = [
        'farmer' => $farmer,
        'paddies' => $paddies,
        'selectedPLR' => $selectedPLR
    ];

    $this->view('officer/farmerProfileView', $data);
}

    //  DELETE PLR (officer)
public function deletePLR()
{
    $plr = $_POST['plr'];

    $this->paddyModel->deletePaddyByPLR($plr);

    $_SESSION['success'] = "PLR deleted successfully by officer";

    //  redirect back to profile (NOT referer)
    header("Location: " . URLROOT . "/officer/FarmerProfile/show");
    exit();
}
}

?>