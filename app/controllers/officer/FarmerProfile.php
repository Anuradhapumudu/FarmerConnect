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

public function open()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $_SESSION['view_farmer_nic'] = $_POST['nic'];
        $_SESSION['selected_plr'] = $_POST['selected_plr'] ?? null;

        header("Location: " . URLROOT . "/officer/FarmerProfile/show");
        exit();
    }
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

public function editPLR()
{
    $plr = $_POST['plr'] ?? null;

    if (!$plr) {
        die("Invalid request");
    }

    $paddy = $this->paddyModel->getPaddyByPLR($plr);

    if (!$paddy) {
        die("Paddy not found");
    }

    $data = [
        'paddy' => $paddy
    ];

    $this->view('officer/editpaddy', $data);
}

public function updatePLR()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Invalid request");
    }

    if (empty($_POST['plr']) || empty($_POST['Paddy_Size'])) {
        die("Missing required data");
    }

    $data = [
        'PLR' => $_POST['plr'],
        'NIC' => $_POST['nic'],
        'Paddy_Seed_Variety' => $_POST['Paddy_Seed_Variety'],
        'Paddy_Size' => $_POST['Paddy_Size'],
        'Province' => $_POST['Province'],
        'District' => $_POST['District'],
        'Govi_Jana_Sewa_Division' => $_POST['Govi_Jana_Sewa_Division'],
        'Grama_Niladhari_Division' => $_POST['Grama_Niladhari_Division'],
        'Yaya' => $_POST['Yaya'],
        'OfficerID' => $_SESSION['officer_id']
    ];

    $this->paddyModel->updatePaddy($data);

    $_SESSION['view_farmer_nic'] = $_POST['nic'];
    $_SESSION['selected_plr'] = $_POST['plr'];

    header("Location: " . URLROOT . "/officer/FarmerProfile/show");
    exit();
}

}

?>