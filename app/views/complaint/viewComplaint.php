<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/complain/viewComplaint.css?v=<?= time(); ?>">

<?php
// ─── Helpers ──────────────────────────────────────────────────────────────────

/**
 * Maps a raw status string to its CSS class name.
 */
function getStatusClass(string $raw): string
{
    $status = strtolower(trim($raw));
    $map = [
        'under review' => 'under-review',
        'under_review' => 'under-review',
        'reviewing' => 'under-review',
        'in progress' => 'under-review',
        'responded' => 'responded',
        'resolved' => 'resolved',
        'closed' => 'closed',
        'rejected' => 'rejected',
    ];
    return $map[$status] ?? 'pending';
}

/**
 * Renders a single media thumbnail (image, video, or file icon).
 */
function renderMediaItem(string $fileUrl, string $file): string
{
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    $isVideo = in_array($ext, ['mp4', 'avi', 'mov', 'wmv'], true);
    $type = $isImage ? 'image' : 'video';

    ob_start(); ?>
    <div class="vc-media-item" onclick="openLightbox('<?php echo $fileUrl; ?>', '<?php echo $type; ?>')">
        <?php if ($isImage): ?>
            <img src="<?php echo $fileUrl; ?>" alt="Attachment" loading="lazy">
        <?php elseif ($isVideo): ?>
            <video preload="metadata" muted playsinline>
                <source src="<?php echo $fileUrl; ?>" type="video/<?php echo $ext === 'mov' ? 'quicktime' : ($ext === 'avi' ? 'x-msvideo' : $ext); ?>">
            </video>
            <div class="vc-play-overlay"><i class="fas fa-play"></i></div>
        <?php else: ?>
            <div class="vc-play-overlay">📄 <?php echo strtoupper($ext); ?></div>
        <?php endif; ?>
    </div>
    <?php return ob_get_clean();
}

// ─── Data Setup ───────────────────────────────────────────────────────────────

$report = $data['report'];
$responses = $data['officer_responses'] ?? [];
$statusClass = getStatusClass($report->status ?? 'pending');
$severityClass = strtolower(trim($report->severity ?? 'low'));

$isDeleted = isset($report->is_deleted) && $report->is_deleted == 1;
$isEdited = isset($report->is_edited) && $report->is_edited == '1';
$userType = $_SESSION['user_type'] ?? '';
$userId = $_SESSION['user_id'] ?? '';
$farmerNIC = $_SESSION['nic'] ?? '';

$isOfficer = $userType === 'officer';
$isFarmer = $userType === 'farmer';
$isAdmin = $userType === 'admin';
$isReportOwner = $isFarmer && $farmerNIC === $report->farmerNIC;
$canEditReport = $isReportOwner && strtolower($report->status) === 'pending' && !$isDeleted;
$statusRaw = strtolower($report->status ?? '');
$isPending = ($statusRaw === 'pending');
$isUnderReview = ($statusRaw === 'under_review' || $statusRaw === 'under review');
?>

