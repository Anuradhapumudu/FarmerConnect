<?php

class TimeLineModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    } 

    public function getPLRS($farmerNIC)
    {
        $this->db->query("SELECT PLR FROM paddy WHERE NIC_FK = :fid ");
        $this->db->bind(':fid', $farmerNIC);
        return $this->db->resultSet();
    }

    public function getSeedVariety($plr)
    {
        $this->db->query("SELECT Paddy_seed_variety FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $plr);
        return $this->db->single();
    }

    public function getTimelineByDuration($duration)
    {
        $this->db->query("
                        SELECT*
                        From timeline_steps
                        Where duration_months = :duration
                        ORDER BY step_order
                        ");

        $this->db->bind(':duration',$duration);
        return $this->db->resultSet();
    }

    public function saveStepStatus($nic, $plr, $stepOrder, $status)
    {
        $this->db->query("
            INSERT INTO farmer_timeline_progress
            (farmer_nic, plr, step_order, status, updated_date)
            VALUES (:nic, :plr, :step, :status, CURDATE())
            ON DUPLICATE KEY UPDATE
                status = :status,
                updated_date = CURDATE()
        ");

        $this->db->bind(':nic', $nic);
        $this->db->bind(':plr', $plr);
        $this->db->bind(':step', $stepOrder);
        $this->db->bind(':status', $status);

        return $this->db->execute();
    }

    public function getSavedProgress($nic, $plr)
    {
        $this->db->query("
            SELECT step_order, status
            FROM farmer_timeline_progress
            WHERE farmer_nic = :nic AND plr = :plr
        ");

        $this->db->bind(':nic', $nic);
        $this->db->bind(':plr', $plr);

        return $this->db->resultSet();
    }


}

?>