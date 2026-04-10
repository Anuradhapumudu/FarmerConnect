<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/reportDetails.css?v=<?= time(); ?>">

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
 * Returns the HTML as a string so it can be used in both report and response sections.
 */
function renderMediaItem(string $fileUrl, string $file): string
{
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    $isVideo = in_array($ext, ['mp4', 'avi', 'mov', 'wmv'], true);
    $type = $isImage ? 'image' : 'video';

    ob_start(); ?>
        <div class="rd-media-item" onclick="openLightbox('<?php echo $fileUrl; ?>', '<?php echo $type; ?>')">
            <?php if ($isImage): ?>
                    <img src="<?php echo $fileUrl; ?>" alt="Attachment" loading="lazy">
            <?php elseif ($isVideo): ?>
                    <div class="rd-video-placeholder"><i class="fas fa-play"></i></div>
            <?php else: ?>
                    <div class="rd-play-overlay">📄 <?php echo strtoupper($ext); ?></div>
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
$isReportOwner = $isFarmer && $farmerNIC === $report->farmerNIC;
$canEditReport = $isReportOwner && strtolower($report->status) === 'pending' && !$isDeleted;
?>

<div class="rd-wrapper">

    <!-- Back Link -->
    <a href="<?php echo URLROOT; ?>/disease/viewReports" class="rd-back">
        <i class="fas fa-arrow-left"></i> Back to My Reports
    </a>

    <!-- ═══ Header Card ═══ -->
    <div class="rd-header">
        <div class="rd-header-top">

            <!-- Left: ID, badges, title, date -->
            <div class="rd-header-left">
                <div class="rd-id-row">
                    <span class="rd-report-id"><?php echo htmlspecialchars($report->report_code); ?></span>

                    <span class="rd-severity <?php echo $severityClass; ?>">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo ucfirst($report->severity ?? 'Low'); ?>
                    </span>

                    <?php if ($isDeleted): ?>
                            <span class="rd-badge rd-badge-deleted"><i class="fas fa-trash"></i> Deleted</span>
                    <?php endif; ?>

                    <?php if ($isEdited): ?>
                            <span class="rd-badge rd-badge-edited"><i class="fas fa-pencil-alt"></i> Edited</span>
                    <?php endif; ?>
                </div>

                <h1 class="rd-title"><?php echo htmlspecialchars($report->title); ?></h1>

                <div class="rd-submitted-date">
                    <i class="fas fa-clock"></i>
                    Submitted on <?php echo date('F d, Y \a\t h:i A', strtotime($report->created_at)); ?>
                </div>
            </div>

            <!-- Right: status, updater, farmer actions -->
            <div class="rd-header-right">

                <?php if (!$isDeleted): ?>
                        <div class="rd-status-group">
                            <?php if ($isOfficer): ?>
                                    <!-- Officers can change status inline -->
                                    <form action="<?php echo URLROOT; ?>/disease/updateReportStatus"
                                          method="POST" class="rd-status-form">
                                        <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">
                                        <div class="rd-select-wrapper">
                                            <select name="status"
                                                    class="rd-status-select <?php echo $statusClass; ?>"
                                                    onchange="this.form.submit()">
                                                <?php
                                                $statusOptions = ['pending' => 'Pending', 'under_review' => 'Under Review', 'resolved' => 'Resolved', 'rejected' => 'Rejected'];
                                                foreach ($statusOptions as $value => $label): ?>
                                                        <option value="<?php echo $value; ?>"
                                                            <?php echo ($report->status === $value) ? 'selected' : ''; ?>>
                                                            <?php echo $label; ?>
                                                        </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </form>
                            <?php else: ?>
                                    <!-- Farmers see a static status pill -->
                                    <div class="rd-status <?php echo $statusClass; ?>">
                                        <span class="dot"></span>
                                        <?php echo ucwords(str_replace('_', ' ', $report->status ?? 'Pending')); ?>
                                    </div>
                            <?php endif; ?>
                        </div>
                <?php endif; ?>

                <?php if (!empty($report->officer_first_name)): ?>
                        <div class="rd-updater">
                            <i class="fas fa-history"></i> Updated by:
                            <strong><?php echo htmlspecialchars($report->officer_first_name . ' ' . $report->officer_last_name); ?></strong>
                            (<?php echo htmlspecialchars($report->updater_id); ?>)
                        </div>
                <?php endif; ?>

                <?php if ($canEditReport): ?>
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

    <!-- ═══ Farmer Information ═══ -->
    <div class="rd-details">
        <div class="rd-section-title"><i class="fas fa-user"></i> Farmer Information</div>
        <div class="rd-info-grid">
            <?php
            $farmerFields = [
                'Farmer Name' => htmlspecialchars($report->farmer_name ?? 'N/A'),
                'Farmer NIC' => htmlspecialchars($report->farmerNIC),
                'Phone Number' => htmlspecialchars($report->farmer_phone ?? 'N/A'),
                'Address' => htmlspecialchars($report->farmer_address ?? 'N/A'),
            ];
            foreach ($farmerFields as $label => $value): ?>
                    <div class="rd-info-item">
                        <label><?php echo $label; ?></label>
                        <p><?php echo $value; ?></p>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ═══ Paddy Field Details ═══ -->
    <div class="rd-details">
        <div class="rd-section-title"><i class="fas fa-seedling"></i> Paddy Field Details</div>
        <div class="rd-info-grid">
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
                    <div class="rd-info-item">
                        <label><?php echo $label; ?></label>
                        <p><?php echo $value; ?></p>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ═══ Report Details ═══ -->
    <div class="rd-details">
        <div class="rd-section-title"><i class="fas fa-info-circle"></i> Report Details</div>

        <div class="rd-info-grid">
            <?php
            $reportFields = [
                'Affected Area' => htmlspecialchars($report->affectedArea) . ' Acres',
                'Observation Date' => date('F d, Y', strtotime($report->observationDate)),
            ];
            foreach ($reportFields as $label => $value): ?>
                    <div class="rd-info-item">
                        <label><?php echo $label; ?></label>
                        <p><?php echo $value; ?></p>
                    </div>
            <?php endforeach; ?>
        </div>

        <div class="rd-desc-box">
            <label>Description</label>
            <div class="rd-desc-text">
                <?php echo nl2br(htmlspecialchars($report->description)); ?>
            </div>
        </div>
    </div>

    <!-- ═══ Media Gallery ═══ -->
    <?php if (!empty($report->media)): ?>
            <div class="rd-media">
                <div class="rd-section-title"><i class="fas fa-images"></i> Media Attachments</div>
                <div class="rd-media-grid">
                    <?php foreach (array_filter(array_map('trim', explode(',', $report->media))) as $file):
                        $fileUrl = URLROOT . '/disease/viewMedia/' . $report->report_code . '/' . urlencode($file);
                        echo renderMediaItem($fileUrl, $file);
                    endforeach; ?>
                </div>
            </div>
    <?php endif; ?>

    <!-- ═══ Officer Responses / Feedback ═══ -->
    <?php if (!empty($responses) || $isFarmer): ?>
            <div class="rd-responses">
                <div class="rd-section-title"><i class="fas fa-clipboard-check"></i> Previous Feedback</div>

                <?php if (empty($responses)): ?>
                        <div class="rd-empty-responses">
                            <p>No feedback provided yet.</p>
                            <span class="rd-pending-pill"><span class="dot"></span> Pending Review</span>
                        </div>
                <?php else: ?>
                        <div class="rd-timeline">
                            <?php foreach ($responses as $response):
                                $officerName = (!empty($response->first_name) && !empty($response->last_name))
                                    ? htmlspecialchars($response->first_name . ' ' . $response->last_name)
                                    : 'Agricultural Officer';
                                $canEditResponse = $isOfficer && $userId === $response->officer_id;
                                $respIsEdited = isset($response->is_edited) && $response->is_edited == '1';
                                $respIsDeleted = isset($response->is_deleted) && $response->is_deleted == '1';
                                ?>
                                    <div class="rd-timeline-item <?php echo $respIsDeleted ? 'rd-resp-deleted-wrap' : ''; ?>" <?php echo $respIsDeleted ? 'style="opacity:0.7"' : ''; ?>>
                                        <div class="rd-timeline-dot"></div>
                                        <div class="rd-timeline-card">

                                            <div class="rd-resp-header">
                                                <span class="rd-officer-name">
                                                    <?php echo $officerName; ?>
                                                    <span class="rd-officer-id">(<?php echo htmlspecialchars($response->officer_id); ?>)</span>
                                                </span>

                                                <span class="rd-resp-date">
                                                    <?php echo date('M d, Y h:i A', strtotime($response->created_at)); ?>
                                                    <?php if ($respIsDeleted): ?>
                                                            <span class="rd-badge rd-badge-deleted" style="margin-left: 8px;"><i class="fas fa-trash"></i> Deleted</span>
                                                    <?php elseif ($respIsEdited): ?>
                                                            <span class="rd-resp-edited">(edited)</span>
                                                    <?php endif; ?>
                                                </span>

                                                <?php if ($canEditResponse && !$respIsDeleted): ?>
                                                        <div class="rd-resp-actions">
                                                            <button class="rd-action-icon edit" title="Edit"
                                                                    onclick="openEditModal(<?php echo htmlspecialchars(json_encode($response)); ?>)">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                            <button class="rd-action-icon delete" title="Delete"
                                                                    onclick="openDeleteRecModal(<?php echo (int) $response->id; ?>)">
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
                                                        <?php foreach (array_filter(array_map('trim', explode(',', $response->response_media))) as $rFile):
                                                            $rFileUrl = URLROOT . '/disease/viewResponseMedia/' . $response->id . '/' . urlencode($rFile);
                                                            echo renderMediaItem($rFileUrl, $rFile);
                                                        endforeach; ?>
                                                    </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                <?php endif; ?>
            </div>
    <?php endif; ?>

    <!-- ═══ Officer: Submit Recommendation ═══ -->
    <?php if ($isOfficer): ?>
            <?php if ($report->status === 'pending'): ?>
                    <!-- Prompt officer to accept the report before responding -->
                    <div class="rd-recommendation-form-section rd-pending-prompt">
                        <div class="rd-section-title"><i class="fas fa-clipboard-check"></i> Start Report Review</div>
                        <div class="rd-prompt-card">
                            <p>This report is currently <strong>Pending</strong>. Change the status to
                                <strong>Under Review</strong> to begin adding recommendations.</p>
                            <form action="<?php echo URLROOT; ?>/disease/updateReportStatus" method="POST">
                                <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">
                                <input type="hidden" name="status" value="under_review">
                                <button type="submit" class="rd-btn rd-btn-submit">
                                    <i class="fas fa-play-circle"></i> Accept &amp; Begin Review
                                </button>
                            </form>
                        </div>
                    </div>

            <?php elseif ($report->status === 'under_review'): ?>
                    <!-- Recommendation form -->
                    <div class="rd-recommendation-form-section">
                        <div class="rd-section-title"><i class="fas fa-comment-medical"></i> Submit Recommendation</div>
                        <form action="<?php echo URLROOT; ?>/disease/submitRecommendation"
                              method="POST" enctype="multipart/form-data" class="rd-rec-form">
                            <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">

                            <div class="rd-form-group">
                                <label>Recommendation Message</label>
                                <textarea name="message" class="rd-textarea"
                                          placeholder="Provide detailed advice or next steps for the farmer..."
                                          required></textarea>
                            </div>

                            <div class="rd-form-group">
                                <label><i class="fas fa-paperclip"></i> Attachments (Optional)</label>
                                <div class="rd-file-upload-container">
                                    <div class="rd-file-upload">
                                        <input type="file" name="media[]" id="recMedia" multiple
                                               accept="image/*,video/*,application/pdf">
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

<!-- ═══ Modals ════════════════════════════════════════════════════════════════ -->

<!-- Delete Report Modal -->
<div id="rdDeleteModal" class="rd-modal">
    <div class="rd-modal-card">
        <div class="rd-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Delete Report?</h3>
        <p>Are you sure you want to delete report <strong id="rdDelId"></strong>?</p>
        <div class="rd-modal-warning">This action cannot be undone.</div>
        <div class="rd-modal-actions">
            <button class="rd-btn rd-btn-cancel" onclick="closeModal('rdDeleteModal')">Cancel</button>
            <a id="rdConfirmDeleteLink" href="#" class="rd-btn rd-btn-confirm-delete">
                <i class="fas fa-trash"></i> Delete
            </a>
        </div>
    </div>
</div>

<!-- Edit Recommendation Modal -->
<div id="editRecModal" class="rd-modal">
    <div class="rd-modal-card rd-modal-card--blue">
        <div class="rd-modal-icon rd-modal-icon--blue"><i class="fas fa-edit"></i></div>
        <h3>Edit Recommendation</h3>
        <form action="<?php echo URLROOT; ?>/disease/updateRecommendation"
              method="POST" enctype="multipart/form-data">
            <input type="hidden" name="responseId" id="editRecId">
            <input type="hidden" name="reportCode" value="<?php echo $report->report_code; ?>">
            <div class="rd-form-group rd-form-group--left">
                <label>Update Message</label>
                <textarea name="message" id="editRecMessage" class="rd-textarea rd-textarea--short" required></textarea>
            </div>
            <div class="rd-form-group rd-form-group--left">
                <label>Add More Files (existing files remain)</label>
                <input type="file" name="media[]" multiple accept="image/*,video/*,application/pdf">
            </div>
            <div class="rd-modal-actions">
                <button type="button" class="rd-btn rd-btn-cancel" onclick="closeModal('editRecModal')">Cancel</button>
                <button type="submit" class="rd-btn rd-btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Recommendation Modal -->
<div id="deleteRecModal" class="rd-modal">
    <div class="rd-modal-card">
        <div class="rd-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Delete Feedback?</h3>
        <p>This will permanently remove your recommendation from the timeline.</p>
        <div class="rd-modal-warning">This action cannot be undone.</div>
        <div class="rd-modal-actions">
            <button type="button" class="rd-btn rd-btn-cancel" onclick="closeModal('deleteRecModal')">Cancel</button>
            <a id="deleteRecLink" href="#" class="rd-btn rd-btn-confirm-delete">Delete</a>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="rdLightbox" class="rd-lightbox" onclick="closeLightbox()">
    <button class="rd-lightbox-close" onclick="closeLightbox()">&times;</button>
    <div class="rd-lightbox-content" onclick="event.stopPropagation()">
        <img    id="rdLbImg"   src="" alt="Preview"  style="display:none;">
        <video  id="rdLbVideo" controls             style="display:none;"></video>
    </div>
</div>

<!-- ═══ JavaScript ════════════════════════════════════════════════════════════ -->
<script>
const URLROOT = '<?php echo URLROOT; ?>';

// ── Lightbox ──────────────────────────────────────────────────────────────────
function openLightbox(url, type) {
    const img = document.getElementById('rdLbImg');
    const vid = document.getElementById('rdLbVideo');
    const isImage = (type === 'image');

    img.src            = isImage ? url : '';
    img.style.display  = isImage ? 'block' : 'none';
    vid.src            = isImage ? '' : url;
    vid.style.display  = isImage ? 'none' : 'block';

    document.getElementById('rdLightbox').style.display = 'flex';
}

function closeLightbox() {
    document.getElementById('rdLightbox').style.display = 'none';
    const vid = document.getElementById('rdLbVideo');
    vid.pause();
    vid.src = '';
}

// ── Generic modal helpers ─────────────────────────────────────────────────────
function openModal(id)  { document.getElementById(id).style.display = 'flex'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }

// ── Delete report modal ───────────────────────────────────────────────────────
function openDeleteModal(reportCode) {
    document.getElementById('rdDelId').textContent           = reportCode;
    document.getElementById('rdConfirmDeleteLink').href      = `${URLROOT}/disease/deleteReport/${reportCode}`;
    openModal('rdDeleteModal');
}

// ── Edit / Delete recommendation modals ──────────────────────────────────────
function openEditModal(response) {
    document.getElementById('editRecId').value      = response.id;
    document.getElementById('editRecMessage').value = response.response_message;
    openModal('editRecModal');
}

function openDeleteRecModal(id) {
    document.getElementById('deleteRecLink').href = `${URLROOT}/disease/deleteRecommendation/${id}`;
    openModal('deleteRecModal');
}

// ── File list preview ─────────────────────────────────────────────────────────
const recMediaInput = document.getElementById('recMedia');
if (recMediaInput) {
    recMediaInput.addEventListener('change', function () {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = Array.from(this.files)
            .map(f => `<div class="rd-file-item"><i class="fas fa-file"></i> ${f.name}</div>`)
            .join('');
    });
}

// ── Close on backdrop click ───────────────────────────────────────────────────
const modalIds = ['rdDeleteModal', 'editRecModal', 'deleteRecModal'];
window.addEventListener('click', (e) => {
    modalIds.forEach(id => {
        if (e.target === document.getElementById(id)) closeModal(id);
    });
});

// ── Close on Escape key ───────────────────────────────────────────────────────
document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    closeLightbox();
    modalIds.forEach(closeModal);
});
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>