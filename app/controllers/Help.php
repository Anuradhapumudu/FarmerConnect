<?php
class Help extends Controller {

    private $helpModel;

    public function __construct() {

        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

                // Check if logged-in and correct user type
        if (!isset($_SESSION['user_type'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

            // For admin, make sure they are redirected to admin login if session invalid
        if ($_SESSION['user_type'] === 'admin' && !isset($_SESSION['user_id'])) {
        header('Location: ' . URLROOT . '/admin/adminlogin');
        exit;
        }

        $this->helpModel = $this->model('M_Help');
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
        $data = [
            'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
        ];

        $this->view('help/V_helpAdmin', $data);
    }

    
    public function helpOfficer() {
         $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];

        $this->view('help/V_helpOfficer', $data);
    }

    
    public function helpSeller() {

        $seller_id = $_SESSION['user_id'];

         $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];
         

        $this->view('help/V_helpSeller', $data);
    }

    
    public function helpFarmer() {

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

        // 1️⃣ Check if user exists
        if (!$this->helpModel->userExists($id, $type)) {
            $errors[] = "Invalid Member ID. No such $type exists.";
        }

        // 2️⃣ Check if already added
        if ($this->helpModel->isAlreadyHelpMember($id)) {
            $errors[] = "This member is already in the Help Center.";
        }

        // ❌ If errors → reload page with alert
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

        // ✅ Insert if everything is valid
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
            $this->helpModel->updateEmergencyContact($_POST['phone']);
            header("Location: " . URLROOT . "/help/helpAdmin");
            exit;
        }
    }
}
