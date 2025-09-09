<?php
class Product {
 private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Get products by seller
    public function getProductsBySeller($seller_id) {
        $this->db->query("SELECT * FROM products WHERE seller_id = :seller_id");
        $this->db->bind(':seller_id', $seller_id);
        return $this->db->resultSet();
    }
}
?>
