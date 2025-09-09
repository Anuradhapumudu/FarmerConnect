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
                if (isset($_POST['officerID'])) {
                    $formType = 'officer';
                } elseif (isset($_POST['brn'])) {
                    $formType = 'seller';
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
                    'officerID' => '',
                    'brn' => '',

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'officerID_error' => '',
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
                    'officerID' => trim($_POST['officerID']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'brn' => '',

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'officerID_error' => '',
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
                    if (empty($data['officerID'])) {
                        $data['officerID_error'] = 'Please enter your Officer ID';
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
                    'officerID' => '',

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'brn_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'officerID_error' => '',
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
                    // Register user
                    if ($this->userModel->register($data)) {
                        // Redirect to the login page
                        die('User registered successfully');
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
                    'officerID' => '',
                    'brn' => '',

                    'first_name_error' => '',
                    'last_name_error' => '',
                    'nic_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'officerID_error' => '',
                    'brn_error' => ''
                ];
                // Load the view with the initial data
                $this->view('users/v_register', $data);
            }
        }
    }
?>