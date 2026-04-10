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

        if (!empty($_SESSION['selected_plr'])) {

            $plr = $_SESSION['selected_plr'];
            $data['selected_plr'] = $plr;

            $seed = $model->getSeedVariety($plr);
            
            if ($seed && isset($seed->Paddy_seed_variety)) {
                $duration = $this->getSeedDuration($seed->Paddy_seed_variety);
                
                $timeline = [];
                try {
                    $timeline = $model->getTimelineByDuration($duration);
                } catch (Exception $e) {
                    // Fallback if table doesn't exist
                    for ($i = 1; $i <= 11; $i++) {
                        $timeline[] = (object)['step_order' => $i, 'gap_days' => 7];
                    }
                }

                $estimatedDates = [];
                
                $startDate = null;
                try {
                    $startDate = $model->getStartDate($_SESSION['nic'], $plr);
                } catch (Exception $e) {}

                if (!$startDate) {
                    // before step 1 is done
                    $startDate = date('Y-m-d');
                }

                foreach ($timeline as $step) {
                    $startDate = date('Y-m-d', strtotime("+{$step->gap_days} days", strtotime($startDate)));
                    $estimatedDates[$step->step_order] = $startDate;
                }

                $saved = [];
                try {
                    $saved = $model->getSavedProgress($_SESSION['nic'], $plr);
                } catch (Exception $e) {}
                
                $progress = [];
                $updatedDates = [];

                if ($saved) {
                    foreach ($saved as $row) {
                        $progress[$row->step_order] = $row->status;
                        $updatedDates[$row->step_order] = $row->updated_date;
                    }
                }

                $data['estimatedDates'] = $estimatedDates;
                $data['progress'] = $progress;
                $data['updatedDates'] = $updatedDates;
            } else {
                // Revert selection if no seed found to avoid crash
                unset($_SESSION['selected_plr']);
                $data['selected_plr'] = null;
            }
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
        if (isset($_POST['plr'])) {

            // Store selected PLR
            $_SESSION['selected_plr'] = $_POST['plr'];

            // Redirect (PRG pattern)
            header("Location: " . URLROOT . "/FarmerTimeline");
            exit();
        }
    }
    

    public function saveStep()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $model = $this->model('TimeLineModel');

            $nic = $_SESSION['nic'];
            $plr = $_POST['plr'];
            $step = $_POST['step_order'];
            $status = $_POST['status'];

            // Save progress
            $model->saveStepStatus($nic, $plr, $step, $status);

            // ✅ Save start date ONLY when step 1 is done
            if ($step == 1 && $status == 'done') {
                $model->saveStartDate($nic, $plr);
            }

            echo json_encode(['success' => true]);
        }
    }


}
?>