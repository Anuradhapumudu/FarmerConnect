<?php
    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh; //Database handler
        private $stmt; //Statement
        private $error;
        
        public function __construct() {
            //Set DSN
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            //Create PDO instance
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            }
            catch(PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        //Prepared statement
        public function query($sql) {
            $this->stmt = $this->dbh->prepare($sql);
        }

        //Bind the parameters
        public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        //Execute the prepared statement
        public function execute() {
            error_log("=== DATABASE EXECUTE START ===");
            try {
                $result = $this->stmt->execute();
                error_log("PDO execute() returned: " . ($result ? 'TRUE' : 'FALSE'));
                
                if (!$result) {
                    $errorInfo = $this->stmt->errorInfo();
                    error_log("PDO Error Info: " . print_r($errorInfo, true));
                }
                
                error_log("=== DATABASE EXECUTE END ===");
                return $result;
            } catch (Exception $e) {
                error_log("EXCEPTION in Database execute: " . $e->getMessage());
                throw $e;
            }
        }

        //Get multiple records as the result
        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //Get single record as a single result
        public function single() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        //Get row count
        public function rowCount() {
            return $this->stmt->rowCount();
        }

        //Get last insert ID
        public function lastInsertId() {
            return $this->dbh->lastInsertId();
        }
    }
?>