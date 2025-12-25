<?php
class M_disease {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // CREATE - Submit the report
    public function submitDReport($data) {
        try {
            // Generate report code first
            $reportCode = $this->generateReportCode();

            $this->db->query("INSERT INTO disease_reports (report_code, farmerNIC, plrNumber, observationDate, title, description, media, severity, affectedArea, status, created_at)
                               VALUES (:report_code, :farmerNIC, :plrNumber, :observationDate, :title, :description, :media, :severity, :affectedArea, :status, NOW())");

            // Bind values
            $this->db->bind(':report_code', $reportCode);
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
                return $reportCode;
            } else {
                return ['error' => 'Database execution failed.'];
            }
        } catch (Exception $e) {
            error_log("Exception in submitDReport: " . $e->getMessage());
            return ['error' => 'Database error: ' . $e->getMessage()];
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
            return 'DR' . date('His'); // Fallback
        }
    }

    // READ - Get all reports by farmer NIC
    public function getReportsByFarmerNIC($farmerNIC, $includeDeleted = false) {
        try {
            $sql = "SELECT dr.*, f.full_name as farmer_name, p.Paddy_Size as paddySize 
                    FROM disease_reports dr 
                    LEFT JOIN farmers f ON dr.farmerNIC = f.nic 
                    LEFT JOIN paddy p ON dr.plrNumber = p.PLR AND dr.farmerNIC = p.NIC_FK 
                    WHERE dr.farmerNIC = :farmerNIC";

            if (!$includeDeleted) {
                $sql .= " AND dr.is_deleted = 0";
            }

            $sql .= " ORDER BY dr.created_at DESC";

            $this->db->query($sql);
            $this->db->bind(':farmerNIC', $farmerNIC);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByFarmerNIC: " . $e->getMessage());
            return [];
        }
    }

    // READ - Get all reports by PLR number
    public function getReportsByPLR($plrNumber, $includeDeleted = false) {
        try {
            $sql = "SELECT * FROM disease_reports WHERE plrNumber = :plrNumber";
            
            if (!$includeDeleted) {
                $sql .= " AND is_deleted = 0";
            }

            $sql .= " ORDER BY created_at DESC";

            $this->db->query($sql);
            $this->db->bind(':plrNumber', $plrNumber);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getReportsByPLR: " . $e->getMessage());
            return [];
        }
    }

    // READ - Get a single report by report_code
    public function getReportByCode($reportCode, $includeDeleted = false) {
        try {
            $sql = "SELECT dr.*, f.full_name as farmer_name, p.Paddy_Size as paddySize, 
                           o.first_name as officer_first_name, o.last_name as officer_last_name, o.officer_id as updater_id
                    FROM disease_reports dr 
                    LEFT JOIN farmers f ON dr.farmerNIC = f.nic 
                    LEFT JOIN paddy p ON dr.plrNumber = p.PLR AND dr.farmerNIC = p.NIC_FK 
                    LEFT JOIN officers o ON dr.status_updated_by = o.officer_id
                    WHERE dr.report_code = :report_code";

            if (!$includeDeleted) {
                $sql .= " AND dr.is_deleted = 0";
            }

            $this->db->query($sql);
            $this->db->bind(':report_code', $reportCode);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Exception in getReportByCode: " . $e->getMessage());
            return false;
        }
    }

