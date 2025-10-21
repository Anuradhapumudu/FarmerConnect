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
            <div style='
                                text-align: center; 
                                margin-top: 50px; 
                                font-family: Arial, sans-serif; 
                                font-size: 20px; 
                                color: green;'>
                                Announcement deleted! <br>
                                Redirecting to Announcements page in 2 seconds...
                            </div>
                            <script>
                                setTimeout(function(){
                                    window.location.href = '" . URLROOT . "/Announcements/Announcements';
                                }, 2000);
                            </script>
                        ";               
    } else {
        die('Something went wrong. Please try again.');
    }

}

}