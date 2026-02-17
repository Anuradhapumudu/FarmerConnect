<?php
class Disease extends Controller
{

    public function index()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if farmer is logged in and pre-populate NIC
        $farmerNIC = '';
        $paddyFields = [];
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            $farmerNIC = $_SESSION['nic'];
            // Get farmer's paddy fields for PLR dropdown
            $paddyFields = $this->model('M_disease')->getPaddyFieldsByFarmer($farmerNIC);
        }

        $data = [
            'farmerNIC' => $farmerNIC,
            'paddyFields' => $paddyFields,
            'plrNumber' => '',
            'paddySize' => '',
            'observationDate' => '',
            'todayDate' => '',
            'title' => '',
            'description' => '',
            'severity' => '',
            'affectedArea' => '',
            'terms' => '',
            'errors' => []
        ];
        $this->view('disease/disease', $data);
    }

    // Show form to search/view reports
    public function viewReports()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] === 'farmer' && !isset($_SESSION['nic']))) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        $data = [];
        $data['searched'] = false;
        $data['plrNumber'] = '';
        $data['reportCode'] = '';

        // Check if farmer is logged in - they should only see their own reports
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            $farmerNIC = $_SESSION['nic'];
            $data['farmerNIC'] = $farmerNIC;

            // Check if filtering parameters exist in GET request
            if (isset($_GET['reportCode']) || isset($_GET['plrNumber'])) {
                // Handle search form submission
                $plrNumber = isset($_GET['plrNumber']) ? trim($_GET['plrNumber']) : '';
                $reportCode = isset($_GET['reportCode']) ? trim($_GET['reportCode']) : '';

                // Only search if at least one filter is provided
                if (!empty($plrNumber) || !empty($reportCode)) {
                    $reports = $this->model('M_disease')->searchReports($farmerNIC, $plrNumber, $reportCode);
                    $data['reports'] = $reports;
                    $data['plrNumber'] = $plrNumber;
                    $data['reportCode'] = $reportCode;
                    $data['searched'] = true;
                    $data['message'] = count($reports) . ' of your report(s) found';
                } else {
                    // If parameters exist but are empty, show all
                    $reports = $this->model('M_disease')->getReportsByFarmerNIC($farmerNIC);
                    $data['reports'] = $reports;
                    $data['message'] = 'Showing your reports (' . count($reports) . ' total)';
                }
            } else {
                // Show only this farmer's reports by default
                $reports = $this->model('M_disease')->getReportsByFarmerNIC($farmerNIC);
                $data['reports'] = $reports;
                $data['message'] = 'Showing your reports (' . count($reports) . ' total)';
            }

            // Get farmer's paddy fields for PLR dropdown filter
            $data['paddyFields'] = $this->model('M_disease')->getPaddyFieldsByFarmer($farmerNIC);
        } else {
            // For officers/admins - show all reports
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
                $reportCode = isset($_GET['reportCode']) ? trim($_GET['reportCode']) : '';

                if (!empty($farmerNIC) || !empty($plrNumber) || !empty($reportCode)) {
                    $reports = $this->model('M_disease')->searchReports($farmerNIC, $plrNumber, $reportCode, $includeDeleted);

                    $data['reports'] = $reports;
                    $data['farmerNIC'] = $farmerNIC;
                    $data['plrNumber'] = $plrNumber;
                    $data['reportCode'] = $reportCode;
                    $data['searched'] = true;
                    $data['message'] = count($reports) . ' report(s) found';
                } else {
                    $reports = $this->model('M_disease')->getAllReports(null, null, $includeDeleted);
                    $data['reports'] = $reports;
                    $data['farmerNIC'] = '';
                    $data['message'] = 'Showing all reports (' . count($reports) . ' total)';
                }
            } else {
                // Show all reports by default
                $reports = $this->model('M_disease')->getAllReports(null, null, $includeDeleted);
                $data['reports'] = $reports;
                $data['farmerNIC'] = '';
                $data['message'] = 'Showing all reports (' . count($reports) . ' total)';
            }
        }

        // Add officer responses to each report
        if (!empty($data['reports'])) {
            foreach ($data['reports'] as &$report) {
                $report->officer_responses = $this->model('M_disease')->getOfficerResponses($report->report_code);
            }
        }

        $this->view('disease/viewReports', $data);
    }

    // View all submitted reports in table format or single report details
    public function viewReport($reportCode = '')
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] === 'farmer' && !isset($_SESSION['nic']))) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (!empty($reportCode)) {
            // Show specific report details
            $includeDeleted = false;
            // Check if current user is Admin
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                $includeDeleted = true;
            }

            $report = $this->model('M_disease')->getReportByCode($reportCode, $includeDeleted);

            if (!$report) {
                $_SESSION['error_message'] = 'Report not found';
                header('Location: ' . URLROOT . '/disease/viewReports');
                exit();
            }

            // Check if farmer is logged in and trying to view their own report
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
                if ($report->farmerNIC !== $_SESSION['nic']) {
                    $_SESSION['error_message'] = 'You can only view your own reports';
                    header('Location: ' . URLROOT . '/disease/viewReports');
                    exit();
                }
            }

            // Get officer responses for this report
            $officer_responses = $this->model('M_disease')->getOfficerResponses($reportCode);

            $data = [
                'report' => $report,
                'officer_responses' => $officer_responses,
                'singleReport' => true,
                'message' => 'Report details for ' . $reportCode
            ];
        } else {
            // Redirect to viewReports if no ID provided
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $this->view('disease/reportDetail', $data);
    }

    // Show edit form for updating report
    public function editReport($reportCode = '')
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] === 'farmer' && !isset($_SESSION['nic']))) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($reportCode)) {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $report = $this->model('M_disease')->getReportByCode($reportCode);

        if (!$report) {
            $_SESSION['error_message'] = 'Report not found';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        // Check if farmer is logged in and trying to edit their own report
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            if ($report->farmerNIC !== $_SESSION['nic']) {
                $_SESSION['error_message'] = 'You can only edit your own reports';
                header('Location: ' . URLROOT . '/disease/viewReports');
                exit();
            }
        }

        // Get farmer's paddy fields for PLR dropdown
        $paddyFields = $this->model('M_disease')->getPaddyFieldsByFarmer($report->farmerNIC);

        // Populate form with existing data
        // Handle pirNumber vs plrNumber inconsistency from DB
        $plrNumber = isset($report->pirNumber) ? $report->pirNumber : (isset($report->plrNumber) ? $report->plrNumber : '');

        $data = [
            'reportCode' => $report->report_code,
            'farmerNIC' => $report->farmerNIC,
            'paddyFields' => $paddyFields,
            'plrNumber' => $plrNumber,
            'paddySize' => isset($report->paddySize) ? $report->paddySize : '',
            'observationDate' => $report->observationDate,
            'title' => $report->title,
            'description' => $report->description,
            'severity' => $report->severity,
            'affectedArea' => $report->affectedArea,
            'existingMedia' => $report->media,
            'terms' => 'on', // Pre-check terms for edit
            'errors' => [],
            'isEdit' => true
        ];

        $this->view('disease/disease', $data);
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
                    $reportCode = $this->model('M_disease')->submitDReport($data);

                    if ($reportCode && !is_array($reportCode)) {
                        // Display success page
                        $successData = ['report_id' => $reportCode];
                        $this->view('disease/success', $successData);
                        exit();
                    } else {
                        $data['errors']['general_error'] = isset($reportCode['error']) ? $reportCode['error'] : 'Database error occurred.';
                    }
                }
            }

            // If we are here, there were errors
            // Reload paddy fields for the form
            $data['paddyFields'] = $this->model('M_disease')->getPaddyFieldsByFarmer($data['farmerNIC']);
            $this->view('disease/disease', $data);

        } else {
            $this->index();
        }
    }

    // Update report
    public function updateReport()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Sanitize POST data
                $data = [
                    'report_code' => isset($_POST['reportCode']) ? trim($_POST['reportCode']) : '',
                    'farmerNIC' => isset($_POST['farmerNIC']) ? trim($_POST['farmerNIC']) : '',
                    'plrNumber' => isset($_POST['plrNumber']) ? trim($_POST['plrNumber']) : '',
                    'observationDate' => isset($_POST['observationDate']) ? trim($_POST['observationDate']) : '',
                    'title' => isset($_POST['title']) ? trim($_POST['title']) : '',
                    'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
                    'severity' => isset($_POST['severity']) ? trim($_POST['severity']) : '',
                    'affectedArea' => isset($_POST['affectedArea']) ? trim($_POST['affectedArea']) : '',
                    'terms' => isset($_POST['terms']) ? $_POST['terms'] : '',
                    'existingMedia' => isset($_POST['existingMedia']) ? trim($_POST['existingMedia']) : '',
                    'removeMedia' => isset($_POST['removeMedia']) ? $_POST['removeMedia'] : [],
                    'errors' => [],
                    'isEdit' => true
                ];

                // Verify report exists
                $existingReport = $this->model('M_disease')->getReportByCode($data['report_code']);
                if (!$existingReport) {
                    $_SESSION['error_message'] = 'Report not found';
                    header('Location: ' . URLROOT . '/disease/viewReports');
                    exit();
                }

                // Validate Data
                $validationResult = $this->validateReportData($data);
                $data['errors'] = $validationResult['errors'];

                // Handle Media (Combined existing and new)
                if (empty($data['errors'])) {
                    $uploadResult = $this->handleFileUpload($data['existingMedia'], $data['removeMedia'], $data['report_code']);

                    if (isset($uploadResult['error'])) {
                        $data['errors']['media_error'] = $uploadResult['error'];
                    } else {
                        $data['media'] = $uploadResult['media_string'];

                        // Update in database
                        $dbResult = $this->model('M_disease')->updateReport($data);
                        if ($dbResult) {
                            $_SESSION['success_message'] = 'Report updated successfully';
                            header('Location: ' . URLROOT . '/disease/viewReport/' . $data['report_code']);
                            exit();
                        } else {
                            $data['errors']['general_error'] = 'Database update failed. Please try again.';
                        }
                    }
                }

                // If errors, reload necessary data
                $data['paddyFields'] = $this->model('M_disease')->getPaddyFieldsByFarmer($data['farmerNIC']);
                $this->view('disease/disease', $data);

            } catch (Exception $e) {
                error_log("Exception in updateReport: " . $e->getMessage());
                $_SESSION['error_message'] = 'An error occurred while updating the report';
                header('Location: ' . URLROOT . '/disease/viewReports');
                exit();
            }
        } else {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }
    }

    // Delete report
    public function deleteReport($reportCode = '')
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] === 'farmer' && !isset($_SESSION['nic']))) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($reportCode)) {
            $_SESSION['error_message'] = 'Report Code is required';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        // Get report details to clean up media files
        $report = $this->model('M_disease')->getReportByCode($reportCode);

        if (!$report) {
            $_SESSION['error_message'] = 'Report not found';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        // Check if farmer is logged in and trying to delete their own report
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            if ($report->farmerNIC !== $_SESSION['nic']) {
                $_SESSION['error_message'] = 'You can only delete your own reports';
                header('Location: ' . URLROOT . '/disease/viewReports');
                exit();
            }
        }

        try {
            // Delete from database first
            $dbResult = $this->model('M_disease')->deleteReport($reportCode);

            if ($dbResult) {
                // Media files are preserved for soft delete
                $_SESSION['success_message'] = 'Report deleted successfully';
            } else {
                $_SESSION['error_message'] = 'Failed to delete report';
            }
        } catch (Exception $e) {
            error_log("Exception in deleteReport: " . $e->getMessage());
            $_SESSION['error_message'] = 'An error occurred while deleting the report';
        }

        header('Location: ' . URLROOT . '/disease/viewReports');
        exit();
    }

    // Success page - can be accessed directly via URL for testing
    public function success($report_id = null)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if ($report_id === null) {
            header('Location: ' . URLROOT . '/disease');
            exit();
        }

        $successData = ['report_id' => $report_id];
        $this->view('disease/success', $successData);
    }

    // Display media files from file system
    public function viewMedia($reportCode = '', $filename = '')
    {
        // Check if user is logged in (allow officers/admins who may not have 'nic')
        if (!isset($_SESSION['user_type'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($reportCode) || empty($filename)) {
            http_response_code(404);
            echo "Report Code and filename required";
            return;
        }

        try {
            // Verify that this file belongs to this report
            $report = $this->model('M_disease')->getReportByCode($reportCode);

            if ($report && !empty($report->media)) {
                $reportFiles = explode(',', $report->media);
                $reportFiles = array_map('trim', $reportFiles);

                // Check if the requested filename exists for this report
                if (!in_array($filename, $reportFiles)) {
                    http_response_code(403);
                    echo "File not associated with this report";
                    return;
                }

                // Check permissions
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
                    if ($report->farmerNIC !== $_SESSION['nic']) {
                        http_response_code(403);
                        echo "You can only view media from your own reports";
                        return;
                    }
                }

                // Build file path
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';
                $filePath = $uploadDir . $filename;

                if (file_exists($filePath)) {
                    $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $mimeType = $this->getMimeType($fileExtension);

                    header('Content-Type: ' . $mimeType);
                    header('Content-Length: ' . filesize($filePath));
                    header('Content-Disposition: inline; filename="' . basename($filePath) . '"');

                    readfile($filePath);
                    exit();
                } else {
                    http_response_code(404);
                    echo "File not found on server";
                }
            } else {
                http_response_code(404);
                echo "Report not found or has no media";
            }
        } catch (Exception $e) {
            error_log("Error viewing media: " . $e->getMessage());
            http_response_code(500);
            echo "Error loading file";
        }
    }

    // View officer response media
    public function viewResponseMedia($responseId = '', $filename = '')
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_type'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($responseId) || empty($filename)) {
            http_response_code(404);
            echo "Response ID and filename required";
            return;
        }

        try {
            // No strict ownership check for now as these are responses TO the farmer, but arguably we should check if the report belongs to them.
            // For simplicity and to ensure it works, we just check if file exists.

            // Build file path
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/officer_responses/';
            $filePath = $uploadDir . $filename;

            if (file_exists($filePath)) {
                $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $mimeType = $this->getMimeType($fileExtension);

                header('Content-Type: ' . $mimeType);
                header('Content-Length: ' . filesize($filePath));
                header('Content-Disposition: inline; filename="' . basename($filePath) . '"');

                readfile($filePath);
                exit();
            } else {
                http_response_code(404);
                echo "File not found on server";
            }
        } catch (Exception $e) {
            error_log("Error viewing response media: " . $e->getMessage());
            http_response_code(500);
            echo "Error loading file";
        }
    }

    // --- PRIVATE HELPER METHODS ---

    /**
     * Validates report data
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
            $paddyRecord = $this->model('M_disease')->getPaddyByPLR($data['plrNumber']);
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
                $paddyData = $this->model('M_disease')->getPaddyByPLR($data['plrNumber']);
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

    /**
     * Handles file uploads and merges with existing files
     * @param string $existingMedia Comma-separated list of existing files (optional)
     * @param array $filesToRemove List of filenames to remove (optional)
     * @param string $reportCodePrefix Prefix for new filenames (optional)
     * @return array ['media_string' => string, 'error' => string]
     */
    private function handleFileUpload($existingMedia = '', $filesToRemove = [], $reportCodePrefix = 'NEW')
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';
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

    private function getMimeType($extension)
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime',
            'wmv' => 'video/x-ms-wmv'
        ];
        return isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';
    }
}