    // READ - Get all reports (for admin/overview)
    public function getAllReports($limit = null, $offset = null, $includeDeleted = false) {
        try {
            $sql = "SELECT dr.*, f.full_name as farmer_name, p.Paddy_Size as paddySize 
                    FROM disease_reports dr 
                    LEFT JOIN farmers f ON dr.farmerNIC = f.nic 
                    LEFT JOIN paddy p ON dr.plrNumber = p.PLR AND dr.farmerNIC = p.NIC_FK";
            
            if (!$includeDeleted) {
                $sql .= " WHERE dr.is_deleted = 0";
            }

            $sql .= " ORDER BY dr.created_at DESC";

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
                              is_edited = 1,
                              updated_at = NOW()
                              WHERE report_code = :report_code");

            // Bind values
            $this->db->bind(':report_code', $data['report_code']);
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

    // DELETE - Soft Delete report
    public function deleteReport($reportCode) {
        try {
            $this->db->query("UPDATE disease_reports SET is_deleted = 1 WHERE report_code = :report_code");
            $this->db->bind(':report_code', $reportCode);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in deleteReport: " . $e->getMessage());
            return false;
        }
    }

    // Get officer responses for a report
    public function getOfficerResponses($reportCode) {
        try {
            $this->db->query("SELECT dor.*, o.first_name, o.last_name 
                              FROM disease_officer_responses dor 
                              LEFT JOIN officers o ON dor.officer_id = o.officer_id 
                              WHERE dor.report_code = :report_code AND dor.is_deleted = 0
                              ORDER BY dor.created_at DESC");
            $this->db->bind(':report_code', $reportCode);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getOfficerResponses: " . $e->getMessage());
            return [];
        }
    }

    public function getPaddyByPLR($plr) {
        $this->db->query("SELECT * FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $plr);
        return $this->db->single();
    }

    // Get all paddy fields for a specific farmer
    public function getPaddyFieldsByFarmer($farmerNIC) {
        $this->db->query("SELECT PLR, Paddy_Size FROM paddy WHERE NIC_FK = :nic ORDER BY PLR ASC");
        $this->db->bind(':nic', $farmerNIC);
        return $this->db->resultSet();
    }

    // Search reports
    public function searchReports($farmerNIC, $plrNumber, $reportCode, $includeDeleted = false) {
        $sql = "SELECT dr.*, f.full_name as farmer_name, p.Paddy_Size as paddySize 
                FROM disease_reports dr 
                LEFT JOIN farmers f ON dr.farmerNIC = f.nic 
                LEFT JOIN paddy p ON dr.plrNumber = p.PLR AND dr.farmerNIC = p.NIC_FK 
                WHERE 1=1"; // Changed WHERE clause base
        
        if (!$includeDeleted) {
            $sql .= " AND dr.is_deleted = 0";
        }
        
        $params = [];

        // Add filters
        if (!empty($farmerNIC)) {
            $sql .= " AND dr.farmerNIC = :farmerNIC";
            $params[':farmerNIC'] = $farmerNIC;
        }

        if (!empty($plrNumber)) {
            $sql .= " AND dr.plrNumber = :plrNumber";
            $params[':plrNumber'] = $plrNumber;
        }

        if (!empty($reportCode)) {
            $sql .= " AND dr.report_code LIKE :reportCode";
            $params[':reportCode'] = '%' . $reportCode . '%';
        }

        $sql .= " ORDER BY dr.created_at DESC";

        $this->db->query($sql);

        // Bind params
        foreach ($params as $param => $value) {
            $this->db->bind($param, $value);
        }

        return $this->db->resultSet();
    }

    // Update report status
    public function updateReportStatus($reportCode, $status, $officerId = null) {
        try {
            $sql = "UPDATE disease_reports SET status = :status, updated_at = NOW()";
            
            if ($officerId) {
                $sql .= ", status_updated_by = :officer_id";
            }
            
            $sql .= " WHERE report_code = :report_code";

            $this->db->query($sql);
            $this->db->bind(':status', $status);
            $this->db->bind(':report_code', $reportCode);
            
            if ($officerId) {
                $this->db->bind(':officer_id', $officerId);
            }
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in updateReportStatus: " . $e->getMessage());
            return false;
        }
    }

    // Submit officer response/recommendation
    public function submitOfficerResponse($reportCode, $officerId, $message, $media = null) {
        try {
            $this->db->query("INSERT INTO disease_officer_responses (report_code, officer_id, response_message, response_media, created_at) 
                              VALUES (:report_code, :officer_id, :message, :media, NOW())");
            $this->db->bind(':report_code', $reportCode);
            $this->db->bind(':officer_id', $officerId);
            $this->db->bind(':message', $message);
            $this->db->bind(':media', $media);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in submitOfficerResponse: " . $e->getMessage());
            return false;
        }
    }

    // Get single officer response by ID
    public function getOfficerResponseById($id) {
        try {
            $this->db->query("SELECT * FROM disease_officer_responses WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Exception in getOfficerResponseById: " . $e->getMessage());
            return false;
        }
    }

    // Update officer response
    public function updateOfficerResponse($id, $message, $media = null) {
        try {
            $sql = "UPDATE disease_officer_responses SET response_message = :message, is_edited = 1, updated_at = NOW()";
            if ($media !== null) { // Only update media if provided (chk for null specifically)
                 $sql .= ", response_media = :media";
            }
            $sql .= " WHERE id = :id";
            
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $this->db->bind(':message', $message);
            if ($media !== null) {
                $this->db->bind(':media', $media);
            }
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in updateOfficerResponse: " . $e->getMessage());
            return false;
        }
    }

    // Delete officer response
    public function deleteOfficerResponse($id) {
        try {
            $this->db->query("UPDATE disease_officer_responses SET is_deleted = 1 WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in deleteOfficerResponse: " . $e->getMessage());
            return false;
        }
    }
}
?>