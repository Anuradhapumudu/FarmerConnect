<?php
class M_disease {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // CREATE - Submit the report (returns generated report_code)
    public function submitDReport($data) {
        try {
            // Generate report code first
            $reportCode = $this->generateReportCode();

            $this->db->query("INSERT INTO disease_reports (report_code, farmerNIC, pirNumber, observationDate, title, description, media, severity, affectedArea, status, created_at)
                              VALUES (:report_code, :farmerNIC, :pirNumber, :observationDate, :title, :description, :media, :severity, :affectedArea, :status, NOW())");

            // Bind values
            $this->db->bind(':report_code', $reportCode);
            $this->db->bind(':farmerNIC', $data['farmerNIC']);
            $this->db->bind(':pirNumber', $data['plrNumber']); // Note: plrNumber in data, pirNumber in DB
            $this->db->bind(':observationDate', $data['observationDate']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':media', $data['media']);
            $this->db->bind(':severity', $data['severity']);
            $this->db->bind(':affectedArea', $data['affectedArea']);
            $this->db->bind(':status', isset($data['status']) ? $data['status'] : 'pending');

            // Execute
            if ($this->db->execute()) {
                return $reportCode;
            } else {
                error_log("Database execution failed in submitDReport");
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in submitDReport: " . $e->getMessage());
            return false;
        }
    }

    // Generate unique report code
    private function generateReportCode() {
        try {
            // Get the next available ID
            $this->db->query("SELECT COALESCE(MAX(CAST(SUBSTRING(report_code, 3) AS UNSIGNED)), 0) + 1 as next_id FROM disease_reports");
            $result = $this->db->single();
            $nextId = $result ? $result->next_id : 1;

            // Generate report code with leading zeros
            return 'DR' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        } catch (Exception $e) {
            error_log("Exception in generateReportCode: " . $e->getMessage());
            // Fallback to timestamp-based code
            return 'DR' . date('His');
        }
    }

    // READ - Get all reports by farmer NIC
    public function getReportsByFarmerNIC($farmerNIC) {
        try {
            $this->db->query("SELECT * FROM disease_reports WHERE farmerNIC = :farmerNIC ORDER BY created_at DESC");
            $this->db->bind(':farmerNIC', $farmerNIC);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByFarmerNIC: " . $e->getMessage());
            return [];
        }
    }

    // READ - Get all reports by PLR number
    public function getReportsByPLR($plrNumber) {
        try {
            $this->db->query("SELECT * FROM disease_reports WHERE pirNumber = :pirNumber ORDER BY created_at DESC");
            $this->db->bind(':pirNumber', $plrNumber);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByPLR: " . $e->getMessage());
            return [];
        }
    }

    // READ - Get a single report by report_code
    public function getReportByCode($reportCode) {
        try {
            $this->db->query("SELECT dr.*, f.full_name as farmer_name FROM disease_reports dr LEFT JOIN farmers f ON dr.farmerNIC = f.nic WHERE dr.report_code = :report_code");
            $this->db->bind(':report_code', $reportCode);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Exception in getReportByCode: " . $e->getMessage());
            return false;
        }
    }

    // READ - Get all reports (for admin/overview)
    public function getAllReports($limit = null, $offset = null) {
        try {
            $sql = "SELECT dr.*, f.full_name as farmer_name FROM disease_reports dr LEFT JOIN farmers f ON dr.farmerNIC = f.nic ORDER BY dr.created_at DESC";

            if ($limit !== null) {
                $sql .= " LIMIT :limit";
                if ($offset !== null) {
                    $sql .= " OFFSET :offset";
                }
            }

            $this->db->query($sql);

            if ($limit !== null) {
                $this->db->bind(':limit', $limit, PDO::PARAM_INT);
                if ($offset !== null) {
                    $this->db->bind(':offset', $offset, PDO::PARAM_INT);
                }
            }

            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getAllReports: " . $e->getMessage());
            return [];
        }
    }

    // READ - Search reports by multiple criteria
    public function searchReports($farmerNIC = '', $plrNumber = '', $reportCode = '') {
        try {
            $conditions = [];
            $params = [];

            if (!empty($farmerNIC)) {
                $conditions[] = "dr.farmerNIC = :farmerNIC";
                $params[':farmerNIC'] = $farmerNIC;
            }

            if (!empty($plrNumber)) {
                $conditions[] = "dr.pirNumber = :pirNumber";
                $params[':pirNumber'] = $plrNumber;
            }

            if (!empty($reportCode)) {
                $conditions[] = "dr.report_code = :report_code";
                $params[':report_code'] = $reportCode;
            }

            if (empty($conditions)) {
                return []; // No search criteria provided
            }

            $sql = "SELECT dr.*, f.full_name as farmer_name FROM disease_reports dr LEFT JOIN farmers f ON dr.farmerNIC = f.nic WHERE " . implode(' AND ', $conditions) . " ORDER BY dr.created_at DESC";
            $this->db->query($sql);

            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }

            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in searchReports: " . $e->getMessage());
            return [];
        }
    }

    // UPDATE - Update report
    public function updateReport($data) {
        try {
            $this->db->query("UPDATE disease_reports SET
                              farmerNIC = :farmerNIC,
                              pirNumber = :pirNumber,
                              observationDate = :observationDate,
                              title = :title,
                              description = :description,
                              media = :media,
                              severity = :severity,
                              affectedArea = :affectedArea,
                              updated_at = NOW()
                              WHERE report_code = :report_code");

            // Bind values
            $this->db->bind(':report_code', $data['report_code']);
            $this->db->bind(':farmerNIC', $data['farmerNIC']);
            $this->db->bind(':pirNumber', $data['plrNumber']);
            $this->db->bind(':observationDate', $data['observationDate']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':media', $data['media']);
            $this->db->bind(':severity', $data['severity']);
            $this->db->bind(':affectedArea', $data['affectedArea']);

            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in updateReport: " . $e->getMessage());
            return false;
        }
    }

    // UPDATE - Update report media only
    public function updateReportMedia($reportCode, $media) {
        try {
            $this->db->query("UPDATE disease_reports SET media = :media, updated_at = NOW() WHERE report_code = :report_code");
            $this->db->bind(':media', $media);
            $this->db->bind(':report_code', $reportCode);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in updateReportMedia: " . $e->getMessage());
            return false;
        }
    }

    // DELETE - Delete report
    public function deleteReport($reportCode) {
        try {
            $this->db->query("DELETE FROM disease_reports WHERE report_code = :report_code");
            $this->db->bind(':report_code', $reportCode);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in deleteReport: " . $e->getMessage());
            return false;
        }
    }

    // ADDITIONAL HELPER METHODS

    // Get reports count by farmer
    public function getReportsCountByFarmer($farmerNIC) {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM disease_reports WHERE farmerNIC = :farmerNIC");
            $this->db->bind(':farmerNIC', $farmerNIC);
            $result = $this->db->single();
            return $result ? $result->count : 0;
        } catch (Exception $e) {
            error_log("Exception in getReportsCountByFarmer: " . $e->getMessage());
            return 0;
        }
    }

    // Get total reports count
    public function getTotalReportsCount() {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM disease_reports");
            $result = $this->db->single();
            return $result ? $result->count : 0;
        } catch (Exception $e) {
            error_log("Exception in getTotalReportsCount: " . $e->getMessage());
            return 0;
        }
    }

