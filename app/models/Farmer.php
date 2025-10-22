<?php

class Farmer {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ✅ Insert or update farmer using new table columns
    public function updateFarmer($data) {
        // Check if farmer exists
        $this->db->query("SELECT nic FROM farmers WHERE nic = :nic");
        $this->db->bind(':nic', $data['NIC']);
        $existing = $this->db->single();

        if ($existing) {
            // Update existing farmer
            $this->db->query("
                UPDATE farmers 
                SET full_name = :full_name,
                    address = :address,
                    phone_no = :phone_no,
                    birthdate = :birthdate,
                    gender = :gender
                WHERE nic = :nic
            ");
        } else {
            // Insert new farmer
            $this->db->query("
                INSERT INTO farmers (nic, full_name, registration_id, phone_no, gender, birthdate, address, password)
                VALUES (:nic, :full_name, :registration_id, :phone_no, :gender, :birthdate, :address, :password)
            ");
            // use dummy password and registration_id
            $this->db->bind(':registration_id', 0);
            $this->db->bind(':password', password_hash('default123', PASSWORD_BCRYPT));
        }

        $this->db->bind(':nic', $data['NIC']);
        $this->db->bind(':full_name', $data['Name']);
        $this->db->bind(':address', $data['Address']);
        $this->db->bind(':phone_no', $data['TelNo']);
        $this->db->bind(':birthdate', $data['Birthday']);
        $this->db->bind(':gender', $data['Gender']);

        return $this->db->execute();
    }

    // ✅ Get farmer by NIC
    public function getFarmerByNIC($nic) {
        $this->db->query("SELECT * FROM farmers WHERE nic = :nic");
        $this->db->bind(':nic', $nic);
        return $this->db->single();
    }

    // --------------------------------------------------------
    // Update profile image path
    // --------------------------------------------------------
    public function updateProfilePic($nic, $path)
    {
        $this->db->query("UPDATE farmers SET profile_image = :path WHERE nic = :nic");
        $this->db->bind(':path', $path);
        $this->db->bind(':nic', $nic);
        return $this->db->execute();
    }
}