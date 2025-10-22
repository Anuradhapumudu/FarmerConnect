<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>

<div class="content-card">
    <div class="content-header">
        <h1>📋 Disease Reports Management</h1>
        <p class="content-subtitle">Review and manage submitted disease reports</p>
    </div>

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

    <?php if (isset($data['message'])): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div><?php echo htmlspecialchars($data['message']); ?></div>
        </div>
    <?php endif; ?>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filter-group">
            <label for="farmernic-filter" class="filter-label">Farmer NIC</label>
            <input type="number" id="farmernic-filter" class="filter-input" title="Filter by farmer NIC">
        </div>
        <div class="filter-group">
            <label for="date-filter" class="filter-label">Date</label>
            <input type="date" id="date-filter" class="filter-input" title="Filter by report date">
        </div>
        <div class="filter-group">
            <label for="severity-filter" class="filter-label">Severity</label>
            <select id="severity-filter" class="filter-select">
                <option value="">All</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="status-filter" class="filter-label">Status</label>
            <select id="status-filter" class="filter-select">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="under_review">Under Review</option>
                <option value="resolved">Resolved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="filter-group">
            <label>&nbsp;</label>
            <button id="clear-filters" class="btn btn-secondary">Clear</button>
        </div>
    </div>

    <?php if (!empty($data['reports'])): ?>
        <div class="reports-table-container">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Report Code</th>
                        <th>Title</th>
                        <th>Farmer Details</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Date & Area</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['reports'] as $report): ?>
                        <tr>
                            <td>
                                <span class="report-code"><?php echo htmlspecialchars($report->report_code); ?></span>
                            </td>
                            <td>
                                <div class="title-cell">
                                    <div class="report-title"><?php echo htmlspecialchars($report->title); ?></div>
                                    <small class="report-description">
                                        <?php echo htmlspecialchars(substr($report->description ?? '', 0, 60)); ?>
                                        <?php if (strlen($report->description ?? '') > 60): ?>...<?php endif; ?>
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="farmer-info">
                                    <div><?php echo htmlspecialchars($report->farmerNIC); ?></div>
                                    <small>PLR: <?php echo htmlspecialchars($report->pirNumber); ?></small>
                                </div>
                            </td>
                            <td>
                                <span class="severity-badge severity-<?php echo $report->severity; ?>">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <?php echo ucfirst($report->severity); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo URLROOT; ?>/officerDashboard/updateReportStatus" class="status-update-form">
                                    <input type="hidden" name="reportCode" value="<?php echo htmlspecialchars($report->report_code); ?>">
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        <option value="pending" <?php echo ($report->status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="under_review" <?php echo ($report->status == 'under_review') ? 'selected' : ''; ?>>Under Review</option>
                                        <option value="resolved" <?php echo ($report->status == 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                                        <option value="rejected" <?php echo ($report->status == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div><?php echo date('M d, Y', strtotime($report->observationDate)); ?></div>
                                    <small><?php echo number_format($report->affectedArea, 1); ?> acres</small>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo URLROOT; ?>/officerDashboard/viewReport/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-info btn-xs" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3>No Reports Found</h3>
            <p>No disease reports have been submitted yet.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    :root {
        --primary-dark: #1b5e20;
    }

    .content-card {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border-radius: 15px;
        padding: 30px;
        margin: 20px auto 40px;
        max-width: 1400px;
        width: 90%;
    }

    .content-header {
        margin-bottom: 30px;
        text-align: left;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 20px;
    }

    .content-header h1 {
        color: var(--text-primary);
        font-size: 2.2rem;
        margin-bottom: 10px;
        font-weight: 800;
    }

    .content-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin: 10px 0;
    }

    .alert {
        padding: 16px 20px;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .alert-success {
        background: rgba(212, 237, 218, 0.9);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: rgba(248, 215, 218, 0.9);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .alert-info {
        background: rgba(204, 229, 255, 0.9);
        color: #004085;
        border-left: 4px solid #17a2b8;
    }

    .reports-table-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .reports-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .reports-table th,
    .reports-table td {
        padding: 12px 18px;
        text-align: left;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .reports-table th {
        background: rgba(46, 125, 50, 0.1);
        font-weight: 600;
        color: var(--primary);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .reports-table tbody tr:hover {
        background: rgba(46, 125, 50, 0.05);
        cursor: pointer;
    }

    .report-code {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: var(--primary);
        background: rgba(46, 125, 50, 0.1);
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
    }

    .title-cell {
        max-width: 350px;
    }

    .report-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 4px;
    }

    .report-description {
        color: var(--text-secondary);
        font-size: 13px;
    }

    .farmer-info div {
        font-weight: 600;
        color: var(--text-primary);
    }

    .farmer-info small {
        color: var(--text-secondary);
        font-size: 13px;
    }

    .severity-badge, .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .severity-low, .severity-Low {
        background: rgba(76, 175, 80, 0.2);
        color: #2e7d32;
    }

    .severity-medium, .severity-Medium {
        background: rgba(255, 193, 7, 0.2);
        color: #f57c00;
    }

    .severity-high, .severity-High {
        background: rgba(244, 67, 54, 0.2);
        color: #c62828;
    }

    .status-select {
        padding: 4px 8px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        background: white;
        font-size: 12px;
        min-width: 120px;
    }

    .status-update-form {
        margin: 0;
    }

    .date-info div {
        font-weight: 600;
        color: var(--text-primary);
    }

    .date-info small {
        color: var(--text-secondary);
        font-size: 13px;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 12px;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: var(--transition);
    }

    .btn-info {
        background: rgba(23, 162, 184, 0.9);
        color: white;
    }

    .btn-info:hover {
        background: rgba(23, 162, 184, 1);
        transform: translateY(-1px);
    }

    .btn-success {
        background: var(--primary);
        color: white;
        padding: 12px 20px;
        font-size: 14px;
    }

    .btn-success:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: rgba(158, 158, 158, 0.9);
        color: white;
    }

    .btn-secondary:hover {
        background: rgba(158, 158, 158, 1);
        transform: translateY(-1px);
    }

    .filters-section {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        align-items: flex-end;
        background: rgba(46, 125, 50, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 8px;
        padding: 20px;
        border: 1px solid rgba(46, 125, 50, 0.2);
        justify-content: center;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 150px;
    }

    .filter-label {
        font-weight: 1000;
        color: var(--text-primary);
        font-size: 13px;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input, .filter-select {
        padding: 10px 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        color: var(--text-primary);
        font-size: 14px;
        transition: var(--transition);
    }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(46, 125, 50, 0.2);
    }

    .filter-input::placeholder {
        color: var(--text-secondary);
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        color: var(--text-secondary);
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
    }

    .empty-icon {
        font-size: 4rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .empty-state h3 {
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: var(--text-primary);
        font-weight: 700;
    }

    .empty-state p {
        margin-bottom: 30px;
        line-height: 1.6;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .content-card {
            padding: 20px;
            margin: 15px auto 30px;
            width: 95%;
        }

        .content-header h1 {
            font-size: 1.8rem;
        }

        .reports-table th,
        .reports-table td {
            padding: 10px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 4px;
        }

        .btn {
            padding: 6px 10px;
            font-size: 11px;
        }

        .modal-content {
            width: 95%;
            margin: 20px;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 15px 20px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // auto hide alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);

    // view details on row click (excluding status select)
    document.querySelectorAll('.reports-table tbody tr').forEach(row => {
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking on status select or its form
            if (!e.target.closest('.status-select') && !e.target.closest('.status-update-form')) {
                const link = this.querySelector('.btn-info');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });

    //filtering
    const filters = ['farmernic-filter', 'date-filter', 'severity-filter', 'status-filter'];
    filters.forEach(id => {
        document.getElementById(id).addEventListener('change', filterReports);
    });

    document.getElementById('clear-filters').addEventListener('click', function() {
        filters.forEach(id => document.getElementById(id).value = '');
        document.querySelectorAll('.reports-table tbody tr').forEach(row => row.style.display = '');
    });

    function filterReports() {
        const nic = document.getElementById('farmernic-filter').value;
        const date = document.getElementById('date-filter').value;
        const severity = document.getElementById('severity-filter').value.toLowerCase();
        const status = document.getElementById('status-filter').value.toLowerCase();

        document.querySelectorAll('.reports-table tbody tr').forEach(row => {
            const rowNic = row.querySelector('.farmer-info div').textContent.trim();
            const rowSeverity = row.querySelector('.severity-badge').textContent.toLowerCase().trim();
            const rowStatus = row.querySelector('.status-select').value.toLowerCase().trim();
            const rowDate = row.querySelector('.date-info div').textContent;

            const matchesNic = !nic || rowNic.includes(nic);
            const matchesDate = !date || rowDate.includes(date);
            const matchesSeverity = !severity || rowSeverity.includes(severity);
            const matchesStatus = !status || rowStatus.includes(status);

            row.style.display = (matchesNic && matchesDate && matchesSeverity && matchesStatus) ? '' : 'none';
        });
    }
});
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>