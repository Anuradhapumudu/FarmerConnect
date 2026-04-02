<?php

class FarmerTimeline extends Controller
{

    public function index()
    {
        $farmerNIC = $_SESSION['nic'];
        $model = $this->model('TimeLineModel');
        $plrs = $model->getPLRS($farmerNIC);

        $data = [
            'plrs' => $plrs,
            'selected_plr' => null,
            'estimatedDates' => [],
            'progress' => []
        ];

        if (isset($_SESSION['selected_plr'])) {

            $plr = $_SESSION['selected_plr'];
            $data['selected_plr'] = $plr;

            $seed = $model->getSeedVariety($plr);
            $duration = $this->getSeedDuration($seed->Paddy_seed_variety);
            $timeline = $model->getTimelineByDuration($duration);

            $estimatedDates = [];
            $startDate = date('Y-m-d');

            foreach ($timeline as $step) {
                $startDate = date('Y-m-d', strtotime("+{$step->gap_days} days", strtotime($startDate)));
                $estimatedDates[$step->step_order] = $startDate;
            }

            $saved = $model->getSavedProgress($_SESSION['nic'], $plr);
            $progress = [];

            foreach ($saved as $row) {
                $progress[$row->step_order] = $row->status;
            }

            $data['estimatedDates'] = $estimatedDates;
            $data['progress'] = $progress;
        }

        $this->view('farmer/FarmerTimeline', $data);
    }


    private function getSeedDuration($seedname)
    {
        $durations = [
            'B-352'  => 3.0,
            'BW-367' => 3.5,
            'Bw-375' => 4.0,
            'BG-300' => 5.0
        ];

        return $durations[$seedname] ?? null;
    }

    public function getSeed()
    {
        if(isset($_POST['plr']))
            {
                $plr = $_POST['plr'];
                $_SESSION['selected_plr'] = $plr;
                $model = $this->model('TimeLineModel');
                $seed = $model->getSeedVariety($plr);
                $seedname = $seed->Paddy_seed_variety;
               // var_dump($seed);
               // var_dump($seedname);
                // echo json_encode($seed);

                $duration = $this->getSeedDuration($seedname);
                //var_dump($duration);

                $timeline = $model->getTimelineByDuration($duration);
                //var_dump($timeline);

               $estimatedDates = [];
               $startDate = date('Y-m-d'); // or last completion date

               foreach($timeline as $step) {
                   $startDate = date('Y-m-d', strtotime("+{$step->gap_days} days", strtotime($startDate)));
                   $estimatedDates[$step->step_order] = $startDate;
               } 

                $_SESSION['estimatedDates'] = $estimatedDates;

                // Redirect to index page (GET)
                header("Location: " . URLROOT . "/FarmerTimeline");
                exit();


            }
    }

    public function saveStep()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $model = $this->model('TimeLineModel');

            $model->saveStepStatus(
                $_SESSION['nic'],
                $_POST['plr'],
                $_POST['step_order'],
                $_POST['status']
            );

            echo json_encode(['success' => true]);
        }
    }


}
?>