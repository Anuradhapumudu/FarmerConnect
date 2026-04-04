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

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('yellowcase');
            return;
        }

        // ✅ Get farmer data from SESSION
        $farmerNIC = $_SESSION['nic'] ?? null;
        $plrNumber = $_SESSION['selected_plr'] ?? null;

var_dump($farmerNIC, $plrNumber);

        if (!$farmerNIC || !$plrNumber) {
            die('Session expired. Please login again.');
        }

        // ✅ Generate Case ID
        $caseId = $this->generateCaseID();
        $observationDate = $_POST['observationDate'] ?? null;
        $caseTitle = trim($_POST['caseTitle'] ?? '');
        $caseDescription = trim($_POST['caseDescription'] ?? '');

// Debug the POST values
//var_dump($caseId,$observationDate, $caseTitle, $caseDescription);


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

        var_dump($data);

        // ✅ Handle media upload (basic, safe version)
        if (!empty($_FILES['media']['name'][0])) {
            $uploadedFiles = [];

            $uploadDir = APPROOT . '/../public/uploads/yellow_cases/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['media']['name'] as $key => $name) {
                $tmpName = $_FILES['media']['tmp_name'][$key];
                $fileName = time() . '_' . basename($name);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $uploadedFiles[] = $fileName;
                }
            }

            $data['media'] = json_encode($uploadedFiles);
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