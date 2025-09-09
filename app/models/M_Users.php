<?php
    class M_Users {
        private $db;

        /*public function __construct() {
            $this->db = new Database;
        }

        // Register user
        public function register($data) {
            $this->db->query("INSERT INTO users (first_name, last_name, nic, email, password) VALUES (:first_name, :last_name, :nic, :email, :password)");
            // Bind values
            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':last_name', $data['last_name']); 
            $this->db->bind(':nic', $data['nic']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public function findUserByEmail($email) {
            $this->db->query("SELECT * FROM users WHERE email = :email");
            $this->db->bind(':email', $email);
            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }*/
    }