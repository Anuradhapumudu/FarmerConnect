<?php

class FertilizerCalculatorModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

public function getRecommendation($crop_type,$crop_stage)
{
    //prepare sql
    $this->db->query("       
        SELECT urea_per_acre, potash_per_acre, phosphate_per_acre
        FROM fertilizer_recommendations
        WHERE crop_type_months = :crop_type
        AND crop_stage = :crop_stage
        LIMIT 1"
);
    //safely passes values (prevents SQL injection)
    $this->db->bind(':crop_type', $crop_type);
    $this->db->bind(':crop_stage', $crop_stage);

    return $this->db->single(); //fetches 1 row as associative array
}

public function calculateFertilizer($land_area,$crop_type,$crop_stage)
{
    $row = $this->getRecommendation($crop_type,$crop_stage);
 
    if(!$row)
    {
        return null;
    }

    $urea_amount_perAcre = $row->urea_per_acre;
    $potash_amount_perAcre = $row->potash_per_acre;
    $superPhospate_amount_perAcre = $row->phosphate_per_acre;
    
    $Recomont_Urea_amount = $urea_amount_perAcre * $land_area;
    $Recomont_potash_amount = $potash_amount_perAcre * $land_area;
    $Recomont_superPhospate_amount = $superPhospate_amount_perAcre * $land_area;

    $result = ['urea' => $Recomont_Urea_amount,
               'potash' => $Recomont_potash_amount,
               'superPhospate' =>$Recomont_superPhospate_amount];

    return $result;

}

}

?>