    // Get recent reports (last 30 days)
    public function getRecentReports($limit = 10) {
        try {
            $this->db->query("SELECT * FROM disease_reports WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) ORDER BY created_at DESC LIMIT :limit");
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getRecentReports: " . $e->getMessage());
            return [];
        }
    }

    // Update report status
    public function updateReportStatus($reportCode, $status) {
        try {
            $this->db->query("UPDATE disease_reports SET status = :status, updated_at = NOW() WHERE report_code = :report_code");
            $this->db->bind(':status', $status);
            $this->db->bind(':report_code', $reportCode);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in updateReportStatus: " . $e->getMessage());
            return false;
        }
    }

    // Get reports by severity level
    public function getReportsBySeverity($severity) {
        try {
            $this->db->query("SELECT * FROM disease_reports WHERE severity = :severity ORDER BY created_at DESC");
            $this->db->bind(':severity', $severity);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsBySeverity: " . $e->getMessage());
            return [];
        }
    }

    // Get reports within date range
    public function getReportsByDateRange($startDate, $endDate) {
        try {
            $this->db->query("SELECT * FROM disease_reports WHERE observationDate BETWEEN :startDate AND :endDate ORDER BY created_at DESC");
            $this->db->bind(':startDate', $startDate);
            $this->db->bind(':endDate', $endDate);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByDateRange: " . $e->getMessage());
            return [];
        }
    }

