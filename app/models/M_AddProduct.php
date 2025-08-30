<?php
class M_AddProduct {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Check if seller exists
    public function sellerExists($seller_id) {
        $this->db->query("SELECT COUNT(*) AS count FROM sellers WHERE seller_id = :seller_id");
        $this->db->bind(':seller_id', $seller_id);
        $row = $this->db->single();
        return $row->count > 0;
    }

    // Insert new product
    public function addProduct($data) {
        $this->db->query("INSERT INTO products
            (item_name, seller_id, category, description, region, unit_type, price_per_unit, available_quantity, image_url)
            VALUES (:name, :seller_id, :category, :description, :region, :unit_type, :price, :available, :image)");
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':seller_id', $data['seller_id']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':region', $data['region']);
        $this->db->bind(':unit_type', $data['unit_type']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':available', $data['available']);
        $this->db->bind(':image', $data['image']);

        return $this->db->execute();
    }
}
?>
