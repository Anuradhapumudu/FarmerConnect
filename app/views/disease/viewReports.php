<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/viewReports.css">

<?php
// Determine if farmer view
$isFarmer = isset($data['farmerNIC']) && !empty($data['farmerNIC']);

// Count statuses
$totalReports = isset($data['reports']) ? count($data['reports']) : 0;
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

<div class="my-reports-wrapper">

    <!-- Header -->
    <div class="mr-header">
        <div class="mr-header-top">
            <div class="mr-title-group">
                <div class="mr-title-icon">
                    <i class="fas fa-bug"></i>
                </div>
                <div>
                    <div class="mr-title"><?php echo $isFarmer ? 'My Disease Reports' : 'Disease Reports'; ?></div>
                    <div class="mr-subtitle"><?php echo $isFarmer ? 'Track and manage your submitted disease reports' : 'View and manage all submitted disease reports'; ?></div>
                </div>
            </div>
            <?php if ($isFarmer): ?>
                <a href="<?php echo URLROOT; ?>/disease" class="mr-new-btn">
                    <i class="fas fa-plus"></i> New Report
                </a>
            <?php endif; ?>
        </div>

        <!-- Search -->
        <div class="mr-search-bar">
            <form class="mr-search-form" method="GET" action="<?php echo URLROOT; ?>/disease/viewReports">
                <div class="mr-search-group">
                    <label class="mr-search-label"><i class="fas fa-hashtag"></i> Report ID</label>
                    <input type="text" name="reportCode" class="mr-search-input"
                        placeholder="e.g. DR001"
                        value="<?php echo htmlspecialchars($data['reportCode'] ?? ''); ?>">
                </div>
                <div class="mr-search-group">
                    <label class="mr-search-label"><i class="fas fa-map-marker-alt"></i> Paddy Field (PLR)</label>
                    <?php if (!empty($data['paddyFields'])): ?>
                        <select name="plrNumber" class="mr-search-select">
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
                        <input type="text" name="plrNumber" class="mr-search-input"
                            placeholder="PLR Number"
                            value="<?php echo htmlspecialchars($data['plrNumber'] ?? ''); ?>">
                    <?php endif; ?>
                </div>
                <?php if (!$isFarmer): ?>
                    <div class="mr-search-group">
                        <label class="mr-search-label"><i class="fas fa-user"></i> Farmer NIC</label>
                        <input type="text" name="farmerNIC" class="mr-search-input"
                            placeholder="Farmer NIC"
                            value="<?php echo htmlspecialchars($data['farmerNIC'] ?? ''); ?>">
                    </div>
                <?php endif; ?>
                <button type="submit" class="mr-search-btn"><i class="fas fa-search"></i> Search</button>
                <?php if (!empty($data['searched'])): ?>
                    <a href="<?php echo URLROOT; ?>/disease/viewReports" class="mr-clear-btn">
                        <i class="fas fa-times"></i> Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="mr-stats">
        <div class="mr-stat-card total">
            <div class="mr-stat-num"><?php echo $totalReports; ?></div>
            <div class="mr-stat-label">Total</div>
        </div>
        <div class="mr-stat-card pending">
            <div class="mr-stat-num"><?php echo $pendingCount; ?></div>
            <div class="mr-stat-label">Pending</div>
        </div>
        <div class="mr-stat-card reviewed">
            <div class="mr-stat-num"><?php echo $reviewCount; ?></div>
            <div class="mr-stat-label">Under Review</div>
        </div>
        <div class="mr-stat-card resolved">
            <div class="mr-stat-num"><?php echo $resolvedCount; ?></div>
            <div class="mr-stat-label">Resolved</div>
        </div>
    </div>

    <!-- Message -->
    <?php if (!empty($data['message'])): ?>
        <div class="mr-message <?php echo !empty($data['searched']) ? 'search' : 'info'; ?>">
            <i class="fas <?php echo !empty($data['searched']) ? 'fa-search' : 'fa-info-circle'; ?>"></i>
            <?php echo htmlspecialchars($data['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Reports Grid -->
    <?php if (!empty($data['reports'])): ?>
        <div class="mr-grid">
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
                $canEdit = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer'
                    && isset($_SESSION['nic']) && $_SESSION['nic'] === $report->farmerNIC
                    && $report->status === 'pending' && !$isDeleted;
            ?>
                <div class="mr-card <?php echo $isDeleted ? 'deleted' : ''; ?>"
                    onclick="window.location.href='<?php echo URLROOT; ?>/disease/viewReport/<?php echo htmlspecialchars($report->report_code); ?>'"
                    style="cursor: pointer;">
                    <div class="mr-card-top">
                        <span class="mr-card-id"><?php echo htmlspecialchars($report->report_code); ?></span>
                        <span class="mr-card-severity <?php echo $severityClass; ?>">
                            <?php echo htmlspecialchars(ucfirst($report->severity ?? 'Low')); ?>
                        </span>
                    </div>
                    <div class="mr-card-body">
                        <div class="mr-card-title"><?php echo htmlspecialchars($report->title ?? 'Untitled'); ?></div>
                        <div class="mr-card-desc"><?php echo htmlspecialchars($report->description ?? ''); ?></div>
                        <div class="mr-card-meta">
                            <div class="mr-card-meta-item">
                                <i class="fas fa-calendar"></i>
                                <?php echo date('M j, Y', strtotime($report->observationDate ?? $report->created_at)); ?>
                            </div>
                            <div class="mr-card-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo htmlspecialchars($report->plrNumber ?? 'N/A'); ?>
                            </div>
                            <div class="mr-card-meta-item">
                                <i class="fas fa-ruler-combined"></i>
                                <?php echo htmlspecialchars($report->affectedArea ?? '0'); ?> acres
                            </div>
                        </div>
                    </div>
                    <div class="mr-card-footer">
                        <span class="mr-card-status <?php echo $statusClass; ?>">
                            <span class="dot"></span>
                            <?php echo $isDeleted ? 'Deleted' : htmlspecialchars(ucwords($report->status ?? 'Pending')); ?>
                        </span>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <?php if ($responseCount > 0): ?>
                                <span class="mr-card-responses">
                                    <i class="fas fa-comment-dots"></i>
                                    <?php echo $responseCount; ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($canEdit): ?>
                                <button class="mr-card-action-btn edit" title="Edit"
                                    onclick="event.stopPropagation(); window.location.href='<?php echo URLROOT; ?>/disease/editReport/<?php echo htmlspecialchars($report->report_code); ?>';">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="mr-card-action-btn delete" title="Delete"
                                    onclick="event.stopPropagation(); confirmDelete('<?php echo htmlspecialchars($report->report_code); ?>');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="mr-empty">
            <div class="mr-empty-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3>No Reports Found</h3>
            <p><?php echo $isFarmer ? "You haven't submitted any disease reports yet, or none match your search." : "No disease reports match your search criteria."; ?></p>
            <?php if ($isFarmer): ?>
                <a href="<?php echo URLROOT; ?>/disease" class="mr-new-btn">
                    <i class="fas fa-plus"></i> Submit Your First Report
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<!-- Delete Modal -->
<div class="mr-modal-overlay" id="deleteOverlay">
    <div class="mr-modal">
        <div class="mr-modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>Delete Report?</h3>
        <p>Are you sure you want to delete <span class="mr-modal-code" id="modalReportCode"></span>?</p>
        <p class="warn">This action cannot be undone.</p>
        <div class="mr-modal-btns">
            <button class="mr-modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
            <a class="mr-modal-btn confirm" id="modalDeleteLink" href="#">Yes, Delete</a>
        </div>
    </div>
</div>

<script>window.URLROOT = "<?php echo URLROOT; ?>";</script>
<script src="<?php echo URLROOT; ?>/js/disease/viewReports.js"></script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>