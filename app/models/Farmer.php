<?php

class Farmer {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Update or insert farmer
    public function updateFarmer($data) {
    // Check if farmer already exists
    $this->db->query("SELECT NIC FROM farmer WHERE NIC = :NIC");
    $this->db->bind(':NIC', $data['NIC']);
    $existing = $this->db->single();

    if ($existing) {
        // Update existing farmer
        $this->db->query("UPDATE farmer 
                          SET Name = :Name, Address = :Address, TelNo = :TelNo, Birthday = :Birthday, Gender = :Gender 
                          WHERE NIC = :NIC");
    } else {
        // Insert new farmer
        $this->db->query("INSERT INTO farmer (NIC, Name, Address, TelNo, Birthday, Gender)
                          VALUES (:NIC, :Name, :Address, :TelNo, :Birthday, :Gender)");
    }

    $this->db->bind(':NIC', $data['NIC']);
    $this->db->bind(':Name', $data['Name']);
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