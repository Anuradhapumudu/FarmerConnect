<?php
class test extends Controller {


        public function __construct() {
        $this->model = $this->model('testModel');
    }
    
    public function index() {

        $filter = $_GET['filter'] ?? null;

        var_dump($filter);

       if(empty($filter))
        {
        $list = $this->model->getAllNote();
        }
        else
        {
         $list = $this->model->getfilterNote($filter);   
        }

        $data=
        [
            'list'=>$list,
            'filter' => $filter
        ];
       

        $this->view('officer/test',$data);
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
                   //$calculator = $this->model('testModel');
                    $result = $this->model->calculate($num1,$num2,$operation);

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
                $priority = $_POST['note_piority'];
            }

            //var_dump($farmerID);
           // var_dump($note);
            //exit();

           // $create = $this->model('testModel');
            $this->model -> addToDB($farmerID,$note,$priority);

                header("Location: " . URLROOT . "/officer/test/index");
                exit();
        }

        public function search()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $farmerID = $_POST['farmer_ID'];
            }

            //$list = $this->model('testModel');
            $resultlist = $this->model -> listnotes($farmerID);

            //var_dump($farmerID);
            //var_dump($resultlist);
            //exit();
            $data=
            [
                'result' => $resultlist
            ];

            $this->view('officer/test',$data);
        }

        public function edit($id)
        {

            //var_dump($id);
           // var_dump($note);
            //exit();
        $request = $this->model->getRequestById($id);
           //var_dump($request);
            //exit();
                    // Get request by ID

        if (!$request) {
            die("ID found");
        }

        $data = [
            'request' => $request
        ];

        $this->view('officer/test', $data);

        }

        public function delete($id)
        {

        $this->model->deleteById($id);


             header("Location: " . URLROOT . "/officer/test/index");
             exit();;

        }

        public function save()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $farmerID = $_POST['farmer_ID'];
                $note = $_POST['note'];
                $id = $_POST['id'];
                $priority = $_POST['note_piority'];
            }

           // var_dump($farmerID);
            //var_dump($note);
            //var_dump($id);
            //exit();
            $this->model -> updateDB($farmerID,$note,$id,$priority);

                header("Location: " . URLROOT . "/officer/test/index");
                exit();
        }

}?>