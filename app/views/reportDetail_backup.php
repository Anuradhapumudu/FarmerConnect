<?php require APPROOT . '/views/inc/minimalheader.php'; ?>

<div class="container">
    <?php if (isset($data['error']) && !empty($data['error'])): ?>
        <div class="alert alert-danger text-center">
            <h4>⚠️ Report Not Found</h4>
            <p><?php echo htmlspecialchars($data['error']); ?></p>
            <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-primary">
                ← Back to Reports
            </a>
        </div>
    <?php else: ?>
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/disease/viewReports">Reports</a></li>
                    <li class="breadcrumb-item active">Report Details</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1>Disease Report Details</h1>
                    <p class="text-muted">Report ID: <code><?php echo htmlspecialchars($data['report']->reportId); ?></code></p>
                </div>
                <div class="btn-group">
                    <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->reportId; ?>" 
                       class="btn btn-outline-primary">Edit Report</a>
                    <a href="<?php echo URLROOT; ?>/disease/confirmDelete/<?php echo $data['report']->reportId; ?>" 
                       class="btn btn-outline-danger">Delete</a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Report Title -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📝 Report Title</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary"><?php echo htmlspecialchars($data['report']->title); ?></h3>
                    </div>
                </div>

                <!-- Status & Severity -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📊 Status & Severity</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <label class="form-label fw-bold">Current Status</label>
                                <div class="mb-2">
                                    <?php
                                    $statusClass = '';
                                    switch ($data['report']->status) {
                                        case 'pending':
                                            $statusClass = 'bg-warning text-dark';
                                            break;
                                        case 'under_review':
                                            $statusClass = 'bg-info text-white';
                                            break;
                                        case 'resolved':
                                            $statusClass = 'bg-success text-white';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'bg-danger text-white';
                                            break;
                                        default:
                                            $statusClass = 'bg-secondary text-white';
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?> p-2 fs-6">
                                        <?php echo ucfirst(str_replace('_', ' ', $data['report']->status)); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label class="form-label fw-bold">Severity Level</label>
                                <div class="mb-2">
                                    <?php
                                    $severityClass = '';
                                    switch ($data['report']->severity) {
                                        case 'high':
                                            $severityClass = 'bg-danger text-white';
                                            break;
                                        case 'medium':
                                            $severityClass = 'bg-warning text-dark';
                                            break;
                                        case 'low':
                                            $severityClass = 'bg-success text-white';
                                            break;
                                        default:
                                            $severityClass = 'bg-secondary text-white';
                                    }
                                    ?>
                                    <span class="badge <?php echo $severityClass; ?> p-2 fs-6">
                                        <?php echo ucfirst($data['report']->severity); ?> Severity
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📄 Problem Description</h5>
                    </div>
                    <div class="card-body">
                        <p class="lead"><?php echo nl2br(htmlspecialchars($data['report']->description)); ?></p>
                    </div>
                </div>

                <!-- Affected Area -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">🗺️ Affected Area</h5>
                    </div>
                    <div class="card-body text-center">
                        <h2 class="display-4 text-warning mb-0">
                            <?php echo number_format($data['report']->affectedArea, 2); ?>
                        </h2>
                        <p class="text-muted">Acres</p>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">⏰ Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6>Disease Observed</h6>
                                    <p class="text-muted small">
                                        <?php echo date('F d, Y', strtotime($data['report']->observationDate)); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6>Report Created</h6>
                                    <p class="text-muted small">
                                        <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?>
                                    </p>
                                </div>
                            </div>
                            <?php if (isset($data['report']->updated_at) && $data['report']->updated_at != $data['report']->created_at): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6>Last Updated</h6>
                                        <p class="text-muted small">
                                            <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->updated_at)); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Media Files -->
                <?php if (!empty($data['media'])): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">📸 Media Files (<?php echo count($data['media']); ?>)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <?php foreach ($data['media'] as $media): ?>
                                    <div class="col-md-4 col-sm-6">
                                        <?php
                                        $filePath = URLROOT . '/uploads/disease_reports/' . $media->filename;
                                        $fileExt = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));
                                        ?>
                                        
                                        <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                            <div class="card">
                                                <img src="<?php echo $filePath; ?>" 
                                                     class="card-img-top img-thumbnail" 
                                                     alt="Disease evidence" 
                                                     style="height: 150px; object-fit: cover; cursor: pointer;"
                                                     onclick="openModal('<?php echo $filePath; ?>', 'image')">
                                                <div class="card-body p-2">
                                                    <small class="text-muted">📷 Image</small>
                                                </div>
                                            </div>
                                        <?php elseif (in_array($fileExt, ['mp4', 'webm', 'ogg', 'mov'])): ?>
                                            <div class="card">
                                                <video class="card-img-top" 
                                                       style="height: 150px; object-fit: cover; cursor: pointer;"
                                                       onclick="openModal('<?php echo $filePath; ?>', 'video')">
                                                    <source src="<?php echo $filePath; ?>" type="video/<?php echo $fileExt; ?>">
                                                </video>
                                                <div class="card-body p-2">
                                                    <small class="text-muted">🎥 Video</small>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <a href="<?php echo $filePath; ?>" target="_blank" class="text-decoration-none">
                                                        <div class="display-6 mb-2">📄</div>
                                                        <small class="text-muted"><?php echo strtoupper($fileExt); ?> File</small>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="text-muted">
                                <div class="display-1 mb-3">📷</div>
                                <h5>No Media Files</h5>
                                <p>No evidence files have been attached to this report.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Farmer Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">👨‍🌾 Farmer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIC Number</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($data['report']->farmerNIC); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">PLR Number</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($data['report']->plrNumber); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">⚡ Quick Actions</h5>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->reportId; ?>" 
                           class="btn btn-outline-primary">
                            ✏️ Edit Report
                        </a>
                        <a href="<?php echo URLROOT; ?>/disease/viewReports" 
                           class="btn btn-outline-secondary">
                            📊 All Reports
                        </a>
                        <button class="btn btn-outline-info" onclick="window.print()">
                            🖨️ Print Report
                        </button>
                    </div>
                </div>

                <!-- Report Information -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📋 Report Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created Date</label>
                            <p class="form-control-plaintext">
                                <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?>
                            </p>
                        </div>
                        <?php if (isset($data['report']->updated_at) && $data['report']->updated_at != $data['report']->created_at): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated</label>
                                <p class="form-control-plaintext">
                                    <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->updated_at)); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Observation Date</label>
                            <p class="form-control-plaintext">
                                <?php echo date('F d, Y', strtotime($data['report']->observationDate)); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Media Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple Timeline Styles */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
    padding-left: 20px;
}

