<?php

class Help extends Controller{

    public function help(){

        $this->view('help/V_help');
}

    public function helpAdmin(){

        $this->view('help/V_helpAdmin');

}

    public function helpSeller(){

        $this->view('help/V_helpSeller');

}

    public function helpOfficer(){

        $this->view('help/V_helpOfficer');

}

}
?>