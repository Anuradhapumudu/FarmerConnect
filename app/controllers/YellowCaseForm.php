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

//var_dump($farmerNIC, $plrNumber);

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

       // var_dump($data);

        // ✅ Handle media upload (basic, safe version)
        $uploadedFiles = [];

        if (!empty($_FILES['media']['name'][0])) {

            $uploadDir = APPROOT . '/../public/uploads/yellow_cases/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/jpg',
                'video/mp4'
            ];

            $maxSize = 10 * 1024 * 1024; // 10MB

            foreach ($_FILES['media']['name'] as $key => $name) {

                $tmpName = $_FILES['media']['tmp_name'][$key];
                $fileSize = $_FILES['media']['size'][$key];
                $fileType = mime_content_type($tmpName);
                $error = $_FILES['media']['error'][$key];

                if ($error !== 0) continue;

                // ✅ Validate file type
                if (!in_array($fileType, $allowedTypes)) {
                    continue; // skip invalid files
                }

                // ✅ Validate file size
                if ($fileSize > $maxSize) {
                    continue;
                }

                // ✅ Generate safe file name
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $safeName = uniqid('media_', true) . '.' . $extension;

                $targetPath = $uploadDir . $safeName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $uploadedFiles[] = $safeName;
                }
            }

            $data['media'] = !empty($uploadedFiles) ? json_encode($uploadedFiles) : null;
        }

        // ✅ Save to DB
        if ($this->yellowCaseModel->create($data)) {
             header('Location:'.URLROOT.'/YellowCaseList'); // Redirect to the same page
        exit();
        } else {
            die('Failed to submit Yellow Case');
        }
    }
    
    public function view($caseId)
    {
        $farmerNIC = $_SESSION['nic'] ?? null;

        if (!$farmerNIC) {
            die('Session expired');
        }

        // Get single case
        $case = $this->yellowCaseModel->getByCaseId($caseId);

        // Security check
        if (!$case || $case->farmer_nic !== $farmerNIC) {
            die('Unauthorized access');
        }

        $data = [
            'case' => $case
        ];

        $this->view('farmer/YellowCaseDetails', $data);
    }
}

?>