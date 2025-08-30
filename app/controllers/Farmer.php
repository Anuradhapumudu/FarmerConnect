<?php
    class Farmer extends Controller {
        protected $farmerModel;
        protected $diseaseModel;
        protected $userModel;

        public function __construct() {
            // Don't load model in constructor to avoid loading issues
        }

        public function farmer() {
            $this->view('farmer/home');
        }

        public function index() {
            $this->view('farmer/home');
        }

        public function disease() {
            $this->view('farmer/disease');
        }

        public function submitDiseaseReport() {
            // Check if form was submitted via POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST data
                $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

                // Collect form data
                $data = [
                    'report_id' => trim($_POST['report_id']),
                    'farmerNIC' => trim($_POST['farmerNIC']),
                    'plrNumber' => trim($_POST['plrNumber']),
                    'date' => trim($_POST['date']),
                    'submission_timestamp' => trim($_POST['submission_timestamp']),
                    'title' => trim($_POST['title']),
                    'description' => trim($_POST['description']),
                    'severity' => trim($_POST['severity']),
                    'affectedArea' => trim($_POST['affectedArea']),
                    'terms' => isset($_POST['terms']) ? 1 : 0,
                    
                    // Error fields
                    'farmerNIC_error' => '',
                    'plrNumber_error' => '',
                    'date_error' => '',
                    'title_error' => '',
                    'description_error' => '',
                    'severity_error' => '',
                    'affectedArea_error' => '',
                    'terms_error' => ''
                ];

                // Validate form data
                if (empty($data['farmerNIC'])) {
                    $data['farmerNIC_error'] = 'Please enter your NIC number';
                }

                if (empty($data['plrNumber'])) {
                    $data['plrNumber_error'] = 'Please enter your PLR number';
                }

                if (empty($data['date'])) {
                    $data['date_error'] = 'Please select the date of observation';
                }

                if (empty($data['title'])) {
                    $data['title_error'] = 'Please enter a report title';
                }

                if (empty($data['description'])) {
                    $data['description_error'] = 'Please provide a detailed description';
                }

                if (empty($data['severity'])) {
                    $data['severity_error'] = 'Please select severity level';
                }

                if (empty($data['affectedArea'])) {
                    $data['affectedArea_error'] = 'Please enter the affected area';
                }

                if (!$data['terms']) {
                    $data['terms_error'] = 'You must agree to the terms and conditions';
                }

                // Handle file upload
                $uploadedFiles = [];
                if (isset($_FILES['media']) && $_FILES['media']['error'][0] !== UPLOAD_ERR_NO_FILE) {
                    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/FarmerConnect/public/uploads/disease_reports/';
                    
                    // Create directory if it doesn't exist
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    foreach ($_FILES['media']['tmp_name'] as $key => $tmpName) {
                        if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                            $fileName = $data['report_id'] . '_' . $key . '_' . $_FILES['media']['name'][$key];
                            $filePath = $uploadPath . $fileName;
                            
                            if (move_uploaded_file($tmpName, $filePath)) {
                                $uploadedFiles[] = $fileName;
                            }
                        }
                    }
                }

                // Check if there are no validation errors
                if (empty($data['farmerNIC_error']) && empty($data['plrNumber_error']) && 
                    empty($data['date_error']) && empty($data['title_error']) && 
                    empty($data['description_error']) && empty($data['severity_error']) && 
                    empty($data['affectedArea_error']) && empty($data['terms_error'])) {
                    
                    // Prepare data for database insertion
                    $reportData = [
                        'report_id' => $data['report_id'],
                        'farmer_nic' => $data['farmerNIC'],
                        'plr_number' => $data['plrNumber'],
                        'observation_date' => $data['date'],
                        'submission_timestamp' => !empty($data['submission_timestamp']) ? $data['submission_timestamp'] : date('Y-m-d H:i:s'),
                        'title' => $data['title'],
                        'description' => $data['description'],
                        'severity' => $data['severity'],
                        'affected_area' => $data['affectedArea'],
                        'media_files' => implode(',', $uploadedFiles),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Load the disease report model
                    $this->diseaseModel = $this->model('diseasereport');
                    
                    // Save to database
                    if ($this->diseaseModel->create($reportData)) {
                        // Success - redirect to success page
                        header('Location: ' . URLROOT . '/farmer/reportSuccess');
                        exit();
                    } else {
                        // Database error
                        die('Something went wrong while saving the report');
                    }
                } else {
                    // Validation errors - return JSON response for AJAX handling
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'errors' => $data
                    ]);
                    exit();
                }
            } else {
                // Not a POST request
                header('Location: ' . URLROOT . '/farmer');
                exit();
            }
        }

        public function reportSuccess() {
            $data = [
                'title' => 'Report Submitted Successfully',
                'message' => 'Your disease report has been submitted successfully. Thank you for helping protect our agricultural community.'
            ];
            $this->view('farmer/success', $data);
        }

        public function register() {
            // Logic for user registration
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // form submitting
                //validate the data
                $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

                //Input data
                $data = [
                    'FarmerNIC' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),

                    'name_error' => '',
                    'email_error' => '',
                    'username_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];

                //Validate each input
                //validate name
                if (empty($data['name'])) {
                    $data['name_error'] = 'Please enter name';
                }

                //validate email
                if (empty($data['email'])) {
                    $data['email_error'] = 'Please enter email';
                } else{
                    //check email is already registered or not
                    // Load user model
                    $this->userModel = $this->model('Users');
                    
                    if ($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_error'] = 'Email is already registered';
                    }
                }

                //validate the password
                if (empty($data['password'])) {
                    $data['password_error'] = 'Please enter password';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_error'] = 'Password must be at least 6 characters';
                } elseif (!preg_match('/[A-Z]/', $data['password'])) {
                    $data['password_error'] = 'Password must contain at least one uppercase letter';
                } elseif (!preg_match('/[a-z]/', $data['password'])) {
                    $data['password_error'] = 'Password must contain at least one lowercase letter';
                } elseif (!preg_match('/[0-9]/', $data['password'])) {
                    $data['password_error'] = 'Password must contain at least one number';
                } elseif (!preg_match('/[\W_]/', $data['password'])) {
                    $data['password_error'] = 'Password must contain at least one special character';
                }

                //validate confirm password
                if (empty($data['confirm_password'])) {
                    $data['confirm_password_error'] = 'Please confirm password';
                } elseif ($data['confirm_password'] !== $data['password']) {
                    $data['confirm_password_error'] = 'Passwords do not match';
                }

                // Check if there are any errors
                if (empty($data['name_error']) && empty($data['email_error']) && empty($data['username_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                    // No errors, proceed with registration
                    //Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    
                    // Load user model if not already loaded
                    if (!$this->userModel) {
                        $this->userModel = $this->model('Users');
                    }
                    
                    //Register the user
                    if ($this->userModel->register($data)) {
                        // Redirect to login page
                        header ('Location: ' . URLROOT . '/Login/success');
                    } else {
                        die('Something went wrong');
                    }
                    
                } else {
                    // Load the view with the data
                    $this->view('logreg/index', $data);
                }
            } else {
                $data = [
                    'FarmerNIC' => '',
                    'email' => '',
                    'username' => '',
                    'password' => '',
                    'confirm_password' => '',

                    'name_error' => '',
                    'email_error' => '',
                    'username_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];

                // Load the view with the data
                $this->view('logreg/index', $data);
            }
        }

    }
?>