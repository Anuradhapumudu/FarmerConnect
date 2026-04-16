<?php
class test extends Controller {


    
    public function index() {
       
        $this->view('officer/test');
    }

    public function calculate()
    {
        $data=
        [
            'finResult'=> null,
            'error'=>''
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $num1 = $_POST['num1'];
                $num2 = $_POST['num2'];
                $operation = $_POST['operation'];

            }

            if(!is_numeric($num1) || !is_numeric($num2))
                {
                    $data['error'] = "Plese enter a Numeric Value";
                }
            elseif(($num1==0 || $num2==0) && $operation=='/')
                {
                    $data['error'] = "Cant devide by zero";
                }
            else
                {
                    $calculator = $this->model('testModel');
                    $result = $calculator->calculate($num1,$num2,$operation);

                    $data['finResult'] = $result;
                }
           // var_dump($operation);
            
        // var_dump($data);
       //var_dump($result);
       //exit();
        //$data=['finResult' => $result];
        


        $this->view('officer/test',$data);
       // var_dump($data);


      //  header('Location:'.URLROOT.'/officer/test'); // Redirect to the same page
        exit();
    }

        public function create()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $farmerID = $_POST['farmer_ID'];
                $note = $_POST['note'];
            }

            //var_dump($farmerID);
           // var_dump($note);
            //exit();

            $create = $this->model('testModel');
            $create -> addToDB($farmerID,$note);
        }

        public function search()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $farmerID = $_POST['farmer_ID'];
            }

            $list = $this->model('testModel');
            $resultlist = $list -> listnotes($farmerID);

            //var_dump($farmerID);
            //var_dump($resultlist);
            //exit();
            $data=
            [
                'result' => $resultlist
            ];

            $this->view('officer/test',$data);
        }
}?>