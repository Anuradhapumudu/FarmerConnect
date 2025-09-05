<?php
class M_ViewProduct {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // This method must exist
    public function getFertilizerProducts() {
        $this->db->query("
            SELECT products.*, sellers.seller_name AS seller_name 
            FROM products 
            JOIN sellers ON products.seller_id = sellers.seller_id
            WHERE products.category = 'fertilizer'
        ");
        return $this->db->resultSet();
    }
}
?>