    // Search reports with pagination
    public function searchReportsWithPagination($farmerNIC = '', $plrNumber = '', $reportCode = '', $limit = 10, $offset = 0) {
        try {
            $conditions = [];
            $params = [];

            if (!empty($farmerNIC)) {
                $conditions[] = "farmerNIC LIKE :farmerNIC";
                $params[':farmerNIC'] = "%{$farmerNIC}%";
            }

            if (!empty($plrNumber)) {
                $conditions[] = "pirNumber LIKE :pirNumber";
                $params[':pirNumber'] = "%{$plrNumber}%";
            }

            if (!empty($reportCode)) {
                $conditions[] = "report_code LIKE :report_code";
                $params[':report_code'] = "%{$reportCode}%";
            }

            $whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : "";

            $sql = "SELECT * FROM disease_reports {$whereClause} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
            $this->db->query($sql);

            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }

            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            $this->db->bind(':offset', $offset, PDO::PARAM_INT);

            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in searchReportsWithPagination: " . $e->getMessage());
            return [];
        }
    }

    // Get search results count (for pagination)
    public function getSearchResultsCount($farmerNIC = '', $plrNumber = '', $reportCode = '') {
        try {
            $conditions = [];
            $params = [];

            if (!empty($farmerNIC)) {
                $conditions[] = "farmerNIC LIKE :farmerNIC";
                $params[':farmerNIC'] = "%{$farmerNIC}%";
            }

            if (!empty($plrNumber)) {
                $conditions[] = "pirNumber LIKE :pirNumber";
                $params[':pirNumber'] = "%{$plrNumber}%";
            }

            if (!empty($reportCode)) {
                $conditions[] = "report_code LIKE :report_code";
                $params[':report_code'] = "%{$reportCode}%";
            }

            $whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : "";

            $sql = "SELECT COUNT(*) as count FROM disease_reports {$whereClause}";
            $this->db->query($sql);

            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }

            $result = $this->db->single();
            return $result ? $result->count : 0;
        } catch (Exception $e) {
            error_log("Exception in getSearchResultsCount: " . $e->getMessage());
            return 0;
        }
    }

    // Get reports by farmer with pagination
    public function getReportsByFarmerWithPagination($farmerNIC, $limit = 10, $offset = 0) {
        try {
            $this->db->query("SELECT dr.*, f.full_name as farmer_name FROM disease_reports dr LEFT JOIN farmers f ON dr.farmerNIC = f.nic WHERE dr.farmerNIC = :farmerNIC ORDER BY dr.created_at DESC LIMIT :limit OFFSET :offset");
            $this->db->bind(':farmerNIC', $farmerNIC);
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            $this->db->bind(':offset', $offset, PDO::PARAM_INT);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByFarmerWithPagination: " . $e->getMessage());
            return [];
        }
    }

    // Advanced search with multiple filters
    public function advancedSearch($filters = [], $limit = null, $offset = null) {
        try {
            $conditions = [];
            $params = [];

            // Handle different filter types
            if (!empty($filters['farmerNIC'])) {
                $conditions[] = "farmerNIC LIKE :farmerNIC";
                $params[':farmerNIC'] = "%{$filters['farmerNIC']}%";
            }

            if (!empty($filters['plrNumber'])) {
                $conditions[] = "pirNumber LIKE :pirNumber";
                $params[':pirNumber'] = "%{$filters['plrNumber']}%";
            }

            if (!empty($filters['reportCode'])) {
                $conditions[] = "report_code LIKE :report_code";
                $params[':report_code'] = "%{$filters['reportCode']}%";
            }

            if (!empty($filters['severity'])) {
                $conditions[] = "severity = :severity";
                $params[':severity'] = $filters['severity'];
            }

            if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
                $conditions[] = "observationDate BETWEEN :startDate AND :endDate";
                $params[':startDate'] = $filters['startDate'];
                $params[':endDate'] = $filters['endDate'];
            }

            if (!empty($filters['title'])) {
                $conditions[] = "title LIKE :title";
                $params[':title'] = "%{$filters['title']}%";
            }

            if (!empty($filters['minArea']) && is_numeric($filters['minArea'])) {
                $conditions[] = "affectedArea >= :minArea";
                $params[':minArea'] = $filters['minArea'];
            }

            if (!empty($filters['maxArea']) && is_numeric($filters['maxArea'])) {
                $conditions[] = "affectedArea <= :maxArea";
                $params[':maxArea'] = $filters['maxArea'];
            }

            $whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : "";

            $sql = "SELECT * FROM disease_reports {$whereClause} ORDER BY created_at DESC";

            if ($limit !== null) {
                $sql .= " LIMIT :limit";
                if ($offset !== null) {
                    $sql .= " OFFSET :offset";
                }
            }

            $this->db->query($sql);

            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }

            if ($limit !== null) {
                $this->db->bind(':limit', $limit, PDO::PARAM_INT);
                if ($offset !== null) {
                    $this->db->bind(':offset', $offset, PDO::PARAM_INT);
                }
            }

            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in advancedSearch: " . $e->getMessage());
            return [];
        }
    }

    // Get statistics for dashboard
    public function getDashboardStats() {
        try {
            $stats = [];

            // Total reports
            $this->db->query("SELECT COUNT(*) as total FROM disease_reports");
            $result = $this->db->single();
            $stats['total_reports'] = $result ? $result->total : 0;

            // Reports by severity
            $this->db->query("SELECT severity, COUNT(*) as count FROM disease_reports GROUP BY severity");
            $severityResults = $this->db->resultSet();

            $stats['severity_counts'] = [
                'low' => 0,
                'medium' => 0,
                'high' => 0
            ];

            foreach ($severityResults as $row) {
                $stats['severity_counts'][$row->severity] = $row->count;
            }

            // Recent reports (last 7 days)
            $this->db->query("SELECT COUNT(*) as count FROM disease_reports WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
            $result = $this->db->single();
            $stats['recent_reports'] = $result ? $result->count : 0;

            // Most active farmers
            $this->db->query("SELECT farmerNIC, COUNT(*) as report_count FROM disease_reports GROUP BY farmerNIC ORDER BY report_count DESC LIMIT 5");
            $stats['top_farmers'] = $this->db->resultSet();

            return $stats;
        } catch (Exception $e) {
            error_log("Exception in getDashboardStats: " . $e->getMessage());
            return [
                'total_reports' => 0,
                'severity_counts' => ['low' => 0, 'medium' => 0, 'high' => 0],
                'recent_reports' => 0,
                'top_farmers' => []
            ];
        }
    }

    // Batch operations

    // Delete multiple reports
    public function deleteMultipleReports($reportCodes) {
        try {
            if (empty($reportCodes) || !is_array($reportCodes)) {
                return false;
            }

            $placeholders = str_repeat('?,', count($reportCodes) - 1) . '?';
            $this->db->query("DELETE FROM disease_reports WHERE report_code IN ($placeholders)");

            foreach ($reportCodes as $index => $reportCode) {
                $this->db->bind($index + 1, $reportCode);
            }

            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in deleteMultipleReports: " . $e->getMessage());
            return false;
        }
    }

    // Update multiple reports status
    public function updateMultipleReportsStatus($reportCodes, $status) {
        try {
            if (empty($reportCodes) || !is_array($reportCodes)) {
                return false;
            }

            $placeholders = str_repeat('?,', count($reportCodes) - 1) . '?';
            $this->db->query("UPDATE disease_reports SET status = :status, updated_at = NOW() WHERE report_code IN ($placeholders)");

            $this->db->bind(':status', $status);

            foreach ($reportCodes as $index => $reportCode) {
                $this->db->bind($index + 1, $reportCode);
            }

            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in updateMultipleReportsStatus: " . $e->getMessage());
            return false;
        }
    }

    // Check if report exists
    public function reportExists($reportCode) {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM disease_reports WHERE report_code = :report_code");
            $this->db->bind(':report_code', $reportCode);
            $result = $this->db->single();
            return $result && $result->count > 0;
        } catch (Exception $e) {
            error_log("Exception in reportExists: " . $e->getMessage());
            return false;
        }
    }

    // Get reports by farmer sorted by different criteria
    public function getReportsByFarmerSorted($farmerNIC, $sortBy = 'created_at', $sortOrder = 'DESC') {
        try {
            $allowedSortFields = ['created_at', 'observationDate', 'title', 'severity', 'affectedArea'];
            $allowedSortOrders = ['ASC', 'DESC'];

            if (!in_array($sortBy, $allowedSortFields)) {
                $sortBy = 'created_at';
            }

            if (!in_array(strtoupper($sortOrder), $allowedSortOrders)) {
                $sortOrder = 'DESC';
            }

            $this->db->query("SELECT dr.*, f.full_name as farmer_name FROM disease_reports dr LEFT JOIN farmers f ON dr.farmerNIC = f.nic WHERE dr.farmerNIC = :farmerNIC ORDER BY dr.{$sortBy} {$sortOrder}");
            $this->db->bind(':farmerNIC', $farmerNIC);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByFarmerSorted: " . $e->getMessage());
            return [];
        }
    }

    // Submit officer response/recommendation
    public function submitOfficerResponse($reportCode, $officerId, $message, $media = null) {
        try {
            error_log("submitOfficerResponse called with: reportCode=$reportCode, officerId=$officerId, message=$message, media=$media");

            $this->db->query("INSERT INTO disease_officer_responses (report_code, officer_id, response_message, response_media, created_at, updated_at)
                              VALUES (:report_code, :officer_id, :response_message, :response_media, NOW(), NOW())");

            $this->db->bind(':report_code', $reportCode);
            $this->db->bind(':officer_id', $officerId);
            $this->db->bind(':response_message', $message);
            $this->db->bind(':response_media', $media);

            $result = $this->db->execute();
            error_log("Database execution result: " . ($result ? 'true' : 'false'));

            if ($result) {
                // Verify the insert worked
                $this->db->query("SELECT response_media FROM disease_officer_responses WHERE report_code = :report_code AND officer_id = :officer_id ORDER BY created_at DESC LIMIT 1");
                $this->db->bind(':report_code', $reportCode);
                $this->db->bind(':officer_id', $officerId);
                $inserted = $this->db->single();
                error_log("Inserted record media field: " . ($inserted ? $inserted->response_media : 'null'));
            }

            return $result;
        } catch (Exception $e) {
            error_log("Exception in submitOfficerResponse: " . $e->getMessage());
            return false;
        }
    }

    // Get officer responses for a report
    public function getOfficerResponses($reportCode) {
        try {
            $this->db->query("SELECT * FROM disease_officer_responses WHERE report_code = :report_code ORDER BY created_at DESC");
            $this->db->bind(':report_code', $reportCode);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getOfficerResponses: " . $e->getMessage());
            return [];
        }
    }
}
?>