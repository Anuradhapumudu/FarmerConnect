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
            <?php if (!empty($data['cases'])): ?>
                <?php foreach ($data['cases'] as $case): ?>
                <tr>
                    <td><?php echo $case->case_id; ?></td>
                    <td><?php echo htmlspecialchars($case->case_title); ?></td>
                    <td><?php echo $case->observation_date; ?></td>
                    <td><?php echo $case->submitted_date; ?></td>
                    <td>
                        <span class="status <?php echo strtolower($case->status); ?>">
                            <?php echo $case->status; ?>
                        </span>
                    </td>
                    <td class="btn-cell">
                        <a href="<?php echo URLROOT; ?>/YellowCaseForm/show/<?php echo $case->case_id; ?>" class="btn view-btn" style="text-decoration:none;">View</a>
                        <button class="btn reply-btn">View Reply</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No Yellow Cases Found</td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>
    </div>

                <!-- ✅ Mobile Cards View -->
        <div class="case-cards">
        <?php if (!empty($data['cases'])): ?>
            <?php foreach ($data['cases'] as $case): ?>
            <div class="case-card">
                <div class="case-card-header">
                    <h4><?php echo $case->case_id; ?> — <?php echo htmlspecialchars($case->case_title); ?></h4>
                    <span class="status <?php echo strtolower($case->status); ?>"><?php echo $case->status; ?></span>
                </div>
                <div class="case-card-body">
                    <p><strong>Observation Date:</strong> <?php echo $case->observation_date; ?></p>
                    <p><strong>Submitted On:</strong> <?php echo $case->submitted_date; ?></p>
                </div>
                <div class="case-card-actions">
                    <a href="<?php echo URLROOT; ?>/YellowCaseForm/show/<?php echo $case->case_id; ?>" class="btn view-btn">View</a>
                    <button class="btn reply-btn">View Reply</button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Yellow Cases Found</p>
        <?php endif; ?>
        </div>
        </div>
    


<?php require_once APPROOT . '/views/inc/footer.php'; ?>

