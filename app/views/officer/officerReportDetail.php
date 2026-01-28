<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/diseaseReport.css?v=<?= time(); ?>">

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

<div class="content-card">
    <div class="report-header">
        <div class="header-content">
            <a href="<?php echo URLROOT; ?>/officerDashboard/viewDiseaseReports" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Reports
            </a>
            <div class="title-row">
                <h1>Report: <?php echo $data['report']->report_code; ?></h1>
            </div>
            <p class="report-date">
                Submitted on <?php echo date('F d, Y \a\t h:i A', strtotime($data['report']->created_at)); ?>
                <?php if(isset($data['report']->is_edited) && $data['report']->is_edited == '1'): ?>
                    <span class="status-badge status-edited"><i class="fas fa-pencil-alt"></i> Edited</span>
                <?php endif; ?>
            </p>
        </div>
        
        <div class="header-actions">
            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                <form method="POST" action="<?php echo URLROOT; ?>/officerDashboard/updateReportStatus" class="status-form-header" style="margin: 0;">
                    <input type="hidden" name="reportCode" value="<?php echo htmlspecialchars($data['report']->report_code); ?>">
                    <input type="hidden" name="redirect_to" value="details">
                    <div class="status-select-wrapper status-<?php echo $data['report']->status; ?>">
                        <select name="status" onchange="this.form.submit()" class="status-select">
                            <option value="pending" <?php echo ($data['report']->status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="under_review" <?php echo ($data['report']->status == 'under_review') ? 'selected' : ''; ?>>Under Review</option>
                            <option value="resolved" <?php echo ($data['report']->status == 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                            <option value="rejected" <?php echo ($data['report']->status == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                </form>
                <?php if(isset($data['report']->officer_first_name) && !empty($data['report']->officer_first_name)): ?>
                    <div class="status-updater-info" style="margin-top: 0; text-align: right;">
                        <i class="fas fa-history"></i> Updated by: 
                        <strong><?php echo htmlspecialchars($data['report']->officer_first_name . ' ' . $data['report']->officer_last_name); ?></strong>
                        (ID: <?php echo htmlspecialchars($data['report']->updater_id); ?>)
                    </div>
                <?php endif; ?>
            </div>
        </div>
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
                    <p><?php echo $data['report']->plrNumber ?? $data['report']->pirNumber; ?></p>
                </div>

                <div class="info-item">
                    <label>Farmer Name</label>
                    <p><?php echo $data['report']->farmer_name ?? 'N/A'; ?></p>
                </div>

                <div class="info-item">
                    <label>Farmer NIC</label>
                    <p class="highlight-text"><?php echo $data['report']->farmerNIC; ?></p>
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
        <h3><i class="fas fa-clipboard-check"></i> Officer Feedback & History</h3>
        
        <?php 
        $responses = $this->model('M_disease')->getOfficerResponses($data['report']->report_code);
        if(empty($responses)): 
        ?>
            <div class="empty-responses">
                <p>No feedback provided yet.</p>
            </div>
        <?php else: ?>
            <div class="timeline">
                <?php 
                $currentOfficerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'officer_' . session_id(); 
                foreach($responses as $response): 
                ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="response-header">
                                <span class="officer-name">
                                    <?php 
                                        $officerName = isset($response->first_name) && isset($response->last_name) 
                                            ? htmlspecialchars($response->first_name . ' ' . $response->last_name) 
                                            : 'Officer';
                                        echo $officerName . ' (' . htmlspecialchars($response->officer_id) . ')'; 
                                    ?>
                                    <?php if($response->officer_id === $currentOfficerId): ?>
                                        <span class="badge-me">(Me)</span>
                                    <?php endif; ?>
                                </span>
                                <div class="response-meta-group">
                                    <span class="response-date">
                                        <?php echo date('M d, Y h:i A', strtotime($response->created_at)); ?>
                                        <?php if(isset($response->is_edited) && $response->is_edited == '1'): ?>
                                            <span style="font-size: 0.8em; color: #888; font-style: italic; margin-left: 5px;">(edited)</span>
                                        <?php endif; ?>
                                    </span>
                                    <?php if($response->officer_id === $currentOfficerId): ?>
                                        <div class="response-actions">
                                            <button onclick="openEditModal('<?php echo $response->id; ?>', '<?php echo htmlspecialchars(addslashes($response->response_message)); ?>')" class="btn-icon-small edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="confirmDeleteRecommendation('<?php echo $response->id; ?>')" class="btn-icon-small delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
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
                                        $rFileUrl = URLROOT . '/officerDashboard/viewResponseMedia/' . $response->id . '/' . urlencode($rFile);
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

        <!-- Submit New Recommendation Form -->
        <?php if($data['report']->status === 'under_review'): ?>
            <div class="recommendation-form-wrapper" style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                <h3>Submit New Recommendation</h3>
                <form action="<?php echo URLROOT; ?>/officerDashboard/submitRecommendation" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="reportCode" value="<?php echo htmlspecialchars($data['report']->report_code); ?>">
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="message" style="display:block; margin-bottom: 5px; font-weight:600;">Recommendation Message</label>
                        <textarea id="message" name="message" rows="4" placeholder="Enter your recommendation..." required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display:block; margin-bottom: 8px; font-weight:600;">Attach Media</label>
                        <div class="upload-zone" id="drop-zone">
                            <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple hidden onchange="handleFileSelect(this)">
                            <label for="media" class="upload-label">
                                <div class="upload-icon-circle">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <span class="upload-text">Drag & drop files here or <span class="highlight">browse</span></span>
                                <small class="upload-hint">Supported: JPG, PNG, MP4 (Max 10MB)</small>
                            </label>
                            <div id="file-list" class="file-preview-list"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Recommendation
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Recommendation Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <div class="modal-header">
            <h3>Edit Recommendation</h3>
        </div>
        <form action="<?php echo URLROOT; ?>/officerDashboard/updateRecommendation" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="reportCode" value="<?php echo htmlspecialchars($data['report']->report_code); ?>">
            <input type="hidden" name="responseId" id="editResponseId">
            
            <div class="form-group">
                <label for="editMessage">Message</label>
                <textarea id="editMessage" name="message" rows="4" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
            </div>
            
             <div class="form-group" style="margin-top: 15px;">
                 <label>Add More Media (Optional)</label>
                 <input type="file" name="media[]" accept="image/*,video/*" multiple style="padding: 10px; background: #f9f9f9; width: 100%; border-radius: 8px;">
            </div>

            <div class="modal-actions" style="margin-top: 20px; text-align: right;">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Recommendation Modal -->
<div id="deleteRecModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteRecModal()">&times;</span>
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" style="color: #e74c3c; font-size: 2rem;"></i>
            <h3>Delete Recommendation?</h3>
        </div>
        <p>Are you sure you want to delete this recommendation?</p>
        <div class="modal-actions">
            <button onclick="closeDeleteRecModal()" class="btn btn-secondary">Cancel</button>
            <a id="confirmRecDeleteLink" href="#" class="btn btn-danger">Yes, Delete It</a>
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

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/officer_report_detail.css">
<script src="<?php echo URLROOT; ?>/js/officer/officer_report_detail.js"></script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>