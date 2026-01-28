<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/diseaseReport.css?v=<?= time(); ?>">
<script src="<?php echo URLROOT; ?>/js/disease/diseaseReport.js?v=<?= time(); ?>" defer></script>

<div class="content-card">
    <div class="content-header">
        <div>
            <h1>Disease Detector</h1>
            <p class="content-subtitle"><?php echo isset($data['isEdit']) && $data['isEdit'] ? 'Update your disease report' : 'Report plant diseases to help protect our agricultural community'; ?></p>
        </div>
        <?php if (isset($data['isEdit']) && $data['isEdit']): ?>
            <button type="button" class="btn btn-danger" onclick="confirmDeleteReport('<?php echo $data['reportCode']; ?>')" style="background-color: #e74c3c; color: white; border: none; padding: 10px 20px; font-size: 1rem;">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        <?php endif; ?>
    </div>

    <!-- General Error Message -->
    <?php if (isset($data['errors']['general_error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <div><?php echo $data['errors']['general_error']; ?></div>
        </div>
    <?php endif; ?>

    <!-- Report ID display for edit mode -->
    <?php if (isset($data['isEdit']) && $data['isEdit']): ?>
        <div class="report-id-display">
            <label>Editing Report:</label>
            <span><?php echo htmlspecialchars($data['reportCode']); ?></span>
        </div>
    <?php endif; ?>

    <form action="<?php echo URLROOT; ?>/disease/<?php echo isset($data['isEdit']) && $data['isEdit'] ? 'updateReport' : 'submit'; ?>" method="POST" id="diseaseReportForm" class="framework-form" enctype="multipart/form-data">
        <!-- Hidden inputs for edit mode -->
        <?php if (isset($data['isEdit']) && $data['isEdit']): ?>
            <input type="hidden" name="reportCode" value="<?php echo $data['reportCode']; ?>">
            <input type="hidden" name="existingMedia" value="<?php echo $data['existingMedia']; ?>">
        <?php endif; ?>
        <input type="hidden" name="submission_timestamp" value="">

        <div class="form-group">
            <label for="farmerNIC" class="required">Farmer NIC Number</label>
            <input type="text" id="farmerNIC" name="farmerNIC"
                   placeholder="Enter your National Identity Card number" value="<?php echo $data['farmerNIC']; ?>" readonly class="<?php echo !empty($data['errors']['farmerNIC_error']) ? 'is-invalid' : ''; ?>">
            <span class="error"><?php echo $data['errors']['farmerNIC_error'] ?? ''; ?></span>
        </div>
        
        <div class="form-group">
            <label for="plrNumber" class="required">PLR Number</label>
            <select id="plrNumber" name="plrNumber" onchange="loadPaddySize()" class="<?php echo !empty($data['errors']['plrNumber_error']) ? 'is-invalid' : ''; ?>">
                <option value="">.. Select PLR ..</option>
                <?php if(!empty($data['paddyFields'])): ?>
                    <?php foreach($data['paddyFields'] as $paddy): ?>
                        <option value="<?php echo $paddy->PLR; ?>" data-size="<?php echo $paddy->Paddy_Size; ?>"
                                <?php echo (isset($data['plrNumber']) && $data['plrNumber'] == $paddy->PLR) ? 'selected' : ''; ?>>
                            <?php echo $paddy->PLR; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <span class="error"><?php echo $data['errors']['plrNumber_error'] ?? ''; ?></span>
        </div>

        <div class="form-group">
            <label for="paddySize" class="required">Paddy Size (Acres)</label>
            <input type="number" id="paddySize" name="paddySize" step="0.01" min="0" readonly value="<?php echo isset($data['paddySize']) ? $data['paddySize'] : ''; ?>" class="<?php echo !empty($data['errors']['paddySize_error']) ? 'is-invalid' : ''; ?>">
            <span class="error"><?php echo $data['errors']['paddySize_error'] ?? ''; ?></span>
        </div>
        
        <div class="form-group-split">
            <div class="form-group-half">
                <label for="observationDate" style="color:#2e7d32; font-weight:600">Date of Observation <span class="required-star">*</span></label>
                <input type="date" id="observationDate" name="observationDate" value="<?php echo $data['observationDate']; ?>" class="<?php echo !empty($data['errors']['observationDate_error']) ? 'is-invalid' : ''; ?>">
                <span class="error"><?php echo $data['errors']['observationDate_error'] ?? ''; ?></span>
            </div>
            <div class="form-group-half">
                <label for="todayDate" style="color:#2e7d32; font-weight:600">Today's Date</label>
                <input type="date" id="todayDate" name="todayDate" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label for="title" class="required">Report Title</label>
            <input type="text" id="title" name="title" 
                   placeholder="Brief description of the issue" value="<?php echo $data['title']; ?>" class="<?php echo !empty($data['errors']['title_error']) ? 'is-invalid' : ''; ?>">
            <span class="error"><?php echo $data['errors']['title_error'] ?? ''; ?></span>
        </div>
        
        <div class="form-group">
            <label for="description" class="required">Detailed Description</label>
            <textarea id="description" name="description" 
                placeholder="Describe the symptoms, patterns, and any other relevant details" class="<?php echo !empty($data['errors']['description_error']) ? 'is-invalid' : ''; ?>"><?php echo $data['description']; ?></textarea>
            <span class="error"><?php echo $data['errors']['description_error'] ?? ''; ?></span>
        </div>
        
        <div class="form-group">
            <label for="media">Upload Images / Video</label>
            <label class="file-upload" id="mediaUploadArea" for="media">
                <div>
                    <i class="upload-icon"><img style="width: 30px; height: 30px;" src="https://cdn-icons-png.flaticon.com/128/10024/10024248.png"></i>
                    <div class="blinking-text-container">
                <p class="blinking-text">‼️ Reports with photos/videos get faster response from officers!</p>
            </div>
                    <p>Click to upload or drag and drop</p>
                    <p class="upload-subtext">PNG, JPG, GIF, MP4 up to 10MB</p>
                </div>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" hidden multiple>
            </label>
            <span class="error"><?php echo $data['errors']['media_error'] ?? ''; ?></span>
            <div class="uploaded-files" id="uploadedFiles" style="margin-top: 10px;"></div>

            <!-- Existing media files for edit mode -->
            <?php if (isset($data['isEdit']) && $data['isEdit'] && !empty($data['existingMedia'])): ?>
                <div class="existing-media-section" id="existingMedia">
                    <h4>Current Media Files:</h4>
                    <div class="media-grid">
                        <?php
                        $existingFiles = explode(',', $data['existingMedia']);
                        foreach ($existingFiles as $index => $filename):
                            $filename = trim($filename);
                            if (empty($filename)) continue;
                            $fileUrl = URLROOT . '/disease/viewMedia/' . $data['reportCode'] . '/' . urlencode($filename);
                            $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                            $isVideo = in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv']);
                        ?>
                            <div class="media-card">
                                <!-- Remove button -->
                                <button type="button" class="btn-remove-media" data-filename="<?php echo htmlspecialchars($filename); ?>" title="Remove file">
                                    <i class="fas fa-times"></i>
                                </button>

                                <!-- Hidden checkbox for form submission -->
                                <input type="checkbox" name="removeMedia[]" value="<?php echo htmlspecialchars($filename); ?>" id="remove_<?php echo $index; ?>" style="display: none;">

                                <!-- Media preview -->
                                <div class="media-preview-container">
                                    <?php if ($isImage): ?>
                                        <img src="<?php echo $fileUrl; ?>" alt="Preview">
                                    <?php elseif ($isVideo): ?>
                                        <video controls>
                                            <source src="<?php echo $fileUrl; ?>" type="video/<?php echo $fileExtension; ?>">
                                            Video preview not supported
                                        </video>
                                    <?php else: ?>
                                        <div class="file-icon-placeholder">
                                            📄 <?php echo strtoupper($fileExtension); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Filename -->
                                <div class="media-filename">
                                    <?php echo htmlspecialchars($filename); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <p class="media-help-text">
                        Click the <i class="fas fa-times-circle" style="color:#e74c3c;"></i> button to remove files.
                    </p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label class="required">Severity Level</label>
            <div class="radio-group" class="<?php echo !empty($data['errors']['severity_error']) ? 'is-invalid-group' : ''; ?>">
                <label class="radio-option severity-low">
                    <input type="radio" name="severity" value="low" <?php echo ($data['severity'] == 'low') ? 'checked' : ''; ?>>
                    Low
                </label>
                <label class="radio-option severity-medium">
                    <input type="radio" name="severity" value="medium" <?php echo ($data['severity'] == 'medium') ? 'checked' : ''; ?>>
                    Medium
                </label>
                <label class="radio-option severity-high">
                    <input type="radio" name="severity" value="high" <?php echo ($data['severity'] == 'high') ? 'checked' : ''; ?>>
                    High
                </label>
            </div>
            <span class="error"><?php echo $data['errors']['severity_error'] ?? ''; ?></span>
        </div>
        
        <div class="form-group">
            <label for="affectedArea" class="required">Affected Area (in acres)</label>
            <input type="number" id="affectedArea" name="affectedArea" 
                   placeholder="Enter the size of the affected area" min="0" step="0.1" value="<?php echo $data['affectedArea']; ?>" class="<?php echo !empty($data['errors']['affectedArea_error']) ? 'is-invalid' : ''; ?>">
            <span class="error"><?php echo $data['errors']['affectedArea_error'] ?? ''; ?></span>
        </div>
        
        <div class="form-group">
            <div class="checkbox-container">
                <label for="terms" class="checkbox-label required">
                    <input type="checkbox" id="terms" name="terms" <?php echo ($data['terms'] == 'on') ? 'checked' : ''; ?> class="<?php echo !empty($data['errors']['terms_error']) ? 'is-invalid-checkbox' : ''; ?>">
                    I agree to the <a href="<?php echo URLROOT; ?>/pages/terms/disease" class="terms-link" target="_blank">terms and conditions</a>
                </label>
            </div>
            <span class="error"><?php echo $data['errors']['terms_error'] ?? ''; ?></span>
        </div>
        
        <!-- Required fields notice -->
        <div class="required-fields-notice" role="alert" aria-live="polite">
            <span class="required-indicator" aria-hidden="true">*</span> All fields marked with <span class="required-indicator" aria-hidden="true">*</span> are required
        </div>

        <div class="form-actions" style="display: flex; gap: 15px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">
                <?php echo isset($data['isEdit']) && $data['isEdit'] ? 'Update Report' : 'Submit Report'; ?>
            </button>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteReportModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeReportModal()">&times;</span>
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" style="color: #e74c3c; font-size: 2rem;"></i>
            <h3>Delete Report?</h3>
        </div>
        <p>Are you sure you want to delete report <b id="delReportCode"></b>?</p>
        <p class="modal-warning">This action cannot be undone.</p>
        
        <div class="modal-actions">
            <button onclick="closeReportModal()" class="btn btn-secondary">Cancel</button>
            <a id="confirmReportDeleteLink" href="#" class="btn btn-danger">Yes, Delete It</a>
        </div>
    </div>
</div>

<script>
    function confirmDeleteReport(reportCode) {
        const modal = document.getElementById('deleteReportModal');
        const deleteLink = document.getElementById('confirmReportDeleteLink');
        const codeSpan = document.getElementById('delReportCode');
        
        codeSpan.textContent = reportCode;
        deleteLink.href = "<?php echo URLROOT; ?>/disease/deleteReport/" + reportCode;
        
        modal.style.display = "block";
    }

    function closeReportModal() {
        document.getElementById('deleteReportModal').style.display = "none";
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('deleteReportModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>