<?php

class FarmerProfile extends Controller
{
    private $farmerModel;
    private $paddyModel;

    public function __construct()
    {
        $this->farmerModel = $this->model('Farmer');
        $this->paddyModel = $this->model('Paddy');
    }

    // --------------------------------------------------------
    // Display Farmer Profile and Paddy List
    // --------------------------------------------------------
    public function index()
    {
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

    // --------------------------------------------------------
    // Update Farmer Profile
    // --------------------------------------------------------
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Sanitize input
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'NIC' => trim($_POST['NIC'] ?? ''),
                'Address' => trim($_POST['Address'] ?? ''),
                'TelNo' => trim($_POST['TelNo'] ?? ''),
                'Birthday' => trim($_POST['Birthday'] ?? ''),
                'Gender' => trim($_POST['Gender'] ?? ''),
                'errors' => []
            ];

            // Ensure we have the farmer Name (updateFarmer expects Name)
            // Try to fetch existing farmer from DB to preserve Name if not sent in form
            $existingFarmer = $this->farmerModel->getFarmerByNIC($data['NIC']);
            $data['Name'] = $existingFarmer->Name ?? '';

            // -------------------------
            // TelNo validation (server-side)
            // -------------------------
            if (empty($data['TelNo'])) {
                $data['errors']['TelNo'] = 'Telephone number is required.';
            } else {
                // Sri Lanka example: start with +94 or 0 then mobile(7xxxxxxxx) or landline(1xxxxxxxx etc)
                $pattern = '/^(?:\+94|0)(7\d{8}|1\d{8})$/';
                if (!preg_match($pattern, $data['TelNo'])) {
                    $data['errors']['TelNo'] = 'Invalid telephone number format. Use 0711234567 or +94711234567.';
                }
            }

            // -------------------------
            // Birthday validation (server-side)
            // -------------------------
            if (empty($data['Birthday'])) {
                $data['errors']['Birthday'] = 'Birthday is required.';
            } else {
                $birthdayTimestamp = strtotime($data['Birthday']);
                $today = strtotime(date('Y-m-d'));

                if ($birthdayTimestamp === false) {
                    $data['errors']['Birthday'] = 'Invalid date format.';
                } elseif ($birthdayTimestamp > $today) {
                    $data['errors']['Birthday'] = 'Birthday cannot be in the future.';
                }
            }

                // -------------------------
                // Address validation
                // -------------------------
                if (empty($data['Address'])) {
                    $data['errors']['Address'] = 'Address is required.';
                }

                // -------------------------
                // Gender validation
                // -------------------------
                if (empty($data['Gender'])) {
                    $data['errors']['Gender'] = 'Gender is required.';
                }

            // If validation failed, reload view with errors and current farmer data
            if (!empty($data['errors'])) {
                // Provide farmer object for the view (so other fields still show)
                $farmerObj = $existingFarmer ? $existingFarmer : (object)[
                    'NIC' => $data['NIC'],
                    'Name' => $data['Name'],
                    'Address' => $data['Address'],
                    'TelNo' => $data['TelNo'],
                    'Birthday' => $data['Birthday'],
                    'Gender' => $data['Gender']
                ];

                $viewData = [
                    'farmer' => $farmerObj,
                    'errors' => $data['errors'],
                    'paddyFields' => $this->paddyModel->getPaddyByNIC($data['NIC'])
                ];

                $this->view('farmer/FarmerProfile', $viewData);
                return; // Stop here, do not update
            }

            // All good — update farmer
            $updateData = [
                'NIC' => $data['NIC'],
                'Name' => $data['Name'],
                'Address' => $data['Address'],
                'TelNo' => $data['TelNo'],
                'Birthday' => $data['Birthday'],
                'Gender' => $data['Gender']
            ];

            $this->farmerModel->updateFarmer($updateData);
            header('Location: ' . URLROOT . '/farmerprofile/index');
            exit;
        }
    }



    // --------------------------------------------------------
    // Save or Update Paddy
    // --------------------------------------------------------
        public function savePaddy()
        {
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
                    'Yaya' => trim($_POST['Yaya']),
                    'errors' => []
                ];

                // ------------------------------
                // ✅ Step 1: Validate PLR Number
                // ------------------------------
                $plrPattern = '/^\d{2}\/\d{2}\/\d{5}\/\d{3}\/[A-Za-z]\/\d{4}$/';

                if (empty($data['PLR'])) {
                    $data['errors']['PLR'] = 'PLR number is required.';
                } elseif (!preg_match($plrPattern, $data['PLR'])) {
                    $data['errors']['PLR'] = 'Invalid PLR format. Use format: 02/25/00083/001/P/0066';
                }

                // ✅ Paddy Size validation
                if (empty($data['Paddy_Size'])) {
                    $data['errors']['Paddy_Size'] = 'Paddy size is required.';
                } elseif (!is_numeric($data['Paddy_Size']) || $data['Paddy_Size'] <= 0) {
                    $data['errors']['Paddy_Size'] = 'Paddy size must be a positive number greater than 0.';
                }
                

                // 🔸 You can add other field validations here if needed
                // Example:
                // if (empty($data['Paddy_Size'])) {
                //     $data['errors']['Paddy_Size'] = 'Paddy size is required.';
                // }

                // ------------------------------
                // ✅ Step 2: Check for errors
                // ------------------------------
                if (!empty($data['errors'])) {
                    // Load farmer details again for re-render
                    $farmer = $this->farmerModel->getFarmerByNIC($data['NIC']);
                    $data['farmer'] = $farmer;
                    $data['paddyFields'] = $this->paddyModel->getPaddyByNIC($data['NIC']);

                    // Return to the same view with error messages
                    $this->view('farmer/FarmerProfile', $data);
                    return;
                }

                // ------------------------------
                // ✅ Step 3: Save only if valid
                // ------------------------------
                $this->paddyModel->savePaddy($data);

                header('Location: ' . URLROOT . '/farmerprofile/index');
                exit;
            }
        }

    // --------------------------------------------------------
    // Fetch Paddy row by PLR for editing
    // --------------------------------------------------------
    public function getPaddy()
    {
        $plr = $_GET['plr'] ?? '';
        $paddy = $this->paddyModel->getPaddyByPLR($plr);
        echo json_encode($paddy);
    }

    // --------------------------------------------------------
    // Get Agrarian Centers by District
    // --------------------------------------------------------
    public function getCenters()
    {
        $district = $_GET['district'] ?? '';

        if ($district) {
            $db = new Database();
            $db->query("
                SELECT center_name 
                FROM agrarian_service_centers 
                INNER JOIN districts 
                ON agrarian_service_centers.district_id = districts.district_id 
                WHERE districts.district_name = :district
            ");
            $db->bind(':district', $district);
            $centers = $db->resultSet();
            echo json_encode($centers);
        } else {
            echo json_encode([]);
        }
    }

    // --------------------------------------------------------
    // Delete Paddy row by PLR
    // --------------------------------------------------------
    public function deletePaddy()
    {
        $plr = $_GET['plr'] ?? '';

        if ($plr) {
            $deleted = $this->paddyModel->deletePaddyByPLR($plr);
            echo json_encode(['success' => $deleted]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
