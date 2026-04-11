<?php

class Paddy {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function savePaddyRequest($data)
    {
        $this->db->query("
            INSERT INTO paddy_requests
            (PLR, NIC_FK, OfficerID, Paddy_Seed_Variety, Paddy_Size, Province, District, Govi_Jana_Sewa_Division, Grama_Niladhari_Division, Yaya)
            VALUES
            (:PLR, :NIC_FK, :OfficerID, :Paddy_Seed_Variety, :Paddy_Size, :Province, :District, :Govi_Jana_Sewa_Division, :Grama_Niladhari_Division, :Yaya)
        ");

        $this->db->bind(':PLR', $data['PLR']);
        $this->db->bind(':NIC_FK', $data['NIC']);
        $this->db->bind(':OfficerID', $data['OfficerID']);
        $this->db->bind(':Paddy_Seed_Variety', $data['Paddy_Seed_Variety']);
        $this->db->bind(':Paddy_Size', $data['Paddy_Size']);
        $this->db->bind(':Province', $data['Province']);
        $this->db->bind(':District', $data['District']);
        $this->db->bind(':Govi_Jana_Sewa_Division', $data['Govi_Jana_Sewa_Division']);
        $this->db->bind(':Grama_Niladhari_Division', $data['Grama_Niladhari_Division']);
        $this->db->bind(':Yaya', $data['Yaya']);

        return $this->db->execute();
    }

    public function getRequestsByNIC($nic)
    {
        $this->db->query("
            SELECT * 
            FROM paddy_requests
            WHERE NIC_FK = :nic
            ORDER BY created_at DESC
        ");

        $this->db->bind(':nic', $nic);

        return $this->db->resultSet();
    }

    // Insert or update paddy
    public function savePaddy($data) {
        $this->db->query("REPLACE INTO paddy
            (PLR, NIC_FK, OfficerID, Paddy_Seed_Variety, Paddy_Size, Province, District, Govi_Jana_Sewa_Division, Grama_Niladhari_Division, Yaya)
            VALUES
            (:PLR, :NIC_FK, :OfficerID, :Paddy_Seed_Variety, :Paddy_Size, :Province, :District, :Govi_Jana_Sewa_Division, :Grama_Niladhari_Division, :Yaya)");

        $this->db->bind(':PLR', $data['PLR']);
        $this->db->bind(':NIC_FK', $data['NIC']);
        $this->db->bind(':OfficerID', $data['OfficerID']);
        $this->db->bind(':Paddy_Seed_Variety', $data['Paddy_Seed_Variety']);
        $this->db->bind(':Paddy_Size', $data['Paddy_Size']);
        $this->db->bind(':Province', $data['Province']);
        $this->db->bind(':District', $data['District']);
        $this->db->bind(':Govi_Jana_Sewa_Division', $data['Govi_Jana_Sewa_Division']);
        $this->db->bind(':Grama_Niladhari_Division', $data['Grama_Niladhari_Division']);
        $this->db->bind(':Yaya', $data['Yaya']);

        return $this->db->execute();
    }

    // Get all paddy rows for a farmer
    public function getPaddyByNIC($nic) {
        $this->db->query("SELECT * FROM paddy WHERE NIC_FK = :nic ORDER BY PLR ASC");
        $this->db->bind(':nic', $nic);
        return $this->db->resultSet();
    }

    // Get single paddy row by PLR
    public function getPaddyByPLR($plr) {
        $this->db->query("SELECT * FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $plr);
        return $this->db->single();
    }

    // Delete single paddy row by PLR
    public function deletePaddyByPLR($plr) {

        // 1. Get full row
        $this->db->query("SELECT * FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $plr);
        $row = $this->db->single();

        if (!$row) return false;

        // 2. Insert FULL row into deleted_plr
        $this->db->query("
            INSERT INTO deleted_plr (
                PLR, NIC_FK, OfficerID, Paddy_Seed_Variety, Paddy_Size,
                Province, District, Govi_Jana_Sewa_Division,
                Grama_Niladhari_Division, Yaya, CreatedDate,
                deleted_by, deleted_by_id
            ) VALUES (
                :PLR, :NIC, :OfficerID, :Seed, :Size,
                :Province, :District, :Division,
                :GN, :Yaya, :CreatedDate,
                :deleted_by, :deleted_by_id
            )
        ");

        $this->db->bind(':PLR', $row->PLR);
        $this->db->bind(':NIC', $row->NIC_FK);
        $this->db->bind(':OfficerID', $row->OfficerID);
        $this->db->bind(':Seed', $row->Paddy_Seed_Variety);
        $this->db->bind(':Size', $row->Paddy_Size);
        $this->db->bind(':Province', $row->Province);
        $this->db->bind(':District', $row->District);
        $this->db->bind(':Division', $row->Govi_Jana_Sewa_Division);
        $this->db->bind(':GN', $row->Grama_Niladhari_Division);
        $this->db->bind(':Yaya', $row->Yaya);
        $this->db->bind(':CreatedDate', $row->CreatedDate);

        // 👇 who deleted
        if (isset($_SESSION['officer_id'])) {
            $this->db->bind(':deleted_by', 'officer');
            $this->db->bind(':deleted_by_id', $_SESSION['officer_id']);
        } else {
            $this->db->bind(':deleted_by', 'farmer');
            $this->db->bind(':deleted_by_id', $_SESSION['nic']);
        }

        $this->db->execute();

        // 3. Delete original (CASCADE will handle others)
        $this->db->query("DELETE FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $plr);

        return $this->db->execute();
    }

}