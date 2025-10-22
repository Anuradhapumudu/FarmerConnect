
// Load paddy size when PLR is selected
function loadPaddySize() {
    const plrSelect = document.getElementById('plrNumber');
    const paddySizeInput = document.getElementById('paddySize');
    const selectedOption = plrSelect.options[plrSelect.selectedIndex];

    if (selectedOption.value) {
        const paddySize = selectedOption.getAttribute('data-size');
        paddySizeInput.value = paddySize;
    } else {
        paddySizeInput.value = '';
    }
}

// Initialize paddy size on page load if PLR is already selected
document.addEventListener('DOMContentLoaded', function() {
    // Set dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('todayDate').value = today;
    if (!document.getElementById('observationDate').value) {
        document.getElementById('observationDate').value = today;
        document.getElementById('observationDate').max = today;
    }

    // Initialize paddy size if PLR is pre-selected
    const plrSelect = document.getElementById('plrNumber');
    if (plrSelect.value) {
        loadPaddySize();
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
