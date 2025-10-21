<?php
    class M_Users {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }
        
        // Register user (into registrations table)
        public function register($data) {
            switch($data['form_type']) {
                case 'farmer':
                    // Insert to registrations table
                    $this->db->query("INSERT INTO registrations (user_type, password)
                        VALUES (:user_type, :password)
                    ");
                    $this->db->bind(':user_type', $data['form_type']);   
                    $this->db->bind(':password', $data['password']);            
                    $this->db->execute();
                    $registration_id = $this->db->lastInsertId();
                    // Insert to farmers table
                    // Combine first name and last name into full_name
                    $full_name = trim($data['first_name'] . ' ' . $data['last_name']);

                    $this->db->query("INSERT INTO farmers
                        (nic, full_name, phone_no, registration_id, password)
                        VALUES (:nic, :full_name, :phone_no, :registration_id, :password)
                    ");
                    $this->db->bind(':nic', $data['nic']);
                    $this->db->bind(':full_name', $full_name);
                    $this->db->bind(':phone_no', $data['phone_no']);
                    $this->db->bind(':registration_id', $registration_id);
                    $this->db->bind(':password', $data['password']);
                    $this->db->execute();
                    return true;
                    break;
                case 'officer':
                    // Insert to registrations table
                    $this->db->query("INSERT INTO registrations (user_type, password)
                        VALUES (:user_type, :password)
                    ");
                    $this->db->bind(':user_type', $data['form_type']);   
                    $this->db->bind(':password', $data['password']);            
                    $this->db->execute();
                    $registration_id = $this->db->lastInsertId();
                    // Update officers table
                    $this->db->query("UPDATE officers
                        SET first_name = :first_name, last_name = :last_name, email = :email, nic = :nic, phone_no = :phone_no, registration_id = :registration_id, password = :password
                        WHERE officer_id = :officer_id
                    ");
                    $this->db->bind(':first_name', $data['first_name']);
                    $this->db->bind(':last_name', $data['last_name']);
                    $this->db->bind(':email', $data['email']);
                    $this->db->bind(':nic', $data['nic']);
                    $this->db->bind(':phone_no', $data['phone_no']);
                    $this->db->bind(':registration_id', $registration_id);
                    $this->db->bind(':password', $data['password']);
                    $this->db->bind(':officer_id', $data['officer_id']);
                    $this->db->execute();
                    return true;
                    break;
                    case 'seller':
                        // Insert into registrations table with pending status
                        $this->db->query("INSERT INTO registrations
                            (user_type, password, approval_status)
                            VALUES (:user_type, :password, 'Pending')");
                        $this->db->bind(':user_type', $data['form_type']);
                        $this->db->bind(':password', $data['password']);
                        $this->db->execute();
                        $registration_id = $this->db->lastInsertId();

                        // Insert directly into sellers table
                        $this->db->query("INSERT INTO sellers
                            (registration_id, first_name, last_name, company_name, nic, brn, phone_no, email, address, password)
                            VALUES (:registration_id, :first_name, :last_name, :company_name, :nic, :brn, :phone_no, :email, :address, :password)
                        ");
                        $this->db->bind(':registration_id', $registration_id);
                        $this->db->bind(':first_name', $data['first_name']);
                        $this->db->bind(':last_name', $data['last_name']);
                        $this->db->bind(':company_name', $data['company_name']);
                        $this->db->bind(':nic', $data['nic']);
                        $this->db->bind(':brn', $data['brn']);
                        $this->db->bind(':phone_no', $data['phone_no']);
                        $this->db->bind(':email', $data['email']);
                        $this->db->bind(':address', $data['address']);
                        $this->db->bind(':password', $data['password']);
                        $this->db->execute();
                        return true;



                    break;

                default:
                    return false;
            }
        }

        // Login the user
        public function login($form_type, $username, $password) {
            // Choose table and column based on user type
            switch ($form_type) {
                case 'farmer':
                    $table = "farmers";
                    $idColumn = "nic";
                    $passwordColumn = "password";
                    break;
                case 'officer':
                    $table = "officers";
                    $idColumn = "officer_id";
                    $passwordColumn = "password";
                    break;
                case 'seller':
                    $table = "sellers";
                    $idColumn = "seller_id";
                    $passwordColumn = "password";
                    break;
                case 'admin':
                    $table = "admins";
                    $idColumn = "admin_id";
                    $passwordColumn = "password";
                    break;
                default:
                    return false;
            }
            $this->db->query("SELECT * FROM $table WHERE $idColumn = :username");
            $this->db->bind(':username', $username);

            $row = $this->db->single();

            if ($row) {
                // Verify password
                $hashed_password = $row->$passwordColumn;
                if (password_verify($password, $hashed_password)) {
                    return $row; // successful login
                }
            }
            return false; // invalid login
        }


        // Check if email already exists in registrations
        public function findUserByEmail($email, $table) {
            $this->db->query("SELECT * FROM $table WHERE email = :email");
            $this->db->bind(':email', $email);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }
        public function findUserByPhoneNo($phone_no, $table) {
            $this->db->query("SELECT * FROM $table WHERE phone_no = :phone_no");
            $this->db->bind(':phone_no', $phone_no);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if nic already exists in farmers
        public function findUserByNic($nic, $table) {
            $this->db->query("SELECT * FROM $table WHERE nic = :nic");
            $this->db->bind(':nic', $nic);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if officer ID already exists in registrations
        public function isOfficerAlreadyRegistered($officer_id) {
            $this->db->query("SELECT * FROM officers WHERE officer_id = :officer_id AND registration_id IS NOT NULL");
            $this->db->bind(':officer_id', $officer_id);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if seller ID already exists in registrations
        public function findUserBySellerId($seller_id, $table) {
            $this->db->query("SELECT * FROM $table WHERE seller_id = :seller_id");
            $this->db->bind(':seller_id', $seller_id);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if admin ID already exists in registrations
        public function findUserByAdminId($admin_id, $table) {
            $this->db->query("SELECT * FROM $table WHERE admin_id = :admin_id");
            $this->db->bind(':admin_id', $admin_id);
            $row = $this->db->single();

            return ($this->db->rowCount() > 0);
        }

        // Check if officer_id exists in officers table
        public function isOfficerIdValid($officer_id) {
            $this->db->query("SELECT * FROM officers WHERE officer_id = :officer_id");
            $this->db->bind(':officer_id', $officer_id);
            $this->db->single();
            return ($this->db->rowCount() > 0);
        }

        public function findSellerByBRN($brn) {
            $this->db->query("SELECT * FROM sellers WHERE brn = :brn");
            $this->db->bind(':brn', $brn);
            $this->db->single();
            return ($this->db->rowCount() > 0);
        }


    }
?>
