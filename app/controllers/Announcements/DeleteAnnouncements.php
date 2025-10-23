<?php

class DeleteAnnouncements extends Controller{
    public function __construct() {
        $this->announcementModel = $this->model('M_Announcements/M_Announcements');
        if (!isset($_SESSION['user_type']) || 
            !in_array($_SESSION['user_type'], ['officer', 'admin'])) {
            die('Access Denied');
            exit();
        }
    }
    public function delete($id) {
    $announcementModel = $this->model('M_Announcements/M_Announcements');

    if($announcementModel->deleteAnnouncement($id)) {
        echo "
           
                            <script>
                                setTimeout(function(){
                                    window.location.href = '" . URLROOT . "/Announcements/Announcements';
                                }, 0000);
                            </script>
                        ";               
    } else {
        die('Something went wrong. Please try again.');
    }

}

}