<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<div class="content-card">
    <div class="content-header">
        <h1>✏️ Update Disease Report</h1>
        <p class="content-subtitle">Modify your disease report information</p>
    </div>
    
    <div class="report-id-display">
        <label>Report ID:</label>
        <span><?php echo htmlspecialchars($data['reportId']); ?></span>
    </div>

    <form action="<?php echo URLROOT; ?>/disease/updateReport?id=<?php echo urlencode($data['reportId']); ?>" 
          method="POST" id="updateReportForm" class="framework-form" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="farmerNIC" class="required">Farmer NIC Number
                <span class="tooltip" title="Your National Identity Card number (e.g., 123456789V)">🛈</span>
            </label>
            <input type="text" id="farmerNIC" name="farmerNIC" 
                   placeholder="Enter your National Identity Card number" 
                   value="<?php echo htmlspecialchars($data['farmerNIC']); ?>"
                   pattern="[0-9]{9}[VvXx]" maxlength="10" autofocus required aria-describedby="farmerNICHelp">
            <small id="farmerNICHelp" class="form-text">Format: 9 digits followed by V/X</small>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['farmerNIC_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="plrNumber" class="required">PLR Number
                <span class="tooltip" title="Your Planters Registration Number">🛈</span>
            </label>
            <input type="text" id="plrNumber" name="plrNumber" 
                   placeholder="Enter your Planters Registration Number" 
                   value="<?php echo htmlspecialchars($data['plrNumber']); ?>"
                   maxlength="12" required aria-describedby="plrHelp">
            <small id="plrHelp" class="form-text">Max 12 characters</small>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['plrNumber_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="observationDate" class="required">Date of Observation
                <span class="tooltip" title="Date when you observed the disease">🛈</span>
            </label>
            <input type="date" id="observationDate" name="observationDate" 
                   value="<?php echo htmlspecialchars($data['observationDate']); ?>"
                   required>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['observationDate_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="title" class="required">Report Title
                <span class="tooltip" title="Short summary of the disease issue">🛈</span>
            </label>
            <input type="text" id="title" name="title" 
                   placeholder="Brief description of the issue" 
                   value="<?php echo htmlspecialchars($data['title']); ?>"
                   maxlength="50" required>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['title_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="description" class="required">Detailed Description
                <span class="tooltip" title="Describe symptoms, patterns, and details">🛈</span>
            </label>
            <textarea id="description" name="description" 
                      placeholder="Describe the symptoms, patterns, and any other relevant details"
                      minlength="20" required><?php echo htmlspecialchars($data['description']); ?></textarea>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['description_error']; ?></span>
        </div>

        <!-- Existing Media Section -->
        <?php if (!empty($data['existing_media'])): ?>
            <div class="form-group">
                <label>Current Media Files</label>
                <div class="existing-media">
                    <?php 
                    $existingFiles = json_decode($data['existing_media'], true);
                    if ($existingFiles):
                        foreach ($existingFiles as $index => $file): 
                    ?>
                        <div class="existing-media-item">
                            <?php if (strpos($file['type'], 'image/') === 0): ?>
                                <img src="<?php echo URLROOT; ?>/disease/viewMedia/<?php echo $data['reportId']; ?>?file=<?php echo $index; ?>" 
                                     alt="<?php echo htmlspecialchars($file['filename']); ?>"
                                     class="media-thumbnail">
                            <?php else: ?>
                                <div class="video-thumbnail">
                                    📹 <?php echo htmlspecialchars($file['filename']); ?>
                                </div>
                            <?php endif; ?>
                            <p><?php echo htmlspecialchars($file['filename']); ?></p>
                        </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <div class="media-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="keep_existing_media" value="yes" checked>
                        Keep existing media files
                    </label>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="media">Upload New Images / Video (Optional)
                <span class="tooltip" title="Add new images or videos (PNG, JPG, MP4, max 10MB each)">🛈</span>
            </label>
            <div class="file-upload" id="mediaUploadArea" tabindex="0" aria-label="Upload area">
                <div>
                    <i class="upload-icon">
                        <img style="width: 30px; height: 30px;" 
                             src="https://cdn-icons-png.flaticon.com/128/10024/10024248.png">
                    </i>
                    <p>Click to upload or drag and drop</p>
                    <p class="upload-subtext">PNG, JPG, MP4 up to 10MB</p>
                    <p class="upload-note">New files will be added to existing ones</p>
                </div>
                <input type="file" id="media" name="media" accept="image/*,video/*" hidden multiple>
                <div id="mediaPreview" class="media-preview"></div>
            </div>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['media_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label class="required">Severity Level
                <span class="tooltip" title="How severe is the disease?">🛈</span>
            </label>
            <div class="radio-group">
                <label class="radio-option severity-low">
                    <input type="radio" name="severity" value="low" 
                           <?php echo ($data['severity'] == 'low') ? 'checked' : ''; ?>>
                    <span title="Low severity">🟢 Low</span>
                </label>
                <label class="radio-option severity-medium">
                    <input type="radio" name="severity" value="medium" 
                           <?php echo ($data['severity'] == 'medium') ? 'checked' : ''; ?>>
                    <span title="Medium severity">🟡 Medium</span>
                </label>
                <label class="radio-option severity-high">
                    <input type="radio" name="severity" value="high" 
                           <?php echo ($data['severity'] == 'high') ? 'checked' : ''; ?>>
                    <span title="High severity">🔴 High</span>
                </label>
            </div>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['severity_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="affectedArea" class="required">Affected Area (in acres)
                <span class="tooltip" title="Size of the affected area in acres">🛈</span>
            </label>
            <input type="number" id="affectedArea" name="affectedArea" 
                   placeholder="Enter the size of the affected area" min="0" step="0.1" 
                   value="<?php echo htmlspecialchars($data['affectedArea']); ?>"
                   required>
            <span class="error" role="alert" aria-live="polite"><?php echo $data['affectedArea_error']; ?></span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Report</button>
            <a href="<?php echo URLROOT; ?>/disease/viewReport?id=<?php echo urlencode($data['reportId']); ?>" 
               class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
.existing-media {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}
.existing-media-item {
    text-align: center;
}
.media-thumbnail {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ddd;
}
.video-thumbnail {
    width: 100%;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e9ecef;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 24px;
}
.existing-media-item p {
    margin: 5px 0 0 0;
    font-size: 0.8rem;
    color: #666;
    word-break: break-word;
}
.media-options {
    margin-top: 15px;
    padding: 10px;
    background: #e3f2fd;
    border-radius: 5px;
}
.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    margin: 0;
}
.upload-note {
    color: #666;
    font-size: 0.8rem;
    font-style: italic;
    margin-top: 5px;
}
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
}
.btn-secondary {
    background: #6c757d;
    color: white;
    padding: 15px 30px;
    text-decoration: none;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    font-size: 1.1rem;
}
.btn-secondary:hover {
    background: #5a6268;
}
/* Reuse existing styles from disease report form */
.error {
    color: red;
    font-size: 0.8em;
}
.content-card {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    border-radius: 15px;
    padding: 30px;
    margin: 20px auto 40px;
    max-width: 1200px;
    width: 90%;
}
.content-header {
    margin-bottom: 30px;
    text-align: left;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 20px;
}
.report-id-display {
    background: rgba(46, 125, 50, 0.1);
    border: 1px solid rgba(46, 125, 50, 0.3);
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.framework-form {
    width: 100%;
    margin: 0 auto;
}
.form-group {
    margin-bottom: 25px;
}
.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: var(--text-primary);
}
.required::after {
    content: " *";
    color: #e74c3c;
}
input, select, textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--card-border);
    border-radius: 8px;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.8);
    transition: var(--transition);
    color: var(--dark);
    box-sizing: border-box;
}
textarea {
    min-height: 120px;
    resize: vertical;
}
.radio-group {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.radio-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.7);
    cursor: pointer;
}
.severity-low { color: var(--primary-light); }
.severity-medium { color: var(--secondary); }
.severity-high { color: #e74c3c; }
.file-upload {
    border: 2px dashed var(--card-border);
    padding: 25px;
    text-align: center;
    border-radius: 8px;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.7);
}
.btn-primary {
    width: auto;
    padding: 15px 30px;
    font-size: 1.1rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
}
/* Tooltip style */
.tooltip {
    margin-left: 6px;
    cursor: help;
    font-size: 1em;
    color: #888;
}
.form-text {
    display: block;
    font-size: 0.85em;
    color: #888;
    margin-top: 2px;
}
.media-preview {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
}
.media-preview img, .media-preview video {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ccc;
}
.media-preview .remove-preview {
    display: block;
    text-align: center;
    color: #e74c3c;
    font-size: 0.8em;
    cursor: pointer;
}
</style>

