<?php
class OfficerTimelineModel {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get officer division
    public function getOfficerDivision($officerId) {
        $this->db->query("
            SELECT govi_jana_sewa_division 
            FROM officers 
            WHERE officer_id = :officer_id
        ");

        $this->db->bind(':officer_id', $officerId);

        $row = $this->db->single();

        return $row ? $row->govi_jana_sewa_division : null;
    }

    // Get farmers (PLR list) in that division
    public function getFarmersByDivision($division, $search = null, $status = null)
    {
        $query = "
            SELECT p.PLR, p.NIC_FK, f.full_name, f.status
            FROM paddy p
            JOIN farmers f ON p.NIC_FK = f.nic
            WHERE p.Govi_Jana_Sewa_Division = :division
        ";

        //  SEARCH
        if ($search) {
            $query .= " AND (p.PLR LIKE :search OR p.NIC_FK LIKE :search)";
        }

        //  FILTER
        if ($status && $status != 'all') {
            $query .= " AND f.status = :status";
        }

        $this->db->query($query);

        $this->db->bind(':division', $division);

        if ($search) {
            $this->db->bind(':search', '%' . $search . '%');
        }

        if ($status && $status != 'all') {
            $this->db->bind(':status', ucfirst($status)); // Active / Inactive
        }

        return $this->db->resultSet();
    }

public function getNICByPLR($plr)
{
    $this->db->query("
        SELECT NIC_FK 
        FROM paddy 
        WHERE PLR = :plr
    ");

    $this->db->bind(':plr', $plr);

    $row = $this->db->single();

    return $row ? $row->NIC_FK : null;
}

public function getSeedVariety($plr)
{
    $this->db->query("SELECT Paddy_Seed_Variety FROM paddy WHERE PLR = :plr");
    $this->db->bind(':plr', $plr);
    return $this->db->single();
}

public function getTimelineByDuration($duration)
{
    $this->db->query("
        SELECT * 
        FROM timeline_steps 
        WHERE duration_months = :duration
        ORDER BY step_order
    ");
    $this->db->bind(':duration', (float)$duration);
    return $this->db->resultSet();
}

public function getStartDate($nic, $plr)
{
    $this->db->query("
        SELECT start_date 
        FROM farmer_timeline 
        WHERE farmer_nic = :nic AND plr = :plr
    ");
    $this->db->bind(':nic', $nic);
    $this->db->bind(':plr', $plr);

    $row = $this->db->single();
    return $row ? $row->start_date : null;
}

public function getSavedProgress($nic, $plr)
{
    $this->db->query("
        SELECT step_order, status,updated_date
        FROM farmer_timeline_progress
        WHERE farmer_nic = :nic AND plr = :plr
    ");
    $this->db->bind(':nic', $nic);
    $this->db->bind(':plr', $plr);

    return $this->db->resultSet();
}



}