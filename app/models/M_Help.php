<?php
class M_Help {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /* ================= SUPPORT MEMBERS ================= */

    // Get help members
    public function getMembers() {
        $this->db->query("
            SELECT officer_id AS id,
                   CONCAT(first_name, ' ', last_name) AS name,
                   phone_no AS phone,
                   image_url AS image,
                   'Officer' AS type
            FROM officers
            WHERE is_help_contact = 1

            UNION ALL

            SELECT admin_id AS id,
                   CONCAT(first_name, ' ', last_name) AS name,
                   phone_no AS phone,
                   image_url AS image,
                   'Admin' AS type
            FROM admins
            WHERE is_help_contact = 1
        ");

        return $this->db->resultSet();
    }

    // Add member to help center (existing officer/admin)
    public function addMember($id, $type) {
        if ($type === 'Officer') {
            $this->db->query("UPDATE officers SET is_help_contact = 1 WHERE officer_id = :id");
        } else {
            $this->db->query("UPDATE admins SET is_help_contact = 1 WHERE admin_id = :id");
        }

        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Remove member
    public function removeMember($id, $type) {
        if ($type === 'Officer') {
            $this->db->query("UPDATE officers SET is_help_contact = 0 WHERE officer_id = :id");
        } else {
            $this->db->query("UPDATE admins SET is_help_contact = 0 WHERE admin_id = :id");
        }

        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Edit member
    public function editMember($data) {
        if ($data['type'] === 'Officer') {
            $this->db->query("
                UPDATE officers
                SET first_name = :first,
                    last_name = :last,
                    phone_no = :phone,
                    image_url = :image
                WHERE officer_id = :id
            ");
        } else {
            $this->db->query("
                UPDATE admins
                SET first_name = :first,
                    last_name = :last,
                    phone_no = :phone,
                    image_url = :image
                WHERE admin_id = :id
            ");
        }

        $nameParts = explode(' ', $data['name'], 2);

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first', $nameParts[0]);
        $this->db->bind(':last', $nameParts[1] ?? '');
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':image', $data['image']);

        return $this->db->execute();
    }

    /* ================= EMERGENCY CONTACT ================= */

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
