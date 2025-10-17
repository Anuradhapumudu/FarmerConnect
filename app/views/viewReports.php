<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<div class="content-card">
    <div class="content-header">
        <h1>📋 Submitted Reports</h1>
        <p class="content-subtitle">View all submitted disease reports</p>
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
                                <div class="action-buttons">
                                    <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-info btn-xs" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-primary btn-xs" title="Edit Report">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/disease/confirmDelete/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-danger btn-xs" title="Delete Report">
                                        <i class="fas fa-trash"></i>
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
            <p>No disease reports have been submitted yet. Be the first to create a report!</p>
            <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success">
                <i class="fas fa-plus"></i> Create New Report
            </a>
        </div>
    <?php endif; ?>
</div>

<style>
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
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'all 0.3s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>
