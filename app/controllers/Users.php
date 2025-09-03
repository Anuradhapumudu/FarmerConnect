<?php
    class Users  extends Controller {
        public function __construct() {
            $this->userModel = $this->model('M_Users');
        }
        // Registration logic here
        public function register() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Form is submitting
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Determine which form was submitted
                $formType = 'farmer';
                if (isset($_POST['officer_id'])) {
                    $formType = 'officer';
                } elseif (isset($_POST['brn'])) {
                    $formType = 'seller';
                } elseif (isset($_POST['admin_id'])) {
                    $formType = 'admin';
                }

                // Input data
                if ($formType === 'farmer') { // Farmer
                    $data = [
                    'form_type' => $formType,
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'nic' => trim($_POST['nic']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'officer_id' => '',
                    'brn' => '',
                    

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'officer_id_error' => '',
                    'brn_error' => '',
                    ];
                    // Validate farmer inputs
                    if (empty($data['first_name'])) {
                        $data['first_name_error'] = 'Please enter your first name';
                    }
                    if (empty($data['last_name'])) {
                        $data['last_name_error'] = 'Please enter your last name';
                    }
                    if (empty($data['nic'])) {
                        $data['nic_error'] = 'Please enter your NIC';
                    } else {
                        // Old format: 9 digits + V/X (total 10 chars)
                        // New format: 12 digits (total 12 chars)
                        $nic = $data['nic'];
                        if (!preg_match('/^(\d{9}[VXvx]|\d{12})$/', $nic)) {
                            $data['nic_error'] = 'NIC format is invalid';
                        }
                    }
                    if (empty($data['email'])) {
                        $data['email_error'] = 'Please enter your email';
                    } else {
                        if ($this->userModel->findUserByEmail($data['email'])) {
                            $data['email_error'] = 'Email is already taken';
                        }
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                    if ($data['password'] !== $data['confirm_password']) {
                        $data['confirm_password_error'] = 'Passwords do not match';
                    }
                } elseif ($formType === 'officer') { // Officer
                    $data = [
                    'form_type' => $formType,
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'nic' => trim($_POST['nic']),
                    'email' => trim($_POST['email']),
                    'officer_id' => trim($_POST['officer_id']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'brn' => '',

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'officer_id_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'brn_error' => ''
                    ];
                    // Validate officer inputs
                    if (empty($data['first_name'])) {
                        $data['first_name_error'] = 'Please enter your first name';
                    }
                    if (empty($data['last_name'])) {
                        $data['last_name_error'] = 'Please enter your last name';
                    }
                    if (empty($data['nic'])) {
                        $data['nic_error'] = 'Please enter your NIC';
                    }
                    if (empty($data['email'])) {
                        $data['email_error'] = 'Please enter your email';
                    } else {
                        if ($this->userModel->findUserByEmail($data['email'])) {
                            $data['email_error'] = 'Email is already taken';
                        }
                    }
                    if (empty($data['officer_id'])) {
                        $data['officer_id_error'] = 'Please enter your Officer ID';
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                    if ($data['password'] !== $data['confirm_password']) {
                        $data['confirm_password_error'] = 'Passwords do not match';
                    }
                } else { // Seller
                    $data = [
                    'form_type' => $formType,
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'nic' => trim($_POST['nic']),
                    'email' => trim($_POST['email']),
                    'brn' => trim($_POST['brn']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'officer_id' => '',

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'brn_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'officer_id_error' => '',
                    ];
                    // Validate seller inputs
                    if (empty($data['first_name'])) {
                        $data['first_name_error'] = 'Please enter your first name';
                    }
                    if (empty($data['last_name'])) {
                        $data['last_name_error'] = 'Please enter your last name';
                    }
                    if (empty($data['nic'])) {
                        $data['nic_error'] = 'Please enter your NIC';
                    }
                    if (empty($data['email'])) {
                        $data['email_error'] = 'Please enter your email';
                    } else {
                        if ($this->userModel->findUserByEmail($data['email'])) {
                            $data['email_error'] = 'Email is already taken';
                        }
                    }
                    if (empty($data['brn'])) {
                        $data['brn_error'] = 'Please enter your Business Registration Number (BRN)';
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                    if ($data['password'] !== $data['confirm_password']) {
                        $data['confirm_password_error'] = 'Passwords do not match';
                    }
            }
                // validation is completed and then register the user
                if (empty($data['first_name_error']) && empty($data['last_name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    // Set ApprovalStatus according to user type
                    if ($data['form_type'] === 'seller') {
                        $data['approval_status'] = 'Pending';
                    } else {
                        $data['approval_status'] = NULL;
                    }

                    // Register user
                    if ($this->userModel->register($data)) {
                        // Redirect to the login page
                        echo "
                            <div style='
                                text-align: center; 
                                margin-top: 50px; 
                                font-family: Arial, sans-serif; 
                                font-size: 20px; 
                                color: green;'>
                                Registration successful! 🎉 <br>
                                Redirecting to login page in 5 seconds...
                            </div>
                            <script>
                                setTimeout(function(){
                                    window.location.href = '" . URLROOT . "/users/login';
                                }, 5000);
                            </script>
                        ";
                    exit;
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load the view with errors
                    $this->view('users/v_register', $data);
                }

            } else {
                // Initial form
                $data = [
                    'form_type' => 'farmer', // Default form type
                    'first_name' => '',
                    'last_name' => '',
                    'nic' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'officer_id' => '',
                    'brn' => '',

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'officer_id_error' => '',
                    'brn_error' => ''
                ];
                // Load the view with the initial data
                $this->view('users/v_register', $data);
            }
        }

        // Login logic here
        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Process login form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Determine which form was submitted
                if (isset($_POST['officer_id'])) {
                    $formType = 'officer';
                } elseif (isset($_POST['seller_id'])) {
                    $formType = 'seller';
                } elseif (isset($_POST['admin_id'])) {
                    $formType = 'admin';
                } else {
                    $formType = 'farmer';
                }

                // Input data
                if ($formType === 'farmer') { // Farmer
                    $data = [
                        'form_type' => $formType,
                        'nic' => trim($_POST['nic']),
                        'password' => trim($_POST['password']),
                        'officer_id' => '',
                        'seller_id' => '',
                        'admin_id' => '',
                        'farmer_nic_error' => '',
                        'password_error' => '',
                        'officer_id_error' => '',
                        'seller_id_error' => '',
                        'admin_id_error' => ''
                    ];
                    // Validate farmer inputs
                    if (empty($data['nic'])) {
                        $data['farmer_nic_error'] = 'Please enter your NIC';
                    } else {
                        if (!$this->userModel->findUserByNic($data['nic'])) {
                            $data['farmer_nic_error'] = 'No user found';
                        }
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                } elseif ($formType === 'officer') { // Officer
                    $data = [
                        'form_type' => $formType,
                        'officer_id' => trim($_POST['officer_id']),
                        'password' => trim($_POST['password']),
                        'nic' => '',
                        'seller_id' => '',
                        'admin_id' => '',
                        'farmer_nic_error' => '',
                        'password_error' => '',
                        'officer_id_error' => '',
                        'seller_id_error' => '',
                        'admin_id_error' => ''
                    ];
                    // Validate officer inputs
                    if (empty($data['officer_id'])) {
                        $data['officer_id_error'] = 'Please enter your Officer ID';
                    } else {
                        if (!$this->userModel->findUserByOfficer_id($data['officer_id'])) {
                            $data['officer_id_error'] = 'No user found';
                        }
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                } elseif ($formType === 'seller') { // Seller
                    $data = [
                        'form_type' => $formType,
                        'seller_id' => trim($_POST['seller_id']),
                        'password' => trim($_POST['password']),
                        'nic' => '',
                        'officer_id' => '',
                        'admin_id' => '',
                        'farmer_nic_error' => '',
                        'password_error' => '',
                        'officer_id_error' => '',
                        'seller_id_error' => '',
                        'admin_id_error' => ''
                    ];
                    // Validate seller inputs
                    if (empty($data['seller_id'])) {
                        $data['seller_id_error'] = 'Please enter your Seller ID';
                    } else {
                        if (!$this->userModel->findUserBySellerId($data['seller_id'])) {
                            $data['seller_id_error'] = 'No user found';
                        }
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                } else { // Admin
                    $data = [
                        'form_type' => $formType,
                        'admin_id' => trim($_POST['admin_id']),
                        'password' => trim($_POST['password']),
                        'nic' => '',
                        'officer_id' => '',
                        'seller_id' => '',
                        'farmer_nic_error' => '',
                        'password_error' => '',
                        'officer_id_error' => '',
                        'seller_id_error' => '',
                        'admin_id_error' => ''
                    ];
                    // Validate admin ID
                    if (empty($data['admin_id'])) {
                        $data['admin_id_error'] = 'Please enter your Admin ID';
                    } else {
                        if (!$this->userModel->findUserByAdminId($data['admin_id'])) {
                            $data['admin_id_error'] = 'No user found';
                        }
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                }

                // Check for user
                switch ($formType) {
                    case 'farmer':
                        $data['username'] = $data['nic'];
                        if (empty($data['farmer_nic_error']) && empty($data['password_error'])) {
                            $loggedUser = $this->userModel->login($formType ,$data['username'], $data['password']);
                            if ($loggedUser) {
                                // Create session,
                                $this->createUserSession($loggedUser, $formType);
                            } else {
                                $data['password_error'] = 'Password incorrect';
                                // Load the view with errors
                                $this->view('users/v_login', $data);
                            }
                        } else {
                            // Load the view with errors
                            $this->view('users/v_login', $data);
                        }
                        break;
                    case 'officer':
                        $data['username'] = $data['officer_id'];
                        if (empty($data['officer_id_error']) && empty($data['password_error'])) {
                            $loggedUser = $this->userModel->login($formType ,$data['username'], $data['password']);
                            if ($loggedUser) {
                                // Create session,
                                $this->createUserSession($loggedUser, $formType);
                            } else {
                                $data['password_error'] = 'Password incorrect';
                                // Load the view with errors
                                $this->view('users/v_login', $data);
                            }
                        } else {
                            // Load the view with errors
                            $this->view('users/v_login', $data);
                        }
                        break;
                    case 'seller':
                        $data['username'] = $data['seller_id'];
                        if (empty($data['seller_id_error']) && empty($data['password_error'])) {
                            $loggedUser = $this->userModel->login($formType ,$data['username'], $data['password']);
                            if ($loggedUser) {
                                if ($loggedUser->approval_status !== 'Approved') {
                                    $data['seller_id_error'] = 'Your account is not approved yet.';
                                    $this->view('users/v_login', $data);
                                    return;
                                } else {
                                    // Create session,
                                    $this->createUserSession($loggedUser, $formType);
                                }
                            } else {
                                $data['password_error'] = 'Password incorrect';
                                // Load the view with errors
                                $this->view('users/v_login', $data);
                            }
                        } else {
                            // Load the view with errors
                            $this->view('users/v_login', $data);
                        }
                        break;
                    case 'admin':
                        $data['username'] = $data['admin_id'];
                        if (empty($data['admin_id_error']) && empty($data['password_error'])) {
                            $loggedUser = $this->userModel->login($formType ,$data['username'], $data['password']);
                            if ($loggedUser) {
                                // Create session,
                                $this->createUserSession($loggedUser, $formType);
                            } else {
                                $data['password_error'] = 'Password incorrect';
                                // Load the view with errors
                                $this->view('users/v_login', $data);
                            }
                        } else {
                            // Load the view with errors
                            $this->view('users/v_login', $data);
                        }
                        break;
                }
            } else {
                // Initial form
                $data = [
                    'form_type' => 'farmer', // Default form type
                    'nic' => '',
                    'officer_id' => '',
                    'seller_id' => '',
                    'admin_id' => '',
                    'password' => '',
                    'farmer_nic_error' => '',
                    'officer_id_error' => '',
                    'seller_id_error' => '',
                    'admin_id_error' => '',
                    'password_error' => ''
                ];
                // Load the view with the initial data
                $this->view('users/v_login', $data);
            }
        }

        // user session creation
        public function createUserSession($user, $formType) {
            $_SESSION['user_type'] = $formType;
            switch ($formType) {
                case 'farmer':
                    $_SESSION['nic'] = $user->nic;
                    break;
                case 'officer':
                    $_SESSION['officer_id'] = $user->officer_id;
                    break;
                case 'seller':
                    $_SESSION['seller_id'] = $user->seller_id;
                    break;
                case 'admin':
                    $_SESSION['admin_id'] = $user->admin_id;
                    break;
                default:
                    break;
            }
            $this->view('officer/v_create_announcements', $data);
            die('Success');
        }

        public function logout() {
            $_SESSION = [];
            session_destroy();
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        public function isLoggedIn() {
            if(isset($_SESSION['user_type'])) {
                return true;
            }
            return false;
        }
    }
?>