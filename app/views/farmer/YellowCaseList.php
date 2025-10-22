<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/YellowCaseList.css?v=<?= time(); ?>">

<div class="content-card yellowcase-list">
    <div class="content-header">
        <h1> My Yellow Cases</h1>
        <p class="content-subtitle">Track and monitor your submitted yellow case reports</p>
    </div>

    <!-- Create Report Button -->
    <div class="action-bar">
        <a href="<?php echo URLROOT; ?>/YellowCaseForm" class="btn create-btn">
            + Create Yellow Case Report
        </a>
    </div>

    <div class="table-wrapper">
        <table class="yellowcase-table">
            <thead>
                <tr>
                    <th>Case ID</th>
                    <th>Title</th>
                    <th>Observation Date</th>
                    <th>Submitted On</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>001</td>
                    <td>Leaf discoloration in paddy</td>
                    <td>2025-10-12</td>
                    <td>2025-10-13</td>
                    <td><span class="status pending">Pending</span></td>
                    <td class="btn-cell">
                        <button class="btn view-btn">View</button>
                        <button class="btn reply-btn">View Reply</button>
                    </td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>Stem borer damage</td>
                    <td>2025-09-29</td>
                    <td>2025-09-30</td>
                    <td><span class="status replied">Replied</span></td>
                    <td class="btn-cell">
                        <button class="btn view-btn">View</button>
                        <button class="btn reply-btn">View Reply</button>
                    </td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>Brown spot disease</td>
                    <td>2025-08-15</td>
                    <td>2025-08-16</td>
                    <td><span class="status resolved">Resolved</span></td>
                    <td class="btn-cell">
                        <button class="btn view-btn">View</button>
                        <button class="btn reply-btn">View Reply</button>
                    </td>
                </tr>
            </tbody>
        </table>

                <!-- ✅ Mobile Cards View -->
        <div class="case-cards">
        <div class="case-card">
            <div class="case-card-header">
            <h4>001 — Leaf discoloration in paddy</h4>
            <span class="status pending">Pending</span>
            </div>
            <div class="case-card-body">
            <p><strong>Observation Date:</strong> 2025-10-12</p>
            <p><strong>Submitted On:</strong> 2025-10-13</p>
            </div>
            <div class="case-card-actions">
            <button class="btn view-btn">View</button>
            <button class="btn reply-btn">View Reply</button>
            </div>
        </div>

        <div class="case-card">
            <div class="case-card-header">
            <h4>002 — Stem borer damage</h4>
            <span class="status replied">Replied</span>
            </div>
            <div class="case-card-body">
            <p><strong>Observation Date:</strong> 2025-09-29</p>
            <p><strong>Submitted On:</strong> 2025-09-30</p>
            </div>
            <div class="case-card-actions">
            <button class="btn view-btn">View</button>
            <button class="btn reply-btn">View Reply</button>
            </div>
        </div>

        <div class="case-card">
            <div class="case-card-header">
            <h4>003 — Brown spot disease</h4>
            <span class="status resolved">Resolved</span>
            </div>
            <div class="case-card-body">
            <p><strong>Observation Date:</strong> 2025-08-15</p>
            <p><strong>Submitted On:</strong> 2025-08-16</p>
            </div>
            <div class="case-card-actions">
            <button class="btn view-btn">View</button>
            <button class="btn reply-btn">View Reply</button>
            </div>
        </div>
        </div>

    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

