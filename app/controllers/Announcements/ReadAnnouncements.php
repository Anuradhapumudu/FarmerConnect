<?php

class ReadAnnouncements extends Controller {

    public function __construct() {
        $this->announcementModel = $this->model('M_Announcements/M_Announcements');
    }


    public function index() {
        // Get announcements from the model
        $announcements = $this->announcementModel->getAnnouncements();

        // Prepare data for the view
        $data = [
            'latestAnnouncements' => $announcements['latest'],
            'previousAnnouncements' => $announcements['previous']
        ];

        // Load the view and pass the data
        $this->view('announcements/v_announcements', $data);
    }
}
?>
