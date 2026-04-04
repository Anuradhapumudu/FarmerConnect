<?php
class M_ProfileView {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getSellerProfile($seller_id) {
        $this->db->query("SELECT * FROM sellers WHERE seller_id = :seller_id");
        $this->db->bind(':seller_id', $seller_id);
        return $this->db->single();
    }

  public function updateSellerProfile($data){
    $this->db->query("
        UPDATE sellers SET
            first_name = :first_name,
            last_name = :last_name,
            company_name = :company_name,
            address = :address,
            phone_no = :phone_no,
            image_url = :image_url
        WHERE seller_id = :seller_id
    ");

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':company_name', $data['company_name']);
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':phone_no', $data['phone_no']);
    $this->db->bind(':image_url', $data['image_url']);
    $this->db->bind(':seller_id', $data['seller_id']);

    return $this->db->execute(); 
}

    public function getOfficerProfile($officer_id) {
        $this->db->query("SELECT * FROM officers WHERE officer_id = :officer_id");
        $this->db->bind(':officer_id', $officer_id);
        return $this->db->single();
    }

  public function updateOfficerProfile($data){
    $this->db->query("
        UPDATE officers SET
            first_name = :first_name,
            last_name = :last_name,
            phone_no = :phone_no,
            image_url = :image_url
        WHERE officer_id = :officer_id
    ");

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':phone_no', $data['phone_no']);
    $this->db->bind(':image_url', $data['image_url']);
    $this->db->bind(':officer_id', $data['officer_id']);

    return $this->db->execute(); 
}

public function getAdminProfile($admin_id) {
    $this->db->query("SELECT * FROM admins WHERE admin_id = :admin_id");
    $this->db->bind(':admin_id', $admin_id);
    return $this->db->single();
}

public function updateAdminProfile($data) {
    $this->db->query("
        UPDATE admins SET
            first_name = :first_name,
            last_name  = :last_name,
            phone_no   = :phone_no,
            image_url  = :image_url
        WHERE admin_id = :admin_id
    ");

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name',  $data['last_name']);
    $this->db->bind(':phone_no',   $data['phone_no']);
    $this->db->bind(':image_url',  $data['image_url']);
    $this->db->bind(':admin_id',   $data['admin_id']);

    return $this->db->execute();
}


}
?>