<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/YellowCaseForm.css?v=<?= time(); ?>">

<div class="yellowcase-card">
    <div class="yellowcase-header">
        <h1>Yellow Case Report (View Only)</h1>
        <p class="yellowcase-subtitle">This is a submitted yellow case record regarding a cultivational issue.</p>
    </div>
    
    <div class="case-id-display">
        <label>Case ID:</label>
        <span id="caseIdDisplay">YC-2025-00452</span>
    </div>

    <div class="yellowcase-form readonly-view">

        <div class="form-group">
            <label>Farmer NIC Number</label>
            <p class="readonly-field">197940306V</p>
        </div>

        <div class="form-group">
            <label>PLR Number</label>
            <p class="readonly-field">02/25/00083/002/P/0006</p>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label>Observation Date</label>
                <p class="readonly-field">2025-10-17</p>
            </div>
            <div class="form-col">
                <label>Today's Date</label>
                <p class="readonly-field">2025-10-19</p>
            </div>
        </div>

        <div class="form-group">
            <label>Case Title</label>
            <p class="readonly-field">Low Water Supply to Cultivation Area</p>
        </div>

        <div class="form-group">
            <label>Detailed Description</label>
            <p class="readonly-field">For the past two weeks, the irrigation canal supplying water to our paddy field area has had a very low water flow. Due to this, we are unable to maintain the required water level for cultivation. Nearby farmers are also facing the same issue, and the water is insufficient even during scheduled release times. We request officers to inspect the canal system and restore proper water supply before the crops get damaged.
            </p>
        </div>

        <div class="form-group">
            <label>Uploaded Media</label>
            <div class="uploaded-files">
                <p>📌 canal_waterflow.jpg</p>
                <p>📌 field_condition.jpg</p>
            </div>
        </div>

        <button class="btn-reply" onclick="window.location.href='<?php echo URLROOT; ?>/officer/YellowCaseReplyForm'">Reply</button>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
