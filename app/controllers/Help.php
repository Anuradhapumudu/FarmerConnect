<?php
class Help extends Controller {

    private $helpModel;

    public function __construct() {
        $this->helpModel = $this->model('M_Help');
    }

    // Show Help Admin Page
    public function index() {
        $members = $this->helpModel->getMembers();
        $data = [
            'members' => $members
        ];
        $this->view('help/V_helpAdmin', $data);
    }

    // Add a member
    public function add() {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $id = $_POST['id'];
        $type = $_POST['type'];

        if($type === 'officer') {
            $this->helpModel->addOfficer($id);
        } else {
            $this->helpModel->addAdmin($id);
        }

        header("Location: " . URLROOT . "/help/index");
        exit;
    }
}


    // Delete a member
public function delete($id, $type) {
    if($type === 'Officer') {
        $this->helpModel->removeOfficer($id);
    } else {
        $this->helpModel->removeAdmin($id);
    }

    header("Location: " . URLROOT . "/help/index");
    exit;
}


    // Edit member phone or role
    public function edit($officer_id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'officer_id' => $officer_id,
                'phone' => $_POST['phone'] ?? '',
                'role' => $_POST['role'] ?? ''
            ];

            if($this->helpModel->editMember($data)) {
                header("Location: " . URLROOT . "/help/index");
                exit;
            } else {
                die('Something went wrong');
            }
        }
    }
}
?>
