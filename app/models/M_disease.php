<?php
class M_disease {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // CREATE - Submit the report
    public function submitDReport($data) {
        try {
            $this->db->query("INSERT INTO disease_reports (reportId, farmerNIC, plrNumber, observationDate, title, description, media, severity, affectedArea, status, created_at)
                              VALUES (:reportId, :farmerNIC, :plrNumber, :observationDate, :title, :description, :media, :severity, :affectedArea, :status, NOW())");

            // Bind values
            $this->db->bind(':reportId', $data['reportId']);
            $this->db->bind(':farmerNIC', $data['farmerNIC']);
            $this->db->bind(':plrNumber', $data['plrNumber']);
            $this->db->bind(':observationDate', $data['observationDate']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':media', $data['media']);
            $this->db->bind(':severity', $data['severity']);
            $this->db->bind(':affectedArea', $data['affectedArea']);
            $this->db->bind(':status', isset($data['status']) ? $data['status'] : 'pending');

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                error_log("Database execution failed in submitDReport");
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in submitDReport: " . $e->getMessage());
            return false;
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
            $this->db->query("SELECT * FROM disease_reports WHERE plrNumber = :plrNumber ORDER BY created_at DESC");
            $this->db->bind(':plrNumber', $plrNumber);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByPLR: " . $e->getMessage());
            return [];
        }
    }

    // READ - Get a single report by reportId
    public function getReportById($reportId) {
        try {
            $this->db->query("SELECT * FROM disease_reports WHERE reportId = :reportId");
            $this->db->bind(':reportId', $reportId);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Exception in getReportById: " . $e->getMessage());
            return false;
        }
    }

    // READ - Get all reports (for admin/overview)
    public function getAllReports($limit = null, $offset = null) {
        try {
            $sql = "SELECT * FROM disease_reports ORDER BY created_at DESC";
            
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
    public function searchReports($farmerNIC = '', $plrNumber = '', $reportId = '') {
        try {
            $conditions = [];
            $params = [];

            if (!empty($farmerNIC)) {
                $conditions[] = "farmerNIC = :farmerNIC";
                $params[':farmerNIC'] = $farmerNIC;
            }

            if (!empty($plrNumber)) {
                $conditions[] = "plrNumber = :plrNumber";
                $params[':plrNumber'] = $plrNumber;
            }

            if (!empty($reportId)) {
                $conditions[] = "reportId = :reportId";
                $params[':reportId'] = $reportId;
            }

            if (empty($conditions)) {
                return []; // No search criteria provided
            }

            $sql = "SELECT * FROM disease_reports WHERE " . implode(' AND ', $conditions) . " ORDER BY created_at DESC";
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
                              plrNumber = :plrNumber,
                              observationDate = :observationDate,
                              title = :title,
                              description = :description,
                              media = :media,
                              severity = :severity,
                              affectedArea = :affectedArea,
                              updated_at = NOW()
                              WHERE reportId = :reportId");
            
            // Bind values
            $this->db->bind(':reportId', $data['reportId']);
            $this->db->bind(':farmerNIC', $data['farmerNIC']);
            $this->db->bind(':plrNumber', $data['plrNumber']);
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

    // DELETE - Delete report
    public function deleteReport($reportId) {
        try {
            $this->db->query("DELETE FROM disease_reports WHERE reportId = :reportId");
            $this->db->bind(':reportId', $reportId);
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

    // Update report status (for future use - you might want to add a status column)
    public function updateReportStatus($reportId, $status) {
        try {
            // Note: This requires adding a 'status' column to your database table
            $this->db->query("UPDATE disease_reports SET status = :status, updated_at = NOW() WHERE reportId = :reportId");
            $this->db->bind(':status', $status);
            $this->db->bind(':reportId', $reportId);
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
    public function searchReportsWithPagination($farmerNIC = '', $plrNumber = '', $reportId = '', $limit = 10, $offset = 0) {
        try {
            $conditions = [];
            $params = [];

            if (!empty($farmerNIC)) {
                $conditions[] = "farmerNIC LIKE :farmerNIC";
                $params[':farmerNIC'] = "%{$farmerNIC}%";
            }

            if (!empty($plrNumber)) {
                $conditions[] = "plrNumber LIKE :plrNumber";
                $params[':plrNumber'] = "%{$plrNumber}%";
            }

            if (!empty($reportId)) {
                $conditions[] = "reportId LIKE :reportId";
                $params[':reportId'] = "%{$reportId}%";
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
    public function getSearchResultsCount($farmerNIC = '', $plrNumber = '', $reportId = '') {
        try {
            $conditions = [];
            $params = [];

            if (!empty($farmerNIC)) {
                $conditions[] = "farmerNIC LIKE :farmerNIC";
                $params[':farmerNIC'] = "%{$farmerNIC}%";
            }

            if (!empty($plrNumber)) {
                $conditions[] = "plrNumber LIKE :plrNumber";
                $params[':plrNumber'] = "%{$plrNumber}%";
            }

            if (!empty($reportId)) {
                $conditions[] = "reportId LIKE :reportId";
                $params[':reportId'] = "%{$reportId}%";
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
            $this->db->query("SELECT * FROM disease_reports WHERE farmerNIC = :farmerNIC ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
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
                $conditions[] = "plrNumber LIKE :plrNumber";
                $params[':plrNumber'] = "%{$filters['plrNumber']}%";
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
    public function deleteMultipleReports($reportIds) {
        try {
            if (empty($reportIds) || !is_array($reportIds)) {
                return false;
            }
            
            $placeholders = str_repeat('?,', count($reportIds) - 1) . '?';
            $this->db->query("DELETE FROM disease_reports WHERE reportId IN ($placeholders)");
            
            foreach ($reportIds as $index => $reportId) {
                $this->db->bind($index + 1, $reportId);
            }
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in deleteMultipleReports: " . $e->getMessage());
            return false;
        }
    }

    // Update multiple reports status
    public function updateMultipleReportsStatus($reportIds, $status) {
        try {
            if (empty($reportIds) || !is_array($reportIds)) {
                return false;
            }
            
            $placeholders = str_repeat('?,', count($reportIds) - 1) . '?';
            $this->db->query("UPDATE disease_reports SET status = :status, updated_at = NOW() WHERE reportId IN ($placeholders)");
            
            $this->db->bind(':status', $status);
            
            foreach ($reportIds as $index => $reportId) {
                $this->db->bind($index + 1, $reportId);
            }
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in updateMultipleReportsStatus: " . $e->getMessage());
            return false;
        }
    }

    // Check if report exists
    public function reportExists($reportId) {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM disease_reports WHERE reportId = :reportId");
            $this->db->bind(':reportId', $reportId);
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
            
            $this->db->query("SELECT * FROM disease_reports WHERE farmerNIC = :farmerNIC ORDER BY {$sortBy} {$sortOrder}");
            $this->db->bind(':farmerNIC', $farmerNIC);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByFarmerSorted: " . $e->getMessage());
            return [];
        }
    }
}
?>