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
                <a href="<?php echo URLROOT; ?>/disease/confirmDelete/<?php echo htmlspecialchars($report->report_code); ?>" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Report
                </a>
                <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Reports
                </a>
            </div>
        </div>

        <div class="report-details-grid">
            <div class="report-details-column">
                <div class="detail-card">
                    <div class="detail-header">
                        <h3><i class="fas fa-user"></i> Farmer Information</h3>
                    </div>
                    <div class="detail-content">
                        <div class="farmer-info">
                            <div class="info-item">
                                <span class="info-label">NIC Number:</span>
                                <span class="info-value"><?php echo htmlspecialchars($report->farmerNIC); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">PLR Number:</span>
                                <span class="info-value"><?php echo htmlspecialchars($report->plrNumber); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <h3><i class="fas fa-calendar-alt"></i> Observation Details</h3>
                    </div>
                    <div class="detail-content">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <p><strong>Observation Date:</strong> <?php echo date('F d, Y', strtotime($report->observationDate)); ?></p>
                                    <p class="text-muted">Date when the disease was first observed</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <p><strong>Report Submitted:</strong> <?php echo date('F d, Y \a\t g:i A', strtotime($report->submission_timestamp ?? 'now')); ?></p>
                                    <p class="text-muted">When this report was submitted to the system</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-details-column">
                <div class="detail-card">
                    <div class="detail-header">
                        <h3><i class="fas fa-chart-area"></i> Affected Area</h3>
                    </div>
                    <div class="detail-content">
                        <div class="area-display">
                            <div class="area-number"><?php echo number_format($report->affectedArea, 1); ?></div>
                            <div class="area-unit">Acres</div>
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <h3><i class="fas fa-file-alt"></i> Report Description</h3>
                    </div>
                    <div class="detail-content">
                        <p><?php echo nl2br(htmlspecialchars($report->description)); ?></p>
                    </div>
                </div>

                <?php if (!empty($report->media)): ?>
                    <div class="detail-card">
                        <div class="detail-header">
                            <h3><i class="fas fa-images"></i> Media Files</h3>
                        </div>
                        <div class="detail-content">
                            <div class="media-grid">
                                <?php
                                $mediaFiles = explode(',', $report->media);
                                $mediaIndex = 0;
                                foreach ($mediaFiles as $filename):
                                    $filename = trim($filename);
                                    if (empty($filename)) continue;
                                    $fileUrl = URLROOT . '/disease/viewMedia/' . $report->report_code . '/' . urlencode($filename);
                                    $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                    $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']);
                                    $isVideo = in_array($fileExt, ['mp4', 'avi', 'mov', 'wmv']);
                                ?>
                                    <div class="media-item" onclick="openModal('<?php echo $fileUrl; ?>', '<?php echo $isImage ? 'image' : ($isVideo ? 'video' : 'file'); ?>', <?php echo $mediaIndex; ?>)">
                                        <?php if ($isImage): ?>
                                            <img src="<?php echo $fileUrl; ?>" alt="Media file" loading="lazy">
                                        <?php elseif ($isVideo): ?>
                                            <video muted>
                                                <source src="<?php echo $fileUrl; ?>" type="video/<?php echo $fileExt; ?>">
                                                <i class="fas fa-play-circle media-play-icon"></i>
                                            </video>
                                        <?php else: ?>
                                            <a href="<?php echo $fileUrl; ?>" class="file-preview" target="_blank">
                                                <div class="file-icon"><i class="fas fa-file"></i></div>
                                                <span><?php echo htmlspecialchars($filename); ?></span>
                                            </a>
                                        <?php endif; ?>
                                        <div class="media-badge"><?php echo strtoupper($fileExt); ?></div>
                                    </div>
                                <?php
                                $mediaIndex++;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modal for media viewing -->
        <div id="mediaModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <button class="modal-nav modal-prev" onclick="navigateMedia(-1)" style="display: none;">&#10094;</button>
            <button class="modal-nav modal-next" onclick="navigateMedia(1)" style="display: none;">&#10095;</button>
            <div class="modal-content">
                <img id="modalImage" style="display: none;" alt="Media preview">
                <video id="modalVideo" controls style="display: none;" alt="Video preview"></video>
            </div>
            <div class="modal-counter" id="modalCounter" style="display: none;"></div>
        </div>

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
                                    <small>PLR: <?php echo htmlspecialchars($report->plrNumber); ?></small>
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

    .report-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .report-details-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .detail-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .detail-header {
        padding: 18px 20px;
        background: rgba(46, 125, 50, 0.05);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .detail-header h3 {
        color: var(--primary);
        font-size: 1.1rem;
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-content {
        padding: 20px;
    }

    .area-display {
        text-align: center;
    }

    .area-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .area-unit {
        color: var(--text-secondary);
        font-size: 1rem;
        font-weight: 500;
    }

    .farmer-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: var(--text-primary);
    }

    .info-value {
        color: var(--text-secondary);
        font-family: 'Courier New', monospace;
    }

    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline:before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: rgba(46, 125, 50, 0.3);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-marker {
        position: absolute;
        left: -1.5rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .timeline-marker.bg-info {
        background: #17a2b8;
    }

    .timeline-marker.bg-success {
        background: #28a745;
    }

    .timeline-marker.bg-warning {
        background: #ffc107;
    }

    .timeline-content {
        margin-left: 0.5rem;
    }

    .timeline-content p {
        margin: 0;
    }

    .timeline-content .text-muted {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .media-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
        background: #f8f8f8;
        cursor: pointer;
        transition: var(--transition);
        border: 2px solid rgba(0, 0, 0, 0.05);
    }

    .media-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .media-item img, .media-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .media-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.8);
        pointer-events: none;
        z-index: 2;
    }

    .media-item:hover .media-play-icon {
        color: rgba(255, 255, 255, 1);
        transform: translate(-50%, -50%) scale(1.1);
    }

    .media-badge {
        position: absolute;
        top: 6px;
        right: 6px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
    }

    .file-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--text-secondary);
        text-decoration: none;
        background: rgba(46, 125, 50, 0.05);
        border: 2px dashed rgba(46, 125, 50, 0.3);
    }

    .file-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
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

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.98);
        backdrop-filter: blur(8px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
        padding: 10px;
        box-sizing: border-box;
    }

    .modal-content {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: zoomIn 0.3s ease;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal img, .modal video {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.7);
        display: block;
    }

    .close {
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
        z-index: 1002;
    }

    .close:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
        border-color: rgba(255,255,255,0.7);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 2.2rem;
        cursor: pointer;
        background: rgba(0,0,0,0.9);
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 2px solid rgba(255,255,255,0.4);
        z-index: 1001;
    }

    .modal-nav:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-50%) scale(1.1);
        border-color: rgba(255,255,255,0.7);
    }

    .modal-prev {
        left: 20px;
    }

    .modal-next {
        right: 20px;
    }

    .modal-counter {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        background: rgba(0,0,0,0.9);
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 600;
        border: 2px solid rgba(255,255,255,0.4);
        z-index: 1001;
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

        .report-details-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .modal-content {
            padding: 15px;
        }

        .modal img, .modal video {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
        }

        .close {
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            font-size: 1.8rem;
        }

        .modal-nav {
            width: 45px;
            height: 45px;
            font-size: 1.8rem;
        }

        .modal-prev {
            left: 10px;
        }

        .modal-next {
            right: 10px;
        }

        .modal-counter {
            bottom: 10px;
            font-size: 13px;
            padding: 6px 14px;
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

// Global variables for media navigation
let currentMediaIndex = 0;
let mediaFiles = [];

// Modal functions for media viewing
function openModal(url, type, index = 0) {
    const modal = document.getElementById('mediaModal');
    const modalImage = document.getElementById('modalImage');
    const modalVideo = document.getElementById('modalVideo');
    const modalCounter = document.getElementById('modalCounter');
    const prevBtn = document.querySelector('.modal-prev');
    const nextBtn = document.querySelector('.modal-next');

    // Reset modal state
    modalImage.style.display = 'none';
    modalVideo.style.display = 'none';
    modalCounter.style.display = 'none';
    prevBtn.style.display = 'none';
    nextBtn.style.display = 'none';

    // Get all media files from the current report
    const mediaItems = document.querySelectorAll('.media-item');
    mediaFiles = Array.from(mediaItems).map(item => {
        const img = item.querySelector('img');
        const video = item.querySelector('video');
        const fileLink = item.querySelector('.file-preview');

        if (img) {
            return { url: img.src, type: 'image' };
        } else if (video) {
            return { url: video.querySelector('source').src, type: 'video' };
        } else if (fileLink) {
            return { url: fileLink.href, type: 'file' };
        }
        return null;
    }).filter(item => item !== null);

    currentMediaIndex = index;

    // Show navigation if there are multiple files
    if (mediaFiles.length > 1) {
        prevBtn.style.display = 'flex';
        nextBtn.style.display = 'flex';
        modalCounter.style.display = 'block';
        modalCounter.textContent = `${currentMediaIndex + 1} of ${mediaFiles.length}`;
    }

    // Load the selected media
    loadMedia(url, type);

    // Store current scroll position and prevent body scrolling
    modal.dataset.scrollY = window.scrollY;
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.top = `-${window.scrollY}px`;
    document.body.style.width = '100%';

    modal.style.display = 'flex';
}

function loadMedia(url, type) {
    const modalImage = document.getElementById('modalImage');
    const modalVideo = document.getElementById('modalVideo');

    modalImage.style.display = 'none';
    modalVideo.style.display = 'none';

    if (type === 'image') {
        modalImage.src = url;
        modalImage.style.display = 'block';
        modalImage.onload = function() {
            // Image loaded successfully
        };
    } else if (type === 'video') {
        modalVideo.src = url;
        modalVideo.style.display = 'block';
        modalVideo.load();
    }
}

function navigateMedia(direction) {
    if (mediaFiles.length <= 1) return;

    currentMediaIndex += direction;

    if (currentMediaIndex < 0) {
        currentMediaIndex = mediaFiles.length - 1;
    } else if (currentMediaIndex >= mediaFiles.length) {
        currentMediaIndex = 0;
    }

    const media = mediaFiles[currentMediaIndex];
    loadMedia(media.url, media.type);

    // Update counter
    const modalCounter = document.getElementById('modalCounter');
    modalCounter.textContent = `${currentMediaIndex + 1} of ${mediaFiles.length}`;
}

function closeModal() {
    const modal = document.getElementById('mediaModal');
    const modalImage = document.getElementById('modalImage');
    const modalVideo = document.getElementById('modalVideo');

    modal.style.display = 'none';
    modalImage.src = '';
    modalVideo.src = '';

    // Restore scroll position and body scrolling
    const scrollY = modal.dataset.scrollY || 0;
    document.body.style.overflow = 'auto';
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width = '';
    window.scrollTo(0, parseInt(scrollY));
}

// Close modal when clicking outside
document.getElementById('mediaModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('mediaModal');
    if (modal.style.display === 'flex') {
        switch(e.key) {
            case 'Escape':
                closeModal();
                break;
            case 'ArrowLeft':
                navigateMedia(-1);
                break;
            case 'ArrowRight':
                navigateMedia(1);
                break;
        }
    }
});

</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>