<div class="vc-wrapper">

    <!-- Back Link -->
    <a href="<?php echo URLROOT; ?>/complaint/myComplaints" class="vc-back">
        <i class="fas fa-arrow-left"></i> Back to My Complaints
    </a>

    <!-- ═══ Header Card ═══ -->
    <div class="vc-header">
        <div class="vc-header-top">

            <!-- Left: ID, badges, title, date -->
            <div class="vc-header-left">
                <div class="vc-id-row">
                    <span class="vc-complaint-id"><?php echo htmlspecialchars($report->complaint_id); ?></span>

                    <span class="vc-severity <?php echo $severityClass; ?>">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo ucfirst($report->severity ?? 'Low'); ?>
                    </span>

                    <?php if ($isDeleted): ?>
                        <span class="vc-badge vc-badge-deleted"><i class="fas fa-trash"></i> Deleted</span>
                    <?php endif; ?>

                    <?php if ($isEdited): ?>
                        <span class="vc-badge vc-badge-edited"><i class="fas fa-pencil-alt"></i> Edited</span>
                    <?php endif; ?>
                </div>

                <h1 class="vc-title"><?php echo htmlspecialchars($report->title); ?></h1>

                <div class="vc-submitted-date">
                    <i class="fas fa-clock"></i>
                    Submitted on <?php echo date('F d, Y \a\t h:i A', strtotime($report->created_at)); ?>
                </div>
            </div>

            <!-- Right: status, updater, farmer actions -->
            <div class="vc-header-right">

                <?php if (!$isDeleted): ?>
                    <div class="vc-status-group">
                        <?php if ($isOfficer): ?>
                            <!-- Officers can change status inline -->
                            <form action="<?php echo URLROOT; ?>/complaint/updateReportStatus" method="POST" class="vc-status-form">
                                <input type="hidden" name="reportCode" value="<?php echo $report->complaint_id; ?>">
                                <div class="vc-select-wrapper">
                                    <select name="status" class="vc-status-select <?php echo $statusClass; ?>" onchange="this.form.submit()">
                                        <?php
                                        $statusOptions = ['pending' => 'Pending', 'under_review' => 'Under Review', 'resolved' => 'Resolved', 'rejected' => 'Rejected'];
                                        foreach ($statusOptions as $value => $label): ?>
                                            <option value="<?php echo $value; ?>" <?php echo ($report->status === $value) ? 'selected' : ''; ?>>
                                                <?php echo $label; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </form>
                        <?php else: ?>
                            <!-- Farmers see a static status pill -->
                            <div class="vc-status <?php echo $statusClass; ?>">
                                <span class="dot"></span>
                                <?php echo ucwords(str_replace('_', ' ', $report->status ?? 'Pending')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($report->officer_first_name)): ?>
                    <div class="vc-updater">
                        <i class="fas fa-history"></i> Updated by:
                        <strong><?php echo htmlspecialchars($report->officer_first_name . ' ' . $report->officer_last_name); ?></strong>
                        (<?php echo htmlspecialchars($report->updater_id); ?>)
                    </div>
                <?php endif; ?>

                <?php if ($canEditReport): ?>
                    <div class="vc-actions">
                        <a href="<?php echo URLROOT; ?>/complaint/editReport/<?php echo $report->complaint_id; ?>" class="vc-btn vc-btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="vc-btn vc-btn-delete" onclick="openDeleteModal('<?php echo $report->complaint_id; ?>')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- ═══ Farmer Information ═══ -->
    <div class="vc-details">
        <div class="vc-section-title"><i class="fas fa-user"></i> Farmer Information</div>
        <div class="vc-info-grid">
            <?php
            $farmerFields = [
                'Farmer Name' => htmlspecialchars($report->farmer_name ?? 'N/A'),
                'Farmer NIC' => htmlspecialchars($report->farmerNIC),
                'Phone Number' => htmlspecialchars($report->farmer_phone ?? 'N/A'),
                'Address' => htmlspecialchars($report->farmer_address ?? 'N/A'),
            ];
            foreach ($farmerFields as $label => $value): ?>
                <div class="vc-info-item">
                    <label><?php echo $label; ?></label>
                    <p><?php echo $value; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ═══ Paddy Field Details ═══ -->
    <div class="vc-details">
        <div class="vc-section-title"><i class="fas fa-seedling"></i> Paddy Field Details</div>
        <div class="vc-info-grid">
            <?php
            $paddyFields = [
                'PLR Number' => htmlspecialchars($report->plrNumber),
                'Paddy Size' => htmlspecialchars($report->paddySize ?? 'N/A') . ' Acres',
                'Seed Variety' => htmlspecialchars($report->paddySeedVariety ?? 'N/A'),
                'Province' => htmlspecialchars($report->paddyProvince ?? 'N/A'),
                'District' => htmlspecialchars($report->paddyDistrict ?? 'N/A'),
                'GN Division' => htmlspecialchars($report->paddyGN ?? 'N/A'),
                'Agrarian Division' => htmlspecialchars($report->paddyAgrarian ?? 'N/A'),
                'Yaya' => htmlspecialchars($report->paddyYaya ?? 'N/A'),
            ];
            foreach ($paddyFields as $label => $value): ?>
                <div class="vc-info-item">
                    <label><?php echo $label; ?></label>
                    <p><?php echo $value; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ═══ Complaint Details ═══ -->
    <div class="vc-details">
        <div class="vc-section-title"><i class="fas fa-info-circle"></i> Complaint Details</div>

        <div class="vc-info-grid">
            <?php
            $reportFields = [
                'Affected Area' => htmlspecialchars($report->affectedArea) . ' Acres',
                'Observation Date' => date('F d, Y', strtotime($report->observationDate)),
            ];
            foreach ($reportFields as $label => $value): ?>
                <div class="vc-info-item">
                    <label><?php echo $label; ?></label>
                    <p><?php echo $value; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="vc-desc-box">
            <label>Description</label>
            <div class="vc-desc-text">
                <?php echo nl2br(htmlspecialchars($report->description)); ?>
            </div>
        </div>
    </div>

    <!-- ═══ Media Gallery ═══ -->
    <?php if (!empty($report->media)): ?>
        <div class="vc-media">
            <div class="vc-section-title"><i class="fas fa-images"></i> Media Attachments</div>
            <div class="vc-media-grid">
                <?php foreach (array_filter(array_map('trim', explode(',', $report->media))) as $file):
                    $filename = basename(trim($file));
                    $fileUrl = URLROOT . '/complaint/viewMedia/' . $report->complaint_id . '/' . urlencode($filename);
                    echo renderMediaItem($fileUrl, $filename);
                endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══ Officer Responses / Feedback ═══ -->
    <div class="vc-responses">
        <div class="vc-section-title"><i class="fas fa-clipboard-check"></i> Officer Feedback</div>

        <?php if (!empty($responses)): ?>
            <div class="vc-timeline">
                <?php foreach ($responses as $response):
                    $officerName = (!empty($response->first_name) && !empty($response->last_name))
                        ? htmlspecialchars($response->first_name . ' ' . $response->last_name)
                        : 'Agricultural Officer';
                    $canEditResponse = $isOfficer && $userId === $response->officer_id;
                    $respIsEdited = isset($response->is_edited) && $response->is_edited == '1';
                    $respIsDeleted = isset($response->is_deleted) && $response->is_deleted == '1';
                    ?>
                    <div class="vc-timeline-item <?php echo $respIsDeleted ? 'vc-resp-deleted-wrap' : ''; ?>" <?php echo $respIsDeleted ? 'style="opacity:0.7"' : ''; ?>>
                        <div class="vc-timeline-dot"></div>
                        <div class="vc-timeline-card">

                            <div class="vc-resp-header">
                                <span class="vc-officer-name">
                                    <?php echo $officerName; ?>
                                    <span class="vc-officer-id">(<?php echo htmlspecialchars($response->officer_id); ?>)</span>
                                </span>

                                <span class="vc-resp-date">
                                    <?php echo date('M d, Y h:i A', strtotime($response->created_at)); ?>
                                    <?php if ($respIsDeleted): ?>
                                        <span class="vc-badge vc-badge-deleted" style="margin-left: 8px;"><i class="fas fa-trash"></i> Deleted</span>
                                    <?php elseif ($respIsEdited): ?>
                                        <span class="vc-resp-edited">(edited)</span>
                                    <?php endif; ?>
                                </span>

                                <?php if ($canEditResponse && !$respIsDeleted): ?>
                                    <div class="vc-resp-actions">
                                        <button class="vc-action-icon edit" title="Edit" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($response)); ?>)">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="vc-action-icon delete" title="Delete" onclick="openDeleteRecModal(<?php echo (int) $response->id; ?>)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="vc-resp-body">
                                <?php echo nl2br(htmlspecialchars($response->response_message)); ?>
                            </div>

                            <?php if (!empty($response->response_media)): ?>
                                <div class="vc-resp-media">
                                    <?php foreach (array_filter(array_map('trim', explode(',', $response->response_media))) as $rFile):
                                        $responseFilename = basename(trim($rFile));
                                        $rFileUrl = URLROOT . '/complaint/viewResponseMedia/' . $response->id . '/' . urlencode($responseFilename);
                                        echo renderMediaItem($rFileUrl, $responseFilename);
                                    endforeach; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Conditional Officer Actions or Farmer Empty State -->
        <?php if ($isOfficer): ?>
            <?php if ($isPending): ?>
                <!-- Pending: Accept & Begin Review -->
                <div class="vc-officer-action-card">
                    <p>This complaint is currently <strong>Pending</strong>. Accept it to begin review.</p>
                    <form action="<?php echo URLROOT; ?>/complaint/updateReportStatus" method="POST">
                        <input type="hidden" name="reportCode" value="<?php echo $report->complaint_id; ?>">
                        <input type="hidden" name="status" value="under_review">
                        <button type="submit" class="vc-btn vc-btn-submit">
                            <i class="fas fa-play-circle"></i> Accept & Begin Review
                        </button>
                    </form>
                </div>
            <?php elseif ($isUnderReview): ?>
                <!-- Under Review: Submit Feedback Form -->
                <div class="vc-resp-form-wrapper">
                    <h4 class="vc-form-subtitle"><i class="fas fa-plus-circle"></i> Add New Feedback</h4>
                    <form action="<?php echo URLROOT; ?>/complaint/submitRecommendation" method="POST" enctype="multipart/form-data" class="vc-rec-form">
                        <input type="hidden" name="reportCode" value="<?php echo $report->complaint_id; ?>">
                        <div class="vc-form-group">
                            <label>Response Message</label>
                            <textarea name="message" class="vc-textarea" placeholder="Provide detailed advice for the farmer..." required></textarea>
                        </div>
                        <div class="vc-form-group">
                            <label><i class="fas fa-paperclip"></i> Attachments (Optional)</label>
                            <input type="file" name="media[]" id="recMedia" multiple accept="image/*,video/*,application/pdf">
                            <div id="fileList" class="vc-file-list"></div>
                        </div>
                        <button type="submit" class="vc-btn vc-btn-submit">
                            <i class="fas fa-paper-plane"></i> Submit Feedback
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        <?php elseif (($isFarmer || $isAdmin) && empty($responses)): ?>
            <!-- Farmer/Admin: No Feedback Yet -->
            <div class="vc-empty-responses">
                <p>No feedback provided yet.</p>
                <span class="vc-pending-pill"><span class="dot"></span> Pending Review</span>
            </div>
        <?php endif; ?>

    </div>

