<?php require APPROOT . '/views/inc/minimalheader.php'; ?>

<style>
/* Minimalist styles */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 1.5rem;
    border: 1px solid #eee;
}

.card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #eee;
    background: #fafafa;
}

.card-body {
    padding: 1.5rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 1.5rem;
}

.btn-group {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    font-weight: 500;
    border: 1px solid transparent;
}

.btn-outline {
    background: transparent;
    border-color: #ddd;
    color: #555;
}

.btn-outline:hover {
    background: #f5f5f5;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.media-item {
    position: relative;
    border-radius: 6px;
    overflow: hidden;
    aspect-ratio: 1;
    background: #f8f8f8;
}

.media-item img, .media-item video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.media-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 11px;
}

.file-preview {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #666;
    text-decoration: none;
}

.file-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 992px) {
    .info-grid {
        grid-template-columns: 2fr 1fr;
    }
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-block;
}

.bg-warning { background: #fff3cd; color: #856404; }
.bg-info { background: #d1ecf1; color: #0c5460; }
.bg-success { background: #d4edda; color: #155724; }
.bg-danger { background: #f8d7da; color: #721c24; }
.bg-secondary { background: #f8f9fa; color: #383d41; }

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
    background: #eee;
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

.timeline-content {
    margin-left: 0.5rem;
}

.text-muted { color: #6c757d; }
.text-primary { color: #007bff; }

.alert {
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert h4 {
    margin-top: 0;
}

h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    font-weight: 600;
}

.mb-0 { margin-bottom: 0; }
.mb-1 { margin-bottom: 0.5rem; }
.mb-2 { margin-bottom: 1rem; }
.mb-3 { margin-bottom: 1.5rem; }
.mb-4 { margin-bottom: 2rem; }

.text-center { text-align: center; }

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-content {
    max-width: 90%;
    max-height: 90%;
}

.modal img, .modal video {
    max-width: 100%;
    max-height: 90vh;
}

.close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: white;
    font-size: 2rem;
    cursor: pointer;
    background: rgba(0,0,0,0.5);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<div class="container">
    <?php if (isset($data['error']) && !empty($data['error'])): ?>
        <div class="alert alert-danger">
            <h4>Report Not Found</h4>
            <p><?php echo htmlspecialchars($data['error']); ?></p>
            <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-outline">
                Back to Reports
            </a>
        </div>
    <?php else: ?>
        <!-- Page Header -->
        <nav class="breadcrumb">
            <a href="<?php echo URLROOT; ?>/disease/viewReports">Reports</a>
            <span> / </span>
            <span>Report Details</span>
        </nav>
        
        <div class="card mb-4">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1>Disease Report</h1>
                        <p class="text-muted">ID: <?php echo htmlspecialchars($data['report']->reportId); ?></p>
                    </div>
                    <div class="btn-group">
                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->reportId; ?>" 
                           class="btn btn-outline">Edit</a>
                        <a href="<?php echo URLROOT; ?>/disease/confirmDelete/<?php echo $data['report']->reportId; ?>" 
                           class="btn btn-outline">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <!-- Main Content -->
            <div>
                <!-- Report Title -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Report Title</h3>
                    </div>
                    <div class="card-body">
                        <h2 class="text-primary"><?php echo htmlspecialchars($data['report']->title); ?></h2>
                    </div>
                </div>

                <!-- Status & Severity -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Status & Severity</h3>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <p class="mb-1"><strong>Status</strong></p>
                                <?php
                                $statusClass = '';
                                switch ($data['report']->status) {
                                    case 'pending':
                                        $statusClass = 'bg-warning';
                                        break;
                                    case 'under_review':
                                        $statusClass = 'bg-info';
                                        break;
                                    case 'resolved':
                                        $statusClass = 'bg-success';
                                        break;
                                    case 'rejected':
                                        $statusClass = 'bg-danger';
                                        break;
                                    default:
                                        $statusClass = 'bg-secondary';
                                }
                                ?>
                                <span class="status-badge <?php echo $statusClass; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $data['report']->status)); ?>
                                </span>
                            </div>
                            <div>
                                <p class="mb-1"><strong>Severity</strong></p>
                                <?php
                                $severityClass = '';
                                switch ($data['report']->severity) {
                                    case 'high':
                                        $severityClass = 'bg-danger';
                                        break;
                                    case 'medium':
                                        $severityClass = 'bg-warning';
                                        break;
                                    case 'low':
                                        $severityClass = 'bg-success';
                                        break;
                                    default:
                                        $severityClass = 'bg-secondary';
                                }
                                ?>
                                <span class="status-badge <?php echo $severityClass; ?>">
                                    <?php echo ucfirst($data['report']->severity); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Description</h3>
                    </div>
                    <div class="card-body">
                        <p><?php echo nl2br(htmlspecialchars($data['report']->description)); ?></p>
                    </div>
                </div>

                <!-- Affected Area -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Affected Area</h3>
                    </div>
                    <div class="card-body text-center">
                        <h2 style="font-size: 2.5rem; margin: 0; color: #e9b949;">
                            <?php echo number_format($data['report']->affectedArea, 2); ?>
                        </h2>
                        <p class="text-muted">Acres</p>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Timeline</h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Disease Observed</strong></p>
                                    <p class="text-muted">
                                        <?php echo date('F d, Y', strtotime($data['report']->observationDate)); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Report Created</strong></p>
                                    <p class="text-muted">
                                        <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?>
                                    </p>
                                </div>
                            </div>
                            <?php if (isset($data['report']->updated_at) && $data['report']->updated_at != $data['report']->created_at): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <p class="mb-0"><strong>Last Updated</strong></p>
                                        <p class="text-muted">
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
                            <h3>Media Files (<?php echo count($data['media']); ?>)</h3>
                        </div>
                        <div class="card-body">
                            <div class="media-grid">
                                <?php foreach ($data['media'] as $media): ?>
                                    <?php
                                    $filePath = URLROOT . '/uploads/disease_reports/' . $media->filename;
                                    $fileExt = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));
                                    ?>
                                    
                                    <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                        <div class="media-item" onclick="openModal('<?php echo $filePath; ?>', 'image')">
                                            <img src="<?php echo $filePath; ?>" alt="Disease evidence">
                                            <div class="media-badge">Image</div>
                                        </div>
                                    <?php elseif (in_array($fileExt, ['mp4', 'webm', 'ogg', 'mov'])): ?>
                                        <div class="media-item" onclick="openModal('<?php echo $filePath; ?>', 'video')">
                                            <video preload="metadata">
                                                <?php
                                                $mimeType = 'video/mp4';
                                                if ($fileExt == 'webm') $mimeType = 'video/webm';
                                                if ($fileExt == 'ogg') $mimeType = 'video/ogg';
                                                if ($fileExt == 'mov') $mimeType = 'video/quicktime';
                                                ?>
                                                <source src="<?php echo $filePath; ?>" type="<?php echo $mimeType; ?>">
                                            </video>
                                            <div class="media-badge">Video</div>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?php echo $filePath; ?>" target="_blank" class="media-item file-preview">
                                            <div class="file-icon">📄</div>
                                            <small><?php echo strtoupper($fileExt); ?> File</small>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <p class="text-muted">No media files attached to this report.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Farmer Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Farmer Information</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>NIC Number</strong></p>
                        <p class="mb-3"><?php echo htmlspecialchars($data['report']->farmerNIC); ?></p>
                        
                        <p class="mb-2"><strong>PLR Number</strong></p>
                        <p><?php echo htmlspecialchars($data['report']->plrNumber); ?></p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Actions</h3>
                    </div>
                    <div class="card-body" style="display: grid; gap: 0.5rem;">
                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->reportId; ?>" 
                           class="btn btn-outline">
                            Edit Report
                        </a>
                        <a href="<?php echo URLROOT; ?>/disease/viewReports" 
                           class="btn btn-outline">
                            All Reports
                        </a>
                        <button class="btn btn-outline" onclick="window.print()">
                            Print Report
                        </button>
                    </div>
                </div>

                <!-- Report Information -->
                <div class="card">
                    <div class="card-header">
                        <h3>Report Information</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Created</strong></p>
                        <p class="mb-3 text-muted">
                            <?php echo date('M d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?>
                        </p>
                        
                        <?php if (isset($data['report']->updated_at) && $data['report']->updated_at != $data['report']->created_at): ?>
                            <p class="mb-2"><strong>Updated</strong></p>
                            <p class="mb-3 text-muted">
                                <?php echo date('M d, Y \a\t g:i A', strtotime($data['report']->updated_at)); ?>
                            </p>
                        <?php endif; ?>
                        
                        <p class="mb-2"><strong>Observed</strong></p>
                        <p class="text-muted">
                            <?php echo date('M d, Y', strtotime($data['report']->observationDate)); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div id="modal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content" id="modalContent"></div>
</div>

<script>
// Function to open media in modal
function openModal(filePath, mediaType) {
    const modal = document.getElementById('modal');
    const modalContent = document.getElementById('modalContent');
    
    if (mediaType === 'image') {
        modalContent.innerHTML = `<img src="${filePath}" alt="Media preview">`;
    } else if (mediaType === 'video') {
        modalContent.innerHTML = `
            <video controls autoplay>
                <source src="${filePath}" type="video/mp4">
            </video>
        `;
    }
    
    modal.style.display = 'flex';
}

// Function to close modal
function closeModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none';
    
    // Stop any playing videos
    const videos = modal.querySelectorAll('video');
    videos.forEach(video => {
        video.pause();
    });
    
    document.getElementById('modalContent').innerHTML = '';
}

// Close modal when clicking outside content
document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

<?php require APPROOT . '/views/inc/minimalfooter.php'; ?>