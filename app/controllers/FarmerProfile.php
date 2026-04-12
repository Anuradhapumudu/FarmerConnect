<?php

class FarmerProfile extends Controller
{
    private $farmerModel;
    private $paddyModel;

    public function __construct()
    {
            // Ensure session started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // ✅ Check if logged-in and correct user type
            if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'farmer') {
                header('Location: ' . URLROOT . '/users/login');
                exit;
            }

        $this->farmerModel = $this->model('Farmer');
        $this->paddyModel = $this->model('Paddy');
    }

    // Display Farmer Profile and Paddy List

    public function index()
{
    $farmerNIC = $_SESSION['nic']; // from session after login

    // Get farmer details
    $farmer = $this->farmerModel->getFarmerByNIC($farmerNIC);

    if (!$farmer) {
        // If first login and farmer not in table yet, create one
        $this->farmerModel->updateFarmer([
            'NIC' => $farmerNIC,
            'Name' => 'Unknown Farmer', // You can replace this if you store names separately
            'Address' => '',
            'TelNo' => '',
            'Birthday' => '',
            'Gender' => ''
        ]);

        $farmer = (object)[
            'nic' => $farmerNIC,
            'full_name' => 'Unknown Farmer',
            'address' => '',
            'phone_no' => '',
            'birthdate' => '',
            'gender' => ''
        ];
    }

    $requests = $this->paddyModel->getRequestsByNIC($farmerNIC);

    // Get all paddy rows for this farmer
    $paddyList = $this->paddyModel->getPaddyByNIC($farmerNIC);

    $data = [
        'farmer' => $farmer,
        'paddyFields' => $paddyList,
        'requests' => $requests
    ];

    $this->view('farmer/FarmerProfile', $data);
}


    // Update Farmer Profile

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
            $data['Name'] = $existingFarmer->full_name ?? '';

            
            // TelNo validation (server-side)
            
            if (empty($data['TelNo'])) {
                $data['errors']['TelNo'] = 'Telephone number is required.';
            } else {
                // Sri Lanka example: start with +94 or 0 then mobile(7xxxxxxxx) or landline(1xxxxxxxx etc)
                $pattern = '/^(?:\+94|0)(7\d{8}|1\d{8})$/';
                if (!preg_match($pattern, $data['TelNo'])) {
                    $data['errors']['TelNo'] = 'Invalid telephone number format. Use 0711234567 or +94711234567.';
                }
            }

        
            // Birthday validation (server-side)
            
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

                
                // Address validation
                
                if (empty($data['Address'])) {
                    $data['errors']['Address'] = 'Address is required.';
                }

                
                // Gender validation
                
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



    
    // Save or Update Paddy
    
        public function savePaddy()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'PLR' => trim($_POST['PLR']),
                    'NIC' => $_SESSION['nic'],
                    'OfficerID' => 'O2', // constant for now
                    'Paddy_Seed_Variety' => trim($_POST['Paddy_Seed_Variety']),
                    'Paddy_Size' => trim($_POST['Paddy_Size']),
                    'Province' => trim($_POST['Province']),
                    'District' => trim($_POST['District']),
                    'Govi_Jana_Sewa_Division' => trim($_POST['Govi_Jana_Sewa_Division']),
                    'Grama_Niladhari_Division' => trim($_POST['Grama_Niladhari_Division']),
                    'Yaya' => trim($_POST['Yaya']),
                    'errors' => []
                ];

                
                // ✅ Step 1: Validate PLR Number
                
                $plrPattern = '/^\d{2}\/\d{2}\/\d{5}\/\d{3}\/[A-Za-z]\/\d{4}$/';

                if (empty($data['PLR'])) {
                    $data['errors']['PLR'] = 'PLR number is required.';
                } elseif (!preg_match($plrPattern, $data['PLR'])) {
                    $data['errors']['PLR'] = 'Invalid PLR format. Use format: 02/25/00083/001/P/0066';
                }

                // Paddy Size validation
                if (empty($data['Paddy_Size'])) {
                    $data['errors']['Paddy_Size'] = 'Paddy size is required.';
                } elseif (!is_numeric($data['Paddy_Size']) || $data['Paddy_Size'] <= 0) {
                    $data['errors']['Paddy_Size'] = 'Paddy size must be a positive number greater than 0.';
                }
                

                
                
                //  Step 2: Check for error
                if (!empty($data['errors'])) {
                    // Load farmer details again for re-render
                    $farmer = $this->farmerModel->getFarmerByNIC($data['NIC']);
                    $data['farmer'] = $farmer;
                    $data['paddyFields'] = $this->paddyModel->getPaddyByNIC($data['NIC']);

                    // Return to the same view with error messages
                    $this->view('farmer/FarmerProfile', $data);
                    return;
                }

                // 🔍 CHECK SAME FARMER + SAME PLR
                $this->db = new Database();

                $this->db->query("
                    SELECT status 
                    FROM paddy_requests 
                    WHERE PLR = :plr AND NIC_FK = :nic
                    ORDER BY created_at DESC
                    LIMIT 1
                ");

                $this->db->bind(':plr', $data['PLR']);
                $this->db->bind(':nic', $data['NIC']);

                $existing = $this->db->single();

                if ($existing) {

                    if ($existing->status == 'pending') {
                        $_SESSION['message'] = "You already have a pending request for this PLR.";
                        header('Location: ' . URLROOT . '/farmerprofile/index');
                        exit;
                    }

                    if ($existing->status == 'approved') {
                        $_SESSION['message'] = "This PLR is already approved under your name.";
                        header('Location: ' . URLROOT . '/farmerprofile/index');
                        exit;
                    }

                    // ✅ if rejected → allow
                }
                //  Step 3: Save only if valid
                
                $this->paddyModel->savePaddyRequest($data);

                $_SESSION['message'] = "Paddy registration sent for approval!";

                header('Location: ' . URLROOT . '/farmerprofile/index');
                exit;
            }
        }

    
    // Fetch Paddy row by PLR for editing

    public function getPaddy()
    {
        $plr = $_GET['plr'] ?? '';
        $paddy = $this->paddyModel->getPaddyByPLR($plr);
        echo json_encode($paddy);
    }

    
    // Get Agrarian Centers by District
    
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

    
    // Delete Paddy row by PLR
    
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

    
    // Upload Profile Picture
    
    public function uploadProfilePic()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
            $nic = $_SESSION['nic'];
            $file = $_FILES['profile_image'];

            // Check for upload errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'message' => 'Upload error.']);
                return;
            }

            // Validate file type
            $allowed = ['jpg', 'jpeg', 'png'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                echo json_encode(['success' => false, 'message' => 'Only JPG and PNG allowed.']);
                return;
            }

            // Create upload directory if not exists
            $uploadDir = APPROOT . '/../public/uploads/farmer_profiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Unique file name
            $fileName = 'farmer_' . $nic . '.' . $ext;
            $filePath = $uploadDir . $fileName;

            //  If file already exists, remove it first
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Move file
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Save relative path in DB
                $relativePath = '/uploads/farmer_profiles/' . $fileName;
                $this->farmerModel->updateProfilePic($nic, $relativePath);
                echo json_encode(['success' => true, 'image' => URLROOT . $relativePath]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save file.']);
            }
        }
    }

    
    // Remove Profile Picture
    
    public function removeProfilePic()
    {
        $nic = $_SESSION['nic'];
        $farmer = $this->farmerModel->getFarmerByNIC($nic);

        if (!empty($farmer->profile_image)) {
            //  Correct path to the public folder
            $filePath = APPROOT . '/../public' . $farmer->profile_image;

            if (file_exists($filePath)) {
                unlink($filePath); // delete file from folder
            }

            //  Clear DB entry
            $this->farmerModel->updateProfilePic($nic, NULL);
        }

        echo json_encode(['success' => true]);
    }
}

