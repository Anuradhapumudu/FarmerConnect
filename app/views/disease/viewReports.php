<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<div class="content-card">
    <div class="content-header">
        <h1>📋 Submitted Reports</h1>
        <p class="content-subtitle">View all submitted disease reports</p>

        <div class = "create-report-btn">
        <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success">
            <i class="fas fa-plus"></i> Create New Report
        </a>
    </div>
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
                        <th>Officer Response</th>
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
                                <?php if (isset($report->status)): ?>
                                    <span class="status-badge status-<?php echo $report->status; ?>">
                                        <i class="fas fa-<?php
                                            switch ($report->status) {
                                                case 'pending': echo 'clock'; break;
                                                case 'under_review': echo 'eye'; break;
                                                case 'resolved': echo 'check-circle'; break;
                                                case 'rejected': echo 'times-circle'; break;
                                                default: echo 'question-circle';
                                            }
                                        ?>"></i>
                                        <?php echo ucfirst(str_replace('_', ' ', $report->status)); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge status-unknown">
                                        <i class="fas fa-question-circle"></i> Unknown
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div><?php echo date('M d, Y', strtotime($report->observationDate)); ?></div>
                                    <small><?php echo number_format($report->affectedArea, 1); ?> acres</small>
                                </div>
                            </td>
                            <td>
                                <div class="officer-response">
                                    <?php if (!empty($report->officer_responses)): ?>
                                        <?php $latest_response = end($report->officer_responses); ?>
                                        <div class="response-preview">
                                            <i class="fas fa-user-md text-success"></i>
                                            <small class="text-muted">
                                                <?php echo htmlspecialchars(substr($latest_response->response_message, 0, 50)); ?>
                                                <?php if (strlen($latest_response->response_message) > 50): ?>...<?php endif; ?>
                                            </small>
                                            <br>
                                            <small class="text-secondary">
                                                <?php echo date('M d, Y H:i', strtotime($latest_response->created_at)); ?>
                                            </small>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-response">
                                            <i class="fas fa-clock text-warning"></i>
                                            <small class="text-muted">Pending</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-info btn-xs" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-primary btn-xs" title="Edit Report">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-xs" title="Delete Report"
                                            onclick="event.stopPropagation(); openDeleteModal('<?php echo htmlspecialchars($report->report_code); ?>', '<?php echo htmlspecialchars(addslashes($report->title)); ?>', '<?php echo htmlspecialchars($report->farmerNIC); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
            <p>No disease reports have been submitted yet. Be the first to create a report!</p>
            <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success">
                <i class="fas fa-plus"></i> Create New Report
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fas fa-exclamation-triangle text-danger"></i>
                Confirm Report Deletion
            </h4>
            <button type="button" class="close-btn" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="warning-message">
                <p class="warning-text">
                    <strong>Are you sure you want to delete this report?</strong>
                </p>
                <div class="report-info">
                    <p><strong>Report ID:</strong> <span id="modal-report-code"></span></p>
                    <p><strong>Title:</strong> <span id="modal-report-title"></span></p>
                    <p><strong>Farmer NIC:</strong> <span id="modal-farmer-nic"></span></p>
                </div>
                <p class="danger-text">
                    <i class="fas fa-exclamation-circle"></i>
                    This action cannot be undone. The report and all associated media files will be permanently deleted.
                </p>
            </div>
            <div class="confirmation-section">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirm-delete-checkbox" required>
                    <label class="form-check-label" for="confirm-delete-checkbox">
                        I understand that this action is permanent and cannot be undone
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirm-delete-btn" onclick="confirmDelete()" disabled>
                <i class="fas fa-trash"></i> Delete Report
            </button>
        </div>
    </div>
</div>

<!-- Hidden form for deletion -->
<form id="deleteForm" method="POST" action="" style="display: none;">
    <input type="hidden" name="confirmDelete" value="1">
