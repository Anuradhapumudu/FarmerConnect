<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<div class="content-card">
    <div class="content-header">
        <h1><?php echo isset($data['singleReport']) && $data['singleReport'] ? '📋 Report Details' : '📋 Submitted Reports'; ?></h1>
        <p class="content-subtitle"><?php echo isset($data['singleReport']) && $data['singleReport'] ? 'Detailed view of the selected disease report' : 'View all submitted disease reports'; ?></p>
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

    <?php if (isset($data['singleReport']) && $data['singleReport'] && isset($data['report'])): ?>
        <?php $report = $data['report']; ?>
        <!-- Single Report Details View -->
        <div class="report-header-card">
            <div class="report-header-content">
                <div class="report-title-section">
                    <h2><?php echo htmlspecialchars($report->title); ?></h2>
                    <div class="report-code-display">
                        <span class="report-code"><?php echo htmlspecialchars($report->report_code); ?></span>
                    </div>
                </div>
                <div class="report-status-badges">
                    <span class="severity-badge severity-<?php echo $report->severity; ?>">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo ucfirst($report->severity); ?> Severity
                    </span>
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
                    <?php endif; ?>
                </div>
            </div>
            <div class="report-actions">
                <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo htmlspecialchars($report->report_code); ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Report
                </a>
                <button type="button" class="btn btn-danger" onclick="openDeleteModal('<?php echo htmlspecialchars($report->report_code); ?>', '<?php echo htmlspecialchars(addslashes($report->title)); ?>', '<?php echo htmlspecialchars($report->farmerNIC); ?>')">
                    <i class="fas fa-trash"></i> Delete Report
                </button>
                <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Reports
                </a>
            </div>
        </div>

        <!-- Clean Overview Section -->
        <div class="report-overview">
            <div class="overview-grid">
                <div class="overview-card">
                    <div class="overview-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Farmer Details</h4>
                        <p><strong>NIC:</strong> <?php echo htmlspecialchars($report->farmerNIC); ?></p>
                        <p><strong>PLR:</strong> <?php echo htmlspecialchars($report->pirNumber); ?></p>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Observation Date</h4>
                        <p class="date-large"><?php echo date('M d, Y', strtotime($report->observationDate)); ?></p>
                        <p class="date-small"><?php echo date('l, F jS Y', strtotime($report->observationDate)); ?></p>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-icon">
                        <i class="fas fa-chart-area"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Affected Area</h4>
                        <p class="area-large"><?php echo number_format($report->affectedArea, 1); ?> <span>acres</span></p>
                        <p class="area-conversion"><?php echo number_format($report->affectedArea * 0.405, 1); ?> hectares</p>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Report Submitted</h4>
                        <p class="date-large"><?php echo date('M d, Y', strtotime($report->submission_timestamp ?? 'now')); ?></p>
                        <p class="date-small"><?php echo date('g:i A', strtotime($report->submission_timestamp ?? 'now')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="description-section">
            <div class="section-header">
                <h3><i class="fas fa-file-alt"></i> Report Description</h3>
            </div>
            <div class="description-content">
                <div class="description-text">
                    <?php echo nl2br(htmlspecialchars($report->description)); ?>
                </div>
            </div>
        </div>

        <!-- Media Section -->
        <?php if (!empty($report->media)): ?>
            <div class="media-section">
                <div class="section-header">
                    <h3><i class="fas fa-images"></i> Media Files (<?php echo count(array_filter(explode(',', $report->media))); ?>)</h3>
                </div>
                <div class="media-content">
                    <div class="media-grid">
                        <?php
                        $mediaFiles = explode(',', $report->media);
                        foreach ($mediaFiles as $filename):
                            $filename = trim($filename);
                            if (empty($filename)) continue;
                            $fileUrl = URLROOT . '/disease/viewMedia/' . $report->report_code . '/' . urlencode($filename);
                            $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']);
                            $isVideo = in_array($fileExt, ['mp4', 'avi', 'mov', 'wmv']);
                        ?>
                            <div class="media-item" onclick="openFullscreenModal('<?php echo $fileUrl; ?>', '<?php echo $isImage ? 'image' : ($isVideo ? 'video' : 'other'); ?>', '<?php echo $fileExt; ?>', '<?php echo htmlspecialchars($filename); ?>')">
                                <?php if ($isImage): ?>
                                    <img src="<?php echo $fileUrl; ?>" alt="Media file" loading="lazy">
                                <?php elseif ($isVideo): ?>
                                    <video muted>
                                        <source src="<?php echo $fileUrl; ?>" type="video/<?php echo $fileExt; ?>">
                                        <i class="fas fa-play-circle media-play-icon"></i>
                                    </video>
                                <?php else: ?>
                                    <div class="file-preview">
                                        <div class="file-icon"><i class="fas fa-file"></i></div>
                                        <span><?php echo htmlspecialchars($filename); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="media-badge"><?php echo strtoupper($fileExt); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Officer Responses Section -->
        <?php if (!empty($data['officer_responses'])): ?>
            <div class="responses-section">
                <div class="section-header">
                    <h3><i class="fas fa-user-md"></i> Officer Responses (<?php echo count($data['officer_responses']); ?>)</h3>
                </div>
                <div class="responses-content">
                    <?php foreach ($data['officer_responses'] as $response): ?>
                        <div class="response-card">
                            <div class="response-header">
                                <div class="officer-info">
                                    <i class="fas fa-user-md"></i>
                                    <span class="officer-label">Agricultural Officer</span>
                                </div>
                                <div class="response-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo date('M d, Y \a\t g:i A', strtotime($response->created_at)); ?>
                                </div>
                            </div>
                            <div class="response-message">
                                <div class="message-content">
                                    <?php echo nl2br(htmlspecialchars($response->response_message)); ?>
                                </div>
                                <?php if (!empty($response->response_media)): ?>
                                    <div class="response-media">
                                        <div class="media-label">
                                            <i class="fas fa-paperclip"></i> Attached Files:
                                        </div>
                                        <div class="media-files">
                                            <?php
                                            $mediaFiles = explode(',', $response->response_media);
                                            foreach ($mediaFiles as $filename):
                                                $filename = trim($filename);
                                                if (empty($filename)) continue;
                                                $fileUrl = URLROOT . '/officer/viewResponseMedia/' . $response->id . '/' . urlencode($filename);
                                                $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                                $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']);
                                                $isVideo = in_array($fileExt, ['mp4', 'avi', 'mov', 'wmv']);
                                            ?>
                                                <div class="response-media-item" onclick="openFullscreenModal('<?php echo $fileUrl; ?>', '<?php echo $isImage ? 'image' : ($isVideo ? 'video' : 'other'); ?>', '<?php echo $fileExt; ?>', '<?php echo htmlspecialchars($filename); ?>')">
                                                    <?php if ($isImage): ?>
                                                        <img src="<?php echo $fileUrl; ?>" alt="Response media" loading="lazy">
                                                    <?php elseif ($isVideo): ?>
                                                        <video muted>
                                                            <source src="<?php echo $fileUrl; ?>" type="video/<?php echo $fileExt; ?>">
                                                            <i class="fas fa-play-circle media-play-icon"></i>
                                                        </video>
                                                    <?php else: ?>
                                                        <div class="file-preview">
                                                            <div class="file-icon"><i class="fas fa-file"></i></div>
                                                            <span><?php echo htmlspecialchars($filename); ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="media-badge"><?php echo strtoupper($fileExt); ?></div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="no-responses-section">
                <div class="section-header">
                    <h3><i class="fas fa-user-md"></i> Officer Responses</h3>
                </div>
                <div class="no-responses-content">
                    <div class="no-responses-icon">
                        <?php
                        switch ($report->status) {
                            case 'pending':
                                echo '<i class="fas fa-clock text-warning"></i>';
                                break;
                            case 'under_review':
                                echo '<i class="fas fa-search text-info"></i>';
                                break;
                            case 'resolved':
                                echo '<i class="fas fa-check-circle text-success"></i>';
                                break;
                            case 'rejected':
                                echo '<i class="fas fa-times-circle text-danger"></i>';
                                break;
                            default:
                                echo '<i class="fas fa-clock text-secondary"></i>';
                        }
                        ?>
                    </div>
                    <h4>
                        <?php
                        switch ($report->status) {
                            case 'pending':
                                echo 'Report Submitted';
                                break;
                            case 'under_review':
                                echo 'Under Review';
                                break;
                            case 'resolved':
                                echo 'Report Resolved';
                                break;
                            case 'rejected':
                                echo 'Report Rejected';
                                break;
                            default:
                                echo 'Status Unknown';
                        }
                        ?>
                    </h4>
                    <p>
                        <?php
                        switch ($report->status) {
                            case 'pending':
                                echo 'Your report has been submitted and is waiting to be reviewed by agricultural officers. You will receive a response soon.';
                                break;
                            case 'under_review':
                                echo 'Your report is currently being reviewed by agricultural officers. They will provide recommendations or solutions shortly.';
                                break;
                            case 'resolved':
                                echo 'This report has been resolved. However, no specific response was recorded. Please contact the agricultural office for more details.';
                                break;
                            case 'rejected':
                                echo 'This report was not accepted for processing. Please contact the agricultural office for more information about the rejection.';
                                break;
                            default:
                                echo 'The status of your report is currently unknown. Please contact the agricultural office for assistance.';
                        }
                        ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>


    <?php elseif (!empty($data['reports'])): ?>
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
                                       class="btn btn-info btn-xs" title="View All Reports">
                                       <i class="fas fa-eye"></i>
                                   </a>
                                    <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-primary btn-xs" title="Edit Report">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-xs" title="Delete Report"
                                            onclick="openDeleteModal('<?php echo htmlspecialchars($report->report_code); ?>', '<?php echo htmlspecialchars(addslashes($report->title)); ?>', '<?php echo htmlspecialchars($report->farmerNIC); ?>')">
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
        background: blue !important;
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

    .report-header-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 25px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .report-header-content {
        flex: 1;
    }

    .report-title-section h2 {
        color: var(--text-primary);
        font-size: 1.8rem;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .report-code-display {
        margin-bottom: 15px;
    }

    .report-code {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: var(--primary);
        background: rgba(46, 125, 50, 0.1);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
    }

    .report-status-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .severity-badge, .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
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

    .report-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }

    /* Clean Overview Section */
    .report-overview {
        margin-bottom: 40px;
    }

    .overview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .overview-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: var(--transition);
    }

    .overview-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .overview-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .overview-content h4 {
        color: var(--text-primary);
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 8px 0;
    }

    .overview-content p {
        margin: 4px 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .date-large {
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        color: var(--primary) !important;
        margin: 0 0 2px 0 !important;
    }

    .date-small {
        font-size: 0.8rem !important;
        color: var(--text-secondary) !important;
        margin: 0 !important;
    }

    .area-large {
        font-size: 1.4rem !important;
        font-weight: 800 !important;
        color: var(--primary) !important;
        margin: 0 0 2px 0 !important;
    }

    .area-large span {
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .area-conversion {
        font-size: 0.8rem !important;
        color: var(--text-secondary) !important;
        margin: 0 !important;
        opacity: 0.8;
    }

    /* Section Headers */
    .section-header {
        margin-bottom: 20px;
    }

    .section-header h3 {
        color: var(--text-primary);
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-header h3 i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* Description Section */
    .description-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 24px;
        margin-bottom: 30px;
    }

    .description-content {
        background: rgba(46, 125, 50, 0.02);
        border-radius: 12px;
        padding: 20px;
        border-left: 4px solid var(--primary);
    }

    .description-text {
        color: var(--text-primary);
        line-height: 1.6;
        font-size: 1rem;
        margin: 0;
    }

    /* Media Section */
    .media-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 24px;
        margin-bottom: 30px;
    }

    .media-content {
        background: rgba(46, 125, 50, 0.02);
        border-radius: 12px;
        padding: 20px;
    }

    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
    }

    .media-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 1;
        background: rgba(46, 125, 50, 0.05);
        cursor: pointer;
        transition: var(--transition);
        border: 2px solid rgba(46, 125, 50, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .media-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-color: var(--primary);
    }

    .media-item img, .media-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .media-item:hover img, .media-item:hover video {
        transform: scale(1.05);
    }

    .media-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.9);
        pointer-events: none;
        z-index: 2;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    .media-item:hover .media-play-icon {
        color: rgba(255, 255, 255, 1);
        transform: translate(-50%, -50%) scale(1.1);
    }

    .media-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    .file-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--text-secondary);
        text-decoration: none;
        background: rgba(46, 125, 50, 0.08);
        border: 2px dashed rgba(46, 125, 50, 0.3);
        transition: var(--transition);
    }

    .media-item:hover .file-preview {
        background: rgba(46, 125, 50, 0.12);
        border-color: var(--primary);
    }

    .file-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
        opacity: 0.8;
    }

    .file-preview span {
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        padding: 0 8px;
        word-break: break-word;
    }

    /* Officer Responses Section */
    .responses-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 24px;
        margin-bottom: 30px;
    }

    .responses-content {
        background: rgba(46, 125, 50, 0.02);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .response-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(46, 125, 50, 0.1);
        overflow: hidden;
    }

    .response-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .officer-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }

    .officer-info i {
        font-size: 1.1rem;
    }

    .officer-label {
        font-size: 0.9rem;
    }

    .response-date {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        opacity: 0.9;
    }

    .response-date i {
        font-size: 0.8rem;
    }

    .response-message {
        padding: 20px;
    }

    .message-content {
        color: var(--text-primary);
        line-height: 1.6;
        font-size: 1rem;
        margin-bottom: 16px;
    }

    .response-media {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding-top: 16px;
    }

    .media-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .media-files {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
    }

    .response-media-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
        background: rgba(46, 125, 50, 0.05);
        cursor: pointer;
        transition: var(--transition);
        border: 2px solid rgba(46, 125, 50, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .response-media-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-color: var(--primary);
    }

    .response-media-item img, .response-media-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .response-media-item:hover img, .response-media-item:hover video {
        transform: scale(1.05);
    }

    .no-responses-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 24px;
        margin-bottom: 30px;
    }

    .no-responses-content {
        background: rgba(46, 125, 50, 0.02);
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        border: 2px dashed rgba(46, 125, 50, 0.2);
    }

    .no-responses-icon {
        font-size: 3rem;
        color: #f57c00;
        margin-bottom: 16px;
        opacity: 0.8;
    }

    .no-responses-content h4 {
        color: var(--text-primary);
        font-size: 1.2rem;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .no-responses-content p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 0;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: none;
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

    .btn-outline-secondary {
        background: transparent;
        color: var(--text-secondary);
        border: 1px solid rgba(0, 0, 0, 0.2);
    }

    .btn-outline-secondary:hover {
        background: var(--text-secondary);
        color: white;
        transform: translateY(-1px);
    }

    .text-center {
        text-align: center;
    }

    .text-muted {
        color: var(--text-secondary);
    }

    /* Fullscreen Modal Styles */
    .fullscreen-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.98);
        backdrop-filter: blur(8px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 0;
        box-sizing: border-box;
    }

    .fullscreen-modal.active {
        display: flex;
    }

    .fullscreen-modal-content {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        box-sizing: border-box;
    }

    .fullscreen-modal img, .fullscreen-modal video {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .fullscreen-modal .close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: white;
        font-size: 2.2rem;
        cursor: pointer;
        background: rgba(0,0,0,0.9);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 2px solid rgba(255,255,255,0.4);
        z-index: 10002;
        line-height: 1;
    }

    .fullscreen-modal .close:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
        border-color: rgba(255,255,255,0.7);
    }

    .fullscreen-modal .filename-display {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        background: rgba(0,0,0,0.8);
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 500;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        z-index: 10001;
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
        transition: background-color 0.3s ease;
    }

    .confirmation-section.checked {
        background-color: red;
        color: white;
    }

    .confirmation-section.checked .form-check-label {
        color: white;
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

        .btn {
            padding: 6px 10px;
            font-size: 11px;
        }

        .overview-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .overview-card {
            padding: 20px;
        }

        .description-section,
        .media-section {
            padding: 20px;
        }

        .report-header-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .report-actions {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .report-actions .btn {
            flex: 1;
            text-align: center;
        }

        .responses-content {
            padding: 15px;
        }

        .response-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .response-message {
            padding: 16px;
        }

        .media-files {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
        }

        .no-responses-content {
            padding: 30px 15px;
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
//delete functionality
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

//media view
window.openFullscreenModal = function(fileUrl, mediaType, fileExt, filename) {
    // Create modal elements
    const modal = document.createElement('div');
    modal.className = 'fullscreen-modal active';
    modal.onclick = function(e) {
        if (e.target === modal) closeFullscreenModal();
    };

    const modalContent = document.createElement('div');
    modalContent.className = 'fullscreen-modal-content';

    // Close button
    const closeBtn = document.createElement('span');
    closeBtn.className = 'close';
    closeBtn.innerHTML = '&times;';
    closeBtn.onclick = closeFullscreenModal;

    // Media content
    let mediaElement;
    if (mediaType === 'image') {
        mediaElement = document.createElement('img');
        mediaElement.src = fileUrl;
        mediaElement.alt = filename;
    } else if (mediaType === 'video') {
        mediaElement = document.createElement('video');
        mediaElement.src = fileUrl;
        mediaElement.controls = true;
    }

    // Assemble modal
    modalContent.appendChild(closeBtn);
    modalContent.appendChild(mediaElement);
    modal.appendChild(modalContent);

    // Add to page
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';

    function closeFullscreenModal() {
        modal.remove();
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeFullscreenModal();
    });
};

// Modal event listeners
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('confirm-delete-checkbox');
    const confirmationSection = document.querySelector('.confirmation-section');

    checkbox.addEventListener('change', function() {
        document.getElementById('confirm-delete-btn').disabled = !this.checked;
        if (this.checked) {
            confirmationSection.classList.add('checked');
        } else {
            confirmationSection.classList.remove('checked');
        }
    });

    document.addEventListener('keydown', e => e.key === 'Escape' && closeDeleteModal());
    document.getElementById('deleteModal').addEventListener('click', e => e.target === document.getElementById('deleteModal') && closeDeleteModal());
});
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>