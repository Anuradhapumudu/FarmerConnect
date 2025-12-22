<?php
class M_Help {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all members marked as help contacts
public function getMembers() {
    $this->db->query("
        SELECT 
           officer_id as id,
            CONCAT(first_name, ' ', last_name) AS name,
            phone_no as phone,
            image_url as image,
            'Officer' AS type
        FROM officers
        WHERE is_help_contact = 1

        UNION ALL

        SELECT 
            admin_id as id,
            CONCAT(first_name, ' ', last_name) AS name,
            phone_no as phone,
            image_url as image,
            'Admin' AS type
        FROM admins
        WHERE is_help_contact = 1
    ");
    return $this->db->resultSet();
}


    // Add member (set is_help_contact = 1)
public function addOfficer($officer_id) {
    $this->db->query("
        UPDATE officers 
        SET is_help_contact = 1 
        WHERE officer_id = :officer_id
    ");
    $this->db->bind(':officer_id', $officer_id);
    return $this->db->execute();
}


public function addAdmin($admin_id) {
    $this->db->query("
        UPDATE admins 
        SET is_help_contact = 1 
        WHERE admin_id = :admin_id
    ");
    $this->db->bind(':admin_id', $admin_id);
    return $this->db->execute();
}



public function removeOfficer($officer_id) {
    $this->db->query("
        UPDATE officers 
        SET is_help_contact = 0 
        WHERE officer_id = :officer_id
    ");
    $this->db->bind(':officer_id', $officer_id);
    return $this->db->execute();
}


public function removeAdmin($admin_id) {
    $this->db->query("
        UPDATE admins 
        SET is_help_contact = 0 
        WHERE admin_id = :admin_id
    ");
    $this->db->bind(':admin_id', $admin_id);
    return $this->db->execute();
}
    


    // Edit member info
    public function editMember($data) {
        $this->db->query("UPDATE officers SET phone = :phone WHERE id = :id");
        $this->db->bind(':id', $data['officer_id']);
        $this->db->bind(':phone', $data['phone']);
        return $this->db->execute();
    }
}
?>
