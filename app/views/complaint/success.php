<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/complain/success.css">

<div class="success-page-wrapper">
    <!-- Main card -->
    <div class="success-card">
        <div class="card-banner">
            <div class="check-wrapper">
                <div class="check-ring"></div>
                <div class="check-circle">
                    <svg class="check-svg" viewBox="0 0 24 24">
                        <path class="check-path" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <h1 class="banner-title">Complaint Submitted!</h1>
            <p class="banner-sub">Your report is now being processed</p>
        </div>

        <div class="card-body">
            <!-- Detail boxes -->
            <div class="details-grid">
                <div class="detail-box">
                    <div class="label"><i class="fas fa-hashtag"></i> Complaint ID</div>
                    <div class="value id-val"><?php echo htmlspecialchars($data['complaint_id']); ?></div>
                </div>
                <div class="detail-box">
                    <div class="label"><i class="fas fa-calendar"></i> Submitted</div>
                    <div class="value"><?php echo date('M j, Y'); ?></div>
                </div>
                <div class="detail-box">
                    <div class="label"><i class="fas fa-signal"></i> Current Status</div>
                    <div class="value">
                        <span class="status-chip">
                            <span class="dot"></span>
                            Pending Review
                        </span>
                    </div>
                </div>
            </div>

            <!-- Step tracker -->
            <div class="tracker">
                <div class="tracker-title"><i class="fas fa-route"></i> Progress Tracker</div>
                <div class="steps">
                    <div class="step active">
                        <div class="step-dot"><i class="fas fa-check"></i></div>
                        <div class="step-label">Received</div>
                    </div>
                    <div class="step">
                        <div class="step-dot">2</div>
                        <div class="step-label">Under Review</div>
                    </div>
                    <div class="step">
                        <div class="step-dot">3</div>
                        <div class="step-label">Response</div>
                    </div>
                    <div class="step">
                        <div class="step-dot">4</div>
                        <div class="step-label">Resolved</div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="actions">
                <a href="<?php echo URLROOT; ?>/complaint" class="btn-act btn-primary-act">
                    <i class="fas fa-plus"></i> New Complaint
                </a>
                <a href="<?php echo URLROOT; ?>/farmerDashboard" class="btn-act btn-outline-act">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </div>

            <!-- Redirect countdown -->
            <div class="redirect-bar" data-redirect-url="<?php echo URLROOT; ?>/Complaint/myComplaints">
                <svg class="progress-ring" viewBox="0 0 24 24">
                    <circle class="progress-ring-bg" cx="12" cy="12" r="11" />
                    <circle class="progress-ring-fg" id="progressRing" cx="12" cy="12" r="11" />
                </svg>
                <span class="redirect-text">Redirecting to my complaints in</span>
                <span class="countdown-num" id="countdown">10</span>
                <span class="redirect-text">s</span>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/js/complain/success.js"></script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>