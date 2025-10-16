<?php

class Farmer {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Update or insert farmer
    public function updateFarmer($data) {
        $this->db->query("REPLACE INTO farmer (NIC, Name, Address, TelNo, Birthday, Gender)
                          VALUES (:NIC, :Name, :Address, :TelNo, :Birthday, :Gender)");

        $this->db->bind(':NIC', $data['NIC']);
        $this->db->bind(':Name', $data['Name'] ?? 'K.R.Aberathna'); // default dummy name
        $this->db->bind(':Address', $data['Address']);
        $this->db->bind(':TelNo', $data['TelNo']);
        $this->db->bind(':Birthday', $data['Birthday']);
        $this->db->bind(':Gender', $data['Gender']);

        return $this->db->execute();
    }

    // Get farmer details by NIC
    public function getFarmerByNIC($nic) {
        $this->db->query("SELECT * FROM farmer WHERE NIC = :nic");
        $this->db->bind(':nic', $nic);
        return $this->db->single();
    }
}