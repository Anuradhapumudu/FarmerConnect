<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>
<!-- Marketplace-specific CSS -->

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/farmerdashboard.css?v=<?= time(); ?>">

<main>
        <h2>Welcome, Farmer!</h2>
        <div class="dashboard-grid">
            <a href="#" class="card">
                <div>🕒</div>
                <p>Timeline Tracker</p>
            </a>
            <a href="#" class="card">
                <div>🧮</div>
                <p>Fertilizer Calculator</p>
            </a>
            <a href="<?php echo URLROOT; ?>/app/views/farmer/DiseaseReport.php" class="card">
                <div>🦠</div>
                <p>Disease Report</p>
            </a>
            <a href="#" class="card">
                <div>📘</div>
                <p>Knowledge Center</p>
            </a>
            <a href="#" class="card">
                <div>🛒</div>
                <p>Marketplace</p>
            </a>
            <a href="#" class="card">
                <div>📝</div>
                <p>Complaint Section</p>
            </a>
        </div>
    </main>


<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>