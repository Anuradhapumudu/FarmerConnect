<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/diseaseReport.css?v=<?= time(); ?>">

<div class="content-card">
    <div class="report-header">
        <div class="header-content">
            <a href="<?php echo URLROOT; ?>/disease/viewReports" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Reports
            </a>
            <div class="title-row">
                <h1>Report : <?php echo $data['report']->report_code; ?></h1>
                <span class="status-badge status-<?php echo strtolower($data['report']->status); ?>">
                    <?php echo ucwords(str_replace('_', ' ', $data['report']->status)); ?>
                </span>
            </div>
            <p class="report-date">Submitted on <?php echo date('F d, Y \a\t h:i A', strtotime($data['report']->created_at)); ?></p>
        </div>
        
        <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && $_SESSION['nic'] === $data['report']->farmerNIC && $data['report']->status === 'pending'): ?>
            <div class="header-actions">
                <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $data['report']->report_code; ?>" class="btn btn-secondary" >
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button onclick="confirmDelete('<?php echo $data['report']->report_code; ?>')" class="btn btn-danger-outline">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        <?php endif; ?>
    </div>

    <div class="report-grid">
        <!-- Main Details -->
        <div class="details-section">
            <h3>Report Details</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Report Title</label>
                    <p class="highlight"><?php echo $data['report']->title; ?></p>
                </div>
                
                <div class="info-item">
                    <label>Observation Date</label>
                    <p><?php echo $data['report']->observationDate; ?></p>
                </div>

                <div class="info-item">
                    <label>Severity Level</label>
                    <p>
                        <span class="severity-dot severity-<?php echo strtolower($data['report']->severity); ?>"></span>
                        <?php echo ucfirst($data['report']->severity); ?>
                    </p>
                </div>

                <div class="info-item">
                    <label>Affected Area</label>
                    <p><?php echo $data['report']->affectedArea; ?> Acres</p>
                </div>

                <div class="info-item">
                    <label>PLR Number</label>
                    <p><?php echo $data['report']->plrNumber; ?></p>
                </div>

                <div class="info-item">
                    <label>Farmer Name</label>
                    <p><?php echo $data['report']->farmer_name ?? 'N/A'; ?></p>
                </div>
            </div>

            <div class="description-box">
                <label>Description</label>
                <div class="text-content">
                    <?php echo nl2br(htmlspecialchars($data['report']->description)); ?>
                </div>
            </div>
        </div>

        <!-- Media Gallery -->
        <div class="media-section">
            <h3>Media Attachments</h3>
            <?php if(!empty($data['report']->media)): ?>
                <div class="media-gallery">
                    <?php 
                    $mediaFiles = explode(',', $data['report']->media);
                    foreach($mediaFiles as $file): 
                        $file = trim($file);
                        if(empty($file)) continue;
                        $fileUrl = URLROOT . '/disease/viewMedia/' . $data['report']->report_code . '/' . urlencode($file);
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                    ?>
                        <div class="media-item" onclick="openLightbox('<?php echo $fileUrl; ?>', '<?php echo $isImage ? 'image' : 'video'; ?>')">
                            <?php if($isImage): ?>
                                <img src="<?php echo $fileUrl; ?>" alt="Evidence">
                            <?php else: ?>
                                <video src="<?php echo $fileUrl; ?>"></video>
                                <div class="play-overlay"><i class="fas fa-play"></i></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-media">
                    <i class="fas fa-image"></i>
                    <p>No media attached to this report.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Officer Responses -->
    <div class="responses-section">
        <h3><i class="fas fa-clipboard-check"></i> Officer Feedback</h3>
        
        <?php if(empty($data['officer_responses'])): ?>
            <div class="empty-responses">
                <p>No feedback provided yet.</p>
                <span class="status-pill pending">Pending Review</span>
            </div>
        <?php else: ?>
            <div class="timeline">
                <?php foreach($data['officer_responses'] as $response): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="response-header">
                                <span class="officer-name">
                                    <?php 
                                        $officerName = isset($response->first_name) && isset($response->last_name) 
                                            ? htmlspecialchars($response->first_name . ' ' . $response->last_name) 
                                            : 'Agricultural Officer';
                                        echo $officerName . ' (' . htmlspecialchars($response->officer_id) . ')'; 
                                    ?>
                                </span>
                                <span class="response-date"><?php echo date('M d, Y h:i A', strtotime($response->created_at)); ?></span>
                            </div>
                            <div class="response-body">
                                <?php echo nl2br(htmlspecialchars($response->response_message)); ?>
                            </div>
                            
                            <?php if(!empty($response->response_media)): ?>
                                <div class="response-media-gallery">
                                    <?php 
                                    $respFiles = explode(',', $response->response_media);
                                    foreach($respFiles as $rFile):
                                        $rFile = trim($rFile);
                                        if(empty($rFile)) continue;
                                        $rFileUrl = URLROOT . '/disease/viewResponseMedia/' . $response->id . '/' . urlencode($rFile);
                                        $ext = strtolower(pathinfo($rFile, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    ?>
                                        <div class="media-item-small" onclick="openLightbox('<?php echo $rFileUrl; ?>', '<?php echo $isImage ? 'image' : 'video'; ?>')">
                                            <?php if($isImage): ?>
                                                <img src="<?php echo $rFileUrl; ?>" alt="Evidence">
                                            <?php else: ?>
                                                <div class="video-placeholder">
                                                    <i class="fas fa-play"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" style="color: #e74c3c; font-size: 2rem;"></i>
            <h3>Delete Report?</h3>
        </div>
        <p>Are you sure you want to delete this report?</p>
        <p class="modal-warning">This action cannot be undone.</p>
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
            <a id="confirmDeleteLink" href="#" class="!important btn-danger">Yes, Delete It</a>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="close-lightbox">&times;</span>
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" style="display:none;">
        <video id="lightbox-video" controls style="display:none;"></video>
    </div>
</div>

<script>
    function confirmDelete(reportCode) {
        document.getElementById('confirmDeleteLink').href = "<?php echo URLROOT; ?>/disease/deleteReport/" + reportCode;
        document.getElementById('deleteModal').style.display = "block";
    }
    
    function closeModal() {
        document.getElementById('deleteModal').style.display = "none";
    }

    function openLightbox(url, type) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const video = document.getElementById('lightbox-video');
        
        lightbox.style.display = 'flex';
        
        if (type === 'image') {
            img.src = url;
            img.style.display = 'block';
            video.style.display = 'none';
            video.pause();
        } else {
            video.src = url;
            video.style.display = 'block';
            img.style.display = 'none';
        }
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.getElementById('lightbox-video').pause();
    }
</script>

<style>
    /* Small Media Grid for Responses */
    .response-media-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 8px;
        margin-top: 12px;
    }

    .media-item-small {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid #eee;
        background: #f9f9f9;
        transition: transform 0.2s;
    }
    
    .media-item-small:hover {
        transform: scale(1.02);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .media-item-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .media-item-small .video-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #000;
        color: white;
    }
</style>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>