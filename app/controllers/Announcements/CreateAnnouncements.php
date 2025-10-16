<?php

class CreateAnnouncements extends Controller{

    public function __construct() {
        $this->announcementModel = $this->model('M_Announcements/M_Announcements');
    }
    public function index() {
        $data = [
            'title' => '',
            'category' => '',
            'content' => '',
            'attachFiles' => '',
            'attachment_path' => ''  
        ];
        $this->view('announcements/v_create_announcements', $data);
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
                    echo "
                            <div style='
                                text-align: center; 
                                margin-top: 50px; 
                                font-family: Arial, sans-serif; 
                                font-size: 20px; 
                                color: green;'>
                                Announcement created successfully! <br>
                                Redirecting to Announcements page in 5 seconds...
                            </div>
                            <script>
                                setTimeout(function(){
                                    window.location.href = '" . URLROOT . "/Announcements/Announcements';
                                }, 5000);
                            </script>
                        ";
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
            $this->view('announcements/v_create_announcements', $data);
        }
    }
}


?>