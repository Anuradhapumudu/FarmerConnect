<?php
    class M_pages {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function getPages(){
            $this->db->query("SELECT * FROM pages");
            return $this->db->resultSet();
        }
    }
?>