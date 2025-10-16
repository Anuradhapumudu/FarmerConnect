<?php

class DeleteAnnouncements extends Controller{
    public function __construct() {
        $this->announcementModel = $this->model('M_Announcements/M_Announcements');
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
                                Redirecting to Announcements page in 5 seconds...
                            </div>
                            <script>
                                setTimeout(function(){
                                    window.location.href = '" . URLROOT . "/Announcements/Announcements';
                                }, 5000);
                            </script>
                        ";
    } else {
        die('Something went wrong. Please try again.');
    }

}

}