</form>

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

    .status-pending {
        background: rgba(255, 193, 7, 0.2);
        color: #f57c00;
    }

    .status-under_review {
        background: rgba(33, 150, 243, 0.2);
        color: #1976d2;
    }

    .status-resolved {
        background: rgba(76, 175, 80, 0.2);
        color: #2e7d32;
    }

    .status-rejected {
        background: rgba(244, 67, 54, 0.2);
        color: #c62828;
    }

    .status-unknown {
        background: rgba(158, 158, 158, 0.2);
        color: #616161;
    }

    .date-info div {
        font-weight: 600;
        color: var(--text-primary);
    }

    .date-info small {
        color: var(--text-secondary);
        font-size: 13px;
    }

    .officer-response {
        max-width: 200px;
    }

    .response-preview {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .response-preview i {
        font-size: 12px;
    }

    .no-response {
        display: flex;
        align-items: center;
        gap: 4px;
        color: #f57c00;
    }

    .no-response i {
        font-size: 12px;
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

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-danger {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }

    .btn-danger:hover {
        background: rgba(220, 53, 69, 1);
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

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn 0.3s ease;
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #495057;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6c757d;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        transition: all 0.2s;
    }

    .close-btn:hover {
        background: #f8f9fa;
        color: #495057;
    }

    .modal-body {
        padding: 20px 25px;
    }

    .warning-message {
        text-align: center;
        margin-bottom: 20px;
    }

    .warning-text {
        font-size: 1.1rem;
        color: #495057;
        margin-bottom: 15px;
    }

    .report-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
        text-align: left;
    }

    .report-info p {
        margin: 5px 0;
        font-size: 0.9rem;
    }

    .danger-text {
        color: #dc3545;
        font-weight: 500;
        font-size: 0.9rem;
        margin: 15px 0;
    }

    .confirmation-section {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }

    .form-check {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .form-check-input {
        margin-top: 2px;
    }

    .form-check-label {
        font-weight: 500;
        color: #856404;
        cursor: pointer;
    }

    .modal-footer {
        padding: 15px 25px;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
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

        .officer-response {
            max-width: 150px;
        }

        .response-preview small {
            font-size: 11px;
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

    // view details on row click
    document.querySelectorAll('.reports-table tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            this.querySelector('.btn-info').click();
        });
    });

    //filtering
    const filters = ['date-filter', 'severity-filter', 'status-filter'];
    filters.forEach(id => {
        document.getElementById(id).addEventListener('change', filterReports);
    });

    document.getElementById('clear-filters').addEventListener('click', function() {
        filters.forEach(id => document.getElementById(id).value = '');
        document.querySelectorAll('.reports-table tbody tr').forEach(row => row.style.display = '');
    });

    function filterReports() {
        const date = document.getElementById('date-filter').value;
        const severity = document.getElementById('severity-filter').value.toLowerCase();
        const status = document.getElementById('status-filter').value.toLowerCase();

        document.querySelectorAll('.reports-table tbody tr').forEach(row => {
            const rowSeverity = row.querySelector('.severity-badge').textContent.toLowerCase().trim();
            const rowStatus = row.querySelector('.status-badge').textContent.toLowerCase().trim();
            const rowDate = row.querySelector('.date-info div').textContent;

            const matchesDate = !date || rowDate.includes(date);
            const matchesSeverity = !severity || rowSeverity.includes(severity);
            const matchesStatus = !status || rowStatus.replace(/\s+/g, '_').includes(status);

            row.style.display = (matchesDate && matchesSeverity && matchesStatus) ? '' : 'none';
        });
    }

    // delete function
    window.openDeleteModal = function(reportCode, title, farmerNic) {
        document.getElementById('modal-report-code').textContent = reportCode;
        document.getElementById('modal-report-title').textContent = title;
        document.getElementById('modal-farmer-nic').textContent = farmerNic;
        document.getElementById('deleteModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('confirm-delete-checkbox').checked = false;
        document.getElementById('confirm-delete-btn').disabled = true;
        document.getElementById('deleteForm').action = '<?php echo URLROOT; ?>/disease/deleteReport/' + reportCode;
    };

    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    window.confirmDelete = function() {
        if (!document.getElementById('confirm-delete-checkbox').checked) {
            alert('Please check the confirmation box before proceeding.');
            return;
        }
        document.getElementById('deleteForm').submit();
    };

    //event listeners
    document.getElementById('confirm-delete-checkbox').addEventListener('change', function() {
        document.getElementById('confirm-delete-btn').disabled = !this.checked;
    });

    document.addEventListener('keydown', e => e.key === 'Escape' && closeDeleteModal());
    document.getElementById('deleteModal').addEventListener('click', e => e.target === document.getElementById('deleteModal') && closeDeleteModal());
});
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>
