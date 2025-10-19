<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="content-card">
    <div class="content-header">
        <h1>🐛 Disease Detector</h1>
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
                   placeholder="Enter your National Identity Card number" value="<?php echo $data['farmerNIC']; ?>">
            <span class="error"><?php echo $data['farmerNIC_error']; ?></span>
        </div>
        
        <div class="form-group">
            <label for="plrNumber" class="required">PLR Number</label>
            <input type="text" id="plrNumber" name="plrNumber" 
                   placeholder="Enter your Planters Registration Number" value="<?php echo $data['plrNumber']; ?>">
            <span class="error"><?php echo $data['plrNumber_error']; ?></span>
        </div>
        
        <div class="form-group-split">
            <div class="form-group-half">
                <label for="observationDate" class="required">Date of Observation</label>
                <input type="date" id="observationDate" name="observationDate" value="<?php echo $data['observationDate']; ?>">
                <span class="error"><?php echo $data['observationDate_error']; ?></span>
            </div>
            <div class="form-group-half">
                <label for="todayDate">Today's Date</label>
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
                    <input type="checkbox" id="terms" name="terms" required>
                    I agree to the <a href="<?php echo URLROOT; ?>/pages/terms/disease" class="terms-link" target="_blank">terms and conditions</a>
                </label>
            </div>
        </div>
        
        <!-- Required fields notice -->
        <div class="required-fields-notice" role="alert" aria-live="polite">
            <span class="required-indicator" aria-hidden="true">*</span> All fields marked with <span class="required-indicator" aria-hidden="true">*</span> are required
        </div>

        <button type="submit" class="btn btn-primary"><?php echo isset($data['isEdit']) && $data['isEdit'] ? 'Update Report' : 'Submit Report'; ?></button>
    </form>
</div>

