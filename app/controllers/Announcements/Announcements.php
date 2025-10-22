<?php
class Announcements extends Controller {
    public function index() {
        // Load the model
        $announcementModel = $this->model('M_Announcements/M_Announcements');

        // Get announcements
        $announcements = $announcementModel->getAnnouncements();
        $pinned = $announcementModel->getPinnedAnnouncements();

        // Get search announcements
        $term = $_GET['term'] ?? '';
        $category = $_GET['category'] ?? '';
        $date = $_GET['date'] ?? '';

        if($term || $category || $date) {
            $searchResults = $announcementModel->searchAnnouncements($term, $category, $date);
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

        // Load the view with data
        $this->loadViewByRole('Announcements', $data);
    }
    public function togglePin($id) {
        if (!isset($_SESSION['user_type']) || 
            !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            header('Location: ' . URLROOT . '/Users/login');
            exit();
        }

        $announcementModel = $this->model('M_Announcements/M_Announcements');
        
        $announcementModel->togglePin($id);
        
        // Redirect back to announcements page
        header('Location: ' . URLROOT . '/Announcements/Announcements');
        exit;
    }
    // view announcement
    public function details($id) {
        $announcementModel = $this->model('M_Announcements/M_Announcements');
        $announcement = $announcementModel->getAnnouncementById($id);

        $data = [
            'announcement' => $announcement
        ];
        $this->loadViewByRole1('view_announcements', $data);
    }
    // Helper to load role-specific views in the same folder
    private function loadViewByRole($baseViewName, $data) {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
            $this->view('announcements/V_Admin' . $baseViewName, $data);
        }else if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'seller') {
            $this->view('announcements/V_Seller' . $baseViewName, $data);
        } else {
            $this->view('announcements/V_Officer' . $baseViewName, $data);
        }
    }
    private function loadViewByRole1($baseViewName, $data) {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
            $this->view('announcements/v_admin_' . $baseViewName, $data);
        } else if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'seller') {
            $this->view('announcements/v_seller_' . $baseViewName, $data);
        } else {
            $this->view('announcements/v_officer_' . $baseViewName, $data);
        }
    }
}
?>
