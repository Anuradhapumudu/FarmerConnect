<?php
class OfficerTimeline extends Controller {

    private $model;

    public function __construct() {
        $this->model = $this->model('OfficerTimelineModel');
    }

    public function index() {

        $officerId = $_SESSION['officer_id']; // make sure this exists

        // 1. Get officer division
        $division = $this->model->getOfficerDivision($officerId);

        // 2. Get farmers in that division
        $farmers = $this->model->getFarmersByDivision($division);

        $data = [
            'farmers' => $farmers
        ];

        $this->view('officer/officertimeline', $data);
    }


public function show()
{
    // 1. Get PLR from POST
    $plr = $_POST['plr'] ?? null;

    if (!$plr) {
        die("Invalid request (PLR missing)");
    }

    // 2. Get NIC using PLR
    $nic = $this->model->getNICByPLR($plr);

    if (!$nic) {
        die("Farmer not found");
    }

    // 3. Get seed variety
    $seed = $this->model->getSeedVariety($plr);

    if (!$seed) {
        die("Seed data not found");
    }

    // 4. Get duration
    $duration = $this->getSeedDuration($seed->Paddy_Seed_Variety);

    if (!$duration) {
        die("Invalid seed duration");
    }

    // 5. Get timeline steps
    $timeline = $this->model->getTimelineByDuration($duration);

    // 6. Get start date
    $startDate = $this->model->getStartDate($nic, $plr);

    if (!$startDate) {
        $startDate = date('Y-m-d'); // fallback
    }

    // 7. Calculate estimated dates
    $estimatedDates = [];

    foreach ($timeline as $step) {
        $startDate = date('Y-m-d', strtotime("+{$step->gap_days} days", strtotime($startDate)));
        $estimatedDates[$step->step_order] = $startDate;
    }

    // 8. Get saved progress
    $saved = $this->model->getSavedProgress($nic, $plr);

    $progress = [];
    $updatedDates = [];

    foreach ($saved as $row) {
        $progress[$row->step_order] = $row->status;
        $updatedDates[$row->step_order] = $row->updated_date;
    }

    // 9. Send to view (READ-ONLY MODE)
    $data = [
        'plr' => $plr,
        'estimatedDates' => $estimatedDates,
        'progress' => $progress,
        'updatedDates' => $updatedDates,
        'readonly' => true
    ];

    $this->view('officer/OfficerTimelineView', $data);
}

    // ✅ ADD THIS ALSO (missing)
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
?>