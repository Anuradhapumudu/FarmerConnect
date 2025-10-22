<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/diseaseReport.css?v=<?= time(); ?>">
<script src="<?php echo URLROOT; ?>/js/disease/diseaseReport.js?v=<?= time(); ?>" defer></script>
<div class="content-card">
    <div class="content-header">
        <h1>Disease Detector</h1>
        <p class="content-subtitle"><?php echo isset($data['isEdit']) && $data['isEdit'] ? 'Update your disease report' : 'Report plant diseases to help protect our agricultural community'; ?></p>
    </div>

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
                   placeholder="Enter your National Identity Card number" value="<?php echo $data['farmerNIC']; ?>" readonly>
            <span class="error"><?php echo $data['farmerNIC_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="plrNumber" class="required">PLR Number</label>
            <select id="plrNumber" name="plrNumber" onchange="loadPaddySize()">
                <option value="">.. Select PLR ..</option>
                <?php if(!empty($data['paddyFields'])): ?>
                    <?php foreach($data['paddyFields'] as $paddy): ?>
                        <option value="<?php echo $paddy->PLR; ?>" data-size="<?php echo $paddy->Paddy_Size; ?>"
                                <?php echo (isset($_POST['plrNumber']) && $_POST['plrNumber'] == $paddy->PLR) ? 'selected' : ''; ?>>
                            <?php echo $paddy->PLR; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <span class="error"><?php echo $data['plrNumber_error']; ?></span>
        </div>

        <div class="form-group">
            <label for="paddySize" class="required">Paddy Size (Acres)</label>
            <input type="number" id="paddySize" name="paddySize" step="0.01" min="0" readonly value="<?php echo isset($_POST['paddySize']) ? $_POST['paddySize'] : $data['paddySize']; ?>">
            <span class="error"><?php echo $data['paddySize_error']; ?></span>
        </div>
        
        <div class="form-group-split">
            <div class="form-group-half">
                <label for="observationDate" style="color:#2e7d32; font-weight:600">Date of Observation</label>
                <input type="date" id="observationDate" name="observationDate" value="<?php echo $data['observationDate']; ?>">
                <span class="error"><?php echo $data['observationDate_error']; ?></span>
            </div>
            <div class="form-group-half">
                <label for="todayDate" style="color:#2e7d32; font-weight:600">Today's Date</label>
                <input type="date" id="todayDate" name="todayDate" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label for="title" class="required">Report Title</label>
            <input type="text" id="title" name="title" 
                   placeholder="Brief description of the issue" value="<?php echo $data['title']; ?>">
            <span class="error"><?php echo $data['title_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="description" class="required">Detailed Description</label>
            <textarea id="description" name="description" 
                placeholder="Describe the symptoms, patterns, and any other relevant details"><?php echo $data['description']; ?></textarea>
            <span class="error"><?php echo $data['description_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="media">Upload Images / Video</label>
            <div class="blinking-text-container">
                <p class="blinking-text">‼️ Reports with photos/videos get faster response from officers!</p>
            </div>
            <div class="file-upload" id="mediaUploadArea">
                <div>
                    <i class="upload-icon"><img style="width: 30px; height: 30px;" src="https://cdn-icons-png.flaticon.com/128/10024/10024248.png"></i>
                    <p>Click to upload or drag and drop</p>
                    <p class="upload-subtext">PNG, JPG, GIF, MP4 up to 10MB</p>
                </div>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" hidden multiple>
            </div>
            <span class="error"><?php echo $data['media_error']; ?></span>
            <div class="uploaded-files" id="uploadedFiles" style="margin-top: 10px;"></div>

            <!-- Existing media files for edit mode -->
            <?php if (isset($data['isEdit']) && $data['isEdit'] && !empty($data['existingMedia'])): ?>
                <div class="existing-media" id="existingMedia" style="margin-top: 15px;">
                    <h4>Current Media Files:</h4>
                    <div class="existing-files-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 10px;">
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
                            <div class="existing-file-item" style="background: rgba(255, 255, 255, 0.9); border-radius: 8px; padding: 10px; border: 1px solid rgba(46, 125, 50, 0.2); position: relative;">
                                <!-- Remove button -->
                                <button type="button" class="remove-file-btn" data-filename="<?php echo htmlspecialchars($filename); ?>"
                                        style="position: absolute; top: 5px; right: 5px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer; font-size: 14px; line-height: 1; z-index: 10;">
                                    ×
                                </button>

                                <!-- Hidden checkbox for form submission -->
                                <input type="checkbox" name="removeMedia[]" value="<?php echo htmlspecialchars($filename); ?>" id="remove_<?php echo $index; ?>" style="display: none;">

                                <!-- Media preview -->
                                <div class="media-preview" style="text-align: center; margin-bottom: 8px;">
                                    <?php if ($isImage): ?>
                                        <img src="<?php echo $fileUrl; ?>" alt="Preview" style="max-width: 100%; max-height: 120px; border-radius: 4px; object-fit: cover;">
                                    <?php elseif ($isVideo): ?>
                                        <video style="max-width: 100%; max-height: 120px; border-radius: 4px;" controls>
                                            <source src="<?php echo $fileUrl; ?>" type="video/<?php echo $fileExtension; ?>">
                                            Video preview not supported
                                        </video>
                                    <?php else: ?>
                                        <div style="width: 100%; height: 80px; background: rgba(46, 125, 50, 0.1); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                            📄 <?php echo strtoupper($fileExtension); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Filename -->
                                <div class="filename" style="font-size: 0.85rem; color: var(--text-primary); text-align: center; word-break: break-all;">
                                    <?php echo htmlspecialchars($filename); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); margin-top: 10px;">
                        Click the × button to remove files. New files will be added to the existing ones.
                    </p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label class="required">Severity Level</label>
            <div class="radio-group">
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
            <span class="error"><?php echo $data['severity_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="affectedArea" class="required">Affected Area (in acres)</label>
            <input type="number" id="affectedArea" name="affectedArea" 
                   placeholder="Enter the size of the affected area" min="0" step="0.1" value="<?php echo $data['affectedArea']; ?>">
            <span class="error"><?php echo $data['affectedArea_error']; ?></span>
        </div>
        
        <div class="form-group">
            <div class="checkbox-container">
                <label for="terms" class="checkbox-label required">
                    <input type="checkbox" id="terms" name="terms">
                    I agree to the <a href="<?php echo URLROOT; ?>/pages/terms/disease" class="terms-link" target="_blank">terms and conditions</a>
                </label>
            </div>
            <span class="error"><?php echo $data['terms_error']; ?></span>
        </div>
        
        <!-- Required fields notice -->
        <div class="required-fields-notice" role="alert" aria-live="polite">
            <span class="required-indicator" aria-hidden="true">*</span> All fields marked with <span class="required-indicator" aria-hidden="true">*</span> are required
        </div>

        <button type="submit" class="btn btn-primary"><?php echo isset($data['isEdit']) && $data['isEdit'] ? 'Update Report' : 'Submit Report'; ?></button>
    </form>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>