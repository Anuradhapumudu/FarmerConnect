<?php

class PublicHelp extends controller{

private $publicHelpModel;

public function __construct(){

 $this->publicHelpModel = $this->model('M_Help', new Database());
}

public function publicHelp(){
   
    $data = [
             'members' => $this->publicHelpModel->getMembers(),
            'emergencyNumber' => $this->publicHelpModel->getEmergencyContact()
         ];

        $this->view('help/V_PublicHelp', $data);
       
}
}

?>