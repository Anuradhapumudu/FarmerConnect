<?php

class ProfileView extends Controller{

    public function sellerProfile(){

        $this->view('profile/V_sellerprofile');
}

    public function adminProfile(){

        $this->view('profile/V_adminprofile');
}

    public function officerProfile(){

        $this->view('profile/V_officerprofile');
}
}