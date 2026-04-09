<?php
class OfficerTimelineItems extends Controller {

public function show()
{
    // ✅ Get PLR from query string
    $plr = $_GET['plr'] ?? null;

    if (!$plr) {
        die('PLR missing');
    }

    $model = $this->model('TimeLineModel');

    $nic = $model->getNICByPLR($plr);

    if (!$nic) {
        die('Invalid PLR: ' . $plr);
    }

    // ✅ Continue full logic
    $seed = $model->getSeedVariety($plr);
    $duration = $this->getSeedDuration($seed->Paddy_seed_variety);
    $timeline = $model->getTimelineByDuration($duration);

    $startDate = $model->getStartDate($nic, $plr);
    if (!$startDate) {
        $startDate = date('Y-m-d');
    }

    $estimatedDates = [];
    foreach ($timeline as $step) {
        $startDate = date('Y-m-d', strtotime("+{$step->gap_days} days", strtotime($startDate)));
        $estimatedDates[$step->step_order] = $startDate;
    }

    $saved = $model->getSavedProgress($nic, $plr);

    $progress = [];
    foreach ($saved as $row) {
        $progress[$row->step_order] = $row->status;
    }

    $data = [
        'plr' => $plr,
        'estimatedDates' => $estimatedDates,
        'progress' => $progress,
        'readonly' => true
    ];

    parent::view('officer/OfficerTimelineView', $data);
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
}