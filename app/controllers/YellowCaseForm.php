<?php
class YellowCaseForm extends Controller {
    
    private $yellowCaseModel;

    public function __construct() 
    {
        $this->yellowCaseModel = $this->model('YellowCaseModel');
    }

    public function index() 
    {
       
        $this->view('farmer/YellowCaseForm');
    }

    private function generateCaseID()
    {
        return 'YC-' . date('YmdHis') . '-' . strtoupper(bin2hex(random_bytes(2)));
    }

    public function show($caseId = null) {
        if (!$caseId) {
            header('Location: ' . URLROOT . '/YellowCaseList');
            exit;
        }

        $case = $this->yellowCaseModel->getByCaseId($caseId);

        if (!$case) {
            die('Case not found');
        }

        $data = [
            'case' => $case
        ];

        $this->view('farmer/Yellowcaseview', $data);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('yellowcase');
            return;
        }

        // ✅ Get farmer data from POST or SESSION
        $farmerNIC = $_POST['farmerNIC'] ?? $_SESSION['nic'] ?? null;
        $plrNumber = $_POST['plrNumber'] ?? $_SESSION['selected_plr'] ?? null;

        if (!$farmerNIC || !$plrNumber) {
            die('Session expired or missing PLR number. Please try again.');
        }

        // ✅ Generate Case ID
        $caseId = $this->generateCaseID();
        $observationDate = !empty($_POST['observationDate']) ? $_POST['observationDate'] : date('Y-m-d');
        $caseTitle = trim($_POST['caseTitle'] ?? '');
        $caseDescription = trim($_POST['caseDescription'] ?? '');

        // ✅ Collect form data
        $data = [
            'case_id'          => $caseId,
            'farmer_nic'       => $farmerNIC,
            'plr_number'       => $plrNumber,
            'observation_date' => $observationDate,
            'submitted_date'   => date('Y-m-d'),
            'case_title'       => $caseTitle,
            'case_description' => $caseDescription,
            'media'            => null
        ];

        $data['media'] = null; // Default to null instead of string 'null'

        if (!empty($_FILES['media']['name'][0])) {
            $uploadedFiles = [];
            $uploadErrors = [];

            $uploadDir = APPROOT . '/../public/uploads/yellow_cases/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['media']['name'] as $key => $name) {
                $error = $_FILES['media']['error'][$key];
                
                if ($error === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['media']['tmp_name'][$key];
                    $fileName = time() . '_' . basename($name);
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedFiles[] = $fileName;
                    } else {
                        $uploadErrors[] = "Failed to move uploaded file: $name";
                    }
                } else if ($error !== UPLOAD_ERR_NO_FILE) {
                    $uploadErrors[] = "Upload error code $error for file: $name";
                }
            }

            if (!empty($uploadErrors)) {
                die("File Upload Errors: " . implode(", ", $uploadErrors));
            }

            if (!empty($uploadedFiles)) {
                $data['media'] = json_encode($uploadedFiles);
            }
        }

        // ✅ Save to DB
        if ($this->yellowCaseModel->create($data)) {
             header('Location:'.URLROOT.'/YellowCaseList'); // Redirect to the same page
        exit();
        } else {
            die('Failed to submit Yellow Case');
        }
    }
}

?>