.timeline-content h6 {
    margin-bottom: 5px;
    color: #495057;
}

/* Print Styles */
@media print {
    .btn, .btn-group, .card-header .btn {
        display: none !important;
    }
    
    .container {
        max-width: 100% !important;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-bottom: 5px;
    }
}
</style>

<script>
function openModal(url, type) {
    const modal = new bootstrap.Modal(document.getElementById('mediaModal'));
    const content = document.getElementById('modalContent');
    
    if (type === 'image') {
        content.innerHTML = `<img src="${url}" class="img-fluid" alt="Disease evidence">`;
    } else if (type === 'video') {
        content.innerHTML = `<video controls class="img-fluid"><source src="${url}"></video>`;
    }
    
    modal.show();
}
</script>

<?php require APPROOT . '/views/inc/minimalfooter.php'; ?>
    <?php if (isset($data['error']) && !empty($data['error'])): ?>
        <div class="alert alert-danger text-center">
            <h4>⚠️ Report Not Found</h4>
            <p><?php echo htmlspecialchars($data['error']); ?></p>
            <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-primary">
                ← Back to Reports
            </a>
        </div>
    <?php else: ?>
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/disease/viewReports">Reports</a></li>
                    <li class="breadcrumb-item active">Report Details</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1>Disease Report Details</h1>
                    <p class="text-muted">Report ID: <code><?php echo htmlspecialchars($data['report']->reportId); ?></code></p>
                </div>
                <div class="btn-group">
                    <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->reportId; ?>" 
                       class="btn btn-outline-primary">Edit Report</a>
                    <a href="<?php echo URLROOT; ?>/disease/confirmDelete/<?php echo $data['report']->reportId; ?>" 
                       class="btn btn-outline-danger">Delete</a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Report Title -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📝 Report Title</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary"><?php echo htmlspecialchars($data['report']->title); ?></h3>
                    </div>
                </div>

                <!-- Status & Severity -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📊 Status & Severity</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <label class="form-label fw-bold">Current Status</label>
                                <div class="mb-2">
                                    <?php
                                    $statusClass = '';
                                    switch ($data['report']->status) {
                                        case 'pending':
                                            $statusClass = 'bg-warning text-dark';
                                            break;
                                        case 'under_review':
                                            $statusClass = 'bg-info text-white';
                                            break;
                                        case 'resolved':
                                            $statusClass = 'bg-success text-white';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'bg-danger text-white';
                                            break;
                                        default:
                                            $statusClass = 'bg-secondary text-white';
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?> p-2 fs-6">
                                        <?php echo ucfirst(str_replace('_', ' ', $data['report']->status)); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label class="form-label fw-bold">Severity Level</label>
                                <div class="mb-2">
                                    <?php
                                    $severityClass = '';
                                    switch ($data['report']->severity) {
                                        case 'high':
                                            $severityClass = 'bg-danger text-white';
                                            break;
                                        case 'medium':
                                            $severityClass = 'bg-warning text-dark';
                                            break;
                                        case 'low':
                                            $severityClass = 'bg-success text-white';
                                            break;
                                        default:
                                            $severityClass = 'bg-secondary text-white';
                                    }
                                    ?>
                                    <span class="badge <?php echo $severityClass; ?> p-2 fs-6">
                                        <?php echo ucfirst($data['report']->severity); ?> Severity
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📄 Problem Description</h5>
                    </div>
                    <div class="card-body">
                        <p class="lead"><?php echo nl2br(htmlspecialchars($data['report']->description)); ?></p>
                    </div>
                </div>

                <!-- Affected Area -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">🗺️ Affected Area</h5>
                    </div>
                    <div class="card-body text-center">
                        <h2 class="display-4 text-warning mb-0">
                            <?php echo number_format($data['report']->affectedArea, 2); ?>
                        </h2>
                        <p class="text-muted">Acres</p>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">⏰ Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6>Disease Observed</h6>
                                    <p class="text-muted small">
                                        <?php echo date('F d, Y', strtotime($data['report']->observationDate)); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6>Report Created</h6>
                                    <p class="text-muted small">
                                        <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?>
                                    </p>
                                </div>
                            </div>
                            <?php if (isset($data['report']->updated_at) && $data['report']->updated_at != $data['report']->created_at): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6>Last Updated</h6>
                                        <p class="text-muted small">
                                            <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->updated_at)); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Media Files -->
                <?php if (!empty($data['media'])): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">📸 Media Files (<?php echo count($data['media']); ?>)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <?php foreach ($data['media'] as $media): ?>
                                    <div class="col-md-4 col-sm-6">
                                        <?php
                                        $filePath = URLROOT . '/uploads/disease_reports/' . $media->filename;
                                        $fileExt = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));
                                        ?>
                                        
                                        <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                            <div class="card">
                                                <img src="<?php echo $filePath; ?>" 
                                                     class="card-img-top img-thumbnail" 
                                                     alt="Disease evidence" 
                                                     style="height: 150px; object-fit: cover; cursor: pointer;"
                                                     onclick="openModal('<?php echo $filePath; ?>', 'image')">
                                                <div class="card-body p-2">
                                                    <small class="text-muted">📷 Image</small>
                                                </div>
                                            </div>
                                        <?php elseif (in_array($fileExt, ['mp4', 'webm', 'ogg', 'mov'])): ?>
                                            <div class="card">
                                                <video class="card-img-top" 
                                                       style="height: 150px; object-fit: cover; cursor: pointer;"
                                                       onclick="openModal('<?php echo $filePath; ?>', 'video')">
                                                    <source src="<?php echo $filePath; ?>" type="video/<?php echo $fileExt; ?>">
                                                </video>
                                                <div class="card-body p-2">
                                                    <small class="text-muted">🎥 Video</small>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <a href="<?php echo $filePath; ?>" target="_blank" class="text-decoration-none">
                                                        <div class="display-6 mb-2">📄</div>
                                                        <small class="text-muted"><?php echo strtoupper($fileExt); ?> File</small>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="text-muted">
                                <div class="display-1 mb-3">📷</div>
                                <h5>No Media Files</h5>
                                <p>No evidence files have been attached to this report.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Farmer Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">👨‍🌾 Farmer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIC Number</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($data['report']->farmerNIC); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">PLR Number</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($data['report']->plrNumber); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">⚡ Quick Actions</h5>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->reportId; ?>" 
                           class="btn btn-outline-primary">
                            ✏️ Edit Report
                        </a>
                        <a href="<?php echo URLROOT; ?>/disease/viewReports" 
                           class="btn btn-outline-secondary">
                            📊 All Reports
                        </a>
                        <button class="btn btn-outline-info" onclick="window.print()">
                            🖨️ Print Report
                        </button>
                    </div>
                </div>

                <!-- Report Information -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">📋 Report Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created Date</label>
                            <p class="form-control-plaintext">
                                <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?>
                            </p>
                        </div>
                        <?php if (isset($data['report']->updated_at) && $data['report']->updated_at != $data['report']->created_at): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated</label>
                                <p class="form-control-plaintext">
                                    <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->updated_at)); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Observation Date</label>
                            <p class="form-control-plaintext">
                                <?php echo date('F d, Y', strtotime($data['report']->observationDate)); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Media Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple Timeline Styles */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
    padding-left: 20px;
}

