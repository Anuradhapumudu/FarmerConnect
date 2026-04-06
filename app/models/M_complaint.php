<?php
class M_complaint
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    //Create Submit Complaint Report
    public function submitComplaint($data)
    {
        try {
            //Use provided complaint ID or generate a new one
            $complaint_id = isset($data['complaint_id']) ? $data['complaint_id'] : $this->generateComplaintCode();

            $this->db->query('INSERT INTO complaints (complaint_id,
                farmerNIC, plrNumber, observationDate, title, description, media, severity, affectedArea, status) 
                VALUES (:complaint_id, :farmerNIC, :plrNumber, :observationDate, :title, :description, :media, :severity, :affectedArea, :status)');

            // Bind values
            $this->db->bind(':complaint_id', $complaint_id);
            $this->db->bind(':farmerNIC', $data['farmerNIC']);
            $this->db->bind(':plrNumber', $data['plrNumber']);
            $this->db->bind(':observationDate', $data['observationDate']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':media', $data['media']);
            $this->db->bind(':severity', $data['severity']);
            $this->db->bind(':affectedArea', $data['affectedArea']);
            $this->db->bind(':status', 'Pending');

            //Execute
            if ($this->db->execute()) {
                return $complaint_id;
            } else {
                return ['error' => 'Database error occurred while submitting complaint.'];
            }
        } catch (Exception $e) {
            error_log('Error in submitComplaint: ' . $e->getMessage());
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    //Generate unique complaint code
    public function generateComplaintCode()
    {
        try {
            //Get the next availbale ID
            $this->db->query("SELECT COALESCE(MAX(CAST(SUBSTRING(complaint_id, 3) AS UNSIGNED)), 0) + 1 as next_id FROM complaints");
            $result = $this->db->single();
            $nextId = $result ? $result->next_id : 1;

            //Generate code with leading zeros
            return 'CP' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        } catch (Exception $e) {
            error_log('Error in generateComplaintCode: ' . $e->getMessage());
            return 'CP' . date('YmdHis'); // Fallback code with timestamp
        }
    }

    //Read - Get all complaints for a farmer
    public function getComplaintsByFarmer($farmerNIC, $includeDeleted = false)
    {
        try {
            $sql = "SELECT cp.*, f.full_name as farmer_name, p.Paddy_Size as paddySize 
                    FROM complaints cp 
                    LEFT JOIN farmers f ON cp.farmerNIC = f.nic 
                    LEFT JOIN paddy p ON cp.plrNumber = p.PLR AND cp.farmerNIC = p.NIC_FK 
                    WHERE cp.farmerNIC = :farmerNIC";

            if (!$includeDeleted) {
                $sql .= " AND cp.is_deleted = 0";
            }

            $sql .= " ORDER BY cp.created_at DESC";

            $this->db->query($sql);
            $this->db->bind(':farmerNIC', $farmerNIC);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getComplaintsByFarmer: " . $e->getMessage());
            return [];
        }
    }

    // READ - Get a single complaint by complaint_code
    public function getComplaintByCode($complaint_id, $includeDeleted = false)
    {
        try {
            $sql = "SELECT cp.*, f.full_name as farmer_name, p.Paddy_Size as paddySize, 
                           o.first_name as officer_first_name, o.last_name as officer_last_name, o.officer_id as updater_id
                    FROM complaints cp 
                    LEFT JOIN farmers f ON cp.farmerNIC = f.nic 
                    LEFT JOIN paddy p ON cp.plrNumber = p.PLR AND cp.farmerNIC = p.NIC_FK 
                    LEFT JOIN officers o ON cp.status_updated_by = o.officer_id
                    WHERE cp.complaint_id = :complaint_id";

            if (!$includeDeleted) {
                $sql .= " AND cp.is_deleted = 0";
            }

            $this->db->query($sql);
            $this->db->bind(':complaint_id', $complaint_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Exception in getComplaintByCode: " . $e->getMessage());
            return false;
        }
    }

    //Read - Get all complaints (for admin)
    public function getAllComplaints($limit = null, $offset = null, $includeDeleted = false)
    {
        try {
            $sql = "SELECT cp.*, f.full_name as farmer_name, p.Paddy_Size as paddySize 
                    FROM complaints cp 
                    LEFT JOIN farmers f ON cp.farmerNIC = f.nic 
                    LEFT JOIN paddy p ON cp.plrNumber = p.PLR AND cp.farmerNIC = p.NIC_FK";

            if (!$includeDeleted) {
                $sql .= " WHERE cp.is_deleted = 0";
            }

            $sql .= " ORDER BY cp.created_at DESC";

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
            error_log("Exception in getAllComplaints: " . $e->getMessage());
            return [];
        }
    }

    // UPDATE - Update complaint
    public function updateComplaint($data)
    {
        try {
            $this->db->query("UPDATE complaints SET
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
                              WHERE complaint_id = :complaint_id");

            // Bind values
            $this->db->bind(':complaint_id', $data['complaint_id']);
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
            error_log("Exception in updateComplaint: " . $e->getMessage());
            return false;
        }
    }

    // DELETE - Soft Delete complaint
    public function deleteComplaint($complaint_id)
    {
        try {
            $this->db->query("UPDATE complaints SET is_deleted = 1 WHERE complaint_id = :complaint_id");
            $this->db->bind(':complaint_id', $complaint_id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in deleteComplaint: " . $e->getMessage());
            return false;
        }
    }

    // Get officer responses for a complaint
    public function getOfficerResponses($complaint_id, $includeDeleted = false)
    {
        try {
            $sql = "SELECT cor.*, o.first_name, o.last_name 
                    FROM complaint_officer_responses cor 
                    LEFT JOIN officers o ON cor.officer_id = o.officer_id 
                    LEFT JOIN complaints c ON cor.complaint_id = c.complaint_id
                    WHERE cor.complaint_id = :complaint_id";
            
            if (!$includeDeleted) {
                $sql .= " AND cor.is_deleted = 0";
            }
            
            $sql .= " ORDER BY cor.created_at DESC";

            $this->db->query($sql);
            $this->db->bind(':complaint_id', $complaint_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Exception in getOfficerResponses: " . $e->getMessage());
            return [];
        }
    }

    public function getPaddyByPLR($plr)
    {
        $this->db->query("SELECT * FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $plr);
        return $this->db->single();
    }

    public function getPaddyFieldsByFarmer($farmerNIC)
    {
        $this->db->query("SELECT PLR, Paddy_Size FROM paddy WHERE NIC_FK = :nic ORDER BY PLR ASC");
        $this->db->bind(':nic', $farmerNIC);
        return $this->db->resultSet();
    }

    // Search reports
    public function searchReports($farmerNIC, $plrNumber, $reportCode, $includeDeleted = false)
    {
        $sql = "SELECT cp.*, f.full_name as farmer_name, p.Paddy_Size as paddySize 
                FROM complaints cp 
                LEFT JOIN farmers f ON cp.farmerNIC = f.nic 
                LEFT JOIN paddy p ON cp.plrNumber = p.PLR AND cp.farmerNIC = p.NIC_FK 
                WHERE 1=1"; // Changed WHERE clause base

        if (!$includeDeleted) {
            $sql .= " AND cp.is_deleted = 0";
        }

        $params = [];

        // Add filters
        if (!empty($farmerNIC)) {
            $sql .= " AND cp.farmerNIC = :farmerNIC";
            $params[':farmerNIC'] = $farmerNIC;
        }

        if (!empty($plrNumber)) {
            $sql .= " AND cp.plrNumber = :plrNumber";
            $params[':plrNumber'] = $plrNumber;
        }

        if (!empty($reportCode)) {
            $sql .= " AND cp.complaint_id LIKE :Complaint_id";
            $params[':Complaint_id'] = '%' . $reportCode . '%';
        }

        $sql .= " ORDER BY cp.created_at DESC";

        $this->db->query($sql);

        // Bind params
        foreach ($params as $param => $value) {
            $this->db->bind($param, $value);
        }

        return $this->db->resultSet();
    }

    // Update report status
    public function updateReportStatus($reportCode, $status, $officerId = null)
    {
        try {
            $sql = "UPDATE complaints SET status = :status, updated_at = NOW()";

            if ($officerId) {
                $sql .= ", status_updated_by = :officer_id";
            }

            $sql .= " WHERE complaint_id = :complaint_id";

            $this->db->query($sql);
            $this->db->bind(':status', $status);
            $this->db->bind(':complaint_id', $reportCode);

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
    public function submitOfficerResponse($complaint_id, $officerId, $message, $media = null)
    {
        try {
            $this->db->query("INSERT INTO complaint_officer_responses (complaint_id, officer_id, response_message, response_media, created_at) 
                              VALUES (:complaint_id, :officer_id, :message, :media, NOW())");
            $this->db->bind(':complaint_id', $complaint_id);
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
    public function getOfficerResponseById($id)
    {
        try {
            $this->db->query("SELECT * FROM complaint_officer_responses WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Exception in getOfficerResponseById: " . $e->getMessage());
            return false;
        }
    }

    // Update officer response
    public function updateOfficerResponse($id, $message, $media = null)
    {
        try {
            $sql = "UPDATE complaint_officer_responses SET response_message = :message, is_edited = 1, updated_at = NOW()";
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
    public function deleteOfficerResponse($id)
    {
        try {
            $this->db->query("UPDATE complaint_officer_responses SET is_deleted = 1 WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Exception in deleteOfficerResponse: " . $e->getMessage());
            return false;
        }
    }
}

?>