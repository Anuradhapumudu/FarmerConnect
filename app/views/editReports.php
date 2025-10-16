<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<div class="content-card">
    <div class="content-header">
        <h1>✏️ Edit Disease Report</h1>
        <p class="content-subtitle">Update your disease report information</p>
        <div class="report-id-display">Report ID: <?php echo htmlspecialchars($data['reportId']); ?></div>
    </div>

    <?php if (!empty($data['general_error'])): ?>
        <div class="error-alert">
            <p><?php echo htmlspecialchars($data['general_error']); ?></p>
        </div>
    <?php endif; ?>

    <form action="<?php echo URLROOT; ?>/disease/updateReport" method="POST" enctype="multipart/form-data" class="framework-form">
        <!-- Hidden fields -->
        <input type="hidden" name="reportId" value="<?php echo htmlspecialchars($data['reportId']); ?>">
        <input type="hidden" name="farmerNIC" value="<?php echo htmlspecialchars($data['farmerNIC']); ?>">
        <input type="hidden" name="plrNumber" value="<?php echo htmlspecialchars($data['plrNumber']); ?>">
        <input type="hidden" name="currentMedia" value="<?php echo htmlspecialchars($data['currentMedia']); ?>">

        <!-- Read-only farmer info -->
        <div class="form-section">
            <h3>👤 Farmer Information</h3>
            <div class="form-group-split">
                <div class="form-group-half">
                    <label>Farmer NIC Number</label>
                    <input type="text" value="<?php echo htmlspecialchars($data['farmerNIC']); ?>" readonly class="readonly-field">
                </div>
                <div class="form-group-half">
                    <label>PLR Number</label>
                    <input type="text" value="<?php echo htmlspecialchars($data['plrNumber']); ?>" readonly class="readonly-field">
                </div>
            </div>
        </div>

        <!-- Editable fields -->
        <div class="form-section">
            <h3>📅 Report Details</h3>
            
            <div class="form-group">
                <label for="observationDate">Observation Date <span class="required">*</span></label>
                <input type="date" id="observationDate" name="observationDate" 
                       value="<?php echo htmlspecialchars($data['observationDate']); ?>"
                       max="<?php echo date('Y-m-d'); ?>" required>
                <?php if (!empty($data['observationDate_error'])): ?>
                    <div class="error-message"><?php echo $data['observationDate_error']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="title">Report Title <span class="required">*</span></label>
                <input type="text" id="title" name="title" 
                       value="<?php echo htmlspecialchars($data['title']); ?>"
                       maxlength="200" required>
                <?php if (!empty($data['title_error'])): ?>
                    <div class="error-message"><?php echo $data['title_error']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Detailed Description <span class="required">*</span></label>
                <textarea id="description" name="description" rows="6" 
                          maxlength="2000" required><?php echo htmlspecialchars($data['description']); ?></textarea>
                <?php if (!empty($data['description_error'])): ?>
                    <div class="error-message"><?php echo $data['description_error']; ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-section">
            <h3>⚠️ Severity & Impact</h3>
            
            <div class="form-group-split">
                <div class="form-group-half">
                    <label for="severity">Severity Level <span class="required">*</span></label>
                    <select id="severity" name="severity" required>
                        <option value="">Select Severity</option>
                        <option value="low" <?php echo ($data['severity'] == 'low') ? 'selected' : ''; ?>>Low</option>
                        <option value="medium" <?php echo ($data['severity'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                        <option value="high" <?php echo ($data['severity'] == 'high') ? 'selected' : ''; ?>>High</option>
                    </select>
                    <?php if (!empty($data['severity_error'])): ?>
                        <div class="error-message"><?php echo $data['severity_error']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group-half">
                    <label for="affectedArea">Affected Area (acres) <span class="required">*</span></label>
                    <input type="number" id="affectedArea" name="affectedArea" 
                           value="<?php echo htmlspecialchars($data['affectedArea']); ?>"
                           step="0.01" min="0.01" max="10000" required>
                    <?php if (!empty($data['affectedArea_error'])): ?>
                        <div class="error-message"><?php echo $data['affectedArea_error']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Current Media Management -->
        <?php if (!empty($data['currentMedia'])): ?>
            <div class="form-section">
                <h3>📷 Current Media Files</h3>
                <div class="current-media-grid">
                    <?php 
                    $filenames = explode(',', $data['currentMedia']);
                    foreach ($filenames as $filename): 
                        $filename = trim($filename);
                        if (!empty($filename)):
                            $fileInfo = pathinfo($filename);
                            $extension = strtolower($fileInfo['extension']);
                            $mediaUrl = URLROOT . '/disease/viewMedia/' . $data['reportId'] . '/' . $filename;
                    ?>
                        <div class="current-media-item">
                            <div class="media-preview">
                                <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <img src="<?php echo $mediaUrl; ?>" alt="<?php echo htmlspecialchars($filename); ?>">
                                <?php elseif ($extension === 'mp4'): ?>
                                    <video controls>
                                        <source src="<?php echo $mediaUrl; ?>" type="video/mp4">
                                    </video>
                                <?php endif; ?>
                            </div>
                            <div class="media-controls">
                                <p class="filename"><?php echo htmlspecialchars($filename); ?></p>
                                <label class="remove-checkbox">
                                    <input type="checkbox" name="removeMedia[]" value="<?php echo htmlspecialchars($filename); ?>">
                                    Remove this file
                                </label>
                            </div>
                        </div>
                    <?php 
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- New Media Upload -->
        <div class="form-section">
            <h3>📎 Add New Media Files</h3>
            <div class="form-group">
                <label for="newMedia">Upload Additional Images/Videos (Optional)</label>
                <input type="file" id="newMedia" name="newMedia[]" 
                       accept="image/jpeg,image/jpg,image/png,image/gif,video/mp4" 
                       multiple>
                <div class="file-info">
                    <small>Supported formats: JPG, PNG, GIF, MP4 | Max size: 10MB per file</small>
                </div>
                <?php if (!empty($data['media_error'])): ?>
                    <div class="error-message"><?php echo $data['media_error']; ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="form-section">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" value="on" required>
                    I confirm that the information provided is accurate and I agree to the terms and conditions <span class="required">*</span>
                </label>
                <?php if (!empty($data['terms_error'])): ?>
                    <div class="error-message"><?php echo $data['terms_error']; ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Report</button>
            <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo htmlspecialchars($data['reportId']); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
.content-card {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    border-radius: 15px;
    padding: 30px;
    margin: 20px auto 40px;
    max-width: 800px;
    width: 90%;
}

.content-header {
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 20px;
}

.report-id-display {
    font-family: 'Courier New', monospace;
    font-size: 1rem;
    background: rgba(46, 125, 50, 0.1);
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid rgba(46, 125, 50, 0.3);
    display: inline-block;
    margin-top: 10px;
}

.error-alert {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
}

.form-section {
    margin-bottom: 30px;
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    border: 1px solid var(--card-border);
}

.form-section h3 {
    margin-bottom: 15px;
    color: var(--dark);
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.readonly-field {
    background: #f8f9fa !important;
    color: #6c757d !important;
    cursor: not-allowed;
}

.current-media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.current-media-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: white;
}

.media-preview {
    height: 120px;
    overflow: hidden;
}

.media-preview img,
.media-preview video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.media-controls {
    padding: 10px;
}

.filename {
    font-size: 0.8rem;
    margin: 0 0 8px 0;
    word-break: break-word;
    color: #666;
}

.remove-checkbox {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.9rem;
    color: #dc3545;
    cursor: pointer;
}

.remove-checkbox input[type="checkbox"] {
    width: auto;
    margin: 0;
}

.file-info {
    margin-top: 5px;
}

.file-info small {
    color: #6c757d;
    font-style: italic;
}

.form-actions {
    text-align: center;
    margin-top: 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    line-height: 1.5;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
    margin: 0;
    margin-top: 2px;
}

.required {
    color: #dc3545;
}

.error-message {
    color: #dc3545;
    font-size: 0.9rem;
    margin-top: 5px;
    display: block;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

@media (max-width: 768px) {
    .content-card {
        padding: 20px;
        margin: 15px auto 30px;
        width: 95%;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .current-media-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>