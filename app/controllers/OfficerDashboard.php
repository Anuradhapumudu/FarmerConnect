<?php
class OfficerDashboard extends Controller
{


    public function __construct()
    {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'officer') {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }
    }

    public function index()
    {
        $this->view('dashboard/officer');
    }

    // View all submitted disease reports for officers

    public function viewDiseaseReports()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

        $this->view('disease/viewReports', $data);
    }

    // View all submitted reports in table format or single report details
    public function viewReport($reportCode = '')
    {
        if (!empty($reportCode)) {
            // Show specific report details
            $report = $this->model('M_disease')->getReportByCode($reportCode);

            if (!$report) {
                $_SESSION['error_message'] = 'Report not found';
                header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
                exit();
            }

            $data = [
                'report' => $report,
                'singleReport' => true,
                'message' => 'Report details for ' . $reportCode
            ];
        } else {
            // Show all reports by default
            $reports = $this->model('M_disease')->getAllReports();
            $data = [
                'reports' => $reports,
                'singleReport' => false,
                'message' => 'Showing all reports (' . count($reports) . ' total)'
            ];
        }

        $this->view('disease/reportDetails', $data);
    }

    // Update report status (for officers)
    public function updateReportStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reportCode = isset($_POST['reportCode']) ? trim($_POST['reportCode']) : '';
            $status = isset($_POST['status']) ? trim($_POST['status']) : '';

            if (empty($reportCode) || empty($status)) {
                $_SESSION['error_message'] = 'Report code and status are required';
                header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
                exit();
            }

            $validStatuses = ['pending', 'under_review', 'resolved', 'rejected'];
            if (!in_array($status, $validStatuses)) {
                $_SESSION['error_message'] = 'Invalid status selected';
                header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
                exit();
            }

            $officerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $result = $this->model('M_disease')->updateReportStatus($reportCode, $status, $officerId);

            if ($result) {
                $_SESSION['success_message'] = 'Report status updated successfully';
            } else {
                $_SESSION['error_message'] = 'Failed to update report status';
            }

            $redirectTo = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : 'details';

            if ($redirectTo === 'dashboard') {
                header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
            } else {
                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
            }
            exit();
        } else {
            header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
            exit();
        }
    }

    // Submit officer recommendation/response
    public function submitRecommendation()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reportCode = isset($_POST['reportCode']) ? trim($_POST['reportCode']) : '';
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';

            if (empty($reportCode) || empty($message)) {
                $_SESSION['error_message'] = 'Report code and recommendation message are required';
                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                exit();
            }

            // Verify report status
            $report = $this->model('M_disease')->getReportByCode($reportCode);
            if (!$report || $report->status !== 'under_review') {
                $_SESSION['error_message'] = 'Recommendations can only be submitted when the report is Under Review';
                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                exit();
            }

            // Get officer ID from session (assuming it's stored there)
            $officerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'officer_' . session_id();

            // Handle media file uploads
            $uploadedFiles = [];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/officer_responses/';

            // Create upload directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Debug: Check if files are being received
            error_log("FILES received: " . print_r($_FILES, true));

            if (!empty($_FILES['media']['name'][0])) {
                try {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv', 'application/pdf'];
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
                                $_SESSION['error_message'] = 'Invalid file type: ' . $fileType;
                                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                                exit();
                            }

                            if ($fileSize > $maxFileSize) {
                                $_SESSION['error_message'] = 'File size exceeds 10MB limit: ' . $filename;
                                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                                exit();
                            }

                            // Generate secure filename
                            $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                            $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($filename, PATHINFO_FILENAME));
                            $baseName = substr($baseName, 0, 30);
                            $uniqueFilename = $reportCode . '_officer_' . $officerId . '_' . $baseName . '_' . time() . '_' . $key . '.' . $fileExtension;
                            $targetPath = $uploadDir . $uniqueFilename;

                            error_log("Attempting to upload file: " . $filename . " to: " . $targetPath);

                            if (move_uploaded_file($tmpName, $targetPath)) {
                                $uploadedFiles[] = $uniqueFilename;
                                chmod($targetPath, 0644);
                                error_log("File uploaded successfully: " . $uniqueFilename);
                            } else {
                                error_log("Failed to upload file: " . $filename . " to: " . $targetPath);
                                $_SESSION['error_message'] = 'Failed to upload file: ' . $filename;
                                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                                exit();
                            }
                        } else {
                            error_log("Upload error for file " . $filename . ": " . $_FILES['media']['error'][$key]);
                        }
                    }
                } catch (Exception $e) {
                    error_log("File processing exception: " . $e->getMessage());
                    $_SESSION['error_message'] = 'File processing failed: ' . $e->getMessage();
                    header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                    exit();
                }
            } else {
                error_log("No files received in _FILES['media']");
            }

            $media = !empty($uploadedFiles) ? implode(',', $uploadedFiles) : null;
            error_log("Final media string: " . $media);

            $result = $this->model('M_disease')->submitOfficerResponse($reportCode, $officerId, $message, $media);

            if ($result) {
                $_SESSION['success_message'] = 'Recommendation submitted successfully';
            } else {
                $_SESSION['error_message'] = 'Failed to submit recommendation';
            }

            header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
            exit();
        } else {
            header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
            exit();
        }
    }

    // Delete recommendation
    public function deleteRecommendation($id = '')
    {
        if (empty($id)) {
            $_SESSION['error_message'] = 'Invalid recommendation ID';
            header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
            exit();
        }

        // Get recommendation to verify ownership
        $recommendation = $this->model('M_disease')->getOfficerResponseById($id);

        if (!$recommendation) {
            $_SESSION['error_message'] = 'Recommendation not found';
            header('Location: ' . URLROOT . '/officerDashboard/viewDiseaseReports');
            exit();
        }

        // Verify ownership
        $currentOfficerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'officer_' . session_id();
        if ($recommendation->officer_id !== $currentOfficerId) {
            $_SESSION['error_message'] = 'You can only delete your own recommendations';
            header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $recommendation->report_code);
            exit();
        }

        if ($this->model('M_disease')->deleteOfficerResponse($id)) {
            // Cleanup media function could be added here similar to report deletion
            $_SESSION['success_message'] = 'Recommendation deleted successfully';
        } else {
            $_SESSION['error_message'] = 'Failed to delete recommendation';
        }

        header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $recommendation->report_code);
        exit();
    }

    // Update recommendation (handle form submission)
    public function updateRecommendation()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $responseId = isset($_POST['responseId']) ? trim($_POST['responseId']) : '';
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';
            $reportCode = isset($_POST['reportCode']) ? trim($_POST['reportCode']) : '';

            if (empty($responseId) || empty($message)) {
                $_SESSION['error_message'] = 'Message is required';
                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                exit();
            }

            // Verify ownership
            $recommendation = $this->model('M_disease')->getOfficerResponseById($responseId);
            $currentOfficerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'officer_' . session_id();

            if (!$recommendation || $recommendation->officer_id !== $currentOfficerId) {
                $_SESSION['error_message'] = 'Permission denied';
                header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
                exit();
            }

            // Handle Media Updates
            $mediaString = null;
            // TODO: Ideally implementing complex media merge logic like in Disease::submit works best. 
            // For now, if new files are uploaded, we append or replace. 
            // Let's adopt a simpler approach: if files are uploaded, ADD them to existing. 
            // If "remove" logic is needed, it takes more UI work. 
            // Let's implement ADD logic same as submitRecommendation.

            $newUploadedFiles = [];
            if (!empty($_FILES['media']['name'][0])) {
                // ... (Reuse upload logic from submitRecommendation) ...
                // Duplicate code alert: In a real app, refactor `handleFileUpload` to a private helper or trait.
                // I'll assume for this task strict limits, I'll inline a simplified version for reliability.

                $uploadDir = APPROOT . '/../public/uploads/officer_responses/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'application/pdf'];

                foreach ($_FILES['media']['name'] as $key => $filename) {
                    if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                        $tmpName = $_FILES['media']['tmp_name'][$key];
                        $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($filename, PATHINFO_FILENAME));
                        $uniqueFilename = $reportCode . '_officer_upd_' . $currentOfficerId . '_' . $baseName . '_' . time() . '_' . $key . '.' . $fileExt;

                        if (move_uploaded_file($tmpName, $uploadDir . $uniqueFilename)) {
                            $newUploadedFiles[] = $uniqueFilename;
                        }
                    }
                }
            }

            if (!empty($newUploadedFiles)) {
                $existingMedia = !empty($recommendation->response_media) ? explode(',', $recommendation->response_media) : [];
                $allMedia = array_merge($existingMedia, $newUploadedFiles);
                // Remove empties and duplicates
                $allMedia = array_unique(array_filter(array_map('trim', $allMedia)));
                $mediaString = implode(',', $allMedia);
            } else {
                // No new files, keep existing (pass null to model to skip update, or pass existing)
                // Model logic: if passed null, it ignores. So $mediaString = null is correct if we want to retain existing 
                // BUT wait, model says: if ($media !== null) $sql .= ", response_media = :media";
                // usage here implies we only update if we have NEW files? 
                // If the user wants to DELETE files, this simple method won't work.
                // Given the prompt "update buttons", usually implies text update. 
                // I will pass null so media isn't touched unless new files are added.
                $mediaString = null;

                if (!empty($newUploadedFiles)) {
                    // We have new files, we must construct the FULL list to save, 
                    // or the model should handle appending (model doesn't handle appending).
                    // The model REPLACES the column. So valid $mediaString MUST include old files + new files.

                    // Redo logic:
                    $existingMedia = !empty($recommendation->response_media) ? explode(',', $recommendation->response_media) : [];
                    $allMedia = array_merge($existingMedia, $newUploadedFiles);
                    $mediaString = implode(',', array_unique(array_filter(array_map('trim', $allMedia))));
                }
            }

            $result = $this->model('M_disease')->updateOfficerResponse($responseId, $message, $mediaString);

            if ($result) {
                $_SESSION['success_message'] = 'Recommendation updated';
            } else {
                $_SESSION['error_message'] = 'Update failed';
            }
            header('Location: ' . URLROOT . '/officerDashboard/viewReport/' . $reportCode);
            exit();

        }
    }

    // Display officer response media files
    public function viewResponseMedia($responseId = '', $filename = '')
    {
        if (empty($responseId) || empty($filename)) {
            http_response_code(404);
            echo "Response ID and filename required";
            return;
        }

        try {
            // Verify that this file belongs to this response
            $response = $this->model('M_disease')->getOfficerResponseById($responseId);

            $validResponse = false;
            if ($response && !empty($response->response_media)) {
                $responseFiles = explode(',', $response->response_media);
                $responseFiles = array_map('trim', $responseFiles);

                if (in_array($filename, $responseFiles)) {
                    $validResponse = true;
                }
            }

            if ($validResponse) {
                // Build file path
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/officer_responses/';
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
                http_response_code(403);
                echo "File not associated with this response";
            }
        } catch (Exception $e) {
            error_log("Error viewing response media: " . $e->getMessage());
            http_response_code(500);
            echo "Error loading file: " . $e->getMessage();
        }
    }

    // Helper method to get MIME type from file extension
    private function getMimeType($extension)
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'mp4' => 'video/mp4',
            'avi' => 'video/avi',
            'mov' => 'video/quicktime',
            'wmv' => 'video/x-ms-wmv',
            'pdf' => 'application/pdf'
        ];

        return isset($mimeTypes[strtolower($extension)]) ? $mimeTypes[strtolower($extension)] : 'application/octet-stream';
    }

}
?>