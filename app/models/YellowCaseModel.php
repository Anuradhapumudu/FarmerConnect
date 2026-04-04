<?php
class YellowCaseModel {

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function create($data)
    {
        $this->db->query("
            INSERT INTO yellow_cases 
            (case_id, farmer_nic, plr_number, observation_date, submitted_date, case_title, case_description, media)
            VALUES
            (:case_id, :farmer_nic, :plr_number, :observation_date, :submitted_date, :case_title, :case_description, :media)
        ");

        $this->db->bind(':case_id', $data['case_id']);
        $this->db->bind(':farmer_nic', $data['farmer_nic']);
        $this->db->bind(':plr_number', $data['plr_number']);
        $this->db->bind(':observation_date', $data['observation_date']);
        $this->db->bind(':submitted_date', $data['submitted_date']);
        $this->db->bind(':case_title', $data['case_title']);
        $this->db->bind(':case_description', $data['case_description']);
        $this->db->bind(':media', $data['media']);

        return $this->db->execute();
    }

    public function getByFarmer($farmerNIC)
    {
        $this->db->query("SELECT * 
                        FROM yellow_cases 
                        WHERE farmer_nic = :farmer_nic 
                        ORDER BY created_at DESC");
                        
        $this->db->bind(':farmer_nic', $farmerNIC);

        return $this->db->resultSet();
    }

    public function getByCaseId($caseId)
    {
        $this->db->query("SELECT * FROM yellow_cases WHERE case_id = :case_id");
        $this->db->bind(':case_id', $caseId);

        return $this->db->single();
    }
}

?>
