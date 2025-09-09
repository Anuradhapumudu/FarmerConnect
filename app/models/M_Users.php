<?php
    class M_Users {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }
        
        // Register user (into registrations table)
        public function register($data) {
            $this->db->query("INSERT INTO registrations 
                (user_type, first_name, last_name, nic, officer_id, brn, email, password, approval_status)
                VALUES
                (:user_type, :first_name, :last_name, :nic, :officer_id, :brn, :email, :password, :approval_status)
            ");

            // Bind values
            $this->db->bind(':user_type', $data['form_type']);   // farmer, officer, seller
            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':last_name', $data['last_name']);
            $this->db->bind(':nic', $data['nic']);
            $this->db->bind(':officer_id', !empty($data['officer_id']) ? $data['officer_id'] : null);
            $this->db->bind(':brn', !empty($data['brn']) ? $data['brn'] : null);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']); // already hashed in controller
            $this->db->bind(':approval_status', $data['approval_status']);

            // Execute
            return $this->db->execute();
        }

        // Login the user
        public function login($form_type, $username, $password) {
            // Choose table and column based on user type
            switch ($form_type) {
                case 'farmer':
                    $table = "registrations";
                    $idColumn = "nic";
                    break;
                case 'officer':
                    $table = "registrations";
                    $idColumn = "officer_id";
                    break;
                case 'seller':
                    $table = "sellers";
                    $idColumn = "seller_id";
                    break;
                case 'admin':
                    $table = "admins";
                    $idColumn = "admin_id";
                    break;
                default:
                    return false;
            }
            $this->db->query("SELECT * FROM $table WHERE $idColumn = :username");
            $this->db->bind(':username', $username);

            $row = $this->db->single();

            if ($row) {
                // Verify password
                $hashed_password = $row->password;
                if (password_verify($password, $hashed_password)) {
                    return $row; // successful login
                }
            }
            return false; // invalid login
        }


        // Check if email already exists in registrations
        public function findUserByEmail($email) {
            $this->db->query("SELECT * FROM registrations WHERE email = :email");
            $this->db->bind(':email', $email);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if nic already exists in registrations
        public function findUserByNic($nic) {
            $this->db->query("SELECT * FROM registrations WHERE nic = :nic");
            $this->db->bind(':nic', $nic);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if officer ID already exists in registrations
        public function findUserByOfficer_id($officer_id) {
            $this->db->query("SELECT * FROM registrations WHERE officer_id = :officer_id");
            $this->db->bind(':officer_id', $officer_id);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if seller ID already exists in registrations
        public function findUserBySellerId($seller_id) {
            $this->db->query("SELECT * FROM sellers WHERE seller_id = :seller_id");
            $this->db->bind(':seller_id', $seller_id);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if admin ID already exists in registrations
        public function findUserByAdminId($admin_id) {
            $this->db->query("SELECT * FROM admins WHERE admin_id = :admin_id");
            $this->db->bind(':admin_id', $admin_id);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }


    }