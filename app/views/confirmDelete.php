<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        Confirm Report Deletion
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <strong>Warning!</strong> This action cannot be undone. Deleting this report will permanently remove:
                        <ul class="mb-0 mt-2">
                            <li>All report data and information</li>
                            <li>All attached media files</li>
                            <li>Historical records and timestamps</li>
                        </ul>
                    </div>

                    <!-- Report Summary -->
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title text-danger">Report to be deleted:</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Report ID:</strong><br>
                                    <code><?php echo htmlspecialchars($data['report']->reportId); ?></code></p>
                                    
                                    <p><strong>Farmer NIC:</strong><br>
                                    <?php echo htmlspecialchars($data['report']->farmerNIC); ?></p>
                                    
                                    <p><strong>PLR Number:</strong><br>
                                    <?php echo htmlspecialchars($data['report']->plrNumber); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Title:</strong><br>
                                    <?php echo htmlspecialchars($data['report']->title); ?></p>
                                    
                                    <p><strong>Severity:</strong><br>
                                    <?php
                                    $severityClass = '';
                                    switch ($data['report']->severity) {
                                        case 'high':
                                            $severityClass = 'badge-danger';
                                            break;
                                        case 'medium':
                                            $severityClass = 'badge-warning';
                                            break;
                                        case 'low':
                                            $severityClass = 'badge-success';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?php echo $severityClass; ?>">
                                        <?php echo ucfirst($data['report']->severity); ?>
                                    </span></p>
                                    
                                    <p><strong>Created:</strong><br>
                                    <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?></p>
                                </div>
                            </div>

                            <?php if (!empty($data['report']->media)): ?>
                                <?php
                                $mediaFiles = explode(',', $data['report']->media);
                                $mediaFiles = array_map('trim', $mediaFiles);
                                ?>
                                <div class="mt-3">
                                    <strong class="text-warning">
                                        <i class="fas fa-images"></i>
                                        Media files that will be deleted (<?php echo count($mediaFiles); ?>):
                                    </strong>
                                    <div class="row mt-2">
                                        <?php foreach ($mediaFiles as $mediaFile): ?>
                                            <?php
                                            $fileExtension = strtolower(pathinfo($mediaFile, PATHINFO_EXTENSION));
                                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                                            ?>
                                            <div class="col-3 mb-2">
                                                <?php if ($isImage): ?>
                                                    <img src="<?php echo URLROOT; ?>/disease/viewMedia/<?php echo $data['report']->reportId; ?>/<?php echo $mediaFile; ?>" 
                                                         class="img-fluid rounded border" 
                                                         alt="Media to be deleted"
                                                         style="height: 60px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-secondary text-white rounded p-2 text-center" style="height: 60px;">
                                                        <i class="fas fa-file"></i><br>
                                                        <small><?php echo $fileExtension; ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Confirmation Form -->
                    <form method="POST" action="<?php echo URLROOT; ?>/disease/deleteReport/<?php echo $data['report']->reportId; ?>" class="mt-4">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirmDelete" name="confirmDelete" required>
                                <label class="form-check-label text-danger" for="confirmDelete">
                                    <strong>I understand that this action is permanent and cannot be undone</strong>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deleteReason">Reason for deletion (optional):</label>
                            <textarea class="form-control" 
                                      id="deleteReason" 
                                      name="deleteReason" 
                                      rows="3" 
                                      placeholder="Enter the reason for deleting this report..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" 
                                        class="btn btn-danger btn-lg" 
                                        id="deleteButton" 
                                        disabled>
                                    <i class="fas fa-trash"></i>
                                    Delete Report Permanently
                                </button>
                            </div>
                            <div>
                                <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo $data['report']->reportId; ?>" 
                                   class="btn btn-secondary btn-lg mr-2">
                                    <i class="fas fa-arrow-left"></i>
                                    Cancel
                                </a>
                                <a href="<?php echo URLROOT; ?>/disease/viewReports" 
                                   class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-list"></i>
                                    Back to Reports
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Additional Safety Notice -->
                    <div class="mt-4 p-3 bg-warning text-dark rounded">
                        <h6><i class="fas fa-shield-alt"></i> Safety Notice:</h6>
                        <small>
                            Before deleting this report, ensure you have:
                            <ul class="mb-0 mt-1">
                                <li>Backed up any important information</li>
                                <li>Documented the deletion reason</li>
                                <li>Informed relevant stakeholders if necessary</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card.border-danger {
    border-width: 2px;
}

.bg-light {
    background-color: #f8f9fa !important;
    border: 1px solid #e9ecef;
}

.form-check-input:checked ~ .form-check-label {
    color: #dc3545 !important;
}

#deleteButton:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

#deleteButton:enabled {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.02);
    }
    100% {
        transform: scale(1);
    }
}

.alert-danger ul {
    padding-left: 20px;
}

code {
    font-size: 0.9em;
    background-color: #f8f9fa;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #e9ecef;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmCheckbox = document.getElementById('confirmDelete');
    const deleteButton = document.getElementById('deleteButton');
    
    confirmCheckbox.addEventListener('change', function() {
        deleteButton.disabled = !this.checked;
    });

    // Add confirmation dialog on form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!confirm('Are you absolutely sure you want to delete this report? This action CANNOT be undone!')) {
            e.preventDefault();
        }
    });

    // Auto-focus on checkbox when page loads
    setTimeout(function() {
        confirmCheckbox.focus();
    }, 500);
});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>