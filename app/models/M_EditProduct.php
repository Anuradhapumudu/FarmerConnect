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
        return $this->db->single(); // returns stdClass object
    }

    // Update product
    public function updateProduct($data) {
        $this->db->query("UPDATE products SET 
            item_name = :item_name,
            category = :category,
            brand = :brand,
            price_per_unit = :price_per_unit,
            discount = :discount,
            discount_price = :discount_price,
            description = :description,
            expiration_date = :expiration_date,
            available_quantity = :available_quantity,
            image_url = :image_url
            WHERE item_id = :item_id
        ");

        $this->db->bind(':item_name', $data['item_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':brand', $data['brand']);
        $this->db->bind(':price_per_unit', $data['price_per_unit']);
        $this->db->bind(':discount', $data['discount']);
        $this->db->bind(':discount_price', $data['discount_price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':expiration_date', $data['expiration_date']);
        $this->db->bind(':available_quantity', $data['available_quantity']);
        $this->db->bind(':image_url', $data['image_url']);
        $this->db->bind(':item_id', $data['item_id']);

        return $this->db->execute();
    }
}
?>
