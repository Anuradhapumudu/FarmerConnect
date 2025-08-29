<?php require_once APPROOT . '/views/inc/header.php'; ?>

<main class="main-content">
    <div class="container">
        <div class="content-card text-center">
            <div style="font-size: 4rem; color: var(--success);">✅</div>
            <h1>Report Submitted Successfully!</h1>
            <p>Your disease report has been received and is being processed.</p>
            
            <div class="report-details">
                <p><strong>Report ID:</strong> <?php echo isset($data['report_id']) ? htmlspecialchars($data['report_id']) : 'N/A'; ?></p>
                <p>Please keep this ID for future reference.</p>
            </div>
            
            <div class="action-buttons" style="margin-top: 30px;">
                <a href="<?php echo URLROOT; ?>/disease/report" class="btn btn-primary">Submit Another Report</a>
                <a href="<?php echo URLROOT; ?>/pages" class="btn btn-secondary">Return to Home</a>
            </div>
        </div>
    </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>