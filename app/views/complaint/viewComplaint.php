<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/complain/viewComplaint.css?v=<?= time(); ?>">

<?php
$report = $data['report'];
$statusRaw = strtolower(trim($report->status ?? 'pending'));
$statusClass = 'pending';
if (in_array($statusRaw, ['under review', 'reviewing', 'in progress']))
    $statusClass = 'under-review';
elseif ($statusRaw === 'responded')
    $statusClass = 'responded';
elseif (in_array($statusRaw, ['resolved', 'closed']))
    $statusClass = $statusRaw;

$severityClass = strtolower(trim($report->severity ?? 'low'));
?>

<div class="vc-wrapper">

    <!-- Back Link -->
    <a href="<?php echo URLROOT; ?>/complaint/myComplaints" class="vc-back">
        <i class="fas fa-arrow-left"></i> Back to My Complaints
    </a>

    <!-- ═══ Header Card ═══ -->
    <div class="vc-header">
        <div class="vc-header-top">
            <div class="vc-header-left">
                <div class="vc-id-row">
                    <span class="vc-complaint-id">
                        <?php echo htmlspecialchars($report->complaint_id); ?>
                    </span>
                    <span class="vc-severity <?php echo $severityClass; ?>">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo ucfirst($report->severity ?? 'Low'); ?>
                    </span>
                    <?php if (isset($report->is_deleted) && $report->is_deleted == 1): ?>
                        <span class="vc-badge vc-badge-deleted"><i class="fas fa-trash"></i> Deleted</span>
                    <?php endif; ?>
                    <?php if (isset($report->is_edited) && $report->is_edited == '1'): ?>
                        <span class="vc-badge vc-badge-edited"><i class="fas fa-pencil-alt"></i> Edited</span>
                    <?php endif; ?>
                </div>
                <h1 class="vc-title">
                    <?php echo htmlspecialchars($report->title); ?>
                </h1>
                <div class="vc-submitted-date">
                    <i class="fas fa-clock"></i>
                    Submitted on
                    <?php echo date('F d, Y \a\t h:i A', strtotime($report->created_at)); ?>
                </div>
            </div>

            <div class="vc-header-right">
                <!-- Status -->
                <?php if (!isset($report->is_deleted) || $report->is_deleted != 1): ?>
                    <div class="vc-status <?php echo $statusClass; ?>">
                        <span class="dot"></span>
                        <?php echo ucwords(str_replace('_', ' ', $report->status ?? 'Pending')); ?>
                    </div>
                <?php endif; ?>

                <!-- Updated By -->
                <?php if (isset($report->officer_first_name) && !empty($report->officer_first_name)): ?>
                    <div class="vc-updater">
                        <i class="fas fa-history"></i> Updated by:
                        <strong>
                            <?php echo htmlspecialchars($report->officer_first_name . ' ' . $report->officer_last_name); ?>
                        </strong>
                        (
                        <?php echo htmlspecialchars($report->updater_id); ?>)
                    </div>
                <?php endif; ?>

                <!-- Farmer Actions -->
                <?php if (
                    isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer'
                    && isset($_SESSION['nic']) && $_SESSION['nic'] === $report->farmerNIC
                    && strtolower($report->status) === 'pending'
                    && (!isset($report->is_deleted) || $report->is_deleted != 1)
                ): ?>
                    <div class="vc-actions">
                        <a href="<?php echo URLROOT; ?>/complaint/editReport/<?php echo $report->complaint_id; ?>"
                            class="vc-btn vc-btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="vc-btn vc-btn-delete"
                            onclick="openDeleteModal('<?php echo $report->complaint_id; ?>')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ═══ Report Details ═══ -->
    <div class="vc-details">
        <div class="vc-section-title">
            <i class="fas fa-info-circle"></i> Complaint Details
        </div>
        <div class="vc-info-grid">
            <div class="vc-info-item">
                <label>Farmer Name</label>
                <p>
                    <?php echo htmlspecialchars($report->farmer_name ?? 'N/A'); ?>
                </p>
            </div>
            <div class="vc-info-item">
                <label>Farmer NIC</label>
                <p>
                    <?php echo htmlspecialchars($report->farmerNIC); ?>
                </p>
            </div>
            <div class="vc-info-item">
                <label>PLR Number</label>
                <p>
                    <?php echo htmlspecialchars($report->plrNumber); ?>
                </p>
            </div>
            <div class="vc-info-item">
                <label>Paddy Size</label>
                <p>
                    <?php echo htmlspecialchars($report->paddySize ?? 'N/A'); ?> Acres
                </p>
            </div>
            <div class="vc-info-item">
                <label>Affected Area</label>
                <p>
                    <?php echo htmlspecialchars($report->affectedArea); ?> Acres
                </p>
            </div>
            <div class="vc-info-item">
                <label>Observation Date</label>
                <p>
                    <?php echo date('F d, Y', strtotime($report->observationDate)); ?>
                </p>
            </div>
        </div>

        <div class="vc-desc-box">
            <label>Description</label>
            <div class="vc-desc-text">
                <?php echo nl2br(htmlspecialchars($report->description)); ?>
            </div>
        </div>
    </div>

    <!-- ═══ Media Gallery ═══ -->
    <div class="vc-media">
        <div class="vc-section-title">
            <i class="fas fa-images"></i> Media Attachments
        </div>
        <?php if (!empty($report->media)): ?>
            <div class="vc-media-grid">
                <?php
                $mediaFiles = explode(',', $report->media);
                foreach ($mediaFiles as $file):
                    $file = trim($file);
                    if (empty($file))
                        continue;
                    $fileUrl = URLROOT . '/complaint/viewMedia/' . $report->complaint_id . '/' . urlencode($file);
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    $isVideo = in_array($ext, ['mp4', 'avi', 'mov', 'wmv']);
                    ?>
                    <div class="vc-media-item"
                        onclick="openLightbox('<?php echo $fileUrl; ?>', '<?php echo $isImage ? 'image' : 'video'; ?>')">
                        <?php if ($isImage): ?>
                            <img src="<?php echo $fileUrl; ?>" alt="Evidence" loading="lazy">
                        <?php elseif ($isVideo): ?>
                            <video src="<?php echo $fileUrl; ?>" preload="metadata"></video>
                            <div class="vc-play-overlay"><i class="fas fa-play"></i></div>
                        <?php else: ?>
                            <div class="vc-play-overlay">📄
                                <?php echo strtoupper($ext); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="vc-no-media">
                <i class="fas fa-image"></i>
                <p>No media attached to this complaint.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- ═══ Officer Responses ═══ -->
    <div class="vc-responses">
        <div class="vc-section-title">
            <i class="fas fa-clipboard-check"></i> Officer Feedback
        </div>

        <?php if (empty($data['officer_responses'])): ?>
            <div class="vc-empty-responses">
                <p>No feedback provided yet.</p>
                <span class="vc-pending-pill">
                    <span class="dot"></span> Pending Review
                </span>
            </div>
        <?php else: ?>
            <div class="vc-timeline">
                <?php foreach ($data['officer_responses'] as $response): ?>
                    <div class="vc-timeline-item">
                        <div class="vc-timeline-dot"></div>
                        <div class="vc-timeline-card">
                            <div class="vc-resp-header">
                                <span class="vc-officer-name">
                                    <?php
                                    $officerName = (isset($response->first_name) && isset($response->last_name))
                                        ? htmlspecialchars($response->first_name . ' ' . $response->last_name)
                                        : 'Agricultural Officer';
                                    echo $officerName;
                                    ?>
                                    <span class="vc-officer-id">(
                                        <?php echo htmlspecialchars($response->officer_id); ?>)
                                    </span>
                                </span>
                                <span class="vc-resp-date">
                                    <?php echo date('M d, Y h:i A', strtotime($response->created_at)); ?>
                                    <?php if (isset($response->is_edited) && $response->is_edited == '1'): ?>
                                        <span class="vc-resp-edited">(edited)</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="vc-resp-body">
                                <?php echo nl2br(htmlspecialchars($response->response_message)); ?>
                            </div>

                            <?php if (!empty($response->response_media)): ?>
                                <div class="vc-resp-media">
                                    <?php
                                    $respFiles = explode(',', $response->response_media);
                                    foreach ($respFiles as $rFile):
                                        $rFile = trim($rFile);
                                        if (empty($rFile))
                                            continue;
                                        $rFileUrl = URLROOT . '/complaint/viewResponseMedia/' . $response->id . '/' . urlencode($rFile);
                                        $ext = strtolower(pathinfo($rFile, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        ?>
                                        <div class="vc-resp-media-item"
                                            onclick="openLightbox('<?php echo $rFileUrl; ?>', '<?php echo $isImage ? 'image' : 'video'; ?>')">
                                            <?php if ($isImage): ?>
                                                <img src="<?php echo $rFileUrl; ?>" alt="Response media" loading="lazy">
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

<!-- ═══ Delete Modal ═══ -->
<div id="vcDeleteModal" class="vc-modal">
    <div class="vc-modal-card">
        <div class="vc-modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>Delete Complaint?</h3>
        <p>Are you sure you want to delete complaint <strong id="vcDelId"></strong>?</p>
        <div class="vc-modal-warning">This action cannot be undone.</div>
        <div class="vc-modal-actions">
            <button class="vc-btn vc-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <a id="vcConfirmDeleteLink" href="#" class="vc-btn vc-btn-confirm-delete">
                <i class="fas fa-trash"></i> Delete
            </a>
        </div>
    </div>
</div>

<!-- ═══ Lightbox ═══ -->
<div id="vcLightbox" class="vc-lightbox" onclick="closeLightbox()">
    <button class="vc-lightbox-close" onclick="closeLightbox()">&times;</button>
    <div class="vc-lightbox-content" onclick="event.stopPropagation()">
        <img id="vcLbImg" src="" style="display:none;" alt="Preview">
        <video id="vcLbVideo" controls style="display:none;"></video>
    </div>
</div>

<script>
    // Lightbox
    function openLightbox(url, type) {
        const lb = document.getElementById('vcLightbox');
        const img = document.getElementById('vcLbImg');
        const vid = document.getElementById('vcLbVideo');
        lb.style.display = 'flex';
        if (type === 'image') {
            img.src = url;
            img.style.display = 'block';
            vid.style.display = 'none';
            vid.pause();
        } else {
            vid.src = url;
            vid.style.display = 'block';
            img.style.display = 'none';
        }
    }
    function closeLightbox() {
        document.getElementById('vcLightbox').style.display = 'none';
        document.getElementById('vcLbVideo').pause();
    }

    // Delete modal
    function openDeleteModal(complaintId) {
        document.getElementById('vcDelId').textContent = complaintId;
        document.getElementById('vcConfirmDeleteLink').href = "<?php echo URLROOT; ?>/complaint/deleteReport/" + complaintId;
        document.getElementById('vcDeleteModal').style.display = 'flex';
    }
    function closeDeleteModal() {
        document.getElementById('vcDeleteModal').style.display = 'none';
    }

    // Close modals on outside click
    window.addEventListener('click', function (e) {
        if (e.target === document.getElementById('vcDeleteModal')) closeDeleteModal();
    });

    // Close lightbox on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeLightbox();
            closeDeleteModal();
        }
    });
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>