</div>

<!-- ═══ Modals ════════════════════════════════════════════════════════════════ -->

<!-- Delete Complaint Modal -->
<div id="vcDeleteModal" class="vc-modal">
    <div class="vc-modal-card">
        <div class="vc-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Delete Complaint?</h3>
        <p>Are you sure you want to delete complaint <strong id="vcDelId"></strong>?</p>
        <div class="vc-modal-warning">This action cannot be undone.</div>
        <div class="vc-modal-actions">
            <button class="vc-btn vc-btn-cancel" onclick="closeModal('vcDeleteModal')">Cancel</button>
            <a id="vcConfirmDeleteLink" href="#" class="vc-btn vc-btn-confirm-delete"><i class="fas fa-trash"></i> Delete</a>
        </div>
    </div>
</div>

<!-- Edit Response Modal -->
<div id="editRecModal" class="vc-modal">
    <div class="vc-modal-card">
        <div class="vc-modal-icon"><i class="fas fa-edit"></i></div>
        <h3>Edit Feedback</h3>
        <form action="<?php echo URLROOT; ?>/complaint/updateRecommendation" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="responseId" id="editRecId">
            <input type="hidden" name="reportCode" value="<?php echo $report->complaint_id; ?>">
            <div class="vc-form-group">
                <label>Update Message</label>
                <textarea name="message" id="editRecMessage" class="vc-textarea" required></textarea>
            </div>
            <div class="vc-form-group">
                <label>Add More Files</label>
                <input type="file" name="media[]" multiple accept="image/*,video/*,application/pdf">
            </div>
            <div class="vc-modal-actions">
                <button type="button" class="vc-btn vc-btn-cancel" onclick="closeModal('editRecModal')">Cancel</button>
                <button type="submit" class="vc-btn vc-btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Response Modal -->
