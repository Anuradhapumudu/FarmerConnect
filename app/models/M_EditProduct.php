<?php
class M_EditProduct {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Get product by ID
    public function getProductById($id) {
        $this->db->query("SELECT * FROM products WHERE item_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Update product
    public function updateProduct($data) {
        $this->db->query("UPDATE products SET 
            item_name = :item_name,
            category = :category,
            description = :description,
            status = :status,
            region = :region,
            unit_type = :unit_type,
            price_per_unit = :price_per_unit,
            available_quantity = :available_quantity,
            image_url = :image_url
            WHERE item_id = :item_id
        ");

        $this->db->bind(':item_name', $data['item_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':region', $data['region']);
        $this->db->bind(':unit_type', $data['unit_type']);
        $this->db->bind(':price_per_unit', $data['price_per_unit']);
        $this->db->bind(':available_quantity', $data['available_quantity']);
        $this->db->bind(':image_url', $data['image_url']);
        $this->db->bind(':item_id', $data['item_id']);

        return $this->db->execute();
    }
}
?>
