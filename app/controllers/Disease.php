<?php

/**
 * Disease Controller
 *
 * Handles disease report submission, viewing, editing, deleting,
 * and media management for farmers, officers, and admins.
 */
class Disease extends Controller
{
    // ─── Constants ────────────────────────────────────────────────────────────

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
    private const UPLOAD_DIR_REPORTS = '/public/uploads/disease_reports/';
    private const UPLOAD_DIR_RESPONSES = '/public/uploads/officer_responses/';

    private const VALID_STATUSES = ['pending', 'under_review', 'resolved', 'rejected'];

    // ─── Session / Role Helpers ───────────────────────────────────────────────

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

    // ─── Guard Helpers ────────────────────────────────────────────────────────

    /** Redirects to login if no valid session exists. */
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user_type'])) {
            $this->redirect('/users/login');
        }

        if ($this->isFarmer() && !isset($_SESSION['nic'])) {
            $this->redirect('/users/login');
        }
    }

    /** Aborts with a redirect if the current user is not an officer or admin. */
    private function requireOfficerOrAdmin(): void
    {
        if (!$this->isOfficer() && !$this->isAdmin()) {
            $this->redirect('/disease/viewReports');
        }
    }

    /** Aborts with a redirect if the current user is not an officer. */
    private function requireOfficer(): void
    {
        if (!$this->isOfficer()) {
            $this->redirect('/disease/viewReports');
        }
    }

    /** Aborts if the request method is not POST. */
    private function requirePost(string $fallbackPath = '/disease/viewReports'): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect($fallbackPath);
        }
    }

    // ─── Navigation / Response Helpers ───────────────────────────────────────

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

    // ─── Report Fetch Helpers ─────────────────────────────────────────────────

    /**
     * Returns the report or redirects with an error if it cannot be found.
     */
    private function getReportOrFail(string $reportCode, bool $includeDeleted = false): object
    {
        $report = $this->model('M_disease')->getReportByCode($reportCode, $includeDeleted);

        if (!$report) {
            $this->flash('error', 'Report not found');
            $this->redirect('/disease/viewReports');
        }

        return $report;
    }

    /**
     * Returns the officer response or redirects with an error if it cannot be found.
     */
    private function getResponseOrFail(string $id, string $reportCode = ''): object
    {
        $response = $this->model('M_disease')->getOfficerResponseById($id);

        if (!$response) {
            $this->flash('error', 'Recommendation not found');
            $this->redirect($reportCode ? "/disease/viewReport/{$reportCode}" : '/disease/viewReports');
        }

        return $response;
    }

    /**
     * Ensures a farmer can only touch their own report.
     */
    private function assertFarmerOwnership(object $report): void
    {
        if ($this->isFarmer() && $report->farmerNIC !== $this->getFarmerNIC()) {
            $this->flash('error', 'You can only access your own reports');
            $this->redirect('/disease/viewReports');
        }
    }

    /**
     * Ensures an officer can only modify their own response.
     */
    private function assertOfficerOwnership(object $response, string $reportCode): void
    {
        if ($response->officer_id !== $this->getSessionUserId()) {
            $this->flash('error', 'You can only modify your own recommendations');
            $this->redirect("/disease/viewReport/{$reportCode}");
        }
    }

    // ─── Public Actions: Farmer ───────────────────────────────────────────────

    /** Shows the disease report submission form. */
    public function index(): void
    {
        $this->requireLogin();

        $farmerNIC = $this->getFarmerNIC();
        $paddyFields = $farmerNIC
            ? $this->model('M_disease')->getPaddyFieldsByFarmer($farmerNIC)
            : [];

        $this->view('disease/disease', [
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
            'errors' => [],
        ]);
    }

    /** Shows the list of disease reports (filtered by role). */
    public function viewReports(): void
    {
        $this->requireLogin();

        $data = ['searched' => false, 'plrNumber' => '', 'reportCode' => ''];

        $this->isFarmer()
            ? $this->loadFarmerReports($data)
            : $this->loadAdminOfficerReports($data);

        foreach ($data['reports'] as &$report) {
            $report->officer_responses = $this->model('M_disease')
                ->getOfficerResponses($report->report_code);
        }

        $this->view('disease/viewReports', $data);
    }

    /** Shows a single report's details. */
    public function viewReport(string $reportCode = ''): void
    {
        $this->requireLogin();

        if (empty($reportCode)) {
            $this->redirect('/disease/viewReports');
        }

        $report = $this->getReportOrFail($reportCode, $this->isAdmin());
        $this->assertFarmerOwnership($report);

        $this->view('disease/reportDetails', [
            'report' => $report,
            'officer_responses' => $this->model('M_disease')->getOfficerResponses($reportCode),
            'singleReport' => true,
            'message' => "Report details for {$reportCode}",
        ]);
    }

    /** Shows the edit form pre-populated with a report's existing data. */
    public function editReport(string $reportCode = ''): void
    {
        $this->requireLogin();

        if (empty($reportCode)) {
            $this->redirect('/disease/viewReports');
        }

        $report = $this->getReportOrFail($reportCode);
        $this->assertFarmerOwnership($report);

        $this->view('disease/disease', [
            'reportCode' => $report->report_code,
            'farmerNIC' => $report->farmerNIC,
            'paddyFields' => $this->model('M_disease')->getPaddyFieldsByFarmer($report->farmerNIC),
            'plrNumber' => $report->pirNumber ?? $report->plrNumber ?? '',
            'paddySize' => $report->paddySize ?? '',
            'observationDate' => $report->observationDate,
            'title' => $report->title,
            'description' => $report->description,
            'severity' => $report->severity,
            'affectedArea' => $report->affectedArea,
            'existingMedia' => $report->media,
            'terms' => 'on',
            'errors' => [],
            'isEdit' => true,
        ]);
    }

    /** Handles new report submission. */
    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->index();
            return;
        }

        $data = $this->collectPostData() + ['status' => 'pending', 'errors' => []];
        $data['errors'] = $this->validateReportData($data)['errors'];

        if (!empty($data['errors'])) {
            $this->renderFormWithErrors($data);
            return;
        }

        $uploadResult = $this->processFileUpload(
            uploadDir: $this->getUploadDir(),
            prefix: 'NEW'
        );

        if (isset($uploadResult['error'])) {
            $data['errors']['media_error'] = $uploadResult['error'];
            $this->renderFormWithErrors($data);
            return;
        }

        $data['media'] = $uploadResult['media_string'];
        $reportCode = $this->model('M_disease')->submitDReport($data);

        if ($reportCode && !is_array($reportCode)) {
            $this->view('disease/success', ['report_id' => $reportCode]);
            exit();
        }

        $data['errors']['general_error'] = $reportCode['error'] ?? 'A database error occurred.';
        $this->renderFormWithErrors($data);
    }

    /** Handles updates to an existing report. */
    public function updateReport(): void
    {
        $this->requirePost();

        try {
            $data = $this->collectPostData() + [
                'report_code' => trim($_POST['reportCode'] ?? ''),
                'existingMedia' => trim($_POST['existingMedia'] ?? ''),
                'removeMedia' => $_POST['removeMedia'] ?? [],
                'errors' => [],
                'isEdit' => true,
            ];

            $this->getReportOrFail($data['report_code']);
            $data['errors'] = $this->validateReportData($data)['errors'];

            if (!empty($data['errors'])) {
                $this->renderFormWithErrors($data);
                return;
            }

            $uploadResult = $this->processFileUpload(
                uploadDir: $this->getUploadDir(),
                prefix: $data['report_code'],
                existingMedia: $data['existingMedia'],
                removeMedia: $data['removeMedia']
            );

            if (isset($uploadResult['error'])) {
                $data['errors']['media_error'] = $uploadResult['error'];
                $this->renderFormWithErrors($data);
                return;
            }

            $data['media'] = $uploadResult['media_string'];

            if ($this->model('M_disease')->updateReport($data)) {
                $this->flash('success', 'Report updated successfully');
                $this->redirect('/disease/viewReport/' . $data['report_code']);
            }

            $data['errors']['general_error'] = 'Database update failed. Please try again.';
            $this->renderFormWithErrors($data);

        } catch (Exception $e) {
            error_log("Exception in updateReport: " . $e->getMessage());
            $this->flash('error', 'An error occurred while updating the report');
            $this->redirect('/disease/viewReports');
        }
    }

    /** Soft-deletes a report. */
    public function deleteReport(string $reportCode = ''): void
    {
        $this->requireLogin();

        if (empty($reportCode)) {
            $this->flash('error', 'Report code is required');
            $this->redirect('/disease/viewReports');
        }

        $report = $this->getReportOrFail($reportCode);
        $this->assertFarmerOwnership($report);

        try {
            $this->model('M_disease')->deleteReport($reportCode)
                ? $this->flash('success', 'Report deleted successfully')
                : $this->flash('error', 'Failed to delete report');

        } catch (Exception $e) {
            error_log("Exception in deleteReport: " . $e->getMessage());
            $this->flash('error', 'An error occurred while deleting the report');
        }

        $this->redirect('/disease/viewReports');
    }

    /** Shows the success page after a report is submitted. */
    public function success(?string $reportId = null): void
    {
        $this->requireLogin();

        if ($reportId === null) {
            $this->redirect('/disease');
        }

        $this->view('disease/success', ['report_id' => $reportId]);
    }

    // ─── Public Actions: Officer ──────────────────────────────────────────────

    /** Updates a report's status (officer or admin only). */
    public function updateReportStatus(): void
    {
        $this->requireLogin();
        $this->requireOfficerOrAdmin();
        $this->requirePost();

        $reportCode = trim($_POST['reportCode'] ?? '');
        $status = trim($_POST['status'] ?? '');

        if (empty($reportCode) || empty($status)) {
            $this->flash('error', 'Report code and status are required');
            $this->redirect('/disease/viewReports');
        }

        if (!in_array($status, self::VALID_STATUSES, true)) {
            $this->flash('error', 'Invalid status selected');
            $this->redirect("/disease/viewReport/{$reportCode}");
        }

        $this->model('M_disease')->updateReportStatus($reportCode, $status, $this->getSessionUserId())
            ? $this->flash('success', 'Report status updated successfully')
            : $this->flash('error', 'Failed to update report status');

        $this->redirect("/disease/viewReport/{$reportCode}");
    }

    /** Submits a new recommendation for a report (officer only). */
    public function submitRecommendation(): void
    {
        $this->requireLogin();
        $this->requireOfficer();
        $this->requirePost();

        $reportCode = trim($_POST['reportCode'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($reportCode) || empty($message)) {
            $this->flash('error', 'Report code and recommendation message are required');
            $this->redirect("/disease/viewReport/{$reportCode}");
        }

        $report = $this->getReportOrFail($reportCode);
        if ($report->status !== 'under_review') {
            $this->flash('error', 'Recommendations can only be submitted when the report is Under Review');
            $this->redirect("/disease/viewReport/{$reportCode}");
        }

        $officerId = $this->getSessionUserId();
        $uploadResult = $this->processFileUpload(
            uploadDir: $this->getUploadDir(self::UPLOAD_DIR_RESPONSES),
            prefix: "{$reportCode}_officer_{$officerId}"
        );

        if (isset($uploadResult['error'])) {
            $this->flash('error', $uploadResult['error']);
            $this->redirect("/disease/viewReport/{$reportCode}");
        }

        $media = $uploadResult['media_string'] ?: null;

        $this->model('M_disease')->submitOfficerResponse($reportCode, $officerId, $message, $media)
            ? $this->flash('success', 'Recommendation submitted successfully')
            : $this->flash('error', 'Failed to submit recommendation');

        $this->redirect("/disease/viewReport/{$reportCode}");
    }

    /** Edits an existing recommendation (the authoring officer only). */
    public function updateRecommendation(): void
    {
        $this->requireLogin();
        $this->requireOfficer();
        $this->requirePost();

        $responseId = trim($_POST['responseId'] ?? '');
        $reportCode = trim($_POST['reportCode'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($responseId) || empty($message)) {
            $this->flash('error', 'Message is required');
            $this->redirect("/disease/viewReport/{$reportCode}");
        }

        $response = $this->getResponseOrFail($responseId, $reportCode);
        $this->assertOfficerOwnership($response, $reportCode);

        $officerId = $this->getSessionUserId();
        $uploadResult = $this->processFileUpload(
            uploadDir: $this->getUploadDir(self::UPLOAD_DIR_RESPONSES),
            prefix: "{$reportCode}_officer_{$officerId}",
            existingMedia: $response->response_media ?? ''
        );

        if (isset($uploadResult['error'])) {
            $this->flash('error', $uploadResult['error']);
            $this->redirect("/disease/viewReport/{$reportCode}");
        }

        $media = $uploadResult['media_string'] ?: null;

        $this->model('M_disease')->updateOfficerResponse($responseId, $message, $media)
            ? $this->flash('success', 'Recommendation updated successfully')
            : $this->flash('error', 'Failed to update recommendation');

        $this->redirect("/disease/viewReport/{$reportCode}");
    }

    /** Soft-deletes a recommendation (the authoring officer only). */
    public function deleteRecommendation(string $id = ''): void
    {
        $this->requireLogin();
        $this->requireOfficer();

        if (empty($id)) {
            $this->flash('error', 'Invalid recommendation ID');
            $this->redirect('/disease/viewReports');
        }

        $response = $this->getResponseOrFail($id);
        $this->assertOfficerOwnership($response, $response->report_code);

        $this->model('M_disease')->deleteOfficerResponse($id)
            ? $this->flash('success', 'Recommendation deleted successfully')
            : $this->flash('error', 'Failed to delete recommendation');

        $this->redirect("/disease/viewReport/{$response->report_code}");
    }

    // ─── Public Actions: Media Streaming ─────────────────────────────────────

    /** Streams a media file attached to a disease report. */
    public function viewMedia(string $reportCode = '', string $filename = ''): void
    {
        if (!isset($_SESSION['user_type'])) {
            $this->redirect('/users/login');
        }

        if (empty($reportCode) || empty($filename)) {
            $this->sendHttpError(404, 'Report code and filename are required');
            return;
        }

        try {
            $report = $this->model('M_disease')->getReportByCode($reportCode);

            if (!$report || !$this->fileExistsInList($filename, $report->media ?? '')) {
                $this->sendHttpError(403, 'File not associated with this report');
                return;
            }

            if ($this->isFarmer() && $report->farmerNIC !== $this->getFarmerNIC()) {
                $this->sendHttpError(403, 'You can only view media from your own reports');
                return;
            }

            $this->streamFile($this->getUploadDir() . $filename);

        } catch (Exception $e) {
            error_log("Error in viewMedia: " . $e->getMessage());
            $this->sendHttpError(500, 'Error loading file');
        }
    }

    /** Streams a media file attached to an officer response. */
    public function viewResponseMedia(string $responseId = '', string $filename = ''): void
    {
        if (empty($responseId) || empty($filename)) {
            $this->sendHttpError(404, 'Response ID and filename are required');
            return;
        }

        try {
            $response = $this->model('M_disease')->getOfficerResponseById($responseId);

            if (!$response || !$this->fileExistsInList($filename, $response->response_media ?? '')) {
                $this->sendHttpError(403, 'File not associated with this response');
                return;
            }

            $this->streamFile($this->getUploadDir(self::UPLOAD_DIR_RESPONSES) . $filename);

        } catch (Exception $e) {
            error_log("Error in viewResponseMedia: " . $e->getMessage());
            $this->sendHttpError(500, 'Error loading file');
        }
    }

    // ─── Private: Report List Loading ────────────────────────────────────────

    private function loadFarmerReports(array &$data): void
    {
        $nic = $this->getFarmerNIC();
        $plrNumber = trim($_GET['plrNumber'] ?? '');
        $reportCode = trim($_GET['reportCode'] ?? '');
        $hasFilters = isset($_GET['reportCode']) || isset($_GET['plrNumber']);

        $data['farmerNIC'] = $nic;
        $data['paddyFields'] = $this->model('M_disease')->getPaddyFieldsByFarmer($nic);

        if ($hasFilters && (!empty($plrNumber) || !empty($reportCode))) {
            $reports = $this->model('M_disease')->searchReports($nic, $plrNumber, $reportCode);
            $data['plrNumber'] = $plrNumber;
            $data['reportCode'] = $reportCode;
            $data['searched'] = true;
            $data['message'] = count($reports) . ' of your report(s) found';
        } else {
            $reports = $this->model('M_disease')->getReportsByFarmerNIC($nic);
            $data['message'] = 'Showing your reports (' . count($reports) . ' total)';
        }

        $data['reports'] = $reports;
    }

    private function loadAdminOfficerReports(array &$data): void
    {
        $includeDeleted = $this->isAdmin();
        $farmerNIC = trim($_GET['farmerNIC'] ?? '');
        $plrNumber = trim($_GET['plrNumber'] ?? '');
        $reportCode = trim($_GET['reportCode'] ?? '');
        $hasFilters = isset($_GET['reportCode']) || isset($_GET['plrNumber']) || isset($_GET['farmerNIC']);

        if ($hasFilters && (!empty($farmerNIC) || !empty($plrNumber) || !empty($reportCode))) {
            $reports = $this->model('M_disease')->searchReports($farmerNIC, $plrNumber, $reportCode, $includeDeleted);
            $data['farmerNIC'] = $farmerNIC;
            $data['plrNumber'] = $plrNumber;
            $data['reportCode'] = $reportCode;
            $data['searched'] = true;
            $data['message'] = count($reports) . ' report(s) found';
        } else {
            $reports = $this->model('M_disease')->getAllReports(null, null, $includeDeleted);
            $data['farmerNIC'] = '';
            $data['message'] = 'Showing all reports (' . count($reports) . ' total)';
        }

        $data['reports'] = $reports;
    }

    // ─── Private: Form Helpers ────────────────────────────────────────────────

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

    /**
     * Re-renders the report form after a validation or upload error.
     * Injects fresh paddy fields so the dropdown is always populated.
     */
    private function renderFormWithErrors(array &$data): void
    {
        $data['paddyFields'] = $this->model('M_disease')
            ->getPaddyFieldsByFarmer($data['farmerNIC']);
        $this->view('disease/disease', $data);
    }

    // ─── Private: Validation ─────────────────────────────────────────────────

    /**
     * @return array{isValid: bool, errors: array<string, string>}
     */
    private function validateReportData(array $data): array
    {
        $errors = [];

        // NIC
        if (empty($data['farmerNIC'])) {
            $errors['farmerNIC_error'] = 'Please enter your NIC number';
        } elseif (!preg_match('/^([0-9]{9}[vV]|[0-9]{12})$/', $data['farmerNIC'])) {
            $errors['farmerNIC_error'] = 'Invalid NIC format. Use 9 digits + V/v, or 12 digits';
        }

        // PLR Number
        if (empty($data['plrNumber'])) {
            $errors['plrNumber_error'] = 'PLR number is required';
        } elseif (!preg_match('/^\d{2}\/\d{2}\/\d{5}\/\d{3}\/[A-Za-z]\/\d{4}$/', $data['plrNumber'])) {
            $errors['plrNumber_error'] = 'Invalid PLR format — example: 02/25/00083/001/P/0066';
        } else {
            $paddyRecord = $this->model('M_disease')->getPaddyByPLR($data['plrNumber']);
            if (!$paddyRecord || $paddyRecord->NIC_FK !== $data['farmerNIC']) {
                $errors['plrNumber_error'] = 'PLR number not found in your registered paddy fields';
            }
        }

        // Observation Date
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

        // Title
        $titleLen = strlen($data['title']);
        if (empty($data['title'])) {
            $errors['title_error'] = 'Please enter a report title';
        } elseif ($titleLen < 5) {
            $errors['title_error'] = 'Title must be at least 5 characters';
        } elseif ($titleLen > 200) {
            $errors['title_error'] = 'Title must be 200 characters or fewer';
        }

        // Description
        $descLen = strlen($data['description']);
        if (empty($data['description'])) {
            $errors['description_error'] = 'Please enter a detailed description';
        } elseif ($descLen < 20) {
            $errors['description_error'] = 'Description must be at least 20 characters';
        } elseif ($descLen > 2000) {
            $errors['description_error'] = 'Description must be 2000 characters or fewer';
        }

        // Severity
        if (empty($data['severity'])) {
            $errors['severity_error'] = 'Please select a severity level';
        } elseif (!in_array($data['severity'], ['low', 'medium', 'high'], true)) {
            $errors['severity_error'] = 'Invalid severity level selected';
        }

        // Affected Area
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
            $paddyData = $this->model('M_disease')->getPaddyByPLR($data['plrNumber']);
            if ($paddyData && $area > (float) $paddyData->Paddy_Size) {
                $errors['affectedArea_error'] =
                    "Affected area cannot exceed the total paddy size ({$paddyData->Paddy_Size} acres)";
            }
        }

        // Terms
        if (($data['terms'] ?? '') !== 'on') {
            $errors['terms_error'] = 'You must agree to the terms and conditions';
        }

        return ['isValid' => empty($errors), 'errors' => $errors];
    }

    // ─── Private: File Handling ───────────────────────────────────────────────

    /**
     * Single unified upload handler used by both report and officer-response uploads.
     *
     * - Retains files from $existingMedia that are NOT in $removeMedia
     * - Deletes removed files from disk
     * - Validates and moves any newly uploaded $_FILES['media'] entries
     *
     * @param  string   $uploadDir     Absolute path to the destination directory
     * @param  string   $prefix        Prefix prepended to each new filename
     * @param  string   $existingMedia Comma-separated list of files already on disk
     * @param  string[] $removeMedia   Filenames to delete from disk
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
                    return ['error' => "File exceeds the " . self::MAX_FILE_SIZE_LABEL . " limit: {$originalName}"];
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
     * Keeps files NOT in $removeMedia and deletes those that are.
     *
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

    /** Builds a sanitised, collision-resistant filename. */
    private function buildUniqueFilename(string $prefix, string $originalName, int $index): string
    {
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $baseName = substr($baseName, 0, self::MAX_FILENAME_LENGTH);

        return "{$prefix}_{$baseName}_" . time() . "_{$index}.{$ext}";
    }

    /** Returns the absolute upload path for the given sub-directory. */
    private function getUploadDir(string $subDir = self::UPLOAD_DIR_REPORTS): string
    {
        return dirname(APPROOT) . $subDir;
    }

    // ─── Private: Media Streaming ─────────────────────────────────────────────

    private function fileExistsInList(string $filename, string $fileList): bool
    {
        return in_array($filename, array_map('trim', explode(',', $fileList)), true);
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