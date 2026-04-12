<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/complain/myComplaints.css">

<?php
// Count statuses
$totalComplaints = isset($data['reports']) ? count($data['reports']) : 0;
$pendingCount = 0;
$reviewCount = 0;
$resolvedCount = 0;

if (!empty($data['reports'])) {
    foreach ($data['reports'] as $r) {
        $st = strtolower(trim($r->status ?? ''));
        $st = str_replace('_', ' ', $st);
        if ($st === 'pending') $pendingCount++;
        elseif (in_array($st, ['under review', 'reviewing', 'in progress'])) $reviewCount++;
        elseif (in_array($st, ['resolved', 'responded', 'closed'])) $resolvedCount++;
    }
}
?>

<div class="my-complaints-wrapper">

    <!-- Header -->
    <div class="mc-header">
        <div class="mc-header-top">
            <div class="mc-title-group">
                <div class="mc-title-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <div class="mc-title">My Complaints</div>
                    <div class="mc-subtitle">Track and manage your submitted complaints</div>
                </div>
            </div>
            <a href="<?php echo URLROOT; ?>/complaint" class="mc-new-btn">
                <i class="fas fa-plus"></i> New Complaint
            </a>
        </div>

        <!-- Search -->
        <div class="mc-search-bar">
            <form class="mc-search-form" method="GET" action="<?php echo URLROOT; ?>/Complaint/myComplaints">
                <div class="mc-search-group">
                    <label class="mc-search-label"><i class="fas fa-hashtag"></i> Complaint ID</label>
                    <input type="text" name="complaint_id" class="mc-search-input"
                        placeholder="e.g. CP001"
                        value="<?php echo htmlspecialchars($data['complaint_id'] ?? ''); ?>">
                </div>
                <div class="mc-search-group">
                    <label class="mc-search-label"><i class="fas fa-map-marker-alt"></i> Paddy Field (PLR)</label>
                    <?php if (!empty($data['paddyFields'])): ?>
                        <select name="plrNumber" class="mc-search-select">
                            <option value="">All Fields</option>
                            <?php foreach ($data['paddyFields'] as $field): ?>
                                <option value="<?php echo htmlspecialchars($field->PLR); ?>"
                                    <?php echo (isset($data['plrNumber']) && $data['plrNumber'] === $field->PLR) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($field->PLR); ?>
                                    (<?php echo htmlspecialchars($field->Paddy_Size); ?> acres)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="text" name="plrNumber" class="mc-search-input"
                            placeholder="PLR Number"
                            value="<?php echo htmlspecialchars($data['plrNumber'] ?? ''); ?>">
                    <?php endif; ?>
                </div>
                <button type="submit" class="mc-search-btn"><i class="fas fa-search"></i> Search</button>
                <?php if (!empty($data['searched'])): ?>
                    <a href="<?php echo URLROOT; ?>/Complaint/myComplaints" class="mc-clear-btn">
                        <i class="fas fa-times"></i> Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="mc-stats">
        <div class="mc-stat-card total">
            <div class="mc-stat-num"><?php echo $totalComplaints; ?></div>
            <div class="mc-stat-label">Total</div>
        </div>
        <div class="mc-stat-card pending">
            <div class="mc-stat-num"><?php echo $pendingCount; ?></div>
            <div class="mc-stat-label">Pending</div>
        </div>
        <div class="mc-stat-card reviewed">
            <div class="mc-stat-num"><?php echo $reviewCount; ?></div>
            <div class="mc-stat-label">Under Review</div>
        </div>
        <div class="mc-stat-card resolved">
            <div class="mc-stat-num"><?php echo $resolvedCount; ?></div>
            <div class="mc-stat-label">Resolved</div>
        </div>
    </div>

    <!-- Message -->
    <?php if (!empty($data['message'])): ?>
        <div class="mc-message <?php echo !empty($data['searched']) ? 'search' : 'info'; ?>">
            <i class="fas <?php echo !empty($data['searched']) ? 'fa-search' : 'fa-info-circle'; ?>"></i>
            <?php echo htmlspecialchars($data['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Complaints Grid -->
    <?php if (!empty($data['reports'])): ?>
        <div class="mc-grid">
            <?php foreach ($data['reports'] as $report):
                $isDeleted = isset($report->is_deleted) && $report->is_deleted == 1;
                $statusRaw = $isDeleted ? 'deleted' : strtolower(trim($report->status ?? 'pending'));
                $statusRaw = str_replace('_', ' ', $statusRaw);
                $statusClass = 'pending';
                if ($isDeleted) $statusClass = 'deleted';
                elseif (in_array($statusRaw, ['under review', 'reviewing', 'in progress'])) $statusClass = 'under-review';
                elseif ($statusRaw === 'responded') $statusClass = 'responded';
                elseif (in_array($statusRaw, ['resolved', 'closed'])) $statusClass = 'resolved';
                elseif ($statusRaw === 'rejected') $statusClass = 'rejected';

                $severityClass = strtolower(trim($report->severity ?? 'low'));
                $responseCount = isset($report->officer_responses) ? count($report->officer_responses) : 0;
            ?>
                <a href="<?php echo URLROOT; ?>/complaint/viewComplaint/<?php echo htmlspecialchars($report->complaint_id); ?>" class="mc-card <?php echo $isDeleted ? 'deleted' : ''; ?>">
                    <div class="mc-card-top">
                        <span class="mc-card-id"><?php echo htmlspecialchars($report->complaint_id); ?></span>
                        <span class="mc-card-severity <?php echo $severityClass; ?>">
                            <?php echo htmlspecialchars(ucfirst($report->severity ?? 'Low')); ?>
                        </span>
                    </div>
                    <div class="mc-card-body">
                        <div class="mc-card-title"><?php echo htmlspecialchars($report->title ?? 'Untitled'); ?></div>
                        <div class="mc-card-desc"><?php echo htmlspecialchars($report->description ?? ''); ?></div>
                        <div class="mc-card-meta">
                            <div class="mc-card-meta-item">
                                <i class="fas fa-calendar"></i>
                                <?php echo date('M j, Y', strtotime($report->observationDate ?? $report->created_at)); ?>
                            </div>
                            <div class="mc-card-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo htmlspecialchars($report->plrNumber ?? 'N/A'); ?>
                            </div>
                            <div class="mc-card-meta-item">
                                <i class="fas fa-ruler-combined"></i>
                                <?php echo htmlspecialchars($report->affectedArea ?? '0'); ?> acres
                            </div>
                        </div>
                    </div>
                    <div class="mc-card-footer">
                        <span class="mc-card-status <?php echo $statusClass; ?>">
                            <span class="dot"></span>
                            <?php echo $isDeleted ? 'Deleted' : htmlspecialchars(ucwords($report->status ?? 'Pending')); ?>
                        </span>
                        <?php if ($responseCount > 0): ?>
                            <span class="mc-card-responses">
                                <i class="fas fa-comment-dots"></i>
                                <?php echo $responseCount; ?> response<?php echo $responseCount > 1 ? 's' : ''; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Empty state -->
        <div class="mc-empty">
            <div class="mc-empty-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3>No Complaints Found</h3>
            <p>You haven't submitted any complaints yet, or none match your search.</p>
            <a href="<?php echo URLROOT; ?>/complaint" class="mc-new-btn">
                <i class="fas fa-plus"></i> Submit Your First Complaint
            </a>
        </div>
    <?php endif; ?>

</div>

<script src="<?php echo URLROOT; ?>/js/complain/myComplaints.js"></script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>
