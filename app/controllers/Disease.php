<?php
class Disease extends Controller{

    public function index(){
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if farmer is logged in and pre-populate NIC
        $farmerNIC = '';
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            $farmerNIC = $_SESSION['nic'];
        }

        $data = [
            'farmerNIC' => $farmerNIC,
            'plrNumber' => '',
            'observationDate' => '',
            'todayDate' => '',
            'title' => '',
            'description' => '',
            'severity' => '',
            'affectedArea' => '',
            'terms' => '',
            'farmerNIC_error' => '',
            'plrNumber_error' => '',
            'observationDate_error' => '',
            'title_error' => '',
            'description_error' => '',
            'media_error' => '',
            'severity_error' => '',
            'affectedArea_error' => '',
            'terms_error' => ''
        ];
        $this->view('disease/disease', $data);
    }

    // Show form to search/view reports
    public function viewReports(){
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if farmer is logged in - they should only see their own reports
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            $farmerNIC = $_SESSION['nic'];

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Handle search form submission - but only for this farmer's reports
                $plrNumber = isset($_POST['plrNumber']) ? trim($_POST['plrNumber']) : '';
                $reportCode = isset($_POST['reportCode']) ? trim($_POST['reportCode']) : '';

                $reports = $this->model('M_disease')->searchReports($farmerNIC, $plrNumber, $reportCode);

                $data = [
                    'reports' => $reports,
                    'farmerNIC' => $farmerNIC,
                    'plrNumber' => $plrNumber,
                    'reportCode' => $reportCode,
                    'searched' => true,
                    'message' => count($reports) . ' of your report(s) found'
                ];
            } else {
                // Show only this farmer's reports by default
                $reports = $this->model('M_disease')->getReportsByFarmerNIC($farmerNIC);
                $data = [
                    'reports' => $reports,
                    'farmerNIC' => $farmerNIC,
                    'plrNumber' => '',
                    'reportCode' => '',
                    'searched' => false,
                    'message' => 'Showing your reports (' . count($reports) . ' total)'
                ];
            }
        } else {
            // For officers/admins - show all reports
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Handle search form submission
                $farmerNIC = isset($_POST['farmerNIC']) ? trim($_POST['farmerNIC']) : '';
                $plrNumber = isset($_POST['plrNumber']) ? trim($_POST['plrNumber']) : '';
                $reportCode = isset($_POST['reportCode']) ? trim($_POST['reportCode']) : '';

                $reports = $this->model('M_disease')->searchReports($farmerNIC, $plrNumber, $reportCode);

                $data = [
                    'reports' => $reports,
                    'farmerNIC' => $farmerNIC,
                    'plrNumber' => $plrNumber,
                    'reportCode' => $reportCode,
                    'searched' => true,
                    'message' => count($reports) . ' report(s) found'
                ];
            } else {
                // Show all reports by default
                $reports = $this->model('M_disease')->getAllReports();
                $data = [
                    'reports' => $reports,
                    'farmerNIC' => '',
                    'plrNumber' => '',
                    'reportCode' => '',
                    'searched' => false,
                    'message' => 'Showing all reports (' . count($reports) . ' total)'
                ];
            }
        }

        // Add officer responses to each report
        foreach ($data['reports'] as &$report) {
            $report->officer_responses = $this->model('M_disease')->getOfficerResponses($report->report_code);
        }

        $this->view('disease/viewReports', $data);
    }

    // View all submitted reports in table format or single report details
    public function viewReport($reportCode = '') {
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (!empty($reportCode)) {
            // Show specific report details
            $report = $this->model('M_disease')->getReportByCode($reportCode);

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
            // Check if farmer is logged in - they should only see their own reports
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
                $farmerNIC = $_SESSION['nic'];
                $reports = $this->model('M_disease')->getReportsByFarmerNIC($farmerNIC);
                $data = [
                    'reports' => $reports,
                    'singleReport' => false,
                    'message' => 'Showing your reports (' . count($reports) . ' total)'
                ];
            } else {
                // Show all reports by default for officers/admins
                $reports = $this->model('M_disease')->getAllReports();
                $data = [
                    'reports' => $reports,
                    'singleReport' => false,
                    'message' => 'Showing all reports (' . count($reports) . ' total)'
                ];
            }
        }

        $this->view('disease/reportDetail', $data);
    }

    // Show edit form for updating report - UPDATED
    public function editReport($reportCode = '') { // Changed parameter name
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($reportCode)) {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $report = $this->model('M_disease')->getReportByCode($reportCode); // Changed method call

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

        // Populate form with existing data
        $data = [
            'reportCode' => $report->report_code, 
            'farmerNIC' => $report->farmerNIC,
            'plrNumber' => $report->pirNumber,
            'observationDate' => $report->observationDate,
            'title' => $report->title,
            'description' => $report->description,
            'severity' => $report->severity,
            'affectedArea' => $report->affectedArea,
            'existingMedia' => $report->media,
            'terms' => 'on', // Pre-check terms for edit

            // Error fields
            'farmerNIC_error' => '',
            'plrNumber_error' => '',
            'observationDate_error' => '',
            'title_error' => '',
            'description_error' => '',
            'media_error' => '',
            'severity_error' => '',
            'affectedArea_error' => '',
            'terms_error' => '',
            'isEdit' => true
        ];

        $this->view('disease/disease', $data);
    }

    // Update report - UPDATED
    public function updateReport() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Sanitize POST data
                $data = [
                    'report_code' => isset($_POST['reportCode']) ? trim($_POST['reportCode']) : '', // Changed
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

                    // Error fields
                    'farmerNIC_error' => '',
                    'plrNumber_error' => '',
                    'observationDate_error' => '',
                    'title_error' => '',
                    'description_error' => '',
                    'media_error' => '',
                    'severity_error' => '',
                    'affectedArea_error' => '',
                    'terms_error' => '',
                    'isEdit' => true
                ];

                // Verify report exists
                $existingReport = $this->model('M_disease')->getReportByCode($data['report_code']); // Changed
                if (!$existingReport) {
                    $_SESSION['error_message'] = 'Report not found';
                    header('Location: ' . URLROOT . '/disease/viewReports');
                    exit();
                }

                // Validate Farmer NIC
                if (empty($data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Please enter your NIC number';
                } elseif (!preg_match('/^([0-9]{9}[vV]|[0-9]{12})$/', $data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Invalid NIC format. Use 9 digits with V or 12 digits';
                }

                // Validate PLR Number
                if (empty($data['plrNumber'])) {
                    $data['plrNumber_error'] = 'Please enter your PLR number';
                } elseif (!preg_match('/^PLR[0-9]+$/', $data['plrNumber'])) {
                    $data['plrNumber_error'] = 'Invalid PLR format. Must start with PLR followed by numbers';
                }

                // Validate Observation Date
                if (empty($data['observationDate'])) {
                    $data['observationDate_error'] = 'Please select the observation date';
                } else {
                    $observationDate = DateTime::createFromFormat('Y-m-d', $data['observationDate']);
                    $today = new DateTime();

                    if (!$observationDate) {
                        $data['observationDate_error'] = 'Invalid date format';
                    } elseif ($observationDate > $today) {
                        $data['observationDate_error'] = 'Observation date cannot be in the future';
                    }
                }

                // Validate Title
                if (empty($data['title'])) {
                    $data['title_error'] = 'Please enter a report title';
                } elseif (strlen($data['title']) < 5) {
                    $data['title_error'] = 'Title must be at least 5 characters long';
                } elseif (strlen($data['title']) > 200) {
                    $data['title_error'] = 'Title must be less than 200 characters';
                }

                // Validate Description
                if (empty($data['description'])) {
                    $data['description_error'] = 'Please enter a detailed description';
                } elseif (strlen($data['description']) < 20) {
                    $data['description_error'] = 'Description must be at least 20 characters long';
                } elseif (strlen($data['description']) > 2000) {
                    $data['description_error'] = 'Description must be less than 2000 characters';
                }

                // Validate Severity
                if (empty($data['severity'])) {
                    $data['severity_error'] = 'Please select a severity level';
                } elseif (!in_array($data['severity'], ['low', 'medium', 'high'])) {
                    $data['severity_error'] = 'Invalid severity level selected';
                }

                // Validate Affected Area
                if (empty($data['affectedArea'])) {
                    $data['affectedArea_error'] = 'Please enter the affected area';
                } elseif (!is_numeric($data['affectedArea'])) {
                    $data['affectedArea_error'] = 'Affected area must be a valid number';
                } elseif (floatval($data['affectedArea']) <= 0) {
                    $data['affectedArea_error'] = 'Affected area must be greater than 0';
                } elseif (floatval($data['affectedArea']) > 10000) {
                    $data['affectedArea_error'] = 'Affected area seems too large (max 10,000 acres)';
                } else {
                    $data['affectedArea'] = floatval($data['affectedArea']);
                }

                // Validate Terms and Conditions
                if (empty($data['terms']) || $data['terms'] !== 'on') {
                    $data['terms_error'] = 'You must agree to the terms and conditions';
                }

                // Handle Media Updates
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';
                $finalMediaList = [];

                // Start with existing media
                if (!empty($data['existingMedia'])) {
                    $existingFiles = explode(',', $data['existingMedia']);
                    $existingFiles = array_map('trim', $existingFiles);

                    // Remove files marked for deletion
                    foreach ($existingFiles as $file) {
                        if (!in_array($file, $data['removeMedia'])) {
                            $finalMediaList[] = $file;
                        } else {
                            // Delete file from filesystem
                            $filePath = $uploadDir . $file;
                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
                        }
                    }
                }

                // Handle new file uploads
                if (!empty($_FILES['media']['name'][0])) {
                    try {
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv'];
                        $maxFileSize = 10 * 1024 * 1024; // 10MB

                        foreach ($_FILES['media']['name'] as $key => $filename) {
                            if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                                $tmpName = $_FILES['media']['tmp_name'][$key];
                                $fileSize = $_FILES['media']['size'][$key];

                                // Use finfo to get accurate MIME type
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $fileType = $finfo->file($tmpName);

                                // Validate file type and size
                                if (!in_array($fileType, $allowedTypes)) {
                                    $data['media_error'] = 'Invalid file type: ' . $fileType;
                                    break;
                                }

                                if ($fileSize > $maxFileSize) {
                                    $data['media_error'] = 'File size exceeds 10MB limit: ' . $filename;
                                    break;
                                }

                                // Generate secure filename - use report_code instead of reportId
                                $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($filename, PATHINFO_FILENAME));
                                $baseName = substr($baseName, 0, 30);
                                $uniqueFilename = $data['report_code'] . '_' . $baseName . '_' . time() . '.' . $fileExtension; // Changed
                                $targetPath = $uploadDir . $uniqueFilename;

                                if (move_uploaded_file($tmpName, $targetPath)) {
                                    $finalMediaList[] = $uniqueFilename;
                                    chmod($targetPath, 0644);
                                } else {
                                    $data['media_error'] = 'Failed to upload file: ' . $filename;
                                    break;
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $data['media_error'] = 'File processing failed: ' . $e->getMessage();
                    }
                }

                $data['media'] = !empty($finalMediaList) ? implode(',', $finalMediaList) : null;

                // Check for validation errors
                $hasErrors = !empty($data['farmerNIC_error']) || !empty($data['plrNumber_error']) ||
                            !empty($data['observationDate_error']) || !empty($data['title_error']) ||
                            !empty($data['description_error']) || !empty($data['media_error']) ||
                            !empty($data['severity_error']) || !empty($data['affectedArea_error']) ||
                            !empty($data['terms_error']);

                if (!$hasErrors) {
                    // Update in database
                    $dbResult = $this->model('M_disease')->updateReport($data);
                    if ($dbResult) {
                        $_SESSION['success_message'] = 'Report updated successfully';
                        header('Location: ' . URLROOT . '/disease/viewReport/' . $data['report_code']); // Changed
                        exit();
                    } else {
                        $data['media_error'] = 'Database update failed. Please try again.';
                    }
                }

                // Show form with errors
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

    // Delete report - UPDATED
    public function deleteReport($reportCode = '') { // Changed parameter name
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($reportCode)) {
            $_SESSION['error_message'] = 'Report Code is required';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        // Get report details to clean up media files
        $report = $this->model('M_disease')->getReportByCode($reportCode); // Changed

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
            $dbResult = $this->model('M_disease')->deleteReport($reportCode); // Changed

            if ($dbResult) {
                // Clean up media files
                if (!empty($report->media)) {
                    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';
                    $mediaFiles = explode(',', $report->media);

                    foreach ($mediaFiles as $filename) {
                        $filename = trim($filename);
                        $filePath = $uploadDir . $filename;
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }

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

    // Confirm delete page - UPDATED
    public function confirmDelete($reportCode = '') { // Changed parameter name
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($reportCode)) {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $report = $this->model('M_disease')->getReportByCode($reportCode); // Changed

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

        $data = [
            'report' => $report
        ];

        $this->view('disease/confirmDelete', $data);
    }

    // Display media files from file system - UPDATED
    public function viewMedia($reportCode = '', $filename = '') { // Changed parameter name
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
            $report = $this->model('M_disease')->getReportByCode($reportCode); // Changed

            if ($report && !empty($report->media)) {
                $reportFiles = explode(',', $report->media);
                $reportFiles = array_map('trim', $reportFiles);

                // Check if the requested filename exists for this report
                if (!in_array($filename, $reportFiles)) {
                    http_response_code(403);
                    echo "File not associated with this report";
                    return;
                }

                // Check if farmer is logged in and trying to view their own report's media
                // Officers and admins can view all media
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
                    if ($report->farmerNIC !== $_SESSION['nic']) {
                        http_response_code(403);
                        echo "You can only view media from your own reports";
                        return;
                    }
                }
                // Officers and admins can access all media files

                // Build file path
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';
                $filePath = $uploadDir . $filename;

                if (file_exists($filePath)) {
                    $fileInfo = pathinfo($filePath);
                    $mimeType = $this->getMimeType($fileInfo['extension']);

                    header('Content-Type: ' . $mimeType);
                    header('Content-Length: ' . filesize($filePath));
                    header('Content-Disposition: inline; filename="' . basename($filePath) . '"');

                    readfile($filePath);
                    exit();
                } else {
                    http_response_code(404);
                    echo "File not found on server: " . $filename;
                }
            } else {
                http_response_code(404);
                echo "Report not found or has no media";
            }
        } catch (Exception $e) {
            error_log("Error viewing media: " . $e->getMessage());
            http_response_code(500);
            echo "Error loading file: " . $e->getMessage();
        }
    }

    // Submit method - MAJOR UPDATE
    public function submit(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try {
                // Remove reportId from data since it's auto-generated
                $data = [
                    'farmerNIC' => isset($_POST['farmerNIC']) ? trim($_POST['farmerNIC']) : '',
                    'plrNumber' => isset($_POST['plrNumber']) ? trim($_POST['plrNumber']) : '',
                    'observationDate' => isset($_POST['observationDate']) ? trim($_POST['observationDate']) : '',
                    'title' => isset($_POST['title']) ? trim($_POST['title']) : '',
                    'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
                    'severity' => isset($_POST['severity']) ? trim($_POST['severity']) : '',
                    'affectedArea' => isset($_POST['affectedArea']) ? trim($_POST['affectedArea']) : '',
                    'status' => 'pending',
                    'terms' => isset($_POST['terms']) ? $_POST['terms'] : '',

                    // Error fields
                    'farmerNIC_error' => '',
                    'plrNumber_error' => '',
                    'observationDate_error' => '',
                    'title_error' => '',
                    'description_error' => '',
                    'media_error' => '',
                    'severity_error' => '',
                    'affectedArea_error' => '',
                    'terms_error' => ''
                ];

                // VALIDATION LOGIC (same as before, but remove reportId validation)
                // ... [keep all your existing validation logic] ...

                // Validate Farmer NIC
                if (empty($data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Please enter your NIC number';
                } elseif (!preg_match('/^([0-9]{9}[vV]|[0-9]{12})$/', $data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Invalid NIC format. Use 9 digits with V or 12 digits';
                }

                // Validate PLR Number
                if (empty($data['plrNumber'])) {
                    $data['plrNumber_error'] = 'Please enter your PLR number';
                } elseif (!preg_match('/^PLR[0-9]+$/', $data['plrNumber'])) {
                    $data['plrNumber_error'] = 'Invalid PLR format. Must start with PLR followed by numbers';
                }

                // Validate Observation Date
                if (empty($data['observationDate'])) {
                    $data['observationDate_error'] = 'Please select the observation date';
                } else {
                    $observationDate = DateTime::createFromFormat('Y-m-d', $data['observationDate']);
                    $today = new DateTime();

                    if (!$observationDate) {
                        $data['observationDate_error'] = 'Invalid date format';
                    } elseif ($observationDate > $today) {
                        $data['observationDate_error'] = 'Observation date cannot be in the future';
                    }
                }

                // Validate Title
                if (empty($data['title'])) {
                    $data['title_error'] = 'Please enter a report title';
                } elseif (strlen($data['title']) < 5) {
                    $data['title_error'] = 'Title must be at least 5 characters long';
                } elseif (strlen($data['title']) > 200) {
                    $data['title_error'] = 'Title must be less than 200 characters';
                }

                // Validate Description
                if (empty($data['description'])) {
                    $data['description_error'] = 'Please enter a detailed description';
                } elseif (strlen($data['description']) < 20) {
                    $data['description_error'] = 'Description must be at least 20 characters long';
                } elseif (strlen($data['description']) > 2000) {
                    $data['description_error'] = 'Description must be less than 2000 characters';
                }

                // Validate Severity
                if (empty($data['severity'])) {
                    $data['severity_error'] = 'Please select a severity level';
                } elseif (!in_array($data['severity'], ['low', 'medium', 'high'])) {
                    $data['severity_error'] = 'Invalid severity level selected';
                }

                // Validate Affected Area
                if (empty($data['affectedArea'])) {
                    $data['affectedArea_error'] = 'Please enter the affected area';
                } elseif (!is_numeric($data['affectedArea'])) {
                    $data['affectedArea_error'] = 'Affected area must be a valid number';
                } elseif (floatval($data['affectedArea']) <= 0) {
                    $data['affectedArea_error'] = 'Affected area must be greater than 0';
                } elseif (floatval($data['affectedArea']) > 10000) {
                    $data['affectedArea_error'] = 'Affected area seems too large (max 10,000 acres)';
                } else {
                    $data['affectedArea'] = floatval($data['affectedArea']);
                }

                // Validate Terms and Conditions
                if (empty($data['terms']) || $data['terms'] !== 'on') {
                    $data['terms_error'] = 'You must agree to the terms and conditions';
                }
                // Handle Media Upload - Store files in filesystem
                $data['media'] = null;
                if (!empty($_FILES['media']['name'][0])) {
                    try {
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv'];
                        $maxFileSize = 10 * 1024 * 1024; // 10MB
                        $uploadedFiles = [];

                        // Define upload directory
                        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';

                        // Create upload directory if it doesn't exist
                        if (!is_dir($uploadDir)) {
                            if (!mkdir($uploadDir, 0755, true)) {
                                $data['media_error'] = 'Failed to create upload directory. Check permissions.';
                            }
                        }

                        if (empty($data['media_error'])) {
                            foreach ($_FILES['media']['name'] as $key => $filename) {
                                if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                                    $tmpName = $_FILES['media']['tmp_name'][$key];
                                    $fileSize = $_FILES['media']['size'][$key];

                                    // Use finfo to get accurate MIME type
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $fileType = $finfo->file($tmpName);

                                    if (!in_array($fileType, $allowedTypes)) {
                                        $data['media_error'] = 'Invalid file type: ' . $fileType;
                                        break;
                                    }

                                    if ($fileSize > $maxFileSize) {
                                        $data['media_error'] = 'File size exceeds 10MB limit: ' . $filename;
                                        break;
                                    }

                                    // For now, generate temporary filename - will update after we get the report code
                                    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                    $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($filename, PATHINFO_FILENAME));
                                    $baseName = substr($baseName, 0, 30);
                                    $tempFilename = 'temp_' . $baseName . '_' . time() . '.' . $fileExtension;
                                    $targetPath = $uploadDir . $tempFilename;

                                    if (move_uploaded_file($tmpName, $targetPath)) {
                                        $uploadedFiles[] = [
                                            'temp_path' => $targetPath,
                                            'original_name' => $filename,
                                            'temp_name' => $tempFilename
                                        ];
                                        chmod($targetPath, 0644);
                                    } else {
                                        $data['media_error'] = 'Failed to upload file: ' . $filename;
                                        break;
                                    }
                                }
                            }
                        }
                    } catch (Exception $e) {
                        error_log("File processing error: " . $e->getMessage());
                        $data['media_error'] = 'File processing failed: ' . $e->getMessage();
                    }
                }

                // Check if there are any validation errors
                $hasErrors = !empty($data['farmerNIC_error']) || !empty($data['plrNumber_error']) ||
                            !empty($data['observationDate_error']) || !empty($data['title_error']) ||
                            !empty($data['description_error']) || !empty($data['media_error']) ||
                            !empty($data['severity_error']) || !empty($data['affectedArea_error']) ||
                            !empty($data['terms_error']);

                if (!$hasErrors) {
                    // All validations passed, submit to database
                    $reportCode = $this->model('M_disease')->submitDReport($data); // This now returns the generated report code

                    if ($reportCode) {
                        // SUCCESS - Rename any temporary files with the actual report code
                        if (!empty($uploadedFiles)) {
                            $finalFilenames = [];
                            foreach ($uploadedFiles as $fileInfo) {
                                $fileExtension = strtolower(pathinfo($fileInfo['original_name'], PATHINFO_EXTENSION));
                                $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($fileInfo['original_name'], PATHINFO_FILENAME));
                                $baseName = substr($baseName, 0, 30);
                                $finalFilename = $reportCode . '_' . $baseName . '_' . time() . '.' . $fileExtension;
                                $finalPath = $uploadDir . $finalFilename;

                                if (rename($fileInfo['temp_path'], $finalPath)) {
                                    $finalFilenames[] = $finalFilename;
                                }
                            }

                            // Update the database with final filenames
                            if (!empty($finalFilenames)) {
                                $this->model('M_disease')->updateReportMedia($reportCode, implode(',', $finalFilenames));
                            }
                        }

                        // Redirect to success page with report code
                        header('Location: ' . URLROOT . '/disease/success/' . $reportCode);
                        exit();
                    } else {
                        // Database insertion failed, clean up uploaded files
                        if (!empty($uploadedFiles)) {
                            foreach ($uploadedFiles as $fileInfo) {
                                if (file_exists($fileInfo['temp_path'])) {
                                    unlink($fileInfo['temp_path']);
                                }
                            }
                        }
                        $data['media_error'] = 'Database insertion failed. Please try again.';
                        $this->view('disease/disease', $data);
                    }
                } else {
                    // Validation errors found, clean up any uploaded files
                    if (!empty($uploadedFiles)) {
                        foreach ($uploadedFiles as $fileInfo) {
                            if (file_exists($fileInfo['temp_path'])) {
                                unlink($fileInfo['temp_path']);
                            }
                        }
                    }

                    // Redisplay form with errors
                    $this->view('disease/disease', $data);
                }

            } catch (Exception $e) {
                error_log("Exception in Disease submit: " . $e->getMessage());
                echo 'An error occurred: ' . $e->getMessage();
                die();
            }
        } else {
            // Handle GET request - show empty form
            // Check if farmer is logged in and pre-populate NIC
            $farmerNIC = '';
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
                $farmerNIC = $_SESSION['nic'];
            }

            $data = [
                'farmerNIC' => $farmerNIC,
                'plrNumber' => '',
                'observationDate' => '',
                'todayDate' => '',
                'title' => '',
                'description' => '',
                'severity' => '',
                'affectedArea' => '',
                'terms' => '',
                'farmerNIC_error' => '',
                'plrNumber_error' => '',
                'observationDate_error' => '',
                'title_error' => '',
                'description_error' => '',
                'media_error' => '',
                'severity_error' => '',
                'affectedArea_error' => '',
                'terms_error' => ''
            ];
            $this->view('disease/disease', $data);
        }
    }

    // Success page method - UPDATED
    public function success($reportCode = '') { // Changed parameter name
        // Check if user is logged in
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['nic'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        if (empty($reportCode)) {
            header('Location: ' . URLROOT . '/disease');
            exit();
        }

        // Verify the report exists
        $report = $this->model('M_disease')->getReportByCode($reportCode); // Changed

        if (!$report) {
            header('Location: ' . URLROOT . '/disease');
            exit();
        }

        // Check if farmer is logged in and trying to view their own report
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && isset($_SESSION['nic'])) {
            if ($report->farmerNIC !== $_SESSION['nic']) {
                header('Location: ' . URLROOT . '/disease/viewReports');
                exit();
            }
        }

        $data = [
            'report_id' => $reportCode, // Changed to match view expectation
            'report' => $report
        ];

        $this->view('disease/success', $data);
    }

    // Helper method to get MIME type from file extension
    private function getMimeType($extension) {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'mp4' => 'video/mp4',
            'avi' => 'video/avi',
            'mov' => 'video/quicktime',
            'wmv' => 'video/x-ms-wmv'
        ];

        return isset($mimeTypes[strtolower($extension)]) ? $mimeTypes[strtolower($extension)] : 'application/octet-stream';
    }
}
?>