<?php
class Help extends Controller {

    private $helpModel;

        public function __construct() {

        $this->startSession();
        $this->checkAuth();

        $this->helpModel = $this->model('M_Help');
    }

    // Start session if not already started
    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

    }

    // Check authentication and user type
    private function checkAuth() {

        if (!isset($_SESSION['user_type'])) {
            $this->redirect('/users/login');
        }

        if ($_SESSION['user_type'] === 'admin' && !isset($_SESSION['user_id'])) {
            $this->redirect('/admin/adminlogin');
        }
    }

    // Redirect helper
    private function redirect($path) {
        header('Location: ' . URLROOT . $path);
        exit;
    }

        public function index() {
        switch($_SESSION['user_type']) {
            case 'farmer':
                $this->helpOfficer();
                break;
            case 'seller':
                $this->helpSeller();
                break;
            case 'admin':
                $this->helpAdmin();
                break;
            case 'officer':
                $this->helpOfficer();
                break;
            default:
                header('Location: ' . URLROOT . '/users/login');
                exit;
        }
    }

    // View page
    public function helpAdmin() {

    //checks again user is admin
    if ($_SESSION['user_type'] !== 'admin') {
        $this->redirect('/admin/adminlogin');
        exit;
    }
        $data = [
            'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
        ];

        $this->view('help/V_helpAdmin', $data);
    }

    
    public function helpOfficer() {

        if ($_SESSION['user_type'] !== 'officer') {
        $this->redirect('/users/login');
        exit;
    }
         $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];

        $this->view('help/V_helpOfficer', $data);
    }

    
    public function helpSeller() {

            if ($_SESSION['user_type'] !== 'seller') {
        $this->redirect('/users/login');
        exit;
    }

        $seller_id = $_SESSION['user_id'];

         $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];
         

        $this->view('help/V_helpSeller', $data);
    }

    
    public function helpFarmer() {


            if ($_SESSION['user_type'] !== 'farmer') {
        $this->redirect('/users/login');
        exit;
    }

          $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];

        $this->view('help/V_helpFarmer', $data);
    }


    // Add support member
public function add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $id   = trim($_POST['id']);
        $type = trim($_POST['type']);

        $errors = [];

        // Check if user exists
        if (!$this->helpModel->userExists($id, $type)) {
            $errors[] = "Invalid Member ID. No such $type exists.";
        } else if ($this->helpModel->isAlreadyHelpMember($id)) {
            $errors[] = "This member is already in the Help Center.";
        }

        //  If errors ,,reload page with alert
        if (!empty($errors)) {
            $data = [
                'members' => $this->helpModel->getMembers(),
                'emergencyNumber' => $this->helpModel->getEmergencyContact(),
                'form_errors' => [
                    'add_member' => $errors
                ],
                'form_data' => [
                    'id' => $id,
                    'type' => $type
                ]
            ];

            $this->view('help/V_helpAdmin', $data);
            return;
        }

        // Insert if everything is valid
        $this->helpModel->addMember($id, $type);

        header("Location: " . URLROOT . "/help/helpAdmin");
        exit;
    }
}


    // Remove support member
    public function delete($id) {
        $this->helpModel->removeMember($id);
        header("Location: " . URLROOT . "/help/helpAdmin");
        exit;
    }


    // Update emergency number
    public function updateEmergency() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $errors = [];
            $phone = trim($_POST['phone'] ?? '');

            // Check empty
            if (empty($phone)) {
                $errors[] = "Emergency contact number is required.";
            }
            // Check only digits
            elseif (!ctype_digit($phone)) {
                $errors[] = "Emergency contact number must contain only digits.";
            }
            // Check length = 10
            elseif (strlen($phone) !== 10) {
                $errors[] = "Emergency contact number must be exactly 10 digits.";
            }

            // If no errors ,,update
            if (empty($errors)) {
                $this->helpModel->updateEmergencyContact($phone);
                header("Location: " . URLROOT . "/help/helpAdmin");
                exit;
            }

            $data = [
                'members' => $this->helpModel->getMembers(),
                'emergencyNumber' => $this->helpModel->getEmergencyContact(),
                'form_errors' => [
                    'emergency' => $errors
                ],
                'form_data' => [
                    'emergency_phone' => $phone
                ]
            ];

            $this->view('help/V_helpAdmin', $data);
            return;


        }

    }
}
