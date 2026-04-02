<?php

class officerCalculator
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function updateData($cropType,$cropStage,$urea,$potash,$phosphate)
    {
        $this->db->query("UPDATE fertilizer_recommendations
                          SET urea_per_acre = :urea,
                              potash_per_acre = :potash,
                              phosphate_per_acre = :phosphate
                          WHERE crop_type_months = :cropType
                          AND crop_stage = :cropStage ");

        $this->db->bind(':urea',$urea);
        $this->db->bind(':potash', $potash);
        $this->db->bind(':phosphate', $phosphate);
        $this->db->bind(':cropType', $cropType);
        $this->db->bind(':cropStage', $cropStage);

        return $this->db->execute();

    }


    public function getAllRecommendationI()
    {
        $this->db->query("SELECT * FROM fertilizer_recommendations 
                        ORDER BY crop_type_months, crop_stage");
        return $this->db->resultSet(); //returns all rows as array
    }
}

?>