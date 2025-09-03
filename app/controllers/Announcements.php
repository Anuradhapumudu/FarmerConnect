<?php
class Announcements extends Controller {
    public function index() {
        // Load the model
        $announcementModel = $this->model('M_Announcements');

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
        $this->view('officer/v_announcements', $data);
    }
    public function togglePin($id) {
        $announcementModel = $this->model('M_Announcements');
        
        $announcementModel->togglePin($id);
        
        // Redirect back to announcements page
        header('Location: ' . URLROOT . '/Announcements');
        exit;
    }
    // view announcement
    public function details($id) {
        $announcementModel = $this->model('M_Announcements');
        $announcement = $announcementModel->getAnnouncementById($id);

        $data = [
            'announcement' => $announcement
        ];

        $this->view('officer/v_view_announcements', $data);
    }
}
?>
