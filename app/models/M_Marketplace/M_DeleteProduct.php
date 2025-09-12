<?php

class M_DeleteProduct {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM products WHERE item_id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function getProductById($id) {
        $this->db->query('SELECT * FROM products WHERE item_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}

?>