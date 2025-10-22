<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/reportDetail.css?v=<?= time(); ?>">

<div class="content-card">
    <div class="content-header">
        <h1><?php echo isset($data['singleReport']) && $data['singleReport'] ? 'Report Details' : 'Submitted Reports'; ?></h1>
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
                <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Reports
                </a>
                <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo htmlspecialchars($report->report_code); ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Report
                </a>
                <button type="button" class="btn btn-danger" onclick="openDeleteModal('<?php echo htmlspecialchars($report->report_code); ?>', '<?php echo htmlspecialchars(addslashes($report->title)); ?>', '<?php echo htmlspecialchars($report->farmerNIC); ?>')">
                    <i class="fas fa-trash"></i> Delete Report
                </button>
            </div>
        </div>

        <!-- Clean Overview Section -->
        <div class="report-overview">
            <div class="overview-grid">
                <div class="overview-card">
                    <div class="overview-icon farmer">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Farmer Details</h4>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($report->farmer_name ?? $report->farmerNIC); ?></p>
                        <p><strong>NIC:</strong> <?php echo htmlspecialchars($report->farmerNIC); ?></p>
                        <p><strong>PLR:</strong> <?php echo htmlspecialchars($report->pirNumber); ?></p>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-icon date">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Observation Date</h4>
                        <p class="date-large"><?php echo date('M d, Y', strtotime($report->observationDate)); ?></p>
                        <p class="date-small"><?php echo date('l, F jS Y', strtotime($report->observationDate)); ?></p>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-icon paddy">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Paddy Size</h4>
                        <?php if (!empty($report->paddySize)): ?>
                            <p class="area-large"><?php echo number_format($report->paddySize, 1); ?> <span>acres</span></p>
                            <p class="area-conversion"><?php echo number_format($report->paddySize * 0.405, 1); ?> hectares</p>
                        <?php else: ?>
                            <p class="area-large">N/A</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-icon affected">
                        <i class="fas fa-virus"></i>
                    </div>
                    <div class="overview-content">
                        <h4>Area Affected by Disease</h4>
                        <p class="area-large"><?php echo number_format($report->affectedArea, 1); ?> <span>acres</span></p>
                        <p class="area-conversion"><?php echo number_format($report->affectedArea * 0.405, 1); ?> hectares</p>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-icon submitted">
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
                <p><?php echo nl2br(htmlspecialchars($report->description)); ?></p>
            </div>
        </div>

        <!-- Media Section -->
        <?php if (!empty($report->media)): ?>
            <div class="media-section">
                <div class="section-header">
                    <h3><i class="fas fa-images"></i> Media Files</h3>
                    <span class="count">(<?php echo count(array_filter(explode(',', $report->media))); ?>)</span>
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
                                <div class="media-wrapper">
                                    <?php if ($isImage): ?>
                                        <img src="<?php echo $fileUrl; ?>" alt="Media file" loading="lazy">
                                    <?php elseif ($isVideo): ?>
                                        <video muted>
                                            <source src="<?php echo $fileUrl; ?>" type="video/<?php echo $fileExt; ?>">
                                            <i class="fas fa-play-circle play-overlay"></i>
                                        </video>
                                    <?php else: ?>
                                        <div class="file-preview">
                                            <div class="file-icon"><i class="fas fa-file"></i></div>
                                            <span><?php echo htmlspecialchars($filename); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
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
                    <h3><i class="fas fa-user-md"></i> Officer Responses</h3>
                    <span class="count">(<?php echo count($data['officer_responses']); ?>)</span>
                </div>
                <div class="responses-timeline">
                    <?php foreach ($data['officer_responses'] as $response): ?>
                        <div class="response-card">
                            <div class="response-indicator"></div>
                            <div class="response-header">
                                <div class="officer-info">
                                    <div class="officer-avatar">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div>
                                        <span class="officer-label">Agricultural Officer</span>
                                        <div class="response-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            <?php echo date('M d, Y \a\t g:i A', strtotime($response->created_at)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="response-message">
                                <p><?php echo nl2br(htmlspecialchars($response->response_message)); ?></p>
                                <?php if (!empty($response->response_media)): ?>
                                    <div class="response-media">
                                        <div class="media-label">
                                            <i class="fas fa-paperclip"></i> Attached Files:
                                        </div>
                                        <div class="response-media-grid">
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
                                                            <i class="fas fa-play-circle play-overlay-small"></i>
                                                        </video>
                                                    <?php else: ?>
                                                        <div class="file-preview-small">
                                                            <i class="fas fa-file"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="media-badge-small"><?php echo strtoupper($fileExt); ?></div>
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
                                    <div><?php echo htmlspecialchars($report->farmer_name ?? $report->farmerNIC); ?></div>
                                    <small>NIC: <?php echo htmlspecialchars($report->farmerNIC); ?> | PLR: <?php echo htmlspecialchars($report->pirNumber); ?></small>
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
                                    <div class="date-text"><?php echo date('M d, Y', strtotime($report->observationDate)); ?></div>
                                    <div class="area-info">
                                        <?php if (!empty($report->paddySize)): ?>
                                            <span><i class="fas fa-leaf"></i> <?php echo number_format($report->paddySize, 1); ?> acres</span>
                                        <?php endif; ?>
                                        <span class="separator">•</span>
                                        <span><i class="fas fa-exclamation-triangle"></i> <?php echo number_format($report->affectedArea, 1); ?> acres</span>
                                    </div>
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
                                       class="btn btn-info btn-sm" title="View Details">
                                       <i class="fas fa-eye"></i>
                                   </a>
                                    <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo htmlspecialchars($report->report_code); ?>"
                                       class="btn btn-primary btn-sm" title="Edit Report">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" title="Delete Report"
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
<style>
    .content-header h1 {
        color: #2e7d32;
        font-size: 2.8rem;
        margin-bottom: 10px;
        font-weight: 800;
        text-align: center;
        border-bottom: 2px solid #c8e6c9;
    }
    .content-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin: 10px 0;
        text-align: center;
    }
</style>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>