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
            image_url = :image_url,
            email=:email
        WHERE seller_id = :seller_id
    ");

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':company_name', $data['company_name']);
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':phone_no', $data['phone_no']);
    $this->db->bind(':image_url', $data['image_url']);
    $this->db->bind(':seller_id', $data['seller_id']);
    $this->db->bind(':email', $data['email']);

    return $this->db->execute(); 
}

public function sellerEmailExists($email, $seller_id){
    $this->db->query("
        SELECT seller_id 
        FROM sellers 
        WHERE email = :email 
        AND seller_id != :seller_id
    ");

    $this->db->bind(':email', $email);
    $this->db->bind(':seller_id', $seller_id);

    $this->db->execute();

    return $this->db->rowCount() > 0;
}


public function deleteSellerImage($seller_id){

    $this->db->query("
        UPDATE sellers 
        SET image_url = NULL 
        WHERE seller_id = :seller_id
    ");

    $this->db->bind(':seller_id', $seller_id);

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
            image_url = :image_url,
            email=:email
        WHERE officer_id = :officer_id
    ");

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':phone_no', $data['phone_no']);
    $this->db->bind(':image_url', $data['image_url']);
    $this->db->bind(':officer_id', $data['officer_id']);
    $this->db->bind(':email', $data['email']);

    return $this->db->execute(); 
}

public function officerEmailExists($email, $officer_id){
    $this->db->query("
        SELECT officer_id 
        FROM officers 
        WHERE email = :email 
        AND officer_id != :officer_id
    ");

    $this->db->bind(':email', $email);
    $this->db->bind(':officer_id', $officer_id);

    $this->db->execute();

    return $this->db->rowCount() > 0;
}


public function deleteOfficerImage($officer_id){

    $this->db->query("
        UPDATE officers 
        SET image_url = DEFAULT
        WHERE officer_id = :officer_id
    ");

    $this->db->bind(':officer_id', $officer_id);

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
            image_url  = :image_url,
            email = :email
        WHERE admin_id = :admin_id
    ");

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name',  $data['last_name']);
    $this->db->bind(':phone_no',   $data['phone_no']);
    $this->db->bind(':image_url',  $data['image_url']);
    $this->db->bind(':admin_id',   $data['admin_id']);
    $this->db->bind(':email', $data['email']);

    return $this->db->execute();
}

public function adminEmailExists($email, $admin_id){
    $this->db->query("
        SELECT admin_id 
        FROM admins 
        WHERE email = :email 
        AND admin_id != :admin_id
    ");

    $this->db->bind(':email', $email);
    $this->db->bind(':admin_id', $admin_id);

    $this->db->execute();

    return $this->db->rowCount() > 0;
}


public function deleteAdminImage($admin_id){

    $this->db->query("
        UPDATE admins 
        SET image_url = DEFAULT
        WHERE admin_id = :admin_id
    ");

    $this->db->bind(':admin_id', $admin_id);

    return $this->db->execute();
}

}
?>