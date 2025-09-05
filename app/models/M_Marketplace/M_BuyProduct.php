<?php
class M_BuyProduct {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Get product by ID
    public function getProductById($item_id) {
        $this->db->query("SELECT * FROM products WHERE item_id = :item_id");
        $this->db->bind(":item_id", $item_id);
        return $this->db->single();
    }

    // Insert new order
    public function createOrder($farmer_id, $item_id, $quantity, $total_price) {
        $this->db->query("INSERT INTO orderDetails (farmer_id, item_id, quantity, total_price, status) 
                          VALUES (:farmer_id, :item_id, :quantity, :total_price, 'Pending')");
        $this->db->bind(":farmer_id", $farmer_id);
        $this->db->bind(":item_id", $item_id);
        $this->db->bind(":quantity", $quantity);
        $this->db->bind(":total_price", $total_price);
        return $this->db->execute();
    }

    // Update stock
    public function updateStock($item_id, $newQty) {
        $this->db->query("UPDATE products SET available_quantity = :qty WHERE item_id = :item_id");
        $this->db->bind(":qty", $newQty);
        $this->db->bind(":item_id", $item_id);
        return $this->db->execute();
    }
}