document.getElementById("mediaUploadArea").addEventListener("click", function () {
    document.getElementById("media").click();
});
<script>
// Accessible click and keyboard for upload area
document.getElementById("mediaUploadArea").addEventListener("click", function () {
    document.getElementById("media").click();
});
document.getElementById("mediaUploadArea").addEventListener("keydown", function(e) {
    if (e.key === "Enter" || e.key === " ") {
        document.getElementById("media").click();
    }
});

// Preview selected files before upload
const mediaInput = document.getElementById('media');
const mediaPreview = document.getElementById('mediaPreview');
mediaInput.addEventListener('change', function() {
    mediaPreview.innerHTML = '';
    Array.from(mediaInput.files).forEach((file, idx) => {
        let preview;
        if (file.type.startsWith('image/')) {
            preview = document.createElement('img');
            preview.src = URL.createObjectURL(file);
        } else if (file.type.startsWith('video/')) {
            preview = document.createElement('video');
            preview.src = URL.createObjectURL(file);
            preview.controls = true;
        }
        preview.title = file.name;
        preview.alt = file.name;
        preview.className = 'preview-item';
        mediaPreview.appendChild(preview);
        // Remove button
        const removeBtn = document.createElement('span');
        removeBtn.textContent = '✖';
        removeBtn.className = 'remove-preview';
        removeBtn.title = 'Remove';
        removeBtn.onclick = function() {
            const dt = new DataTransfer();
            Array.from(mediaInput.files).forEach((f, i) => {
                if (i !== idx) dt.items.add(f);
            });
            mediaInput.files = dt.files;
            mediaInput.dispatchEvent(new Event('change'));
        };
        mediaPreview.appendChild(removeBtn);
    });
});
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>