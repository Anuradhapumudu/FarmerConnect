<?php
class Complaint extends Controller
{
    public function index()
    {
        //Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        //check if user is a farmer and pre-populate the form with existing data if available
        $farmerNIC = '';
        $paddyFields = [];
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer') {
            $farmerNIC = $_SESSION['nic'];
            $paddyFields = $this->model('M_complaint')->getPaddyFieldsByFarmer($farmerNIC);
        }

        $data = [
            'farmerNIC' => $farmerNIC,
            'paddyFields' => $paddyFields,
            'plrNumber' => '',
            'paddySize' => '',
            'affectedArea' => '',
            'observationDate' => '',
            'todayDate' => '',
            'title' => '',
            'description' => '',
            'severity' => '',
            'terms' => '',
            'errors' => []
        ];
        $this->view('complaint/complaint', $data);
    }

    //Show form to search and view complaints
    public function myComplaints()
    {
        //Check if user is logged in
        if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] === 'farmer' && !isset($_SESSION['nic']))) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        $data = [];
        $data['searched'] = false;
        $data['plrNumber'] = '';
        $data['complaint_id'] = '';

        // Check if farmer is logged in - they should only see their own reports
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            $farmerNIC = $_SESSION['nic'];
            $data['farmerNIC'] = $farmerNIC;

            // Check if filtering parameters exist in GET request
            if (isset($_GET['complaint_id']) || isset($_GET['plrNumber'])) {
                // Handle search form submission
                $plrNumber = isset($_GET['plrNumber']) ? trim($_GET['plrNumber']) : '';
                $complain_id = isset($_GET['complaint_id']) ? trim($_GET['complaint_id']) : '';

                // Only search if at least one filter is provided
                if (!empty($plrNumber) || !empty($complain_id)) {
                    $reports = $this->model('M_complaint')->searchReports($farmerNIC, $plrNumber, $complain_id);
                    $data['reports'] = $reports;
                    $data['plrNumber'] = $plrNumber;
                    $data['complaint_id'] = $complain_id;
                    $data['searched'] = true;
                    $data['message'] = count($reports) . ' of your complaint(s) found';
                } else {
                    // If parameters exist but are empty, show all
                    $reports = $this->model('M_complaint')->getComplaintsByFarmer($farmerNIC);
                    $data['reports'] = $reports;
                    $data['message'] = 'Showing your complaints (' . count($reports) . ' total)';
                }
            } else {
                // Show only this farmer's complaints by default
                $reports = $this->model('M_complaint')->getComplaintsByFarmer($farmerNIC);
                $data['reports'] = $reports;
                $data['message'] = 'Showing your complaints (' . count($reports) . ' total)';
            }

            // Get farmer's paddy fields for PLR dropdown filter
            $data['paddyFields'] = $this->model('M_complaint')->getPaddyFieldsByFarmer($farmerNIC);
        } else {
            // For officers/admins - show all complaints
            $farmerNIC = '';
            $includeDeleted = false;

            // Check if current user is Admin
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                $includeDeleted = true;
            }

            if (isset($_GET['reportCode']) || isset($_GET['plrNumber']) || isset($_GET['farmerNIC'])) {
                // Handle search form submission
                $farmerNIC = isset($_GET['farmerNIC']) ? trim($_GET['farmerNIC']) : '';
                $plrNumber = isset($_GET['plrNumber']) ? trim($_GET['plrNumber']) : '';
                $complaint_id = isset($_GET['complaint_id']) ? trim($_GET['complaint_id']) : '';

                if (!empty($farmerNIC) || !empty($plrNumber) || !empty($complaint_id)) {
                    $reports = $this->model('M_complaint')->searchReports($farmerNIC, $plrNumber, $complaint_id, $includeDeleted);

                    $data['reports'] = $reports;
                    $data['farmerNIC'] = $farmerNIC;
                    $data['plrNumber'] = $plrNumber;
                    $data['complaint_id'] = $complaint_id;
                    $data['searched'] = true;
                    $data['message'] = count($reports) . ' complaint(s) found';
                } else {
                    $reports = $this->model('M_complaint')->getAllComplaints(null, null, $includeDeleted);
                    $data['reports'] = $reports;
                    $data['farmerNIC'] = '';
                    $data['message'] = 'Showing all complaints (' . count($reports) . ' total)';
                }
            } else {
                // Show all complaints by default
                $reports = $this->model('M_complaint')->getAllComplaints(null, null, $includeDeleted);
                $data['reports'] = $reports;
                $data['farmerNIC'] = '';
                $data['message'] = 'Showing all complaints (' . count($reports) . ' total)';
            }
        }

        // Add officer responses to each complaint
        if (!empty($data['reports'])) {
            foreach ($data['reports'] as &$report) {
                $report->officer_responses = $this->model('M_complaint')->getOfficerResponses($report->complaint_id);
            }
        }

        $this->view('complaint/myComplaints', $data);
    }

    // Submit method
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize and prepare data
            $data = [
                'farmerNIC' => isset($_POST['farmerNIC']) ? trim($_POST['farmerNIC']) : '',
                'plrNumber' => isset($_POST['plrNumber']) ? trim($_POST['plrNumber']) : '',
                'paddySize' => isset($_POST['paddySize']) ? trim($_POST['paddySize']) : '',
                'observationDate' => isset($_POST['observationDate']) ? trim($_POST['observationDate']) : '',
                'title' => isset($_POST['title']) ? trim($_POST['title']) : '',
                'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
                'severity' => isset($_POST['severity']) ? trim($_POST['severity']) : '',
                'affectedArea' => isset($_POST['affectedArea']) ? trim($_POST['affectedArea']) : '',
                'status' => 'pending',
                'terms' => isset($_POST['terms']) ? $_POST['terms'] : '',
                'errors' => []
            ];

            // Validate Data
            $validationResult = $this->validateReportData($data);
            $data['errors'] = $validationResult['errors'];

            // Proceed if no errors
            if (empty($data['errors'])) {
                // Handle File Uploads
                $uploadResult = $this->handleFileUpload();

                if (isset($uploadResult['error'])) {
                    $data['errors']['media_error'] = $uploadResult['error'];
                } else {
                    $data['media'] = $uploadResult['media_string'];

                    // Submit to Database
                    $complaint_id = $this->model('M_complaint')->submitComplaint($data);

                    if ($complaint_id && !is_array($complaint_id)) {
                        // Redirect to success page
                        header('Location: ' . URLROOT . '/complaint/success/' . $complaint_id);
                        exit();
                    } else {
                        $data['errors']['general_error'] = isset($complaint_id['error']) ? $complaint_id['error'] : 'Database error occurred.';
                    }
                }
            }

            // If we are here, there were errors
            // Reload paddy fields for the form
            $data['paddyFields'] = $this->model('M_complaint')->getPaddyFieldsByFarmer($data['farmerNIC']);
            $this->view('complaint/complaint', $data);

        } else {
            $this->index();
        }
    }

    /**
     * Show success page for a submitted complaint
     * URL: /complaint/success/{complaint_id}
     */
    public function success($complaint_id = null)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if ($complaint_id === null) {
            header('Location: ' . URLROOT . '/complaint');
            exit();
        }

        $successData = ['complaint_id' => $complaint_id];
        $this->view('complaint/success', $successData);
    }

    /**
     * Validates complaint report data
     * @param array $data
     * @return array ['isValid' => bool, 'errors' => array]
     */
    private function validateReportData($data)
    {
        $errors = [];

        // Validate Farmer NIC
        if (empty($data['farmerNIC'])) {
            $errors['farmerNIC_error'] = 'Please enter your NIC number';
        } elseif (!preg_match('/^([0-9]{9}[vV]|[0-9]{12})$/', $data['farmerNIC'])) {
            $errors['farmerNIC_error'] = 'Invalid NIC format. Use 9 digits with V or 12 digits';
        }

        // Validate PLR Number
        $plrPattern = '/^\d{2}\/\d{2}\/\d{5}\/\d{3}\/[A-Za-z]\/\d{4}$/';
        if (empty($data['plrNumber'])) {
            $errors['plrNumber_error'] = 'PLR number is required.';
        } elseif (!preg_match($plrPattern, $data['plrNumber'])) {
            $errors['plrNumber_error'] = 'Invalid PLR format. Example: 02/25/00083/001/P/0066';
        } else {
            // Check if PLR exists in paddy table for this farmer
            $paddyRecord = $this->model('M_complaint')->getPaddyByPLR($data['plrNumber']);
            if (!$paddyRecord || $paddyRecord->NIC_FK !== $data['farmerNIC']) {
                $errors['plrNumber_error'] = 'PLR number not found in your registered paddy fields.';
            }
        }

        // Validate Observation Date
        if (empty($data['observationDate'])) {
            $errors['observationDate_error'] = 'Please select the observation date';
        } else {
            $observationDate = DateTime::createFromFormat('Y-m-d', $data['observationDate']);
            $today = new DateTime();

            if (!$observationDate) {
                $errors['observationDate_error'] = 'Invalid date format';
            } elseif ($observationDate > $today) {
                $errors['observationDate_error'] = 'Observation date cannot be in the future';
            }
        }

        // Validate Title
        if (empty($data['title'])) {
            $errors['title_error'] = 'Please enter a report title';
        } elseif (strlen($data['title']) < 5) {
            $errors['title_error'] = 'Title must be at least 5 characters long';
        } elseif (strlen($data['title']) > 200) {
            $errors['title_error'] = 'Title must be less than 200 characters';
        }

        // Validate Description
        if (empty($data['description'])) {
            $errors['description_error'] = 'Please enter a detailed description';
        } elseif (strlen($data['description']) < 20) {
            $errors['description_error'] = 'Description must be at least 20 characters long';
        } elseif (strlen($data['description']) > 2000) {
            $errors['description_error'] = 'Description must be less than 2000 characters';
        }

        // Validate Severity
        if (empty($data['severity'])) {
            $errors['severity_error'] = 'Please select a severity level';
        } elseif (!in_array($data['severity'], ['low', 'medium', 'high'])) {
            $errors['severity_error'] = 'Invalid severity level selected';
        }

        // Validate Affected Area
        if (empty($data['affectedArea'])) {
            $errors['affectedArea_error'] = 'Please enter the affected area';
        } elseif (!is_numeric($data['affectedArea'])) {
            $errors['affectedArea_error'] = 'Affected area must be a valid number';
        } elseif (floatval($data['affectedArea']) <= 0) {
            $errors['affectedArea_error'] = 'Affected area must be greater than 0';
        } elseif (floatval($data['affectedArea']) > 10000) {
            $errors['affectedArea_error'] = 'Affected area seems too large (max 10,000 acres)';
        } else {
            // Check against actual Paddy Size in DB
            if (!empty($data['plrNumber'])) {
                $paddyData = $this->model('M_complaint')->getPaddyByPLR($data['plrNumber']);
                if ($paddyData) {
                    $maxPaddySize = floatval($paddyData->Paddy_Size);
                    if (floatval($data['affectedArea']) > $maxPaddySize) {
                        $errors['affectedArea_error'] = "Affected area cannot be larger than the total paddy size ({$maxPaddySize} acres)";
                    }
                }
            }
        }

        // Validate Terms
        if (empty($data['terms']) || $data['terms'] !== 'on') {
            $errors['terms_error'] = 'You must agree to the terms and conditions';
        }

        return ['isValid' => empty($errors), 'errors' => $errors];
    }

    private function handleFileUpload($existingMedia = '', $filesToRemove = [], $reportCodePrefix = 'NEW')
    {
        $uploadDir = APPROOT . '/../public/uploads/complaint_reports/';
        $finalMediaList = [];

        // Ensure upload directory exists
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return ['error' => 'Failed to create upload directory.'];
            }
        }

        // 1. Process Existing Files
        if (!empty($existingMedia)) {
            $existingFiles = explode(',', $existingMedia);
            $existingFiles = array_map('trim', $existingFiles);

            foreach ($existingFiles as $file) {
                // If the file is NOT in the remove list, keep it
                if (!in_array($file, $filesToRemove)) {
                    $finalMediaList[] = $file;
                } else {
                    // It IS in the remove list, try to delete from disk
                    $filePath = $uploadDir . $file;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
        }

        // 2. Process New Uploads
        if (!empty($_FILES['media']['name'][0])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            foreach ($_FILES['media']['name'] as $key => $filename) {
                if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['media']['tmp_name'][$key];
                    $fileSize = $_FILES['media']['size'][$key];

                    // Validate Type
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $fileType = $finfo->file($tmpName);

                    if (!in_array($fileType, $allowedTypes)) {
                        return ['error' => 'Invalid file type: ' . $fileType];
                    }

                    // Validate Size
                    if ($fileSize > $maxFileSize) {
                        return ['error' => 'File size exceeds 10MB limit: ' . $filename];
                    }

                    // Generate Filename
                    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($filename, PATHINFO_FILENAME));
                    $baseName = substr($baseName, 0, 30);
                    $uniqueFilename = $reportCodePrefix . '_' . $baseName . '_' . time() . '_' . $key . '.' . $fileExtension;

                    $targetPath = $uploadDir . $uniqueFilename;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $finalMediaList[] = $uniqueFilename;
                        chmod($targetPath, 0644);
                    } else {
                        return ['error' => 'Failed to upload file: ' . $filename];
                    }
                }
            }
        }

        return ['media_string' => implode(',', $finalMediaList)];
    }

    public function viewComplaint($reportCode = '')
    {
        if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] === 'farmer' && !isset($_SESSION['nic']))) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (!empty($reportCode)) {
            //show specific complaint details
            $includeDeleted = false;
            //check if current user is Admin
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                $includeDeleted = true;
            }

            $report = $this->model('M_complaint')->getComplaintByCode($reportCode, $includeDeleted);

            if (!$report) {
                //Complaint not found
                $_SESSION['error_message'] = 'Complaint not found';
                header('Location: ' . URLROOT . '/complaint/myComplaints');
                exit();
            }

            //Check if farmer is logged in and trying to view their own report
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
                if ($report->farmerNIC !== $_SESSION['nic']) {
                    $_SESSION['error_message'] = 'You do not have permission to view this report';
                    header('Location: ' . URLROOT . '/complaint/myComplaints');
                    exit();
                }
            }

            //Get officer responses to the complaint
            $officer_responses = $this->model('M_complaint')->getOfficerResponses($reportCode);
            $data = [
                'report' => $report,
                'officer_responses' => $officer_responses,
                'singleReport' => true,
                'message' => 'Report details for ' . $reportCode,
            ];
        } else {
            //Redirect to viewReports if not ID provided
            header('Location: ' . URLROOT . '/complaint/myComplaints');
            exit();
        }

        $this->view('complaint/viewComplaint', $data);
    }

}
?>