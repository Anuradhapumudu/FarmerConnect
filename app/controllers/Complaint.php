<?php

/**
 * Complaint Controller
 *
 * Handles complaint submission, viewing, editing, deletion,
 * status updates, officer recommendations, and media streaming.
 */
class Complaint extends Controller
{
    private const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'video/mp4',
        'video/avi',
        'video/x-msvideo',
        'video/quicktime',
        'video/x-ms-wmv',
        'application/pdf',
    ];

    private const MIME_TYPE_MAP = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'mp4' => 'video/mp4',
        'avi' => 'video/x-msvideo',
        'mov' => 'video/quicktime',
        'wmv' => 'video/x-ms-wmv',
        'pdf' => 'application/pdf',
    ];

    private const MAX_FILE_SIZE = 100 * 1024 * 1024; // 100 MB
    private const MAX_FILE_SIZE_LABEL = '100 MB';
    private const MAX_FILENAME_LENGTH = 30;
    private const UPLOAD_DIR_COMPLAINTS = '/public/uploads/complaint_reports/';
    private const UPLOAD_DIR_RESPONSES = '/public/uploads/officer_responses/';

    private const VALID_STATUSES = ['pending', 'under_review', 'resolved', 'rejected'];

    private function isFarmer(): bool
    {
        return ($_SESSION['user_type'] ?? '') === 'farmer';
    }

    private function isOfficer(): bool
    {
        return ($_SESSION['user_type'] ?? '') === 'officer';
    }

    private function isAdmin(): bool
    {
        return ($_SESSION['user_type'] ?? '') === 'admin';
    }

    private function getFarmerNIC(): string
    {
        return ($this->isFarmer() && isset($_SESSION['nic'])) ? $_SESSION['nic'] : '';
    }

    private function getSessionUserId(): string
    {
        return $_SESSION['user_id'] ?? '';
    }

    private function requireLogin(): void
    {
        if (!isset($_SESSION['user_type'])) {
            $this->redirect('/users/login');
        }

        if ($this->isFarmer() && !isset($_SESSION['nic'])) {
            $this->redirect('/users/login');
        }
    }

    private function requireOfficerOrAdmin(): void
    {
        if (!$this->isOfficer() && !$this->isAdmin()) {
            $this->redirect('/complaint/myComplaints');
        }
    }

    private function requireOfficer(): void
    {
        if (!$this->isOfficer()) {
            $this->redirect('/complaint/myComplaints');
        }
    }

    private function requirePost(string $fallbackPath = '/complaint/myComplaints'): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect($fallbackPath);
        }
    }

    private function redirect(string $path): void
    {
        header('Location: ' . URLROOT . $path);
        exit();
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION["{$type}_message"] = $message;
    }

    private function sendHttpError(int $code, string $message): void
    {
        http_response_code($code);
        echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    }

    private function getComplaintOrFail(string $complaintId, bool $includeDeleted = false): object
    {
        $complaint = $this->model('M_complaint')->getComplaintByCode($complaintId, $includeDeleted);

        if (!$complaint) {
            $this->flash('error', 'Complaint not found');
            $this->redirect('/complaint/myComplaints');
        }

        return $complaint;
    }

    private function getResponseOrFail(string $id, string $complaintId = ''): object
    {
        $response = $this->model('M_complaint')->getOfficerResponseById($id);

        if (!$response) {
            $this->flash('error', 'Recommendation not found');
            $this->redirect($complaintId ? "/complaint/viewComplaint/{$complaintId}" : '/complaint/myComplaints');
        }

        return $response;
    }

    private function assertFarmerOwnership(object $complaint): void
    {
        if ($this->isFarmer() && $complaint->farmerNIC !== $this->getFarmerNIC()) {
            $this->flash('error', 'You can only access your own complaints');
            $this->redirect('/complaint/myComplaints');
        }
    }

    private function assertOfficerOwnership(object $response, string $complaintId): void
    {
        if ($response->officer_id !== $this->getSessionUserId()) {
            $this->flash('error', 'You can only modify your own recommendations');
            $this->redirect("/complaint/viewComplaint/{$complaintId}");
        }
    }

    public function index(): void
    {
        $this->requireLogin();

        $farmerNIC = $this->getFarmerNIC();
        $paddyFields = $farmerNIC
            ? $this->model('M_complaint')->getPaddyFieldsByFarmer($farmerNIC)
            : [];

        $this->view('complaint/complaint', [
            'complaint_id' => '',
            'reportCode' => '',
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
            'existingMedia' => '',
            'terms' => '',
            'errors' => [],
        ]);
    }

    public function myComplaints(): void
    {
        $this->requireLogin();

        $data = [
            'searched' => false,
            'farmerNIC' => '',
            'plrNumber' => '',
            'complaint_id' => '',
            'paddyFields' => [],
        ];

        $this->isFarmer()
            ? $this->loadFarmerComplaints($data)
            : $this->loadAdminOfficerComplaints($data);

        foreach ($data['reports'] as &$report) {
            $report->officer_responses = $this->model('M_complaint')
                ->getOfficerResponses($report->complaint_id);
        }

        $this->view('complaint/myComplaints', $data);
    }

    public function viewReports(): void
    {
        $this->myComplaints();
    }

    public function viewComplaint(string $complaintId = ''): void
    {
        $this->requireLogin();

        if (empty($complaintId)) {
            $this->redirect('/complaint/myComplaints');
        }

        $complaint = $this->getComplaintOrFail($complaintId, $this->isAdmin());
        $this->assertFarmerOwnership($complaint);

        $this->view('complaint/viewComplaint', [
            'report' => $complaint,
            'officer_responses' => $this->model('M_complaint')->getOfficerResponses($complaintId),
            'singleReport' => true,
            'message' => "Complaint details for {$complaintId}",
        ]);
    }

    public function viewReport(string $complaintId = ''): void
    {
        $this->viewComplaint($complaintId);
    }

    public function editReport(string $complaintId = ''): void
    {
        $this->requireLogin();

        if (empty($complaintId)) {
            $this->redirect('/complaint/myComplaints');
        }

        $complaint = $this->getComplaintOrFail($complaintId);
        $this->assertFarmerOwnership($complaint);

        $this->view('complaint/complaint', [
            'complaint_id' => $complaint->complaint_id,
            'reportCode' => $complaint->complaint_id,
            'farmerNIC' => $complaint->farmerNIC,
            'paddyFields' => $this->model('M_complaint')->getPaddyFieldsByFarmer($complaint->farmerNIC),
            'plrNumber' => $complaint->plrNumber ?? '',
            'paddySize' => $complaint->paddySize ?? '',
            'observationDate' => $complaint->observationDate,
            'title' => $complaint->title,
            'description' => $complaint->description,
            'severity' => $complaint->severity,
            'affectedArea' => $complaint->affectedArea,
            'existingMedia' => $complaint->media,
            'terms' => 'on',
            'errors' => [],
            'isEdit' => true,
        ]);
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->index();
            return;
        }

        $data = $this->collectPostData() + ['status' => 'pending', 'errors' => []];
        $data['errors'] = $this->validateComplaintData($data)['errors'];

        if (!empty($data['errors'])) {
            $this->renderFormWithErrors($data);
            return;
        }

        $uploadResult = $this->processFileUpload(
            uploadDir: $this->getUploadDir(),
            prefix: 'CPNEW'
        );

        if (isset($uploadResult['error'])) {
            $data['errors']['media_error'] = $uploadResult['error'];
            $this->renderFormWithErrors($data);
            return;
        }

        $data['media'] = $uploadResult['media_string'];
        $complaintId = $this->model('M_complaint')->submitComplaint($data);

        if ($complaintId && !is_array($complaintId)) {
            $this->view('complaint/success', ['complaint_id' => $complaintId]);
            exit();
        }

        $data['errors']['general_error'] = $complaintId['error'] ?? 'A database error occurred.';
        $this->renderFormWithErrors($data);
    }

    public function updateReport(): void
    {
        $this->requirePost();

        try {
            $data = $this->collectPostData() + [
                'complaint_id' => trim($_POST['reportCode'] ?? ''),
                'existingMedia' => trim($_POST['existingMedia'] ?? ''),
                'removeMedia' => $_POST['removeMedia'] ?? [],
                'errors' => [],
                'isEdit' => true,
            ];

            $this->getComplaintOrFail($data['complaint_id']);
            $data['errors'] = $this->validateComplaintData($data)['errors'];

            if (!empty($data['errors'])) {
                $this->renderFormWithErrors($data);
                return;
            }

            $uploadResult = $this->processFileUpload(
                uploadDir: $this->getUploadDir(),
                prefix: $data['complaint_id'],
                existingMedia: $data['existingMedia'],
                removeMedia: $data['removeMedia']
            );

            if (isset($uploadResult['error'])) {
                $data['errors']['media_error'] = $uploadResult['error'];
                $this->renderFormWithErrors($data);
                return;
            }

            $data['media'] = $uploadResult['media_string'];

            if ($this->model('M_complaint')->updateComplaint($data)) {
                $this->flash('success', 'Complaint updated successfully');
                $this->redirect('/complaint/viewComplaint/' . $data['complaint_id']);
            }

            $data['errors']['general_error'] = 'Database update failed. Please try again.';
            $this->renderFormWithErrors($data);
        } catch (Exception $e) {
            error_log('Exception in updateReport: ' . $e->getMessage());
            $this->flash('error', 'An error occurred while updating the complaint');
            $this->redirect('/complaint/myComplaints');
        }
    }

    public function deleteReport(string $complaintId = ''): void
    {
        $this->requireLogin();

        if (empty($complaintId)) {
            $this->flash('error', 'Complaint ID is required');
            $this->redirect('/complaint/myComplaints');
        }

        $complaint = $this->getComplaintOrFail($complaintId);
        $this->assertFarmerOwnership($complaint);

        try {
            $this->model('M_complaint')->deleteComplaint($complaintId)
                ? $this->flash('success', 'Complaint deleted successfully')
                : $this->flash('error', 'Failed to delete complaint');
        } catch (Exception $e) {
            error_log('Exception in deleteReport: ' . $e->getMessage());
            $this->flash('error', 'An error occurred while deleting the complaint');
        }

        $this->redirect('/complaint/myComplaints');
    }

    public function success(?string $complaintId = null): void
    {
        $this->requireLogin();

        if ($complaintId === null) {
            $this->redirect('/complaint');
        }

        $this->view('complaint/success', ['complaint_id' => $complaintId]);
    }

    public function updateReportStatus(): void
    {
        $this->requireLogin();
        $this->requireOfficerOrAdmin();
        $this->requirePost();

        $complaintId = trim($_POST['reportCode'] ?? '');
        $status = trim($_POST['status'] ?? '');

        if (empty($complaintId) || empty($status)) {
            $this->flash('error', 'Complaint ID and status are required');
            $this->redirect('/complaint/myComplaints');
        }

        if (!in_array($status, self::VALID_STATUSES, true)) {
            $this->flash('error', 'Invalid status selected');
            $this->redirect("/complaint/viewComplaint/{$complaintId}");
        }

        $this->model('M_complaint')->updateReportStatus($complaintId, $status, $this->getSessionUserId())
            ? $this->flash('success', 'Complaint status updated successfully')
            : $this->flash('error', 'Failed to update complaint status');

        $this->redirect("/complaint/viewComplaint/{$complaintId}");
    }

    public function submitRecommendation(): void
    {
        $this->requireLogin();
        $this->requireOfficer();
        $this->requirePost();

        $complaintId = trim($_POST['reportCode'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($complaintId) || empty($message)) {
            $this->flash('error', 'Complaint ID and recommendation message are required');
            $this->redirect("/complaint/viewComplaint/{$complaintId}");
        }

        $complaint = $this->getComplaintOrFail($complaintId);
        if (strtolower(trim($complaint->status)) !== 'under_review') {
            $this->flash('error', 'Recommendations can only be submitted when the complaint is Under Review');
            $this->redirect("/complaint/viewComplaint/{$complaintId}");
        }

        $officerId = $this->getSessionUserId();
        $uploadResult = $this->processFileUpload(
            uploadDir: $this->getUploadDir(self::UPLOAD_DIR_RESPONSES),
            prefix: "{$complaintId}_officer_{$officerId}"
        );

        if (isset($uploadResult['error'])) {
            $this->flash('error', $uploadResult['error']);
            $this->redirect("/complaint/viewComplaint/{$complaintId}");
        }

        $media = $uploadResult['media_string'] ?: null;

        $this->model('M_complaint')->submitOfficerResponse($complaintId, $officerId, $message, $media)
            ? $this->flash('success', 'Recommendation submitted successfully')
            : $this->flash('error', 'Failed to submit recommendation');

        $this->redirect("/complaint/viewComplaint/{$complaintId}");
    }

    public function updateRecommendation(): void
    {
        $this->requireLogin();
        $this->requireOfficer();
        $this->requirePost();

        $responseId = trim($_POST['responseId'] ?? '');
        $complaintId = trim($_POST['reportCode'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($responseId) || empty($message)) {
            $this->flash('error', 'Message is required');
            $this->redirect("/complaint/viewComplaint/{$complaintId}");
        }

        $response = $this->getResponseOrFail($responseId, $complaintId);
        $this->assertOfficerOwnership($response, $complaintId);

        $officerId = $this->getSessionUserId();
        $uploadResult = $this->processFileUpload(
            uploadDir: $this->getUploadDir(self::UPLOAD_DIR_RESPONSES),
            prefix: "{$complaintId}_officer_{$officerId}",
            existingMedia: $response->response_media ?? ''
        );

        if (isset($uploadResult['error'])) {
            $this->flash('error', $uploadResult['error']);
            $this->redirect("/complaint/viewComplaint/{$complaintId}");
        }

        $media = $uploadResult['media_string'] ?: null;

        $this->model('M_complaint')->updateOfficerResponse($responseId, $message, $media)
            ? $this->flash('success', 'Recommendation updated successfully')
            : $this->flash('error', 'Failed to update recommendation');

        $this->redirect("/complaint/viewComplaint/{$complaintId}");
    }

    public function deleteRecommendation(string $id = ''): void
    {
        $this->requireLogin();
        $this->requireOfficer();

        if (empty($id)) {
            $this->flash('error', 'Invalid recommendation ID');
            $this->redirect('/complaint/myComplaints');
        }

        $response = $this->getResponseOrFail($id);
        $this->assertOfficerOwnership($response, $response->complaint_id);

        $this->model('M_complaint')->deleteOfficerResponse($id)
            ? $this->flash('success', 'Recommendation deleted successfully')
            : $this->flash('error', 'Failed to delete recommendation');

        $this->redirect('/complaint/viewComplaint/' . $response->complaint_id);
    }

    public function viewMedia(string $complaintId = '', string $filename = ''): void
    {
        if (!isset($_SESSION['user_type'])) {
            $this->redirect('/users/login');
        }

        if (empty($complaintId) || empty($filename)) {
            $this->sendHttpError(404, 'Complaint ID and filename are required');
            return;
        }

        try {
            $complaint = $this->model('M_complaint')->getComplaintByCode($complaintId, $this->isAdmin());

            if (!$complaint) {
                $this->sendHttpError(403, 'File not associated with this complaint');
                return;
            }

            $resolvedPath = $this->resolveMediaPathFromList(
                requestedFilename: $filename,
                fileList: $complaint->media ?? '',
                defaultDir: $this->getUploadDir()
            );

            if ($resolvedPath === null) {
                $this->sendHttpError(403, 'File not associated with this complaint');
                return;
            }

            if ($this->isFarmer() && $complaint->farmerNIC !== $this->getFarmerNIC()) {
                $this->sendHttpError(403, 'You can only view media from your own complaints');
                return;
            }

            $this->streamFile($resolvedPath);
        } catch (Exception $e) {
            error_log('Error in viewMedia: ' . $e->getMessage());
            $this->sendHttpError(500, 'Error loading file');
        }
    }

    public function viewResponseMedia(string $responseId = '', string $filename = ''): void
    {
        if (empty($responseId) || empty($filename)) {
            $this->sendHttpError(404, 'Response ID and filename are required');
            return;
        }

        try {
            $response = $this->model('M_complaint')->getOfficerResponseById($responseId);

            if (!$response) {
                $this->sendHttpError(403, 'File not associated with this response');
                return;
            }

            $resolvedPath = $this->resolveMediaPathFromList(
                requestedFilename: $filename,
                fileList: $response->response_media ?? '',
                defaultDir: $this->getUploadDir(self::UPLOAD_DIR_RESPONSES)
            );

            if ($resolvedPath === null) {
                $this->sendHttpError(403, 'File not associated with this response');
                return;
            }

            $this->streamFile($resolvedPath);
        } catch (Exception $e) {
            error_log('Error in viewResponseMedia: ' . $e->getMessage());
            $this->sendHttpError(500, 'Error loading file');
        }
    }

    private function loadFarmerComplaints(array &$data): void
    {
        $nic = $this->getFarmerNIC();
        $plrNumber = trim($_GET['plrNumber'] ?? '');
        $complaintId = trim($_GET['complaint_id'] ?? '');
        $hasFilters = isset($_GET['complaint_id']) || isset($_GET['plrNumber']);

        $data['farmerNIC'] = $nic;
        $data['paddyFields'] = $this->model('M_complaint')->getPaddyFieldsByFarmer($nic);

        if ($hasFilters && (!empty($plrNumber) || !empty($complaintId))) {
            $reports = $this->model('M_complaint')->searchReports($nic, $plrNumber, $complaintId);
            $data['plrNumber'] = $plrNumber;
            $data['complaint_id'] = $complaintId;
            $data['searched'] = true;
            $data['message'] = count($reports) . ' of your complaint(s) found';
        } else {
            $reports = $this->model('M_complaint')->getComplaintsByFarmer($nic);
            $data['message'] = 'Showing your complaints (' . count($reports) . ' total)';
        }

        $data['reports'] = $reports;
    }

    private function loadAdminOfficerComplaints(array &$data): void
    {
        $includeDeleted = $this->isAdmin();
        $farmerNIC = trim($_GET['farmerNIC'] ?? '');
        $plrNumber = trim($_GET['plrNumber'] ?? '');
        $complaintId = trim($_GET['complaint_id'] ?? '');
        $hasFilters = isset($_GET['complaint_id']) || isset($_GET['plrNumber']) || isset($_GET['farmerNIC']);

        if ($hasFilters && (!empty($farmerNIC) || !empty($plrNumber) || !empty($complaintId))) {
            $reports = $this->model('M_complaint')->searchReports($farmerNIC, $plrNumber, $complaintId, $includeDeleted);
            $data['farmerNIC'] = $farmerNIC;
            $data['plrNumber'] = $plrNumber;
            $data['complaint_id'] = $complaintId;
            $data['searched'] = true;
            $data['message'] = count($reports) . ' complaint(s) found';
        } else {
            $reports = $this->model('M_complaint')->getAllComplaints(null, null, $includeDeleted);
            $data['farmerNIC'] = '';
            $data['message'] = 'Showing all complaints (' . count($reports) . ' total)';
        }

        $data['reports'] = $reports;
    }

    private function collectPostData(): array
    {
        return [
            'farmerNIC' => trim($_POST['farmerNIC'] ?? ''),
            'plrNumber' => trim($_POST['plrNumber'] ?? ''),
            'paddySize' => trim($_POST['paddySize'] ?? ''),
            'observationDate' => trim($_POST['observationDate'] ?? ''),
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'severity' => trim($_POST['severity'] ?? ''),
            'affectedArea' => trim($_POST['affectedArea'] ?? ''),
            'terms' => $_POST['terms'] ?? '',
        ];
    }

    private function renderFormWithErrors(array &$data): void
    {
        $data['complaint_id'] = $data['complaint_id'] ?? '';
        $data['reportCode'] = $data['reportCode'] ?? ($data['complaint_id'] ?? '');
        $data['existingMedia'] = $data['existingMedia'] ?? '';
        $data['paddyFields'] = $this->model('M_complaint')->getPaddyFieldsByFarmer($data['farmerNIC']);
        $this->view('complaint/complaint', $data);
    }

    /**
     * @return array{isValid: bool, errors: array<string, string>}
     */
    private function validateComplaintData(array $data): array
    {
        $errors = [];

        if (empty($data['farmerNIC'])) {
            $errors['farmerNIC_error'] = 'Please enter your NIC number';
        } elseif (!preg_match('/^([0-9]{9}[vV]|[0-9]{12})$/', $data['farmerNIC'])) {
            $errors['farmerNIC_error'] = 'Invalid NIC format. Use 9 digits + V/v, or 12 digits';
        }

        if (empty($data['plrNumber'])) {
            $errors['plrNumber_error'] = 'PLR number is required';
        } elseif (!preg_match('/^\d{2}\/\d{2}\/\d{5}\/\d{3}\/[A-Za-z]\/\d{4}$/', $data['plrNumber'])) {
            $errors['plrNumber_error'] = 'Invalid PLR format - example: 02/25/00083/001/P/0066';
        } else {
            $paddyRecord = $this->model('M_complaint')->getPaddyByPLR($data['plrNumber']);
            if (!$paddyRecord || $paddyRecord->NIC_FK !== $data['farmerNIC']) {
                $errors['plrNumber_error'] = 'PLR number not found in your registered paddy fields';
            }
        }

        if (empty($data['observationDate'])) {
            $errors['observationDate_error'] = 'Please select the observation date';
        } else {
            $obsDate = DateTime::createFromFormat('Y-m-d', $data['observationDate']);
            if (!$obsDate) {
                $errors['observationDate_error'] = 'Invalid date format';
            } elseif ($obsDate > new DateTime()) {
                $errors['observationDate_error'] = 'Observation date cannot be in the future';
            }
        }

        $titleLen = strlen($data['title']);
        if (empty($data['title'])) {
            $errors['title_error'] = 'Please enter a complaint title';
        } elseif ($titleLen < 5) {
            $errors['title_error'] = 'Title must be at least 5 characters';
        } elseif ($titleLen > 200) {
            $errors['title_error'] = 'Title must be 200 characters or fewer';
        }

        $descLen = strlen($data['description']);
        if (empty($data['description'])) {
            $errors['description_error'] = 'Please enter a detailed description';
        } elseif ($descLen < 20) {
            $errors['description_error'] = 'Description must be at least 20 characters';
        } elseif ($descLen > 2000) {
            $errors['description_error'] = 'Description must be 2000 characters or fewer';
        }

        if (empty($data['severity'])) {
            $errors['severity_error'] = 'Please select a severity level';
        } elseif (!in_array($data['severity'], ['low', 'medium', 'high'], true)) {
            $errors['severity_error'] = 'Invalid severity level selected';
        }

        $area = (float) ($data['affectedArea'] ?? 0);
        if (empty($data['affectedArea'])) {
            $errors['affectedArea_error'] = 'Please enter the affected area';
        } elseif (!is_numeric($data['affectedArea'])) {
            $errors['affectedArea_error'] = 'Affected area must be a valid number';
        } elseif ($area <= 0) {
            $errors['affectedArea_error'] = 'Affected area must be greater than 0';
        } elseif ($area > 10000) {
            $errors['affectedArea_error'] = 'Affected area seems too large (max 10,000 acres)';
        } elseif (!empty($data['plrNumber'])) {
            $paddyData = $this->model('M_complaint')->getPaddyByPLR($data['plrNumber']);
            if ($paddyData && $area > (float) $paddyData->Paddy_Size) {
                $errors['affectedArea_error'] =
                    "Affected area cannot exceed the total paddy size ({$paddyData->Paddy_Size} acres)";
            }
        }

        if (($data['terms'] ?? '') !== 'on') {
            $errors['terms_error'] = 'You must agree to the terms and conditions';
        }

        return ['isValid' => empty($errors), 'errors' => $errors];
    }

    /**
     * @param  string   $uploadDir
     * @param  string   $prefix
     * @param  string   $existingMedia
     * @param  string[] $removeMedia
     * @return array{media_string: string}|array{error: string}
     */
    private function processFileUpload(
        string $uploadDir,
        string $prefix = 'NEW',
        string $existingMedia = '',
        array $removeMedia = []
    ): array {
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            return ['error' => 'Failed to create the upload directory'];
        }

        $finalFiles = $this->filterExistingMedia($existingMedia, $removeMedia, $uploadDir);

        if (!empty($_FILES['media']['name'][0])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);

            foreach ($_FILES['media']['name'] as $index => $originalName) {
                if ($_FILES['media']['error'][$index] !== UPLOAD_ERR_OK) {
                    continue;
                }

                $tmpPath = $_FILES['media']['tmp_name'][$index];
                $mimeType = $finfo->file($tmpPath);
                $fileSize = $_FILES['media']['size'][$index];

                if (!in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
                    return ['error' => "File type not allowed: {$mimeType}"];
                }

                if ($fileSize > self::MAX_FILE_SIZE) {
                    return ['error' => 'File exceeds the ' . self::MAX_FILE_SIZE_LABEL . " limit: {$originalName}"];
                }

                $newFilename = $this->buildUniqueFilename($prefix, $originalName, $index);
                $targetPath = $uploadDir . $newFilename;

                if (!move_uploaded_file($tmpPath, $targetPath)) {
                    return ['error' => "Failed to upload file: {$originalName}"];
                }

                chmod($targetPath, 0644);
                $finalFiles[] = $newFilename;
            }
        }

        return ['media_string' => implode(',', $finalFiles)];
    }

    /**
     * @param  string[] $removeMedia
     * @return string[]
     */
    private function filterExistingMedia(string $existingMedia, array $removeMedia, string $uploadDir): array
    {
        if (empty($existingMedia)) {
            return [];
        }

        $kept = [];
        foreach (array_map('trim', explode(',', $existingMedia)) as $file) {
            if (in_array($file, $removeMedia, true)) {
                $path = $uploadDir . $file;
                if (file_exists($path)) {
                    unlink($path);
                }
            } else {
                $kept[] = $file;
            }
        }

        return $kept;
    }

    private function buildUniqueFilename(string $prefix, string $originalName, int $index): string
    {
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $baseName = substr($baseName, 0, self::MAX_FILENAME_LENGTH);

        return "{$prefix}_{$baseName}_" . time() . "_{$index}.{$ext}";
    }

    private function getUploadDir(string $subDir = self::UPLOAD_DIR_COMPLAINTS): string
    {
        return dirname(APPROOT) . $subDir;
    }

    private function normalizeFilename(string $filename): string
    {
        return trim(rawurldecode($filename));
    }

    /**
     * Resolves a file request against stored media values and returns the real path.
     * Supports both filename-only entries and legacy entries that contain paths.
     */
    private function resolveMediaPathFromList(string $requestedFilename, string $fileList, string $defaultDir): ?string
    {
        $requested = $this->normalizeFilename($requestedFilename);
        $requestedBase = basename($requested);

        $entries = array_filter(array_map('trim', explode(',', $fileList)));
        foreach ($entries as $entry) {
            $entryDecoded = $this->normalizeFilename($entry);
            $entryBase = basename($entryDecoded);

            if ($requested !== $entryDecoded && $requestedBase !== $entryBase) {
                continue;
            }

            $candidates = [
                $defaultDir . $entryBase,
                dirname(APPROOT) . '/' . ltrim($entryDecoded, '/'),
                dirname(APPROOT) . '/public/' . ltrim($entryDecoded, '/'),
            ];

            foreach ($candidates as $candidate) {
                if (file_exists($candidate)) {
                    return $candidate;
                }
            }
        }

        return null;
    }

    private function streamFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            $this->sendHttpError(404, 'File not found on server');
            return;
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeType = self::MIME_TYPE_MAP[$ext] ?? 'application/octet-stream';

        while (ob_get_level()) {
            ob_end_clean();
        }

        header("Content-Type: {$mimeType}");
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Cache-Control: public, max-age=86400');

        readfile($filePath);
        exit();
    }
}