.timeline-content h6 {
    margin-bottom: 5px;
    color: #495057;
}

/* Print Styles */
@media print {
    .btn, .btn-group, .card-header .btn {
        display: none !important;
    }
    
    .container {
        max-width: 100% !important;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-bottom: 5px;
    }
}
</style>

<script>
function openModal(url, type) {
    const modal = new bootstrap.Modal(document.getElementById('mediaModal'));
    const content = document.getElementById('modalContent');
    
    if (type === 'image') {
        content.innerHTML = `<img src="${url}" class="img-fluid" alt="Disease evidence">`;
    } else if (type === 'video') {
        content.innerHTML = `<video controls class="img-fluid"><source src="${url}"></video>`;
    }
    
    modal.show();
}
</script>

<?php require APPROOT . '/views/inc/minimalfooter.php'; ?>

        <!-- Main Content Grid -->
        <div class="content-layout">
            <div class="main-content">
                
                <!-- Problem Description Panel -->
                <div class="content-panel description-panel">
                    <div class="panel-header">
                        <div class="panel-icon">📝</div>
                        <h3 class="panel-title">Problem Description</h3>
                        <div class="panel-accent"></div>
                    </div>
                    <div class="panel-body">
                        <div class="description-content">
                            <?php echo nl2br(htmlspecialchars($data['report']->description)); ?>
                        </div>
                    </div>
                </div>

                <!-- Impact Metrics -->
                <div class="content-panel metrics-panel">
                    <div class="panel-header">
                        <div class="panel-icon">📊</div>
                        <h3 class="panel-title">Impact Assessment</h3>
                        <div class="panel-accent"></div>
                    </div>
                    <div class="panel-body">
                        <div class="metrics-grid">
                            <div class="metric-card primary">
                                <div class="metric-icon">🌾</div>
                                <div class="metric-content">
                                    <div class="metric-value"><?php echo number_format($data['report']->affectedArea, 1); ?></div>
                                    <div class="metric-label">Acres Affected</div>
                                </div>
                                <div class="metric-trend">
                                    <div class="trend-bar"></div>
                                </div>
                            </div>
                            <div class="metric-card secondary">
                                <div class="metric-icon">⚡</div>
                                <div class="metric-content">
                                    <div class="metric-value"><?php echo ucfirst($data['report']->severity); ?></div>
                                    <div class="metric-label">Severity Level</div>
                                </div>
                                <div class="metric-indicator severity-<?php echo $data['report']->severity; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Panel -->
                <div class="content-panel timeline-panel">
                    <div class="panel-header">
                        <div class="panel-icon">⏰</div>
                        <h3 class="panel-title">Event Timeline</h3>
                        <div class="panel-accent"></div>
                    </div>
                    <div class="panel-body">
                        <div class="timeline-container">
                            <div class="timeline-track"></div>
                            <div class="timeline-event">
                                <div class="event-marker observed">
                                    <div class="marker-icon">👁️</div>
                                    <div class="marker-glow"></div>
                                </div>
                                <div class="event-details">
                                    <div class="event-title">Disease First Observed</div>
                                    <div class="event-date"><?php echo date('F j, Y', strtotime($data['report']->observationDate)); ?></div>
                                </div>
                            </div>
                            <div class="timeline-event">
                                <div class="event-marker created">
                                    <div class="marker-icon">📝</div>
                                    <div class="marker-glow"></div>
                                </div>
                                <div class="event-details">
                                    <div class="event-title">Report Submitted</div>
                                    <div class="event-date"><?php echo date('F j, Y \a\t g:i A', strtotime($data['report']->created_at)); ?></div>
                                </div>
                            </div>
                            <?php if (isset($data['report']->updated_at) && $data['report']->updated_at != $data['report']->created_at): ?>
                                <div class="timeline-event">
                                    <div class="event-marker updated">
                                        <div class="marker-icon">✏️</div>
                                        <div class="marker-glow"></div>
                                    </div>
                                    <div class="event-details">
                                        <div class="event-title">Last Updated</div>
                                        <div class="event-date"><?php echo date('F j, Y \a\t g:i A', strtotime($data['report']->updated_at)); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Media Gallery -->
                <?php if (!empty($data['media'])): ?>
                    <div class="content-panel media-panel">
                        <div class="panel-header">
                            <div class="panel-icon">📸</div>
                            <h3 class="panel-title">Evidence Gallery</h3>
                            <div class="media-counter"><?php echo count($data['media']); ?> files</div>
                            <div class="panel-accent"></div>
                        </div>
                        <div class="panel-body">
                            <div class="media-gallery">
                                <?php foreach ($data['media'] as $index => $media): ?>
                                    <div class="media-item" data-index="<?php echo $index; ?>">
                                        <?php
                                        $filePath = URLROOT . '/uploads/disease_reports/' . $media->filename;
                                        $fileExt = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));
                                        ?>
                                        
                                        <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                            <div class="media-card image-card" onclick="openMediaModal('<?php echo $filePath; ?>', 'image')">
                                                <div class="media-preview">
                                                    <img src="<?php echo $filePath; ?>" alt="Disease evidence" loading="lazy">
                                                    <div class="media-overlay">
                                                        <div class="overlay-icon">🔍</div>
                                                        <div class="overlay-text">View Image</div>
                                                    </div>
                                                </div>
                                                <div class="media-type image-type">📷</div>
                                            </div>
                                        <?php elseif (in_array($fileExt, ['mp4', 'webm', 'ogg', 'mov'])): ?>
                                            <div class="media-card video-card" onclick="openMediaModal('<?php echo $filePath; ?>', 'video')">
                                                <div class="media-preview">
                                                    <video preload="metadata" muted>
                                                        <source src="<?php echo $filePath; ?>" type="video/<?php echo $fileExt; ?>">
                                                    </video>
                                                    <div class="media-overlay">
                                                        <div class="overlay-icon">▶️</div>
                                                        <div class="overlay-text">Play Video</div>
                                                    </div>
                                                </div>
                                                <div class="media-type video-type">🎥</div>
                                            </div>
                                        <?php else: ?>
                                            <div class="media-card file-card">
                                                <a href="<?php echo $filePath; ?>" target="_blank" class="file-link">
                                                    <div class="file-preview">
                                                        <div class="file-icon">📄</div>
                                                        <div class="file-ext"><?php echo strtoupper($fileExt); ?></div>
                                                    </div>
                                                    <div class="file-name"><?php echo basename($media->filename); ?></div>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="content-panel empty-media-panel">
                        <div class="panel-body">
                            <div class="empty-state">
                                <div class="empty-icon">📷</div>
                                <h4>No Media Files</h4>
                                <p>No evidence files have been attached to this report.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="sidebar-content">
                
                <!-- Farmer Information -->
                <div class="info-card farmer-card">
                    <div class="card-header">
                        <div class="header-icon">👨‍🌾</div>
                        <div class="header-text">
                            <h4>Farmer Details</h4>
                            <span class="header-subtitle">Report Submitter</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="info-item">
                            <div class="info-icon">🆔</div>
                            <div class="info-details">
                                <span class="info-label">NIC Number</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['report']->farmerNIC); ?></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">📋</div>
                            <div class="info-details">
                                <span class="info-label">PLR Number</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['report']->plrNumber); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="info-card actions-card">
                    <div class="card-header">
                        <div class="header-icon">⚡</div>
                        <div class="header-text">
                            <h4>Quick Actions</h4>
                            <span class="header-subtitle">Manage Report</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->reportId; ?>" 
                           class="action-link edit-action">
                            <div class="action-icon">✏️</div>
                            <div class="action-text">
                                <span class="action-title">Edit Report</span>
                                <span class="action-desc">Modify report details</span>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>
                        <a href="<?php echo URLROOT; ?>/disease/viewReports" 
                           class="action-link back-action">
                            <div class="action-icon">📊</div>
                            <div class="action-text">
                                <span class="action-title">All Reports</span>
                                <span class="action-desc">View report list</span>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>
                        <button class="action-link export-action" onclick="exportToPDF()">
                            <div class="action-icon">�</div>
                            <div class="action-text">
                                <span class="action-title">Export PDF</span>
                                <span class="action-desc">Download report</span>
                            </div>
                            <div class="action-arrow">→</div>
                        </button>
                    </div>
                </div>

                <!-- Status Progress -->
                <div class="info-card progress-card">
                    <div class="card-header">
                        <div class="header-icon">📈</div>
                        <div class="header-text">
                            <h4>Status Progress</h4>
                            <span class="header-subtitle">Processing Timeline</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="progress-tracker">
                            <div class="progress-step <?php echo in_array($data['report']->status, ['pending', 'under_review', 'resolved']) ? 'completed' : ''; ?>">
                                <div class="step-marker">📝</div>
                                <div class="step-info">
                                    <span class="step-title">Submitted</span>
                                    <span class="step-desc">Report created</span>
                                </div>
                            </div>
                            <div class="progress-step <?php echo in_array($data['report']->status, ['under_review', 'resolved']) ? 'completed' : ($data['report']->status == 'pending' ? 'active' : ''); ?>">
                                <div class="step-marker">👁️</div>
                                <div class="step-info">
                                    <span class="step-title">Under Review</span>
                                    <span class="step-desc">Being evaluated</span>
                                </div>
                            </div>
                            <div class="progress-step <?php echo $data['report']->status == 'resolved' ? 'completed' : ''; ?>">
                                <div class="step-marker">✅</div>
                                <div class="step-info">
                                    <span class="step-title">Resolved</span>
                                    <span class="step-desc">Issue addressed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Media Modal -->
        <div id="mediaModal" class="media-modal">
            <div class="modal-backdrop" onclick="closeMediaModal()"></div>
            <div class="modal-container">
                <div class="modal-header">
                    <h3 class="modal-title">Media Preview</h3>
                    <button class="modal-close" onclick="closeMediaModal()">
                        <span>✕</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalMediaContent" class="modal-content-area"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Media Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple Timeline Styles */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
    padding-left: 20px;
}

