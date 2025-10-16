<?php
    class DiseaseReport {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function create($data) {
            $this->db->query('INSERT INTO disease_reports(report_id, farmer_nic, plr_number, observation_date, submission_timestamp, title, description, severity, affected_area, media_files, created_at) VALUES(:report_id, :farmer_nic, :plr_number, :observation_date, :submission_timestamp, :title, :description, :severity, :affected_area, :media_files, :created_at)');
            
            // Bind values
            $this->db->bind(':report_id', $data['report_id']);
            $this->db->bind(':farmer_nic', $data['farmer_nic']);
            $this->db->bind(':plr_number', $data['plr_number']);
            $this->db->bind(':observation_date', $data['observation_date']);
            $this->db->bind(':submission_timestamp', $data['submission_timestamp']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':severity', $data['severity']);
            $this->db->bind(':affected_area', $data['affected_area']);
            $this->db->bind(':media_files', $data['media_files']);
            $this->db->bind(':created_at', $data['created_at']);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function disease($data) {
            $this->db->query('INSERT INTO disease_reports(farmerNIC, plr, disease_description, report_date) VALUES(:farmer_nic, :crop_id, :disease_description, :report_date);');
            //Bind values
            $this->db->bind(':farmerNIC', $data['farmerNIC']);
            $this->db->bind(':plrNumber', $data['plrNumber']);
            $this->db->bind(':disease_description', $data['disease_description']);
            $this->db->bind(':report_date', $data['report_date']);

            //Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        public function getAllReports() {
            $this->db->query('SELECT * FROM disease_reports ORDER BY created_at DESC');
            return $this->db->resultSet();
        }
        
        public function getReportById($id) {
            $this->db->query('SELECT * FROM disease_reports WHERE report_id = :id');
            $this->db->bind(':id', $id);
            return $this->db->single();
        }
    }
?>