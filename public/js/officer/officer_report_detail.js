function openEditModal(id, message) {
    document.getElementById('editResponseId').value = id;
    document.getElementById('editMessage').value = message;
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function confirmDeleteRecommendation(id) {
    document.getElementById('confirmRecDeleteLink').href = window.location.origin + "/FarmerConnect/officerDashboard/deleteRecommendation/" + id;
    document.getElementById('deleteRecModal').style.display = 'block';
}

function closeDeleteRecModal() {
    document.getElementById('deleteRecModal').style.display = 'none';
}

// Close modals on outside click
window.onclick = function (event) {
    if (event.target == document.getElementById('editModal')) {
        closeEditModal();
    }
    if (event.target == document.getElementById('deleteRecModal')) {
        closeDeleteRecModal();
    }
    if (event.target == document.getElementById('lightbox')) {
        closeLightbox();
    }
}

// Drag and Drop Handling
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('media');
const fileListDisplay = document.getElementById('file-list');
const fileDt = new DataTransfer(); // Store files globally

if (dropZone) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('highlight');
    }

    function unhighlight(e) {
        dropZone.classList.remove('highlight');
    }

    dropZone.addEventListener('drop', handleDrop, false);
}

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    addFiles(files);
}

function handleFileSelect(input) {
    const files = input.files;
    addFiles(files);
}

function addFiles(files) {
    for (let i = 0; i < files.length; i++) {
        // Optional: Check for duplicates or max files here
        fileDt.items.add(files[i]);
    }
    updateFileInput();
}

function removeFile(index) {
    fileDt.items.remove(index);
    updateFileInput();
}

function updateFileInput() {
    fileInput.files = fileDt.files;
    renderPreviews();
}

function renderPreviews() {
    fileListDisplay.innerHTML = '';
    fileListDisplay.className = 'response-media-gallery'; // Reuse grid class

    [...fileDt.files].forEach((file, index) => {
        const item = document.createElement('div');
        item.className = 'media-item-small'; // Reuse item class

        // Remove Button
        const removeBtn = document.createElement('button');
        removeBtn.className = 'remove-media-btn';
        removeBtn.type = 'button'; // Prevent form submit
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.onclick = (e) => {
            e.stopPropagation();
            e.preventDefault();
            removeFile(index);
        };
        item.appendChild(removeBtn);

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            const reader = new FileReader();
            reader.onload = (e) => { img.src = e.target.result; };
            reader.readAsDataURL(file);
            item.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            item.innerHTML += `
                <div class="video-placeholder">
                    <i class="fas fa-video"></i>
                    <span style="font-size:0.7rem; margin-top:4px;">${file.name}</span>
                </div>`;
        } else {
            item.innerHTML += `
                <div class="video-placeholder" style="background:#eee; color:#555;">
                    <i class="fas fa-file"></i>
                    <span style="font-size:0.7rem; margin-top:4px;">${file.name}</span>
                </div>`;
        }

        fileListDisplay.appendChild(item);
    });
}

function formatBytes(bytes, decimals = 1) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function openLightbox(url, type) {
    const lightbox = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    const video = document.getElementById('lightbox-video');

    lightbox.style.display = 'flex';

    if (type === 'image') {
        img.src = url;
        img.style.display = 'block';
        video.style.display = 'none';
        video.pause();
    } else {
        video.src = url;
        video.style.display = 'block';
        img.style.display = 'none';
    }
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.getElementById('lightbox-video').pause();
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
});
