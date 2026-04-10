<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/YellowCaseForm.css?v=<?= time(); ?>">

<div class="yellowcase-card">
    <div class="yellowcase-header">
        <h1>Yellow Case Report (View Only)</h1>
        <p class="yellowcase-subtitle">This is your submitted yellow case record regarding a cultivational issue.</p>
    </div>
    
    <div class="case-id-display">
        <label>Case ID:</label>
        <span id="caseIdDisplay"><?php echo $data['case']->case_id ?? 'Unknown'; ?></span>
    </div>

    <div class="yellowcase-form readonly-view">

        <div class="form-group">
            <label>Farmer NIC Number</label>
            <p class="readonly-field"><?php echo htmlspecialchars($data['case']->farmer_nic ?? ''); ?></p>
        </div>

        <div class="form-group">
            <label>PLR Number</label>
            <p class="readonly-field"><?php echo htmlspecialchars($data['case']->plr_number ?? ''); ?></p>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label>Observation Date</label>
                <p class="readonly-field"><?php echo $data['case']->observation_date ?? ''; ?></p>
            </div>
            <div class="form-col">
                <label>Submitted Date</label>
                <p class="readonly-field"><?php echo $data['case']->submitted_date ?? ''; ?></p>
            </div>
        </div>

        <div class="form-group">
            <label>Case Title</label>
            <p class="readonly-field"><?php echo htmlspecialchars($data['case']->case_title ?? ''); ?></p>
        </div>

        <div class="form-group">
            <label>Detailed Description</label>
            <p class="readonly-field"><?php echo nl2br(htmlspecialchars($data['case']->case_description ?? '')); ?></p>
        </div>

        <div class="form-group">
            <label>Uploaded Media</label>
            <div class="uploaded-files has-files">
                <?php 
                if (!empty($data['case']->media)) {
                    $mediaFiles = json_decode($data['case']->media, true);
                    if (is_array($mediaFiles)) {
                        foreach ($mediaFiles as $file) {
                            $fileUrl = URLROOT . '/uploads/yellow_cases/' . htmlspecialchars($file);
                            echo "<p>📌 <a href='{$fileUrl}' target='_blank'>" . htmlspecialchars($file) . "</a></p>";
                        }
                    }
                } else {
                    echo "<p>No media uploaded.</p>";
                }
                ?>
            </div>
        </div>

        <button class="btn-reply" onclick="window.location.href='<?php echo URLROOT; ?>/YellowCaseList'">Back to List</button>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
