<?php
class M_ViewProduct {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Fetch products by category
    public function getProductsByCategory($category) {
        $this->db->query("
            SELECT products.*, sellers.seller_name AS seller_name 
            FROM products 
            JOIN sellers ON products.seller_id = sellers.seller_id
            WHERE products.category = :category
        ");
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }
}
