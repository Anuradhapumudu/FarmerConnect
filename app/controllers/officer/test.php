<?php
class test extends Controller {


    
    public function index() {
       
        $this->view('officer/test');
    }

    public function calculate()
    {
        //$data=[];

        if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $num1 = $_POST['num1'];
                $num2 = $_POST['num2'];

            }

        $calculator = $this->model('testModel');
        $result = $calculator->calculate($num1,$num2);
        // var_dump($result);
       //var_dump($result);
       // exit();
        $data = 
             ['finResult' => null];

        $this->view('officer/test',$data);
       // var_dump($data);


      //  header('Location:'.URLROOT.'/officer/test'); // Redirect to the same page
        exit();
    }
}?>