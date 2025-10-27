<?php
class Announcements extends Controller {
    private $announcementModel;

    public function __construct() {
        $this->announcementModel = $this->model('M_Announcements/M_Announcements');
    }
    public function index() {
        // Get announcements
        $announcements = $this->announcementModel->getAnnouncements();
        $pinned = $this->announcementModel->getPinnedAnnouncements();

        // Get search announcements
        $term = $_GET['term'] ?? '';
        $category = $_GET['category'] ?? '';
        $date = $_GET['date'] ?? '';

        if($term || $category || $date) {
            $searchResults = $this->announcementModel->searchAnnouncements($term, $category, $date);
        } else {
            $searchResults = [];
        }
        // Prepare data for the view
        $data = [
            'latestAnnouncements' => $announcements['latest'],
            'previousAnnouncements' => $announcements['previous'],
            'pinnedAnnouncements' => $pinned,
            'searchResults' => $searchResults,
            'searchPerformed' => ($term || $category || $date)
        ];
        $this->loadViewByRole('announcements', $data);
    }

    public function togglePin($id) {
        if (!isset($_SESSION['user_type']) || 
            !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            header('Location: ' . URLROOT . '/Users/login');
            exit();
        }

        $announcementModel = $this->model('M_Announcements/M_Announcements');
        
        $announcementModel->togglePin($id);
        
        header('Location: ' . URLROOT . '/Announcements');
        exit;
    }

    public function details($id) {
        $announcement = $this->announcementModel->getAnnouncementById($id);

        $data = [
            'announcement' => $announcement
        ];
        $this->loadViewByRole('view_announcements', $data);
    }

    public function create(){
        if (!isset($_SESSION['user_type']) || 
            !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
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

    public function edit($id){
        if (!isset($_SESSION['user_type']) || 
            !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'announcement_id' => $id,
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
                if($this->announcementModel->editAnnouncement($data)) {
                    // Redirect or show success message
                    echo "
                            
                            <script>
                                setTimeout(function(){
                                    window.location.href = '" . URLROOT . "/Announcements';
                                }, 0000);
                            </script>
                        ";
                } else {
                    // Show error message
                    die('Something went wrong. Please try again.');
                }
            }
        } else {
            $announcement = $this->announcementModel->getAnnouncementById($id);
            // Show form
            $data = [
                'announcement_id' => $id,
                'title' => $announcement->title,
                'category' => $announcement->category,
                'content' => $announcement->content,
                'attachFiles' => '',
                'attachment_path' => $announcement->attachment_path
            ];
            $this->loadViewByRole('edit_announcements', $data);
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user_type']) || 
            !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
        if($this->announcementModel->deleteAnnouncement($id)) {
            echo "
            
                                <script>
                                    setTimeout(function(){
                                        window.location.href = '" . URLROOT . "/Announcements';
                                    }, 0000);
                                </script>
                            ";               
        } else {
            die('Something went wrong. Please try again.');
        }

    }

    // Helper to load role-specific views in the same folder
    private function loadViewByRole($baseViewName, $data) {
        if (!isset($_SESSION['user_type'])) {
            header('Location: /users/login'); 
            exit;
        }
        switch ($_SESSION['user_type']) {
            case 'farmer':
                $this->view('announcements/v_farmer_' . $baseViewName, $data);
                break;
            case 'admin':
                $this->view('announcements/v_admin_' . $baseViewName, $data);
                break;
            case 'seller':
                $this->view('announcements/v_seller_' . $baseViewName, $data);
                break;
            case 'officer':
                $this->view('announcements/v_officer_' . $baseViewName, $data);
                break;
            default:
                header('Location: /User/login');
                exit;
        }
    }

}
?>
