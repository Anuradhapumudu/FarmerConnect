<?php
class Help extends Controller {

    private $helpModel;

    public function __construct() {
        $this->helpModel = $this->model('M_Help');
    }

    // View page
    public function index() {
        $data = [
            'members' => $this->helpModel->getMembers(),
            'emergencyNumber' => $this->helpModel->getEmergencyContact()
        ];

        $this->view('help/V_helpAdmin', $data);
    }

    // Add support member
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $result = $this->helpModel->addMember($_POST['id'], $_POST['type']);

            if (!$result) {
                die('Failed to add member');
            }

            header("Location: " . URLROOT . "/help/index");
            exit;
        }
    }

    // Remove support member
    public function delete($id, $type) {
        $this->helpModel->removeMember($id, $type);
        header("Location: " . URLROOT . "/help/index");
        exit;
    }

    // Edit support member
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'type' => $_POST['type'],
                'image' => $_POST['existing_image']
            ];

            if (!empty($_FILES['profile_image']['name'])) {
                $imageName = uniqid() . '_' . $_FILES['profile_image']['name'];
                $path = 'uploads/help/' . $imageName;
                move_uploaded_file($_FILES['profile_image']['tmp_name'], $path);
                $data['image'] = $path;
            }

            $this->helpModel->editMember($data);
            header("Location: " . URLROOT . "/help/index");
            exit;
        }
    }

    // Update emergency number
    public function updateEmergency() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->helpModel->updateEmergencyContact($_POST['phone']);
            header("Location: " . URLROOT . "/help/index");
            exit;
        }
    }
}
