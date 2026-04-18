<?php

class CalculatorUpdate extends Controller{

    public function index()
    {
    
         $this->updateView();
    }

   public function UpdateRecommendation()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $cropType = $_POST['crop_type'];
                $cropStage = $_POST['crop_stage'];
                $urea = $_POST['urea'];
                $potash = $_POST['potash'];
                $phosphate = $_POST['phosphate'];

              $errors = [
                    'urea' => '',
                    'potash' => '',
                    'phosphate' => ''
              ];

              if(!is_numeric($urea) || $urea <= 0)
                {
                    $errors['urea'] = "Urea amount must be a positive number";
                }

              if(!is_numeric($potash) || $potash <= 0)
                {
                    $errors['potash'] = "potash amount must be a positive number";
                }

              if(!is_numeric($phosphate) || $phosphate <= 0)
                {
                    $errors['phosphate'] = "Phosphate amount must be a positive number";
                }

             if(empty(array_filter($errors)))
                 {
                    $calculator = $this->model('officerCalculator');
                    $calculator->updateData($cropType,$cropStage,$urea,$potash,$phosphate);  
                    
                 }

            $this->updateView($errors);
            }   
    }

    public function updateView($errors = [])
    {
        $calculator = $this->model('officerCalculator');
        $recommendation = $calculator->getAllRecommendationI();

   

        $recommendationArray = [];

        foreach($recommendation as $row) //3d array
        {
            $recommendationArray[$row->crop_type_months][$row->crop_stage]=[
                'urea' => $row->urea_per_acre,
                'potash' => $row->potash_per_acre,
                'phosphate' => $row->phosphate_per_acre
            ];
        }

        $data = [
            'tableData'  => $recommendationArray,
            'errors' => $errors
        ];

        $this->view('admin/CalculatorUpdate',$data);
    }
}


?>