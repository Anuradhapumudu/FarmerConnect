<?php
class M_Help {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all help members
    public function getMembers() {
        $this->db->query("
            SELECT 
                h.user_id AS id,
                CONCAT(o.first_name, ' ', o.last_name) AS name,
                o.phone_no AS phone,
                o.image_url AS image,
                'Officer' AS type
            FROM help_center_members h
            JOIN officers o ON h.user_id = o.officer_id
            WHERE h.user_type = 'officer'

            UNION ALL

            SELECT 
                h.user_id AS id,
                CONCAT(a.first_name, ' ', a.last_name) AS name,
                a.phone_no AS phone,
                a.image_url AS image,
                'Admin' AS type
            FROM help_center_members h
            JOIN admins a ON h.user_id = a.admin_id
            WHERE h.user_type = 'admin'
        ");

        return $this->db->resultSet();
    }

    public function userExists($id, $type) {
    if ($type === 'Officer') {
        $this->db->query("SELECT officer_id FROM officers WHERE officer_id = :id");
    } else {
        $this->db->query("SELECT admin_id FROM admins WHERE admin_id = :id");
    }

    $this->db->bind(':id', $id);
    return $this->db->single();
}


public function isAlreadyHelpMember($id) {
    $this->db->query("SELECT id FROM help_center_members WHERE user_id = :id");
    $this->db->bind(':id', $id);
    return $this->db->single();
}


    // Add member
    public function addMember($id, $type) {
        $this->db->query("
            INSERT INTO help_center_members (user_id, user_type)
            VALUES (:id, :type)
        ");
        $this->db->bind(':id', $id);
        $this->db->bind(':type', strtolower($type));

        return $this->db->execute();
    }

    // Remove member
    public function removeMember($id) {
        $this->db->query("DELETE FROM help_center_members WHERE user_id = :id");
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    /* ===== Emergency Contact ===== */

    public function getEmergencyContact() {
        $this->db->query("SELECT phone FROM emergency_contacts LIMIT 1");
        return $this->db->single();
    }

    public function updateEmergencyContact($phone) {
        $this->db->query("UPDATE emergency_contacts SET phone = :phone WHERE id = 1");
        $this->db->bind(':phone', $phone);
        return $this->db->execute();
    }
}


?>