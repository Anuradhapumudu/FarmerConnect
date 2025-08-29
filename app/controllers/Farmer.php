<?php
class Farmer extends Controller {
    protected $farmerModel;

    public function __construct() {
        // Don't load model in constructor to avoid loading issues
    }

    public function farmer() {
        $this->view('farmer/home');
    }

    public function index() {
        $this->view('farmer/home');
    }

    public function test() {
        echo "Disease controller is working!<br>";
        
        // Test database connection step by step
        echo "Testing database connection...<br>";
        
        try {
            // Test basic database connection
            $db = new Database();
            echo "Database class instantiated successfully!<br>";
            
            // Test a simple query
            $db->query("SELECT 1 as test");
            $result = $db->single();
            
            if ($result && $result->test == 1) {
                echo "Database connection working!<br>";
                
                // Now test if our table exists
                $db->query("SHOW TABLES LIKE 'disease_reports'");
                $tableResult = $db->single();
                
                if ($tableResult) {
                    echo "disease_reports table exists!<br>";
                    
                    // Test table structure
                    $db->query("DESCRIBE disease_reports");
                    $columns = $db->resultSet();
                    echo "Table has " . count($columns) . " columns<br>";
                } else {
                    echo "<strong>ERROR: disease_reports table does NOT exist!</strong><br>";
                    echo "You need to create the table in phpMyAdmin first.<br>";
                }
            } else {
                echo "<strong>ERROR: Database query failed!</strong><br>";
            }
            
        } catch (Exception $e) {
            echo "<strong>ERROR: " . $e->getMessage() . "</strong><br>";
        }
        
        die();
    }
    
    public function debug() {
        echo "Debug information:<br><br>";
        echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
        echo "POST data: " . print_r($_POST, true) . "<br>";
        echo "GET data: " . print_r($_GET, true) . "<br>";
        echo "Current URL: " . $_SERVER['REQUEST_URI'] . "<br>";
        die();
    }

    public function submitReport() {
        error_log("=== SUBMIT REPORT START ===");
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            error_log("POST request detected");
            error_log("POST data received: " . print_r($_POST, true));
            
            // Step 1: Validate required fields
            $errors = [];
            $requiredFields = ['farmerNIC', 'plrNumber', 'date', 'title', 'description', 'severity', 'affectedArea'];
            
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = ucfirst($field) . ' is required.';
                    error_log("Validation error for field: " . $field);
                }
            }
            
            // If validation fails, return to form with errors
            if (!empty($errors)) {
                error_log("Validation failed with errors: " . print_r($errors, true));
                $this->view('disease/report', [
                    'errors' => $errors, 
                    'data' => $_POST
                ]);
                return;
            }
            
            error_log("Validation passed");
            
            // Step 2: Generate report ID
            $reportId = $this->generateReportId();
            error_log("Generated report ID: " . $reportId);
            
            // Step 3: Prepare data for database
            $reportData = [
                'report_id' => $reportId,
                'farmer_nic' => trim($_POST['farmerNIC']),
                'plr_number' => trim($_POST['plrNumber']),
                'observation_date' => trim($_POST['date']),
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'severity' => trim($_POST['severity']),
                'affected_area' => floatval($_POST['affectedArea'])
            ];
            
            error_log("Prepared data for database: " . print_r($reportData, true));
            
            // Step 4: Save to database
            try {
                error_log("Loading Disease model...");
                $diseaseModel = $this->model('Disease');
                error_log("Disease model loaded successfully");
                
                error_log("Calling addReport method...");
                $result = $diseaseModel->addReport($reportData);
                error_log("addReport returned: " . ($result ? 'TRUE' : 'FALSE'));
                
                if ($result) {
                    error_log("SUCCESS: Data saved to database");
                    // Success - show success page
                    $this->view('disease/success', ['report_id' => $reportId]);
                } else {
                    error_log("ERROR: addReport returned false");
                    // Database error - show error on form
                    $errors = ['general' => 'Failed to save report. Please try again.'];
                    $this->view('disease/report', [
                        'errors' => $errors, 
                        'data' => $_POST
                    ]);
                }
                
            } catch (Exception $e) {
                error_log("EXCEPTION in submitReport: " . $e->getMessage());
                error_log("Exception trace: " . $e->getTraceAsString());
                // Exception occurred - show error on form
                $errors = ['general' => 'Database error: ' . $e->getMessage()];
                $this->view('disease/report', [
                    'errors' => $errors, 
                    'data' => $_POST
                ]);
            }
            
        } else {
            error_log("GET request - showing form");
            // GET request - show the report form
            $this->view('disease/report');
        }
        
        error_log("=== SUBMIT REPORT END ===");
    }
    
    private function generateReportId() {
        // Generate a unique report ID with format DR-YYYYMMDD-XXXXX
        $date = date('Ymd');
        $random = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        return "DR-{$date}-{$random}";
    }
}
?>