.timeline-content h6 {
    margin-bottom: 5px;
    color: #495057;
}

/* Print Styles */
@media print {
    .btn, .btn-group, .card-header .btn {
        display: none !important;
    }
    
    .container {
        max-width: 100% !important;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-bottom: 5px;
    }
}
</style>

<script>
function openModal(url, type) {
    const modal = new bootstrap.Modal(document.getElementById('mediaModal'));
    const content = document.getElementById('modalContent');
    
    if (type === 'image') {
        content.innerHTML = `<img src="${url}" class="img-fluid" alt="Disease evidence">`;
    } else if (type === 'video') {
        content.innerHTML = `<video controls class="img-fluid"><source src="${url}"></video>`;
    }
    
    modal.show();
}
</script>

<?php require APPROOT . '/views/inc/minimalfooter.php'; ?>

/* Error State */
.error-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 2rem;
}

.error-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.error-animation {
    position: relative;
    margin-bottom: 2rem;
}

.error-icon {
    font-size: 4rem;
    animation: bounce 2s infinite;
}

.error-ripple {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
    border: 2px solid #e74c3c;
    border-radius: 50%;
    animation: ripple 2s infinite;
    opacity: 0.6;
}

.error-card h2 {
    color: #e74c3c;
    margin-bottom: 1rem;
    font-size: 1.8rem;
    font-weight: 700;
}