<style>
    .error {
        color: red;
        font-size: 0.8em;
    }

    .uploaded-files {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 5px;
        padding: 10px;
        display: none;
    }
    
    .uploaded-files.has-files {
        display: block;
    }
    
    .uploaded-file {
        padding: 5px 10px;
        margin: 2px 0;
        background: rgba(46, 125, 50, 0.1);
        border-radius: 3px;
        font-size: 0.9rem;
        color: var(--primary);
    }
    
    .main-content {
        padding-top: 30px;
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
    
    .content-header h1 {
        color: var(--text-primary);
        font-size: 2.2rem;
        margin-bottom: 10px;
        font-weight: 800;
    }
    
    .content-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin: 10px 0;
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
    
    .report-id-display label {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }
    
    .report-id-display span {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        color: var(--primary);
        background: rgba(255, 255, 255, 0.8);
        padding: 5px 10px;
        border-radius: 4px;
        border: 1px solid rgba(46, 125, 50, 0.2);
    }
    
    .framework-form {
        width: 100%;
        margin: 0 auto;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group-split {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .form-group-half {
        flex: 1;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .form-group .required::after {
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
    
    input:focus, select:focus, textarea:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
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
        transition: var(--transition);
        cursor: pointer;
    }
    
    .radio-option:hover {
        background: rgba(255, 255, 255, 0.9);
    }
    
    .radio-option input {
        width: auto;
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
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.7);
    }
    
    .file-upload:hover {
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.9);
    }
    
    .upload-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    .upload-subtext {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-top: 5px;
    }
    
    .btn-primary {
        width: 100%;
        padding: 15px;
        font-size: 1.1rem;
        margin-top: 10px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .btn-primary:hover {
        background: red;
    }
    
    /* Custom checkbox styling */
    .checkbox-container {
        position: relative;
        margin-top: 10px;
    }
    
    .checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 0.95rem;
        line-height: 1.4;
        background: rgba(255, 255, 255, 0.7);
        transition: var(--transition);
        margin-bottom: 0;
    }
    
    .checkbox-label:hover {
        background: rgba(255, 255, 255, 0.9);
        border-color: var(--primary);
    }
    
    #terms {
        width: 18px;
        height: 18px;
        margin: 0;
        cursor: pointer;
        accent-color: var(--primary);
    }
    
    .terms-link {
        color: #e74c3c;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px solid transparent;
        transition: var(--transition);
    }
    
    .terms-link:hover {
        color: #c0392b;
        border-bottom-color: #c0392b;
    }
    
    .checkbox-label.required::after {
        content: " *";
        color: #e74c3c;
        font-weight: bold;
    }

    .required-fields-notice {
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 20px;
        color: black;
        text-align: center;
        font-weight: 600;
    }

    .required-indicator {
        color: #e74c3c;
    }
    
    @media (max-width: 768px) {
        .content-card {
            padding: 20px;
            margin: 15px auto 30px;
            width: 95%;
        }
        
        .form-group-split {
            flex-direction: column;
            gap: 15px;
        }
        
        .radio-group {
            flex-direction: column;
            gap: 10px;
        }
        
        .file-upload {
            padding: 15px;
        }
        
        .content-header h1 {
            font-size: 1.8rem;
        }
    }
</style>

<script>
    // Form functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Set dates
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('todayDate').value = today;
        if (!document.getElementById('observationDate').value) {
            document.getElementById('observationDate').value = today;
            document.getElementById('observationDate').max = today;
        }

        // File upload with preview
        const uploadArea = document.getElementById('mediaUploadArea');
        const fileInput = document.getElementById('media');
        const uploadedFilesDiv = document.getElementById('uploadedFiles');

        uploadArea.addEventListener('click', () => fileInput.click());
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--primary)';
        });
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = 'var(--card-border)';
        });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--card-border)';
            fileInput.files = e.dataTransfer.files;
            showFilePreview(fileInput.files);
        });

        fileInput.addEventListener('change', () => showFilePreview(fileInput.files));

        function showFilePreview(files) {
            uploadedFilesDiv.innerHTML = '';
            if (files.length > 0) {
                uploadedFilesDiv.classList.add('has-files');
                uploadedFilesDiv.style.display = 'grid';
                uploadedFilesDiv.style.gridTemplateColumns = 'repeat(auto-fill, minmax(200px, 1fr))';
                uploadedFilesDiv.style.gap = '15px';
                uploadedFilesDiv.style.marginTop = '10px';

                Array.from(files).forEach((file, index) => {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'new-file-preview-item';
                    previewWrapper.style.background = 'rgba(255, 255, 255, 0.9)';
                    previewWrapper.style.borderRadius = '8px';
                    previewWrapper.style.padding = '10px';
                    previewWrapper.style.border = '1px solid rgba(46, 125, 50, 0.2)';
                    previewWrapper.style.position = 'relative';

                    // Remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'remove-new-file-btn';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '5px';
                    removeBtn.style.right = '5px';
                    removeBtn.style.background = '#e74c3c';
                    removeBtn.style.color = 'white';
                    removeBtn.style.border = 'none';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.width = '25px';
                    removeBtn.style.height = '25px';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.fontSize = '14px';
                    removeBtn.style.lineHeight = '1';
                    removeBtn.style.zIndex = '10';
                    removeBtn.textContent = '×';
                    removeBtn.onclick = () => removeFile(index);
                    previewWrapper.appendChild(removeBtn);

                    // Media preview
                    const mediaDiv = document.createElement('div');
                    mediaDiv.className = 'media-preview';
                    mediaDiv.style.textAlign = 'center';
                    mediaDiv.style.marginBottom = '8px';

                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.style.width = '100%';
                        img.style.maxHeight = '120px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '4px';
                        img.alt = `Preview of ${file.name}`;

                        const reader = new FileReader();
                        reader.onload = (e) => img.src = e.target.result;
                        reader.readAsDataURL(file);
                        mediaDiv.appendChild(img);
                    } else if (file.type.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.controls = true;
                        video.style.width = '100%';
                        video.style.maxHeight = '120px';
                        video.style.borderRadius = '4px';

                        const reader = new FileReader();
                        reader.onload = (e) => video.src = e.target.result;
                        reader.readAsDataURL(file);
                        mediaDiv.appendChild(video);
                    } else {
                        const fileInfo = document.createElement('div');
                        fileInfo.style.width = '100%';
                        fileInfo.style.height = '80px';
                        fileInfo.style.background = 'rgba(46, 125, 50, 0.1)';
                        fileInfo.style.borderRadius = '4px';
                        fileInfo.style.display = 'flex';
                        fileInfo.style.alignItems = 'center';
                        fileInfo.style.justifyContent = 'center';
                        fileInfo.style.color = 'var(--text-secondary)';
                        fileInfo.innerHTML = `📄 ${file.name.split('.').pop().toUpperCase()}<br><small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>`;
                        mediaDiv.appendChild(fileInfo);
                    }

                    previewWrapper.appendChild(mediaDiv);

                    // Filename
                    const filenameDiv = document.createElement('div');
                    filenameDiv.style.fontSize = '0.85rem';
                    filenameDiv.style.color = 'var(--text-primary)';
                    filenameDiv.style.textAlign = 'center';
                    filenameDiv.style.wordBreak = 'break-all';
                    filenameDiv.textContent = file.name;
                    previewWrapper.appendChild(filenameDiv);

                    uploadedFilesDiv.appendChild(previewWrapper);
                });

                // Update upload area text
                const text = files.length === 1 ? `1 file selected: ${files[0].name}` : `${files.length} files selected`;
                uploadArea.querySelector('p').textContent = text;
            } else {
                uploadedFilesDiv.classList.remove('has-files');
                uploadedFilesDiv.style.display = 'none';
                uploadArea.querySelector('p').textContent = 'Click to upload or drag and drop';
            }
        }

        function removeFile(index) {
            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);
            files.forEach((file, i) => {
                if (i !== index) dt.items.add(file);
            });
            fileInput.files = dt.files;
            showFilePreview(dt.files);
        }

        // Existing media removal
        document.querySelectorAll('.remove-file-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const filename = this.dataset.filename;
                if (confirm(`Remove "${filename}"?`)) {
                    this.closest('.existing-file-item').querySelector('input[type="checkbox"]').checked = true;
                    this.closest('.existing-file-item').style.opacity = '0.5';
                    this.textContent = '↶';
                    this.style.background = '#f39c12';
                }
            });
        });
    });
</script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>