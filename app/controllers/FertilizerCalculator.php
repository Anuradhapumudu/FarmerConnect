<?php

class FertilizerCalculator extends Controller{

    public function index()
    {
        $data = [
            'errors' => [],
            'results' => []
        ];

    // Load inputs + errors (always)
    if (isset($_SESSION['temp_inputs'])) {
        $data['land_area'] = $_SESSION['temp_inputs']['land_area'];
        $data['crop_type'] = $_SESSION['temp_inputs']['crop_type'];
        $data['crop_stage'] = $_SESSION['temp_inputs']['crop_stage'];
        $data['errors'] = $_SESSION['temp_inputs']['errors'];

        unset($_SESSION['temp_inputs']);
    }

    // Load results (only if exists)
    if (isset($_SESSION['temp_results'])) {
        $data['results'] = $_SESSION['temp_results'];
        unset($_SESSION['temp_results']);
    }

    $this->view('farmer/FertilizerCalculator', $data);
    }

    public function calculate()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        $landArea = $_POST['land_area'];  // Read inputs
        $errors = [];
        
        if(empty($landArea))
        {
            $errors['land_area'] = "This field is required";
        }
        elseif(!is_numeric($landArea))
        {
            $errors['land_area'] = "Please enter a valid Land Size";
        }
        elseif($landArea<0)
        {
            $errors['land_area'] = "Land Size should be positive";
        }

        $cropType = $_POST['crop_type'];
        $cropStage = $_POST['crop_stage'];

        if(empty($errors))
        {
        $calculator = $this->model('FertilizerCalculatorModel'); //load the model
        $results = $calculator->calculateFertilizer($landArea,$cropType,$cropStage);  // Calculate fertilizer
        $_SESSION['temp_results'] = $results;   // Store data in session temporarily
        }

        
        $_SESSION['temp_inputs'] = [
            'land_area' => $landArea,
            'crop_type' => $cropType,
            'crop_stage' => $cropStage,
            'errors' => $errors
        ];

        header('Location:'.URLROOT.'/FertilizerCalculator'); // Redirect to the same page
        exit();
        //var_dump($results);
      /*  $data = [                       //Prepare data for view
            'land_area' => $landArea,
            'crop_type' => $cropType,
            'crop_stage' => $cropStage,
            'results' => $results
        ]; */

        //$this->view('farmer/FertilizerCalculator',$data);  //Load view

        }
    }

}


?>