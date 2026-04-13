<?php
class Help extends Controller {

    private $helpModel;

    public function __construct() {

         Auth::check();

        $this->helpModel = $this->model('M_Help', new Database());
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

      Auth::checkAdmin();
    
        $data = [
            'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
        ];

        $this->view('help/V_helpAdmin', $data);
    }

    
    public function helpOfficer() {
                 Auth::checkRole('officer');

         $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];

        $this->view('help/V_helpOfficer', $data);
    }

    
    public function helpSeller() {
         Auth::checkRole('seller');

        $seller_id = $_SESSION['user_id'];

         $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];
         

        $this->view('help/V_helpSeller', $data);
    }

    
    public function helpFarmer() {

        Auth::checkRole('farmer');

          $data = [
             'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
         ];

        $this->view('help/V_helpFarmer', $data);
    }


    // Add support member
public function add() {

    Auth::checkAdmin();

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

        Auth::checkAdmin();

        $this->helpModel->removeMember($id);
        header("Location: " . URLROOT . "/help/helpAdmin");
        exit;
    }


    // Update emergency number
    public function updateEmergency() {

        Auth::checkAdmin();

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
