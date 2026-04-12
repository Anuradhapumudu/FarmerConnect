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

    public function saveStartDate($nic, $plr)
    {
        $this->db->query("
            INSERT INTO farmer_timeline (farmer_nic, plr, start_date)
            VALUES (:nic, :plr, CURDATE())
            ON DUPLICATE KEY UPDATE start_date = start_date
        ");

        $this->db->bind(':nic', $nic);
        $this->db->bind(':plr', $plr);

        return $this->db->execute();
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

    public function getTimelineByDuration($duration)
    {
        $this->db->query("
                        SELECT*
                        From timeline_steps
                        Where duration_months = :duration
                        ORDER BY step_order
                        ");

        $this->db->bind(':duration',(float)$duration);
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
            SELECT step_order, status , updated_date
            FROM farmer_timeline_progress
            WHERE farmer_nic = :nic AND plr = :plr
        ");

        $this->db->bind(':nic', $nic);
        $this->db->bind(':plr', $plr);

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


}

?>