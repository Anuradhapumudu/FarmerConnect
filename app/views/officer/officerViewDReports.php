<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <div><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <div><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    </div>
<?php endif; ?>

<div class="main-content-container main-content">
    <div class="page-header">
        <div class="header-text">
            <h1><i class="fas fa-microscope"></i> Disease Reports</h1>
            <p>Monitor and manage crop disease incidents reported by farmers</p>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <span class="stat-value"><?php echo count($data['reports'] ?? []); ?></span>
                <span class="stat-label">Total Reports</span>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-container glass-panel">
        <div class="filter-row">
            <div class="filter-group search-group">
                <label>NIC</label>
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="farmernic-filter" class="filter-input" placeholder="Search by Farmer NIC...">
            </div>
            
            <div class="filter-separator"></div>

            <div class="filter-group">
                <label>Date</label>
                <input type="date" id="date-filter" class="filter-input date-input">
            </div>

            <div class="filter-group">
                <label>Severity</label>
                <div class="select-wrapper">
                    <select id="severity-filter" class="filter-select">
                        <option value="">All Levels</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>

            <div class="filter-group">
                <label>Status</label>
                <div class="select-wrapper">
                    <select id="status-filter" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="under_review">Under Review</option>
                        <option value="resolved">Resolved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <button id="clear-filters" class="btn-reset" title="Reset Filters">
                <i class="fas fa-redo-alt"></i>
            </button>
        </div>
    </div>

    <?php if (!empty($data['reports'])): ?>
        <div class="table-container glass-panel">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th width="100">Code</th>
                        <th width="30%">Report Details</th>
                        <th>Farmer</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Date & Area</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['reports'] as $report): ?>
                        <tr data-href="<?php echo URLROOT; ?>/officerDashboard/viewReport/<?php echo htmlspecialchars($report->report_code); ?>">
                            <td>
                                <span class="badge badge-code"><?php echo htmlspecialchars($report->report_code); ?></span>
                            </td>
                            <td>
                                <div class="report-info">
                                    <div class="report-title"><?php echo htmlspecialchars($report->title); ?></div>
                                    <div class="report-preview">
                                        <?php 
                                            $desc = $report->description ?? '';
                                            echo htmlspecialchars(strlen($desc) > 50 ? substr($desc, 0, 50) . '...' : $desc); 
                                        ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="farmer-details">
                                    <div class="farmer-nic"><i class="fas fa-id-card"></i> <?php echo htmlspecialchars($report->farmerNIC); ?></div>
                                    <div class="plr-number"><i class="fas fa-map-marker-alt"></i> PLR: <?php echo htmlspecialchars($report->plrNumber); ?></div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge severity-<?php echo strtolower($report->severity); ?>">
                                    <span class="status-dot"></span>
                                    <?php echo ucfirst($report->severity); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo URLROOT; ?>/officerDashboard/updateReportStatus" class="status-form">
                                    <input type="hidden" name="reportCode" value="<?php echo htmlspecialchars($report->report_code); ?>">
                                    <input type="hidden" name="redirect_to" value="dashboard">
                                    <div class="status-select-container status-<?php echo $report->status; ?>">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="pending" <?php echo ($report->status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="under_review" <?php echo ($report->status == 'under_review') ? 'selected' : ''; ?>>Under Review</option>
                                            <option value="resolved" <?php echo ($report->status == 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                                            <option value="rejected" <?php echo ($report->status == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <div class="meta-date">
                                    <div><?php echo date('M d, Y', strtotime($report->observationDate)); ?></div>
                                    <small><?php echo number_format($report->affectedArea, 1); ?> ac</small>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state glass-panel">
            <div class="empty-illustration">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h3>All Caught Up!</h3>
            <p>There are no disease reports to display at the moment.</p>
        </div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/officer_view_reports.css">
<script src="<?php echo URLROOT; ?>/js/officer/officer_view_reports.js"></script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>