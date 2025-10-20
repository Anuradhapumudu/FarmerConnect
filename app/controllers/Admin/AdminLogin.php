<?php
    class AdminLogin extends Controller {
        public function __construct() {
            $this->userModel = $this->model('M_Users');
        }
        public function index() {
            $this->login();
        }

        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Process login form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $formType = 'admin';
                $data = [
                        'form_type' => $formType,
                        'admin_id' => trim($_POST['admin_id']),
                        'password' => trim($_POST['password']),
                        'password_error' => '',
                        'admin_id_error' => ''
                    ];
                    // Validate admin inputs
                    if (empty($data['admin_id'])) {
                        $data['admin_id_error'] = 'Please enter your Admin ID';
                    } else if (!$this->userModel->findUserByAdminId($data['admin_id'], 'admins')){
                        $data['admin_id_error'] = 'No user found';
                    }
                    if (empty($data['password'])) {
                        $data['password_error'] = 'Please enter your password';
                    }
                $data['username'] = $data['admin_id'];
                if (empty($data['admin_id_error']) && empty($data['password_error'])) {
                    $loggedUser = $this->userModel->login($formType ,$data['username'], $data['password']);
                    if ($loggedUser) {
                        // Create session,
                        $this->createUserSession($loggedUser, $formType);
                    } else {
                        $data['password_error'] = 'Password incorrect';
                        // Load the view with errors
                        $this->view('admin/v_adminLogin', $data);
                    }
                } else {
                    // Load the view with errors
                    $this->view('admin/v_adminLogin', $data);
                }
            } else {
                $data = [
                    'admin_id' => '',
                    'password' => '',
                    'admin_id_error' => '',
                    'password_error' => ''
                ];
                $this->view('admin/v_adminLogin', $data);
            }
        }
            public function createUserSession($user, $formType) {
                $_SESSION['user_type'] = $formType;
                $_SESSION['admin_id'] = $user->admin_id;
                $_SESSION['user_id'] = $user->admin_id;
                header('Location: ' . URLROOT . '/AdminDashboard');
            }
            public function logout() {
                $_SESSION = [];
                session_destroy();
                header('Location: ' . URLROOT . '/admin/V_adminLogin');
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