.error-card p {
    color: #666;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.return-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-decoration: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.return-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
}

/* Premium Header */
.report-header {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 60vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.header-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle cx="200" cy="200" r="150" fill="rgba(255,255,255,0.1)"/><circle cx="800" cy="300" r="100" fill="rgba(255,255,255,0.05)"/><circle cx="400" cy="700" r="200" fill="rgba(255,255,255,0.08)"/></svg>');
    opacity: 0.5;
}

.header-content {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    width: 100%;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
}

.breadcrumb-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: white;
}

.breadcrumb-separator {
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0.5rem;
}

.breadcrumb-current {
    color: white;
    font-weight: 600;
}

.header-main {
    text-align: center;
    margin-bottom: 3rem;
}

.report-type-badge {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    margin-bottom: 2rem;
    overflow: hidden;
}

.badge-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: conic-gradient(from 0deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: rotate 4s linear infinite;
}

.badge-icon {
    font-size: 1.2rem;
    z-index: 1;
}

.badge-text {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    z-index: 1;
}

.report-title {
    font-size: clamp(2rem, 5vw, 4rem);
    font-weight: 800;
    color: white;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    margin-bottom: 2rem;
    line-height: 1.2;
}

.report-meta {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.meta-group {
    text-align: center;
}

.meta-label {
    display: block;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.report-code {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.report-code:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.report-date {
    color: white;
    font-weight: 600;
}

.status-overview {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.status-badge,
.severity-badge {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.badge-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    animation: shine 3s infinite;
}

.status-pending {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
}

.status-review {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
}

.status-resolved {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    box-shadow: 0 4px 15px rgba(39, 174, 96, 0.4);
}

.status-rejected {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
}

.severity-high {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
}

.severity-medium {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
}

.severity-low {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    box-shadow: 0 4px 15px rgba(39, 174, 96, 0.4);
}

.header-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.action-btn {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    text-decoration: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    overflow: hidden;
}

.action-btn:hover {
    transform: translateY(-2px);
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.btn-ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-effect 0.6s linear;
}

/* Main Content */
.content-layout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 2rem;
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
    position: relative;
    z-index: 1;
}

.main-content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.content-panel {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    transition: all 0.3s ease;
}

.content-panel:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.panel-header {
    position: relative;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.panel-accent {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.panel-icon {
    font-size: 1.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.panel-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.panel-body {
    padding: 2rem;
}

/* Description Panel */
.description-content {
    background: rgba(248, 249, 250, 0.8);
    padding: 2rem;
    border-radius: 15px;
    font-size: 1.1rem;
    line-height: 1.8;
    color: #2c3e50;
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
}

.description-content::before {
    content: '"';
    position: absolute;
    top: -10px;
    left: 20px;
    font-size: 4rem;
    color: #667eea;
    opacity: 0.3;
    font-family: serif;
}

/* Metrics Panel */
.metrics-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.metric-card {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 15px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.metric-card:hover {
    transform: scale(1.02);
}

.metric-card.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.metric-card.secondary {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

.metric-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.metric-value {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.metric-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.metric-trend {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: rgba(255, 255, 255, 0.3);
    overflow: hidden;
}

.trend-bar {
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    width: 70%;
    animation: slide-in 2s ease-out;
}

.metric-indicator {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.metric-indicator.severity-high {
    background: #e74c3c;
}

.metric-indicator.severity-medium {
    background: #f39c12;
}

.metric-indicator.severity-low {
    background: #27ae60;
}

/* Timeline */
.timeline-container {
    position: relative;
    padding: 1rem 0;
}

.timeline-track {
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #667eea, #764ba2);
    border-radius: 2px;
}

.timeline-event {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    position: relative;
}

.event-marker {
    position: relative;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.marker-icon {
    font-size: 1.5rem;
    color: white;
}

.marker-glow {
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border-radius: 50%;
    background: inherit;
    opacity: 0.3;
    animation: pulse 2s infinite;
}

.event-marker.observed {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.event-marker.created {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.event-marker.updated {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.event-details {
    margin-left: 2rem;
    flex: 1;
    padding-top: 0.5rem;
}

.event-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.event-date {
    color: #7f8c8d;
    font-size: 0.9rem;
}

/* Media Gallery */
.media-counter {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: auto;
}

.media-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.media-card {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.media-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.media-preview {
    position: relative;
    width: 100%;
    height: 150px;
    overflow: hidden;
    cursor: pointer;
}

.media-preview img,
.media-preview video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.media-preview:hover img,
.media-preview:hover video {
    transform: scale(1.1);
}

.media-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    color: white;
}

.media-preview:hover .media-overlay {
    opacity: 1;
}

.overlay-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.overlay-text {
    font-size: 0.9rem;
    font-weight: 600;
}

.media-type {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.image-type {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.video-type {
    background: linear-gradient(135deg, #f093fb, #f5576c);
}

/* File Cards */
.file-card {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: 2px dashed rgba(102, 126, 234, 0.3);
}

.file-link {
    display: block;
    text-decoration: none;
    color: inherit;
    padding: 1rem;
    text-align: center;
    transition: all 0.3s ease;
}

.file-link:hover {
    color: #667eea;
    transform: scale(1.05);
}

.file-preview {
    height: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.file-icon {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.file-ext {
    font-weight: 700;
    font-size: 0.9rem;
    color: #667eea;
}

.file-name {
    font-size: 0.8rem;
    color: #7f8c8d;
    margin-top: 0.5rem;
    word-break: break-all;
}

/* Empty State */
.empty-media-panel .panel-body {
    padding: 4rem 2rem;
}

.empty-state {
    text-align: center;
    color: #7f8c8d;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h4 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

/* Sidebar */
.sidebar-content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.info-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    font-size: 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    width: 50px;
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-text h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
}

.header-subtitle {
    font-size: 0.8rem;
    opacity: 0.8;
    margin-top: 0.2rem;
}

.card-content {
    padding: 1.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 15px;
    background: rgba(248, 249, 250, 0.8);
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateX(5px);
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-icon {
    font-size: 1.2rem;
    color: #667eea;
    width: 40px;
    height: 40px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-details {
    flex: 1;
}

.info-label {
    display: block;
    font-size: 0.8rem;
    color: #7f8c8d;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.2rem;
}

.info-value {
    font-weight: 700;
    color: #2c3e50;
    font-family: 'Courier New', monospace;
}

/* Action Links */
.action-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 15px;
    background: rgba(248, 249, 250, 0.8);
    text-decoration: none;
    color: inherit;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    width: 100%;
    cursor: pointer;
}

.action-link:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateX(5px);
    color: #667eea;
}

.action-icon {
    font-size: 1.2rem;
    width: 40px;
    height: 40px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-text {
    flex: 1;
}

.action-title {
    display: block;
    font-weight: 600;
    margin-bottom: 0.2rem;
}

.action-desc {
    font-size: 0.8rem;
    color: #7f8c8d;
}

.action-arrow {
    font-size: 1.2rem;
    color: #667eea;
    transition: transform 0.3s ease;
}

.action-link:hover .action-arrow {
    transform: translateX(5px);
}

/* Progress Tracker */
.progress-tracker {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.progress-step {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
}

.step-marker {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    background: rgba(124, 143, 162, 0.2);
    color: #7c8fa2;
    transition: all 0.3s ease;
}

.progress-step.completed .step-marker {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    animation: bounce-in 0.6s ease;
}

.progress-step.active .step-marker {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    animation: pulse 2s infinite;
}

.step-info {
    flex: 1;
}

.step-title {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.2rem;
}

.step-desc {
    font-size: 0.8rem;
    color: #7f8c8d;
}

/* Media Modal */
.media-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.media-modal.active {
    opacity: 1;
}

.modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(10px);
}

.modal-container {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.media-modal.active .modal-container {
    transform: scale(1);
}

.modal-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: background 0.3s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.modal-body {
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}

.modal-content-area img,
.modal-content-area video {
    max-width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

/* Animations */
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-30px);
    }
    60% {
        transform: translateY(-15px);
    }
}

@keyframes ripple {
    0% {
        transform: translate(-50%, -50%) scale(0);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(4);
        opacity: 0;
    }
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes shine {
    0% {
        left: -100%;
    }
    100% {
        left: 100%;
    }
}

@keyframes ripple-effect {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

@keyframes slide-in {
    from {
        width: 0;
    }
    to {
        width: 70%;
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .content-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
        padding: 2rem 1rem;
    }

    .report-header {
        min-height: 50vh;
    }

    .header-content {
        padding: 1rem;
    }

    .report-title {
        font-size: 2rem;
    }

    .report-meta {
        flex-direction: column;
        gap: 1rem;
    }

    .status-overview {
        flex-direction: column;
        align-items: center;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .action-btn {
        width: 100%;
        justify-content: center;
    }

    .metrics-grid {
        grid-template-columns: 1fr;
    }

    .media-gallery {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }

    .modal-container {
        max-width: 95vw;
        max-height: 95vh;
    }

    .modal-header {
        padding: 1rem;
    }

    .modal-body {
        padding: 1rem;
    }
}

@media (max-width: 480px) {
    .report-title {
        font-size: 1.5rem;
    }

    .breadcrumb-nav {
        flex-wrap: wrap;
    }

    .panel-header {
        padding: 1rem;
        flex-wrap: wrap;
    }

    .panel-body {
        padding: 1rem;
    }

    .media-gallery {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
}
</style>

<script>
// Enhanced JavaScript for Modern Report Detail Page
let currentMediaUrl = '';

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Report ID copied to clipboard!', 'success');
    }).catch(() => {
        showNotification('Failed to copy. Please try manually.', 'error');
    });
}

// Media modal functions
function openMediaModal(url, type) {
    currentMediaUrl = url;
    const modal = document.getElementById('mediaModal');
    const content = document.getElementById('modalMediaContent');
    
    content.innerHTML = '';
    
    if (type === 'image') {
        content.innerHTML = `<img src="${url}" alt="Disease evidence" style="max-width: 100%; max-height: 70vh; object-fit: contain; border-radius: 10px;">`;
    } else if (type === 'video') {
        content.innerHTML = `
            <video controls style="max-width: 100%; max-height: 70vh; object-fit: contain; border-radius: 10px;" autoplay>
                <source src="${url}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
        modal.classList.add('active');
    }, 10);
}

function closeMediaModal() {
    const modal = document.getElementById('mediaModal');
    modal.classList.remove('active');
    
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }, 300);
}

// Share report function
function shareReport() {
    if (navigator.share) {
        navigator.share({
            title: 'Disease Report: <?php echo addslashes($data['report']->title ?? ''); ?>',
            text: 'View this disease report for detailed analysis',
            url: window.location.href
        }).catch(() => {
            fallbackShare();
        });
    } else {
        fallbackShare();
    }
}

function fallbackShare() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        showNotification('Report link copied to clipboard!', 'success');
    }).catch(() => {
        showNotification('Unable to share. Please copy URL manually.', 'error');
    });
}

// Export to PDF function
function exportToPDF() {
    showNotification('PDF export feature coming soon!', 'info');
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-icon">${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
            <span class="notification-text">${message}</span>
        </div>
    `;
    
    // Add notification styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        transform: translateX(400px);
        transition: all 0.3s ease;
        font-weight: 600;
        backdrop-filter: blur(10px);
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Enhanced page interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add ripple effects to buttons
    const buttons = document.querySelectorAll('.action-btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.6);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple-effect 0.6s linear;
                pointer-events: none;
            `;
            
            ripple.className = 'btn-ripple';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    // Observe content panels
    document.querySelectorAll('.content-panel, .info-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Enhanced hover effects
    document.querySelectorAll('.media-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeMediaModal();
    }
});

// Prevent modal close when clicking inside modal content
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-backdrop')) {
        closeMediaModal();
    }
});
</script>

<?php require APPROOT . '/views/inc/minimalfooter.php'; ?>

<style>
/* Pure CSS Disease Report Detail Styles - No External Dependencies */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 25%, #a5d6a7 50%, #81c784 75%, #66bb6a 100%);
    min-height: 100vh;
    background-attachment: fixed;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Error Styles */
.error-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 50vh;
}

.error-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    text-align: center;
    max-width: 500px;
    border: 1px solid rgba(244, 67, 54, 0.2);
}

.error-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.error-card h2 {
    color: #d32f2f;
    margin-bottom: 1rem;
    font-size: 1.8rem;
}

.error-card p {
    color: #666;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

/* Page Header */
.page-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(46, 125, 50, 0.1);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
    opacity: 0.1;
    z-index: -1;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.report-icon {
    font-size: 4rem;
    background: linear-gradient(135deg, #2e7d32, #4caf50);
    color: white;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 4px 16px rgba(46, 125, 50, 0.3);
}

.header-text h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2e7d32;
    margin-bottom: 0.5rem;
}

.report-id {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    border: 2px solid rgba(46, 125, 50, 0.2);
    display: inline-block;
    margin-bottom: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.report-id:hover {
    background: rgba(46, 125, 50, 0.2);
    transform: scale(1.05);
}

.created-date {
    color: #666;
    font-size: 1rem;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Buttons */
.btn {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: left 0.5s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #2e7d32, #4caf50);
    color: white;
    box-shadow: 0 4px 16px rgba(46, 125, 50, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(46, 125, 50, 0.4);
}

.btn-edit {
    background: linear-gradient(135deg, #2196f3, #1976d2);
    color: white;
    box-shadow: 0 4px 16px rgba(33, 150, 243, 0.3);
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(33, 150, 243, 0.4);
}

.btn-delete {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
    box-shadow: 0 4px 16px rgba(244, 67, 54, 0.3);
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(244, 67, 54, 0.4);
}

.btn-back {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
    box-shadow: 0 4px 16px rgba(108, 117, 125, 0.3);
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(108, 117, 125, 0.4);
}

/* Report Content Layout */
.report-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
}

/* Content Cards */
.content-card,
.sidebar-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(46, 125, 50, 0.1);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.content-card::before,
.sidebar-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #2e7d32, #4caf50, #8bc34a);
    z-index: 1;
}

.content-card:hover,
.sidebar-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.card-header {
    background: linear-gradient(135deg, rgba(46, 125, 50, 0.05), rgba(139, 195, 74, 0.05));
    padding: 1.5rem 2rem;
    border-bottom: 1px solid rgba(46, 125, 50, 0.1);
}

.card-header h2 {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2e7d32;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body {
    padding: 2rem;
}

/* Report Title */
.report-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2e7d32;
    background: linear-gradient(135deg, rgba(46, 125, 50, 0.05), rgba(139, 195, 74, 0.05));
    padding: 2rem;
    border-radius: 12px;
    border: 2px solid rgba(46, 125, 50, 0.1);
    position: relative;
    overflow: hidden;
}

.report-title::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Status & Severity Grid */
.status-severity-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.status-container,
.severity-container {
    text-align: center;
}

.field-label {
    display: block;
    font-weight: 600;
    color: #2e7d32;
    margin-bottom: 0.8rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    border-radius: 25px;
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    min-width: 180px;
}

.badge:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.status-pending {
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
}

.status-review {
    background: linear-gradient(135deg, #2196f3, #1976d2);
    color: white;
}

.status-resolved {
    background: linear-gradient(135deg, #4caf50, #388e3c);
    color: white;
}

.status-rejected {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
}

.status-unknown {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
}

.severity-high {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
}

.severity-medium {
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
}

.severity-low {
    background: linear-gradient(135deg, #4caf50, #388e3c);
    color: white;
}

/* Description */
.description-content {
    background: rgba(248, 249, 250, 0.8);
    padding: 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
    border: 1px solid rgba(46, 125, 50, 0.1);
    position: relative;
}

.description-content::before {
    content: '"';
    position: absolute;
    top: -10px;
    left: 20px;
    font-size: 4rem;
    color: #4caf50;
    opacity: 0.3;
    font-family: serif;
}

/* Affected Area */
.affected-area {
    text-align: center;
    padding: 2rem;
    background: linear-gradient(135deg, rgba(255, 152, 0, 0.1), rgba(255, 193, 7, 0.1));
    border-radius: 12px;
    border: 2px solid rgba(255, 152, 0, 0.2);
}

.area-value {
    font-size: 4rem;
    font-weight: 800;
    color: #ff9800;
    line-height: 1;
}

.area-unit {
    font-size: 1.5rem;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Timeline */
.timeline {
    position: relative;
    padding: 1rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 40px;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #2e7d32, #4caf50, #8bc34a);
    border-radius: 2px;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    position: relative;
}

.timeline-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    z-index: 2;
    position: relative;
}

.timeline-icon.observation {
    background: linear-gradient(135deg, #2196f3, #1976d2);
}

.timeline-icon.created {
    background: linear-gradient(135deg, #4caf50, #388e3c);
}

.timeline-icon.updated {
    background: linear-gradient(135deg, #ff9800, #f57c00);
}

.timeline-content {
    margin-left: 2rem;
    flex: 1;
    padding-top: 1rem;
}

.timeline-content h3 {
    color: #2e7d32;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.timeline-content p {
    color: #666;
    font-size: 1rem;
    margin: 0;
}

/* Sidebar */
.sidebar {
    display: flex;
    flex-direction: column;
}

.info-item {
    margin-bottom: 1.5rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item .field-label {
    font-weight: 600;
    color: #2e7d32;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-value {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    border: 1px solid rgba(46, 125, 50, 0.2);
    font-family: 'Courier New', monospace;
}

/* Media Grid */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
}

.media-item {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.media-item:hover {
    transform: translateY(-4px);
}

.media-thumbnail {
    position: relative;
    width: 100%;
    height: 120px;
    overflow: hidden;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.media-thumbnail:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    transform: scale(1.05);
}

.media-thumbnail img,
.media-thumbnail video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.media-thumbnail:hover img,
.media-thumbnail:hover video {
    transform: scale(1.1);
}

.media-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    color: white;
    font-size: 2rem;
}

.media-thumbnail:hover .media-overlay {
    opacity: 1;
}

.media-type {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 0.3rem 0.5rem;
    border-radius: 6px;
    font-size: 0.8rem;
}

/* File Thumbnail */
.file-thumbnail {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    border: 2px dashed rgba(46, 125, 50, 0.3);
    text-decoration: none;
    color: #2e7d32;
    transition: all 0.3s ease;
}

.file-thumbnail:hover {
    color: #4caf50;
    border-color: rgba(76, 175, 80, 0.5);
    transform: scale(1.05);
}

.file-thumbnail a {
    text-decoration: none;
    color: inherit;
    text-align: center;
    padding: 1rem;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.file-icon {
    font-size: 2rem;
}

.file-extension {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: #666;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(10px);
}

.modal-content {
    position: relative;
    margin: 2% auto;
    width: 90%;
    max-width: 1000px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    box-shadow: 0 16px 64px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #2e7d32, #4caf50);
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.close {
    font-size: 2rem;
    font-weight: bold;
    cursor: pointer;
    color: rgba(255, 255, 255, 0.8);
    transition: color 0.3s ease;
    line-height: 1;
}

.close:hover {
    color: white;
}

.modal-body {
    padding: 2rem;
    text-align: center;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-body img,
.modal-body video {
    max-width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .page-header {
        padding: 1.5rem;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .header-left {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
    }

    .header-text h1 {
        font-size: 2rem;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .report-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .status-severity-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .badge {
        min-width: 150px;
        padding: 0.8rem 1rem;
        font-size: 0.9rem;
    }

    .report-title {
        font-size: 1.5rem;
        padding: 1.5rem;
    }

    .area-value {
        font-size: 3rem;
    }

    .timeline-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .timeline::before {
        left: 30px;
    }

    .media-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }

    .media-thumbnail {
        height: 100px;
    }

    .modal-content {
        width: 95%;
        margin: 5% auto;
    }

    .modal-header {
        padding: 1rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
        min-height: 300px;
    }
}

@media (max-width: 480px) {
    .header-text h1 {
        font-size: 1.8rem;
    }

    .report-title {
        font-size: 1.3rem;
    }

    .area-value {
        font-size: 2.5rem;
    }

    .timeline-content h3 {
        font-size: 1rem;
    }

    .badge {
        min-width: 120px;
        padding: 0.6rem 0.8rem;
        font-size: 0.8rem;
    }
}

/* Animation for page load */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.content-card,
.sidebar-card,
.page-header {
    animation: fadeInUp 0.6s ease-out;
}

/* Pulse animation for pending status */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

.status-pending {
    animation: pulse 2s infinite;
}
</style>

<script>
// Enhanced JavaScript for Report Detail Page
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            delay: { show: 300, hide: 100 },
            animation: true
        });
    });

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Lazy loading for media items
    const mediaImages = document.querySelectorAll('.media-thumbnail img');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.style.opacity = '0';
                    img.onload = () => {
                        img.style.transition = 'opacity 0.3s ease';
                        img.style.opacity = '1';
                    };
                    observer.unobserve(img);
                }
            });
        });

        mediaImages.forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Enhanced media modal functionality
    const mediaModal = document.getElementById('mediaModal');
    if (mediaModal) {
        mediaModal.addEventListener('hidden.bs.modal', function () {
            const modalImage = document.getElementById('modalImage');
            const modalVideo = document.getElementById('modalVideo');
            
            modalImage.style.display = 'none';
            modalImage.src = '';
            
            modalVideo.style.display = 'none';
            modalVideo.pause();
            modalVideo.querySelector('source').src = '';
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        // ESC key to close modal
        if (e.key === 'Escape') {
            const modalElement = document.querySelector('.modal.show');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
            }
        }
        
        // Ctrl/Cmd + E to edit report
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            const editButton = document.querySelector('a[href*="editReport"]');
            if (editButton) {
                editButton.click();
            }
        }
    });

    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-refresh status (if needed)
    const statusBadge = document.querySelector('.status-badge');
    if (statusBadge) {
        // Add subtle animation to pending status
        if (statusBadge.classList.contains('status-pending')) {
            statusBadge.style.animation = 'pulse 2s infinite';
        }
    }

    // Copy report ID to clipboard
    const reportIdCode = document.querySelector('.report-id-display code');
    if (reportIdCode) {
        reportIdCode.style.cursor = 'pointer';
        reportIdCode.title = 'Click to copy Report ID';
        
        reportIdCode.addEventListener('click', function() {
            const reportId = this.textContent;
            navigator.clipboard.writeText(reportId).then(() => {
                // Show temporary feedback
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                this.style.background = 'rgba(76, 175, 80, 0.3)';
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.background = '';
                }, 1500);
            });
        });
    }
});

// Enhanced Media Modal Function
function openMediaModal(src, type) {
    const modalElement = document.getElementById('mediaModal');
    const modalImage = document.getElementById('modalImage');
    const modalVideo = document.getElementById('modalVideo');
    
    // Hide both elements first
    modalImage.style.display = 'none';
    modalVideo.style.display = 'none';
    
    if (type === 'image') {
        modalImage.src = src;
        modalImage.style.display = 'block';
        
        // Add loading state
        modalImage.style.opacity = '0';
        modalImage.onload = () => {
            modalImage.style.transition = 'opacity 0.3s ease';
            modalImage.style.opacity = '1';
        };
    } else if (type === 'video') {
        const source = modalVideo.querySelector('source');
        source.src = src;
        modalVideo.load();
        modalVideo.style.display = 'block';
    }
    
    // Show modal using Bootstrap 5
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

// Add CSS for ripple effect and animations
const style = document.createElement('style');
style.textContent = `
    .btn {
        position: relative;
        overflow: hidden;
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    @keyframes pulse {
        0%, 100% { 
            opacity: 1; 
            transform: scale(1);
        }
        50% { 
            opacity: 0.8; 
            transform: scale(1.05);
        }
    }

    /* Smooth transitions for all interactive elements */
    .media-thumbnail,
    .status-badge,
    .severity-badge,
    .info-value code {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Focus states for accessibility */
    .media-thumbnail:focus,
    .btn:focus {
        outline: 3px solid rgba(46, 125, 50, 0.5);
        outline-offset: 2px;
    }

    /* Loading animation for images */
    .media-thumbnail img {
        transition: opacity 0.3s ease;
    }

    .media-thumbnail img[src=""] {
        opacity: 0;
    }
`;

document.head.appendChild(style);
</script>

<?php require APPROOT . '/views/inc/minimalfooter.php'; ?>
