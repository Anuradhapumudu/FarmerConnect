<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/complain/complainReport.css?v=<?= time(); ?>">
<script src="<?php echo URLROOT; ?>/js/complain/complainReport.js?v=<?= time(); ?>" defer></script>
<div class="content-card">
    <div class="content-header">
        <h1>� Complain Report</h1>
        <p class="content-subtitle"><?php echo isset($data['isEdit']) && $data['isEdit'] ? 'Update your complaint' : 'Submit your complaint to help us improve our services and address your concerns'; ?></p>
    </div>

    <!-- Complaint ID display for edit mode -->
    <?php if (isset($data['isEdit']) && $data['isEdit']): ?>
        <div class="report-id-display">
            <label>Editing Complaint:</label>
            <span><?php echo htmlspecialchars($data['complainCode']); ?></span>
        </div>
    <?php endif; ?>

    <form action="<?php echo URLROOT; ?>/complain/<?php echo isset($data['isEdit']) && $data['isEdit'] ? 'updateComplain' : 'submit'; ?>" method="POST" id="complainReportForm" class="framework-form" enctype="multipart/form-data">
        <!-- Hidden inputs for edit mode -->
        <?php if (isset($data['isEdit']) && $data['isEdit']): ?>
            <input type="hidden" name="complainCode" value="<?php echo $data['complainCode']; ?>">
            <input type="hidden" name="existingMedia" value="<?php echo $data['existingMedia']; ?>">
        <?php endif; ?>
        <input type="hidden" name="submission_timestamp" value="">

        <div class="form-group">
            <label for="fullName" class="required">Full Name</label>
            <input type="text" id="fullName" name="fullName" 
                   placeholder="Enter your full name" value="<?php echo $data['fullName']; ?>">
            <span class="error"><?php echo $data['fullName_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="email" class="required">Email Address</label>
            <input type="email" id="email" name="email" 
                   placeholder="Enter your email address" value="<?php echo $data['email']; ?>">
            <span class="error"><?php echo $data['email_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="phone" class="required">Phone Number</label>
            <input type="tel" id="phone" name="phone" 
                   placeholder="Enter your phone number" value="<?php echo $data['phone']; ?>">
            <span class="error"><?php echo $data['phone_error']; ?></span>
        </div>
        
        <div class="form-group-split">
            <div class="form-group-half">
                <label for="incidentDate" class="required">Date of Incident</label>
                <input type="date" id="incidentDate" name="incidentDate" value="<?php echo $data['incidentDate']; ?>">
                <span class="error"><?php echo $data['incidentDate_error']; ?></span>
            </div>
            <div class="form-group-half">
                <label for="todayDate">Today's Date</label>
                <input type="date" id="todayDate" name="todayDate" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label for="category" class="required">Complaint Category</label>
            <select id="category" name="category">
                <option value="">Select a category</option>
                <option value="service" <?php echo ($data['category'] == 'service') ? 'selected' : ''; ?>>Service Quality</option>
                <option value="product" <?php echo ($data['category'] == 'product') ? 'selected' : ''; ?>>Product Issue</option>
                <option value="delivery" <?php echo ($data['category'] == 'delivery') ? 'selected' : ''; ?>>Delivery Problem</option>
                <option value="payment" <?php echo ($data['category'] == 'payment') ? 'selected' : ''; ?>>Payment Issue</option>
                <option value="staff" <?php echo ($data['category'] == 'staff') ? 'selected' : ''; ?>>Staff Behavior</option>
                <option value="technical" <?php echo ($data['category'] == 'technical') ? 'selected' : ''; ?>>Technical Support</option>
                <option value="other" <?php echo ($data['category'] == 'other') ? 'selected' : ''; ?>>Other</option>
            </select>
            <span class="error"><?php echo $data['category_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="subject" class="required">Complaint Subject</label>
            <input type="text" id="subject" name="subject" 
                   placeholder="Brief summary of your complaint" value="<?php echo $data['subject']; ?>">
            <span class="error"><?php echo $data['subject_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="description" class="required">Detailed Description</label>
            <textarea id="description" name="description" 
                placeholder="Describe your complaint in detail, including what happened, when, and how it affected you"><?php echo $data['description']; ?></textarea>
            <span class="error"><?php echo $data['description_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="media">Upload Supporting Documents / Images</label>
            <div class="file-upload" id="mediaUploadArea">
                <div>
                    <i class="upload-icon"><img style="width: 30px; height: 30px;" src="https://cdn-icons-png.flaticon.com/128/10024/10024248.png"></i>
                    <p>Click to upload or drag and drop</p>
                    <p class="upload-subtext">PNG, JPG, PDF, DOC up to 10MB (optional)</p>
                </div>
                <input type="file" id="media" name="media[]" accept="image/*,video/*,.pdf,.doc,.docx" hidden multiple>
            </div>
            <span class="error"><?php echo $data['media_error']; ?></span>
            <div class="uploaded-files" id="uploadedFiles" style="margin-top: 10px;"></div>

            <!-- Existing media files for edit mode -->
            <?php if (isset($data['isEdit']) && $data['isEdit'] && !empty($data['existingMedia'])): ?>
                <div class="existing-media" id="existingMedia" style="margin-top: 15px;">
                    <h4>Current Files:</h4>
                    <div class="existing-files-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 10px;">
                        <?php
                        $existingFiles = explode(',', $data['existingMedia']);
                        foreach ($existingFiles as $index => $filename):
                            $filename = trim($filename);
                            if (empty($filename)) continue;
                            $fileUrl = URLROOT . '/complain/viewMedia/' . $data['complainCode'] . '/' . urlencode($filename);
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
            <label class="required">Priority Level</label>
            <div class="radio-group">
                <label class="radio-option severity-low">
                    <input type="radio" name="priority" value="low" <?php echo ($data['priority'] == 'low') ? 'checked' : ''; ?>>
                    Low
                </label>
                <label class="radio-option severity-medium">
                    <input type="radio" name="priority" value="medium" <?php echo ($data['priority'] == 'medium') ? 'checked' : ''; ?>>
                    Medium
                </label>
                <label class="radio-option severity-high">
                    <input type="radio" name="priority" value="high" <?php echo ($data['priority'] == 'high') ? 'checked' : ''; ?>>
                    High
                </label>
                <label class="radio-option severity-high">
                    <input type="radio" name="priority" value="urgent" <?php echo ($data['priority'] == 'urgent') ? 'checked' : ''; ?>>
                    Urgent
                </label>
            </div>
            <span class="error"><?php echo $data['priority_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="expectedResolution">Expected Resolution</label>
            <textarea id="expectedResolution" name="expectedResolution" 
                placeholder="What outcome are you hoping for? (optional)"><?php echo $data['expectedResolution']; ?></textarea>
            <span class="error"><?php echo $data['expectedResolution_error']; ?></span>
        </div>
        
        <div class="form-group">
            <div class="checkbox-container">
                <label for="terms" class="checkbox-label required">
                    <input type="checkbox" id="terms" name="terms" required>
                    I agree to the <a href="<?php echo URLROOT; ?>/pages/complain" class="terms-link" target="_blank">terms and conditions</a>
            </div>
        </div>
        
        <!-- Required fields notice -->
        <div class="required-fields-notice" role="alert" aria-live="polite">
            <span class="required-indicator" aria-hidden="true">*</span> All fields marked with <span class="required-indicator" aria-hidden="true">*</span> are required
        </div>

        <button type="submit" class="btn btn-primary"><?php echo isset($data['isEdit']) && $data['isEdit'] ? 'Update Complaint' : 'Submit Complaint'; ?></button>
    </form>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>