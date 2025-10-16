<?php

class Paddy {
    private $db;

    public function __construct() {
        $this->db = new Database();
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
}
