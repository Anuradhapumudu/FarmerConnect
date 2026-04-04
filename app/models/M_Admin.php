
<?php
class M_Admin {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Sellers
    public function getAllSellers() {
        $this->db->query("SELECT * FROM sellers ORDER BY seller_id DESC");
        return $this->db->resultSet() ?? [];
    }

    public function getCounts() {
        $this->db->query("\n            SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN approval_status='Approved' THEN 1 ELSE 0 END) AS approved,
                SUM(CASE WHEN approval_status='Pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN approval_status='Rejected' THEN 1 ELSE 0 END) AS rejected
            FROM sellers
        ");
        return $this->db->single();
    }

    public function deleteSeller($id) {
        $this->db->query("DELETE FROM sellers WHERE seller_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getSellerById($id) {
        $this->db->query("SELECT * FROM sellers WHERE seller_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateSeller($seller_id, $data) {
        $this->db->query("UPDATE sellers SET 
            first_name = :first_name, 
            last_name = :last_name, 
            nic = :nic,
            email = :email, 
            phone_no = :phone_no, 
            address = :address, 
            company_name = :company_name, 
            brn = :brn, 
            approval_status = :approval_status,
            updated_at = NOW()
            WHERE seller_id = :seller_id
        ");

        // Bind parameters
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':nic', $data['nic']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone_no', $data['phone_no']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':company_name', $data['company_name']);
        $this->db->bind(':brn', $data['brn']);
        $this->db->bind(':approval_status', $data['approval_status']);
        $this->db->bind(':seller_id', $seller_id);

        return $this->db->execute();
    }

    public function updateSellerStatus($seller_id, $status) {
        $this->db->query("UPDATE sellers SET approval_status = :status WHERE seller_id = :seller_id");
        $this->db->bind(':status', $status);
        $this->db->bind(':seller_id', $seller_id);
        return $this->db->execute();
    }




    // Farmers
    public function getAllFarmers() {
        $this->db->query("SELECT * FROM farmers ORDER BY registration_id DESC");
        return $this->db->resultSet() ?? [];
    }

    public function getfarmerCounts() {
        $this->db->query("\n            SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN status='Active' THEN 1 ELSE 0 END) AS active,
                SUM(CASE WHEN status='Inactive' THEN 1 ELSE 0 END) AS inactive
            FROM farmers
        ");
        return $this->db->single();
    }

        public function getFarmerById($id) {
        $this->db->query("SELECT f.* , r.created_at FROM farmers f INNER JOIN registrations r ON f.registration_id = r.registration_id WHERE f.nic = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getPaddyDetailsById($id)
{
    $this->db->query("SELECT * FROM paddy WHERE NIC_FK = :id");
    $this->db->bind(':id', $id);
    return $this->db->resultSet();
}


     public function updateFarmerStatus($farmer_id, $status) {
        $this->db->query("UPDATE farmers SET status = :status WHERE nic = :farmer_id");
        $this->db->bind(':status', $status);
        $this->db->bind(':farmer_id', $farmer_id);
        return $this->db->execute();
    }



    // Officers
    public function getAllOfficers() {
        $this->db->query("SELECT * FROM officers ORDER BY officer_id DESC");
        return $this->db->resultSet() ?? [];
    }


    public function getofficerCounts() {
        $this->db->query("\n            SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN status='Active' THEN 1 ELSE 0 END) AS active,
                SUM(CASE WHEN status='Inactive' THEN 1 ELSE 0 END) AS inactive
            FROM officers
        ");
        return $this->db->single();
    }


     public function getOfficerById($id) {
        $this->db->query("SELECT o.* , r.created_at FROM officers o INNER JOIN registrations r ON o.registration_id = r.registration_id WHERE o.officer_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

         public function updateOfficerStatus($officer_id, $status) {
        $this->db->query("UPDATE officers SET status = :status WHERE officer_id = :officer_id");
        $this->db->bind(':status', $status);
        $this->db->bind(':officer_id', $officer_id);
        return $this->db->execute();
    }
}