<div id="deleteRecModal" class="vc-modal">
    <div class="vc-modal-card">
        <div class="vc-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Delete Feedback?</h3>
        <p>This will permanently remove your feedback from the timeline.</p>
        <div class="vc-modal-warning">This action cannot be undone.</div>
        <div class="vc-modal-actions">
            <button type="button" class="vc-btn vc-btn-cancel" onclick="closeModal('deleteRecModal')">Cancel</button>
            <a id="deleteRecLink" href="#" class="vc-btn vc-btn-confirm-delete">Delete</a>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="vcLightbox" class="vc-lightbox" onclick="closeLightbox()">
    <button class="vc-lightbox-close" onclick="closeLightbox()">&times;</button>
    <div class="vc-lightbox-content" onclick="event.stopPropagation()">
        <img id="vcLbImg" src="" style="display:none;" alt="Preview">
        <video id="vcLbVideo" controls style="display:none;"></video>
    </div>
</div>

<!-- ═══ JavaScript ════════════════════════════════════════════════════════════ -->
<script>
    const URLROOT = '<?php echo URLROOT; ?>';

    // ── Lightbox ──────────────────────────────────────────────────────────────────
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
        const vid = document.getElementById('vcLbVideo');
        vid.pause();
        vid.src = '';
    }

    // ── Modal Helpers ─────────────────────────────────────────────────────────────
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // ── Delete Complaint ──────────────────────────────────────────────────────────
    function openDeleteModal(complaintId) {
        document.getElementById('vcDelId').textContent = complaintId;
        document.getElementById('vcConfirmDeleteLink').href = `${URLROOT}/complaint/deleteReport/${complaintId}`;
        openModal('vcDeleteModal');
    }

    // ── Edit / Delete Response ────────────────────────────────────────────────────
    function openEditModal(response) {
        document.getElementById('editRecId').value = response.id;
        document.getElementById('editRecMessage').value = response.response_message;
        openModal('editRecModal');
    }
    function openDeleteRecModal(id) {
        document.getElementById('deleteRecLink').href = `${URLROOT}/complaint/deleteRecommendation/${id}`;
        openModal('deleteRecModal');
    }

    // ── File Listing ──────────────────────────────────────────────────────────────
    const recMedia = document.getElementById('recMedia');
    if (recMedia) {
        recMedia.addEventListener('change', function() {
            const list = document.getElementById('fileList');
            list.innerHTML = '';
            Array.from(this.files).forEach(f => {
                const div = document.createElement('div');
                div.className = 'vc-file-item';
                div.innerHTML = `<i class="fas fa-file"></i> ${f.name} (${(f.size/1024).toFixed(1)} KB)`;
                list.appendChild(div);
            });
        });
    }

    // ── Event Listeners ───────────────────────────────────────────────────────────

    // Close modals on outside click
    window.addEventListener('click', function (e) {
        ['vcDeleteModal', 'editRecModal', 'deleteRecModal'].forEach(id => {
            const m = document.getElementById(id);
            if (e.target === m) closeModal(id);
        });
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeLightbox();
            ['vcDeleteModal', 'editRecModal', 'deleteRecModal'].forEach(closeModal);
        }
    });
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>