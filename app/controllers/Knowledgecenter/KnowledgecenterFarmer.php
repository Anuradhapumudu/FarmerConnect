<?php

class KnowledgecenterFarmer extends Controller{

    public function index(){

         $this->view('knowledgecenter/v_knowledgecenterFarmer');
    }
    public function ricevarieties() {
        $this->view('knowledgecenter/v_ricevarieties');
    }

    public function fertilizer() {
        $this->view('knowledgecenter/v_fertilizermanagement');
    }

    public function pestcontrol() {
        $this->view('knowledgecenter/v_pestcontrol');
    }

    public function cultivation() {
        $this->view('knowledgecenter/v_cultivation');
    }

    public function soilhealth() {
        $this->view('knowledgecenter/v_soilhealth');
    }

    public function others() {
        $this->view('knowledgecenter/v_others');
    }

}


?>