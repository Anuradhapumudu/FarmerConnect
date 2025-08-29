<?php
class Disease {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Add a new disease report
    public function addReport($data) {
        error_log("=== MODEL addReport START ===");
        error_log("Received data in model: " . print_r($data, true));
        
        try {
            error_log("Creating Database instance...");
            // Make sure we have a fresh database instance
            $this->db = new Database();
            error_log("Database instance created");
            
            // Prepare the SQL query
            $sql = 'INSERT INTO disease_reports 
                    (report_id, farmer_nic, plr_number, observation_date, title, description, severity, affected_area) 
                    VALUES (:report_id, :farmer_nic, :plr_number, :observation_date, :title, :description, :severity, :affected_area)';
            
            error_log("Preparing SQL query: " . $sql);
            $this->db->query($sql);
            error_log("SQL query prepared successfully");
            
            // Bind all values
            error_log("Binding parameters...");
            $this->db->bind(':report_id', $data['report_id']);
            error_log("Bound report_id: " . $data['report_id']);
            
            $this->db->bind(':farmer_nic', $data['farmer_nic']);
            error_log("Bound farmer_nic: " . $data['farmer_nic']);
            
            $this->db->bind(':plr_number', $data['plr_number']);
            error_log("Bound plr_number: " . $data['plr_number']);
            
            $this->db->bind(':observation_date', $data['observation_date']);
            error_log("Bound observation_date: " . $data['observation_date']);
            
            $this->db->bind(':title', $data['title']);
            error_log("Bound title: " . $data['title']);
            
            $this->db->bind(':description', $data['description']);
            error_log("Bound description: " . substr($data['description'], 0, 50) . "...");
            
            $this->db->bind(':severity', $data['severity']);
            error_log("Bound severity: " . $data['severity']);
            
            $this->db->bind(':affected_area', $data['affected_area']);
            error_log("Bound affected_area: " . $data['affected_area']);
            
            error_log("All parameters bound successfully");
            
            // Execute the query
            error_log("Executing query...");
            $result = $this->db->execute();
            error_log("Query execution result: " . ($result ? 'TRUE' : 'FALSE'));
            
            if ($result) {
                error_log("SUCCESS: Data inserted into database");
                return true;
            } else {
                error_log("ERROR: Database execute() returned false");
                return false;
            }
            
        } catch (PDOException $e) {
            // Log the specific PDO error
            error_log("PDO ERROR in addReport: " . $e->getMessage());
            error_log("PDO Error Code: " . $e->getCode());
            throw new Exception("Database error: " . $e->getMessage());
        } catch (Exception $e) {
            // Log any other error
            error_log("GENERAL ERROR in addReport: " . $e->getMessage());
            throw $e;
        } finally {
            error_log("=== MODEL addReport END ===");
        }
    }
    
    // Check if report ID already exists
    public function findReportById($report_id) {
        $this->db->query('SELECT * FROM disease_reports WHERE report_id = :report_id');
        $this->db->bind(':report_id', $report_id);
        
        $row = $this->db->single();
        
        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get all reports for a farmer
    public function getReportsByFarmer($farmer_nic) {
        $this->db->query('SELECT * FROM disease_reports WHERE farmer_nic = :farmer_nic ORDER BY created_at DESC');
        $this->db->bind(':farmer_nic', $farmer_nic);
        
        return $this->db->resultSet();
    }
}
