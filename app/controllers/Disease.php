<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class Disease extends Controller{
    
    public function index(){
        // Initialize empty form data for first load
        $data = [
            'reportId' => '', 
            'farmerNIC' => '', 
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
        $this->view('disease', $data);
    }

    // Show form to search/view reports
    public function viewReports(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Handle search form submission
            $farmerNIC = isset($_POST['farmerNIC']) ? trim($_POST['farmerNIC']) : '';
            $plrNumber = isset($_POST['plrNumber']) ? trim($_POST['plrNumber']) : '';
            $reportId = isset($_POST['reportId']) ? trim($_POST['reportId']) : '';

            $reports = $this->model('M_disease')->searchReports($farmerNIC, $plrNumber, $reportId);
            
            $data = [
                'reports' => $reports,
                'farmerNIC' => $farmerNIC,
                'plrNumber' => $plrNumber,
                'reportId' => $reportId,
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
                'reportId' => '',
                'searched' => false,
                'message' => 'Showing all reports (' . count($reports) . ' total)'
            ];
        }
        
        $this->view('viewReports', $data);
    }

    // View detailed report
    public function viewReport($reportId = '') {
        if (empty($reportId)) {
            // Redirect to search page if no report ID provided
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $report = $this->model('M_disease')->getReportById($reportId);

        if (!$report) {
            $data = [
                'error' => 'Report not found',
                'reportId' => $reportId
            ];
        } else {
            // Process media files for display
            $media = [];
            if (!empty($report->media)) {
                $mediaFiles = explode(',', $report->media);
                $mediaFiles = array_map('trim', $mediaFiles);
                foreach ($mediaFiles as $filename) {
                    if (!empty($filename)) {
                        // Check if file actually exists
                        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/' . $filename;
                        $fileExists = file_exists($fullPath);
                        
                        $media[] = (object)[
                            'filename' => $filename,
                            'exists' => $fileExists,
                            'fullPath' => $fullPath
                        ];
                    }
                }
            }

            // Debug: Log the media information
            error_log("Report ID: " . $reportId);
            error_log("Media field from DB: " . $report->media);
            error_log("Number of media files: " . count($media));
            foreach ($media as $index => $mediaItem) {
                error_log("Media file $index: " . $mediaItem->filename . " (exists: " . ($mediaItem->exists ? 'yes' : 'no') . ")");
            }

            $data = [
                'report' => $report,
                'media' => $media,
                'error' => ''
            ];
        }
        
        $this->view('reportDetail', $data);
    }

    // Show edit form for updating report
    public function editReport($reportId = '') {
        if (empty($reportId)) {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $report = $this->model('M_disease')->getReportById($reportId);
        
        if (!$report) {
            $_SESSION['error_message'] = 'Report not found';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        // Populate form with existing data
        $data = [
            'reportId' => $report->reportId,
            'farmerNIC' => $report->farmerNIC,
            'plrNumber' => $report->plrNumber,
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
        
        $this->view('disease', $data);
    }

    // Update report
    public function updateReport() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Sanitize POST data
                $data = [
                    'reportId' => isset($_POST['reportId']) ? trim($_POST['reportId']) : '',
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
                $existingReport = $this->model('M_disease')->getReportById($data['reportId']);
                if (!$existingReport) {
                    $_SESSION['error_message'] = 'Report not found';
                    header('Location: ' . URLROOT . '/disease/viewReports');
                    exit();
                }

                // VALIDATION LOGIC (same as submit method)
                
                // Validate Farmer NIC
                if (empty($data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Please enter your NIC number';
                } elseif (!preg_match('/^([0-9]{9}[vVxX]|[0-9]{12})$/', $data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Invalid NIC format. Use 9 digits with V/X or 12 digits';
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

                                // Generate secure filename
                                $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($filename, PATHINFO_FILENAME));
                                $baseName = substr($baseName, 0, 30);
                                $uniqueFilename = $data['reportId'] . '_' . $baseName . '_' . time() . '.' . $fileExtension;
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
                        header('Location: ' . URLROOT . '/disease/viewReport/' . $data['reportId']);
                        exit();
                    } else {
                        $data['media_error'] = 'Database update failed. Please try again.';
                    }
                }

                // Show form with errors
                $this->view('disease', $data);

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
    public function deleteReport($reportId = '') {
        if (empty($reportId)) {
            $_SESSION['error_message'] = 'Report ID is required';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        // Get report details to clean up media files
        $report = $this->model('M_disease')->getReportById($reportId);
        
        if (!$report) {
            $_SESSION['error_message'] = 'Report not found';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        try {
            // Delete from database first
            $dbResult = $this->model('M_disease')->deleteReport($reportId);
            
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

    // Confirm delete page
    public function confirmDelete($reportId = '') {
        if (empty($reportId)) {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $report = $this->model('M_disease')->getReportById($reportId);
        
        if (!$report) {
            $_SESSION['error_message'] = 'Report not found';
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $data = [
            'report' => $report
        ];
        
        $this->view('confirmDelete', $data);
    }

    // Display media files from file system
    public function viewMedia($reportId = '', $filename = '') {
        if (empty($reportId) || empty($filename)) {
            http_response_code(404);
            echo "Report ID and filename required";
            return;
        }

        try {
            // Verify that this file belongs to this report
            $report = $this->model('M_disease')->getReportById($reportId);
            
            if ($report && !empty($report->media)) {
                $reportFiles = explode(',', $report->media);
                $reportFiles = array_map('trim', $reportFiles);
                
                // Check if the requested filename exists for this report
                if (!in_array($filename, $reportFiles)) {
                    http_response_code(403);
                    echo "File not associated with this report";
                    return;
                }
                
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
    
    // Helper method to get MIME type from file extension
    private function getMimeType($extension) {
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
        
        return isset($mimeTypes[strtolower($extension)]) ? $mimeTypes[strtolower($extension)] : 'application/octet-stream';
    }

    // Submit method with file system upload (existing method - unchanged)
    public function submit(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try {
                // Sanitize POST data
                $data = [
                    'reportId' => isset($_POST['reportId']) ? trim($_POST['reportId']) : '',
                    'farmerNIC' => isset($_POST['farmerNIC']) ? trim($_POST['farmerNIC']) : '',
                    'plrNumber' => isset($_POST['plrNumber']) ? trim($_POST['plrNumber']) : '',
                    'observationDate' => isset($_POST['observationDate']) ? trim($_POST['observationDate']) : '',
                    'title' => isset($_POST['title']) ? trim($_POST['title']) : '',
                    'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
                    'severity' => isset($_POST['severity']) ? trim($_POST['severity']) : '',
                    'affectedArea' => isset($_POST['affectedArea']) ? trim($_POST['affectedArea']) : '',
                    'status' => 'pending', // Default status for new reports
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

                // VALIDATION LOGIC (same as before)
                
                // Validate Farmer NIC
                if (empty($data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Please enter your NIC number';
                } elseif (!preg_match('/^([0-9]{9}[vVxX]|[0-9]{12})$/', $data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Invalid NIC format. Use 9 digits with V/X or 12 digits';
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

                        // Check if directory is writable
                        if (!is_writable($uploadDir)) {
                            $data['media_error'] = 'Upload directory is not writable. Check permissions.';
                        }

                        if (empty($data['media_error'])) {
                            foreach ($_FILES['media']['name'] as $key => $filename) {
                                if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                                    $tmpName = $_FILES['media']['tmp_name'][$key];
                                    $fileSize = $_FILES['media']['size'][$key];
                                    
                                    // Use finfo to get accurate MIME type
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $fileType = $finfo->file($tmpName);

                                    // Validate file type
                                    if (!in_array($fileType, $allowedTypes)) {
                                        $data['media_error'] = 'Invalid file type: ' . $fileType . '. Only JPG, PNG, GIF, and MP4 files are allowed.';
                                        break;
                                    }

                                    // Validate file size
                                    if ($fileSize > $maxFileSize) {
                                        $data['media_error'] = 'File size exceeds 10MB limit: ' . $filename;
                                        break;
                                    }

                                    // Generate secure filename
                                    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                    $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($filename, PATHINFO_FILENAME));
                                    $baseName = substr($baseName, 0, 30); // Limit base name length
                                    $uniqueFilename = $data['reportId'] . '_' . $baseName . '_' . time() . '.' . $fileExtension;
                                    $targetPath = $uploadDir . $uniqueFilename;

                                    // Move uploaded file
                                    if (move_uploaded_file($tmpName, $targetPath)) {
                                        $uploadedFiles[] = $uniqueFilename;
                                        // Set proper file permissions
                                        chmod($targetPath, 0644);
                                    } else {
                                        $data['media_error'] = 'Failed to upload file: ' . $filename . '. Check server permissions.';
                                        break;
                                    }
                                } elseif ($_FILES['media']['error'][$key] !== UPLOAD_ERR_NO_FILE) {
                                    // Handle upload errors
                                    switch ($_FILES['media']['error'][$key]) {
                                        case UPLOAD_ERR_INI_SIZE:
                                        case UPLOAD_ERR_FORM_SIZE:
                                            $data['media_error'] = 'File is too large: ' . $filename;
                                            break;
                                        case UPLOAD_ERR_PARTIAL:
                                            $data['media_error'] = 'File upload was interrupted: ' . $filename;
                                            break;
                                        default:
                                            $data['media_error'] = 'File upload failed: ' . $filename;
                                            break;
                                    }
                                    break;
                                }
                            }

                            // Store filenames as comma-separated string
                            if (empty($data['media_error']) && !empty($uploadedFiles)) {
                                $data['media'] = implode(',', $uploadedFiles);
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
                    $dbResult = $this->model('M_disease')->submitDReport($data);
                    if ($dbResult) {
                        // SUCCESS - Redirect to success page with report ID
                        header('Location: ' . URLROOT . '/disease/success/' . $data['reportId']);
                        exit();
                    } else {
                        // Database insertion failed, clean up uploaded files
                        if (!empty($data['media'])) {
                            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';
                            $filenames = explode(',', $data['media']);
                            foreach ($filenames as $filename) {
                                $filePath = $uploadDir . trim($filename);
                                if (file_exists($filePath)) {
                                    unlink($filePath);
                                }
                            }
                        }
                        $data['media_error'] = 'Database insertion failed. Please try again.';
                        $this->view('disease', $data);
                    }
                } else {
                    // Validation errors found, clean up any uploaded files
                    if (!empty($uploadedFiles)) {
                        foreach ($uploadedFiles as $filename) {
                            $filePath = $uploadDir . $filename;
                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
                        }
                    }
                    
                    // Redisplay form with errors
                    $this->view('disease', $data);
                }

            } catch (Exception $e) {
                error_log("Exception in Disease submit: " . $e->getMessage());
                echo 'An error occurred: ' . $e->getMessage();
                echo '<br><br>Debug info:<br>';
                echo 'POST data: <pre>' . print_r($_POST, true) . '</pre>';
                echo 'FILES data: <pre>' . print_r($_FILES, true) . '</pre>';
                die();
            }
        } else {
            // Handle GET request - show empty form
            $data = [
                'reportId' => '', 
                'farmerNIC' => '', 
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
            $this->view('disease', $data);
        }
    }
    
    // Success page method
    public function success($reportId = '') {
        if (empty($reportId)) {
            header('Location: ' . URLROOT . '/disease');
            exit();
        }
        
        // Verify the report exists
        $report = $this->model('M_disease')->getReportById($reportId);
        
        if (!$report) {
            header('Location: ' . URLROOT . '/disease');
            exit();
        }
        
        $data = [
            'report_id' => $reportId,
            'report' => $report
        ];
        
        $this->view('success', $data);
    }

    // Get reports by severity for filtering
    public function getBySeverity($severity = '') {
        if (empty($severity) || !in_array($severity, ['low', 'medium', 'high'])) {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }

        $reports = $this->model('M_disease')->getReportsBySeverity($severity);
        
        $data = [
            'reports' => $reports,
            'farmerNIC' => '',
            'plrNumber' => '',
            'reportId' => '',
            'searched' => true,
            'message' => ucfirst($severity) . ' severity reports (' . count($reports) . ' found)',
            'filterType' => 'severity',
            'filterValue' => $severity
        ];
        
        $this->view('viewReports', $data);
    }

    // Get reports by date range
    public function getByDateRange() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $startDate = isset($_POST['startDate']) ? trim($_POST['startDate']) : '';
            $endDate = isset($_POST['endDate']) ? trim($_POST['endDate']) : '';
            
            if (empty($startDate) || empty($endDate)) {
                $_SESSION['error_message'] = 'Please provide both start and end dates';
                header('Location: ' . URLROOT . '/disease/viewReports');
                exit();
            }
            
            $reports = $this->model('M_disease')->getReportsByDateRange($startDate, $endDate);
            
            $data = [
                'reports' => $reports,
                'farmerNIC' => '',
                'plrNumber' => '',
                'reportId' => '',
                'searched' => true,
                'message' => 'Reports from ' . $startDate . ' to ' . $endDate . ' (' . count($reports) . ' found)',
                'filterType' => 'dateRange',
                'startDate' => $startDate,
                'endDate' => $endDate
            ];
            
            $this->view('viewReports', $data);
        } else {
            header('Location: ' . URLROOT . '/disease/viewReports');
            exit();
        }
    }

    // Dashboard/Statistics view
    public function dashboard() {
        $model = $this->model('M_disease');
        
        $data = [
            'totalReports' => count($model->getAllReports()),
            'recentReports' => $model->getRecentReports(5),
            'lowSeverity' => count($model->getReportsBySeverity('low')),
            'mediumSeverity' => count($model->getReportsBySeverity('medium')),
            'highSeverity' => count($model->getReportsBySeverity('high'))
        ];
        
        $this->view('dashboard', $data);
    }
}
?>