<?php
    class Login extends Controller {
        protected $userModel;

        public function __construct() {
            $this->userModel = $this->model('Users');
        }

        public function index() {
            $this->view('logreg/index');
        }

        public function authenticate() {
            // Logic for user authentication
        }

        public function success() {
            $this->view('farmer/success');
        }

        public function register() {
            // Logic for user registration
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // form submitting
                //validate the data
                $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

                //Input data
                $data = [
                    'name' => trim($_POST['name']),
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

                $data = [
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