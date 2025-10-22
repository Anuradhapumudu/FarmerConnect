<?php

class CreateAnnouncements extends Controller{

    public function __construct() {
        $this->announcementModel = $this->model('M_Announcements/M_Announcements');
        if (!isset($_SESSION['user_type']) || 
            !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
    }
    public function index() {
        $data = [
            'title' => '',
            'category' => '',
            'content' => '',
            'attachFiles' => '',
            'attachment_path' => ''  
        ];
        $this->loadViewByRole('create_announcements', $data);
    }
    // Function to load the correct view based on user role
    private function loadViewByRole($baseViewName, $data) {
        if ($_SESSION['user_type'] === 'admin') {
            $this->view('announcements/v_admin_' . $baseViewName, $data);
        } else {
            $this->view('announcements/v_officer_' . $baseViewName, $data);
        }
    }
    public function create(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'category' => trim($_POST['category']),
                'content' => trim($_POST['content']),
                'attachFiles' => '',
                'attachment_path' => '' 
            ];

            // Handle file upload
            if(isset($_FILES['attachFiles']) && $_FILES['attachFiles']['error'][0] != 4) { // 4 = no file
                $uploadDir = 'uploads/'; // folder to save files
                $uploadedFiles = [];

                foreach($_FILES['attachFiles']['tmp_name'] as $key => $tmpName) {
                    $filename = basename($_FILES['attachFiles']['name'][$key]);
                    $targetFile = $uploadDir . time() . '_' . $filename; // unique filename
                    if(move_uploaded_file($tmpName, $targetFile)) {
                        $uploadedFiles[] = $targetFile;
                    }
                }

                // Join multiple files into a comma-separated string
                $data['attachment_path'] = implode(',', $uploadedFiles);
            }

            // Validate and create announcement
            if(!empty($data['title']) && !empty($data['category']) && !empty($data['content'])) {
                if($this->announcementModel->createAnnouncement($data)) {
                    // Redirect or show success message
                    $this->loadViewByRole('announcement_success', $data);
                } else {
                    // Show error message
                    die('Something went wrong. Please try again.');
                }
            }
        } else {
            // Show form
            $data = [
                'title' => '',
                'category' => '',
                'content' => '',
                'attachFiles' => '',
                'attachment_path' => ''  
            ];
            $this->loadViewByRole('create_announcements', $data);
        }
    }
}


?>