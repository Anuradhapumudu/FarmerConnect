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
    $nic = $_POST['nic'] ?? $_SESSION['view_farmer_nic'] ?? null;

    if (!$nic) {
        die("NIC missing");
    }

    $_SESSION['view_farmer_nic'] = $nic;

    $farmer = $this->farmerModel->getFarmerByNIC($nic);
    $paddies = $this->paddyModel->getPaddyByNIC($nic);

    // ✅ SELECTED PLR
    $selectedPLR = $_POST['selected_plr'] ?? ($paddies[0]->PLR ?? null);

    $data = [
        'farmer' => $farmer,
        'paddies' => $paddies,
        'selectedPLR' => $selectedPLR
    ];

    $this->view('officer/farmerProfileView', $data);
}

    // ✅ DELETE PLR (officer)
public function deletePLR()
{
    $plr = $_POST['plr'];

    $this->paddyModel->deletePaddyByPLR($plr);

    $_SESSION['success'] = "PLR deleted successfully by officer";

    // ✅ redirect back to profile (NOT referer)
    header("Location: " . URLROOT . "/officer/FarmerProfile/show");
    exit();
}
}

?>