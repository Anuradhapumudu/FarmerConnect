<?php
class AnnouncementsFarmer extends Controller {
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
        $this->view('announcements/v_announcementsFarmer', $data);
    }
    // view announcement
    public function details($id) {
        $announcementModel = $this->model('M_Announcements/M_Announcements');
        $announcement = $announcementModel->getAnnouncementById($id);

        $data = [
            'announcement' => $announcement
        ];

        $this->view('announcements/v_view_announcementsFarmer', $data);
    }
}
?>
