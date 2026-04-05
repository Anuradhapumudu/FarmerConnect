<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/reportDetails.css?v=<?= time(); ?>">

<?php
$report = $data['report'];
$statusRaw = strtolower(trim($report->status ?? 'pending'));
$statusClass = 'pending';
if (in_array($statusRaw, ['under review', 'under_review', 'reviewing', 'in progress']))
    $statusClass = 'under_review';
elseif ($statusRaw === 'responded')
    $statusClass = 'responded';
elseif (in_array($statusRaw, ['resolved', 'closed']))
    $statusClass = $statusRaw;
elseif ($statusRaw === 'rejected')
    $statusClass = 'rejected';

$severityClass = strtolower(trim($report->severity ?? 'low'));
?>

<div class="rd-wrapper">

    <!-- Back Link -->
    <a href="<?php echo URLROOT; ?>/disease/viewReports" class="rd-back">
        <i class="fas fa-arrow-left"></i> Back to My Reports
    </a>

    <!-- ═══ Header Card ═══ -->
    <div class="rd-header">
        <div class="rd-header-top">
            <div class="rd-header-left">
                <div class="rd-id-row">
                    <span class="rd-report-id"><?php echo htmlspecialchars($report->report_code); ?></span>
                    <span class="rd-severity <?php echo $severityClass; ?>">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo ucfirst($report->severity ?? 'Low'); ?>
                    </span>
                    <?php if (isset($report->is_deleted) && $report->is_deleted == 1): ?>
                        <span class="rd-badge rd-badge-deleted"><i class="fas fa-trash"></i> Deleted</span>
                    <?php endif; ?>
                    <?php if (isset($report->is_edited) && $report->is_edited == '1'): ?>
                        <span class="rd-badge rd-badge-edited"><i class="fas fa-pencil-alt"></i> Edited</span>
                    <?php endif; ?>
                </div>
                <h1 class="rd-title"><?php echo htmlspecialchars($report->title); ?></h1>
                <div class="rd-submitted-date">
                    <i class="fas fa-clock"></i>
                    Submitted on <?php echo date('F d, Y \a\t h:i A', strtotime($report->created_at)); ?>
                </div>
            </div>

            <div class="rd-header-right">
                <!-- Status -->
                <?php if (!isset($report->is_deleted) || $report->is_deleted != 1): ?>
                    <div class="rd-status-group">
                        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'officer'): ?>
                            <!-- Interactive status for officers -->
                            <form action="<?php echo URLROOT; ?>/officerDashboard/updateReportStatus" method="POST"
                                class="rd-status-form">
                                <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">
                                <div class="rd-select-wrapper">
                                    <select name="status" class="rd-status-select <?php echo $statusClass; ?>" onchange="this.form.submit()">
                                        <option value="pending" <?php echo ($report->status === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="under_review" <?php echo ($report->status === 'under_review') ? 'selected' : ''; ?>>Under Review</option>
                                        <option value="resolved" <?php echo ($report->status === 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                                        <option value="rejected" <?php echo ($report->status === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                </div>
                            </form>
                        <?php else: ?>
                            <!-- Static status for farmers -->
                            <div class="rd-status <?php echo $statusClass; ?>">
                                <span class="dot"></span>
                                <?php echo ucwords(str_replace('_', ' ', $report->status ?? 'Pending')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Updated By -->
                <?php if (isset($report->officer_first_name) && !empty($report->officer_first_name)): ?>
                    <div class="rd-updater">
                        <i class="fas fa-history"></i> Updated by:
                        <strong><?php echo htmlspecialchars($report->officer_first_name . ' ' . $report->officer_last_name); ?></strong>
                        (<?php echo htmlspecialchars($report->updater_id); ?>)
                    </div>
                <?php endif; ?>

                <!-- Farmer Actions -->
                <?php if (
                    isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer'
                    && isset($_SESSION['nic']) && $_SESSION['nic'] === $report->farmerNIC
                    && strtolower($report->status) === 'pending'
                    && (!isset($report->is_deleted) || $report->is_deleted != 1)
                ): ?>
                    <div class="rd-actions">
                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $report->report_code; ?>"
                            class="rd-btn rd-btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="rd-btn rd-btn-delete"
                            onclick="openDeleteModal('<?php echo $report->report_code; ?>')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ═══ Report Details ═══ -->
    <div class="rd-details">
        <div class="rd-section-title">
            <i class="fas fa-info-circle"></i> Report Details
        </div>
        <div class="rd-info-grid">
            <div class="rd-info-item">
                <label>Farmer Name</label>
                <p><?php echo htmlspecialchars($report->farmer_name ?? 'N/A'); ?></p>
            </div>
            <div class="rd-info-item">
                <label>Farmer NIC</label>
                <p><?php echo htmlspecialchars($report->farmerNIC); ?></p>
            </div>
            <div class="rd-info-item">
                <label>PLR Number</label>
                <p><?php echo htmlspecialchars($report->plrNumber); ?></p>
            </div>
            <div class="rd-info-item">
                <label>Paddy Size</label>
                <p><?php echo htmlspecialchars($report->paddySize ?? 'N/A'); ?> Acres</p>
            </div>
            <div class="rd-info-item">
                <label>Affected Area</label>
                <p><?php echo htmlspecialchars($report->affectedArea); ?> Acres</p>
            </div>
            <div class="rd-info-item">
                <label>Observation Date</label>
                <p><?php echo date('F d, Y', strtotime($report->observationDate)); ?></p>
            </div>
        </div>

        <div class="rd-desc-box">
            <label>Description</label>
            <div class="rd-desc-text">
                <?php echo nl2br(htmlspecialchars($report->description)); ?>
            </div>
        </div>
    </div>

    <!-- ═══ Media Gallery ═══ -->
    <div class="rd-media">
        <div class="rd-section-title">
            <i class="fas fa-images"></i> Media Attachments
        </div>
        <?php if (!empty($report->media)): ?>
            <div class="rd-media-grid">
                <?php
                $mediaFiles = explode(',', $report->media);
                foreach ($mediaFiles as $file):
                    $file = trim($file);
                    if (empty($file))
                        continue;
                    $fileUrl = URLROOT . '/disease/viewMedia/' . $report->report_code . '/' . urlencode($file);
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    $isVideo = in_array($ext, ['mp4', 'avi', 'mov', 'wmv']);
                    ?>
                    <div class="rd-media-item"
                        onclick="openLightbox('<?php echo $fileUrl; ?>', '<?php echo $isImage ? 'image' : 'video'; ?>')">
                        <?php if ($isImage): ?>
                            <img src="<?php echo $fileUrl; ?>" alt="Evidence" loading="lazy">
                        <?php elseif ($isVideo): ?>
                            <video src="<?php echo $fileUrl; ?>" preload="metadata"></video>
                            <div class="rd-play-overlay"><i class="fas fa-play"></i></div>
                        <?php else: ?>
                            <div class="rd-play-overlay">📄 <?php echo strtoupper($ext); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rd-no-media">
                <i class="fas fa-image"></i>
                <p>No media attached to this report.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- ═══ Officer Responses ═══ -->
    <div class="rd-responses">
        <div class="rd-section-title">
            <i class="fas fa-clipboard-check"></i> Previous Feedback
        </div>

        <?php if (empty($data['officer_responses'])): ?>
            <div class="rd-empty-responses">
                <p>No feedback provided yet.</p>
                <span class="rd-pending-pill">
                    <span class="dot"></span> Pending Review
                </span>
            </div>
        <?php else: ?>
            <div class="rd-timeline">
                <?php foreach ($data['officer_responses'] as $response): ?>
                    <div class="rd-timeline-item">
                        <div class="rd-timeline-dot"></div>
                        <div class="rd-timeline-card">
                            <div class="rd-resp-header">
                                <span class="rd-officer-name">
                                    <?php
                                    $officerName = (isset($response->first_name) && isset($response->last_name))
                                        ? htmlspecialchars($response->first_name . ' ' . $response->last_name)
                                        : 'Agricultural Officer';
                                    echo $officerName;
                                    ?>
                                    <span class="rd-officer-id">(<?php echo htmlspecialchars($response->officer_id); ?>)</span>
                                </span>
                                <span class="rd-resp-date">
                                    <?php echo date('M d, Y h:i A', strtotime($response->created_at)); ?>
                                    <?php if (isset($response->is_edited) && $response->is_edited == '1'): ?>
                                        <span class="rd-resp-edited">(edited)</span>
                                    <?php endif; ?>
                                </span>
                                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'officer' && $_SESSION['user_id'] === $response->officer_id): ?>
                                    <div class="rd-resp-actions">
                                        <button class="rd-action-icon edit" title="Edit"
                                            onclick="openEditModal(<?php echo htmlspecialchars(json_encode($response)); ?>)">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="rd-action-icon delete" title="Delete"
                                            onclick="openDeleteRecModal(<?php echo $response->id; ?>)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="rd-resp-body">
                                <?php echo nl2br(htmlspecialchars($response->response_message)); ?>
                            </div>

                            <?php if (!empty($response->response_media)): ?>
                                <div class="rd-resp-media">
                                    <?php
                                    $respFiles = explode(',', $response->response_media);
                                    foreach ($respFiles as $rFile):
                                        $rFile = trim($rFile);
                                        if (empty($rFile))
                                            continue;
                                        $rFileUrl = URLROOT . '/disease/viewResponseMedia/' . $response->id . '/' . urlencode($rFile);
                                        $ext = strtolower(pathinfo($rFile, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        ?>
                                        <div class="rd-resp-media-item"
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

    <!-- ═══ Officer Recommendations Logic ═══ -->
    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'officer'): ?>
        <?php if ($report->status === 'pending'): ?>
            <!-- Prompt to change status first -->
            <div class="rd-recommendation-form-section rd-pending-prompt">
                <div class="rd-section-title">
                    <i class="fas fa-clipboard-check"></i> Start Report Review
                </div>
                <div class="rd-prompt-card">
                    <p>This report is currently <strong>Pending</strong>. You must change the status to <strong>Under Review</strong> to begin adding recommendations and feedback for the farmer.</p>
                    <form action="<?php echo URLROOT; ?>/officerDashboard/updateReportStatus" method="POST">
                        <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">
                        <input type="hidden" name="status" value="under_review">
                        <button type="submit" class="rd-btn rd-btn-submit">
                            <i class="fas fa-play-circle"></i> Accept & Begin Review
                        </button>
                    </form>
                </div>
            </div>
        <?php elseif ($report->status === 'under_review'): ?>
            <!-- recommendation Form -->
            <div class="rd-recommendation-form-section">
                <div class="rd-section-title">
                    <i class="fas fa-comment-medical"></i> Submit Recommendation
                </div>
                <form action="<?php echo URLROOT; ?>/officerDashboard/submitRecommendation" method="POST"
                    enctype="multipart/form-data" class="rd-rec-form">
                    <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">
                    <div class="rd-form-group">
                        <label>Recommendation Message</label>
                        <textarea name="message" class="rd-textarea"
                            placeholder="Provide detailed advice or next steps for the farmer..." required></textarea>
                    </div>
                    <div class="rd-form-group">
                        <label><i class="fas fa-paperclip"></i> Attachments (Optional)</label>
                        <div class="rd-file-upload-container">
                            <div class="rd-file-upload">
                                <input type="file" name="media[]" id="recMedia" multiple accept="image/*,video/*,application/pdf">
                                <label for="recMedia" class="rd-file-label">
                                    <i class="fas fa-cloud-upload-alt"></i> Choose Files
                                </label>
                            </div>
                            <div id="fileList" class="rd-file-list"></div>
                        </div>
                    </div>
                    <button type="submit" class="rd-btn rd-btn-submit">
                        <i class="fas fa-paper-plane"></i> Submit Recommendation
                    </button>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>


<!-- ═══ Delete Modal ═══ -->
<div id="rdDeleteModal" class="rd-modal">
    <div class="rd-modal-card">
        <div class="rd-modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>Delete Report?</h3>
        <p>Are you sure you want to delete report <strong id="rdDelId"></strong>?</p>
        <div class="rd-modal-warning">This action cannot be undone.</div>
        <div class="rd-modal-actions">
            <button class="rd-btn rd-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <a id="rdConfirmDeleteLink" href="#" class="rd-btn rd-btn-confirm-delete">
                <i class="fas fa-trash"></i> Delete
            </a>
        </div>
    </div>
</div>

<!-- ═══ Lightbox ═══ -->
<div id="rdLightbox" class="rd-lightbox" onclick="closeLightbox()">
    <button class="rd-lightbox-close" onclick="closeLightbox()">&times;</button>
    <div class="rd-lightbox-content" onclick="event.stopPropagation()">
        <img id="rdLbImg" src="" style="display:none;" alt="Preview">
        <video id="rdLbVideo" controls style="display:none;"></video>
    </div>
</div>

<script>
    // Lightbox
    function openLightbox(url, type) {
        const lb = document.getElementById('rdLightbox');
        const img = document.getElementById('rdLbImg');
        const vid = document.getElementById('rdLbVideo');
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
        document.getElementById('rdLightbox').style.display = 'none';
        document.getElementById('rdLbVideo').pause();
    }

    // Delete report modal
    function openDeleteModal(reportCode) {
        document.getElementById('rdDelId').textContent = reportCode;
        document.getElementById('rdConfirmDeleteLink').href = "<?php echo URLROOT; ?>/disease/deleteReport/" + reportCode;
        document.getElementById('rdDeleteModal').style.display = 'flex';
    }

    // Recommendation Edit/Delete Modals
    function openEditModal(response) {
        document.getElementById('editRecId').value = response.id;
        document.getElementById('editRecMessage').value = response.response_message;
        document.getElementById('editRecModal').style.display = 'flex';
    }

    function closeEditRecModal() {
        document.getElementById('editRecModal').style.display = 'none';
    }

    function openDeleteRecModal(id) {
        document.getElementById('deleteRecLink').href = "<?php echo URLROOT; ?>/officerDashboard/deleteRecommendation/" + id;
        document.getElementById('deleteRecModal').style.display = 'flex';
    }

    function closeDeleteRecModal() {
        document.getElementById('deleteRecModal').style.display = 'none';
    }

    function closeDeleteModal() {
        document.getElementById('rdDeleteModal').style.display = 'none';
    }

    // File list display
    const recMedia = document.getElementById('recMedia');
    if (recMedia) {
        recMedia.addEventListener('change', function () {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';
            for (let i = 0; i < this.files.length; i++) {
                const div = document.createElement('div');
                div.className = 'rd-file-item';
                div.innerHTML = `<i class="fas fa-file"></i> ${this.files[i].name}`;
                fileList.appendChild(div);
            }
        });
    }

    // Close modals on outside click
    window.addEventListener('click', function (e) {
        if (e.target === document.getElementById('rdDeleteModal')) closeDeleteModal();
        if (e.target === document.getElementById('editRecModal')) closeEditRecModal();
        if (e.target === document.getElementById('deleteRecModal')) closeDeleteRecModal();
    });

    // Close lightbox/modals on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeLightbox();
            closeDeleteModal();
            closeEditRecModal();
            closeDeleteRecModal();
        }
    });

</script>

<!-- ═══ Edit Recommendation Modal ═══ -->
<div id="editRecModal" class="rd-modal">
    <div class="rd-modal-card">
        <div class="rd-modal-icon" style="background:#e3f2fd; color:#1e88e5;">
            <i class="fas fa-edit"></i>
        </div>
        <h3>Edit Recommendation</h3>
        <form action="<?php echo URLROOT; ?>/officerDashboard/updateRecommendation" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="responseId" id="editRecId">
            <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">
            <div class="rd-form-group" style="text-align:left;">
                <label>Update Message</label>
                <textarea name="message" id="editRecMessage" class="rd-textarea" required
                    style="height:120px;"></textarea>
            </div>
            <div class="rd-form-group" style="text-align:left;">
                <label>Add More Files (Existing remain)</label>
                <input type="file" name="media[]" multiple accept="image/*,video/*,application/pdf">
            </div>
            <div class="rd-modal-actions">
                <button type="button" class="rd-btn rd-btn-cancel" onclick="closeEditRecModal()">Cancel</button>
                <button type="submit" class="rd-btn rd-btn-submit" style="background:#1e88e5; color:white;">Save
                    Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══ Delete Recommendation Modal ═══ -->
<div id="deleteRecModal" class="rd-modal">
    <div class="rd-modal-card">
        <div class="rd-modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>Delete Feedback?</h3>
        <p>This will permanently remove your recommendation from the timeline.</p>
        <div class="rd-modal-warning">This action cannot be undone.</div>
        <div class="rd-modal-actions">
            <button type="button" class="rd-btn rd-btn-cancel" onclick="closeDeleteRecModal()">Cancel</button>
            <a id="deleteRecLink" href="#" class="rd-btn rd-btn-confirm-delete">Delete</a>
        </div>
    </div>
</div>


<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>