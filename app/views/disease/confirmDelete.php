<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="content-card">
    <div class="content-header">
        <h1><i class="fas fa-exclamation-triangle text-danger"></i> Confirm Report Deletion</h1>
        <p class="content-subtitle">This action cannot be undone. Please review the report details carefully before proceeding.</p>
    </div>

    <!-- Warning Alert -->
    <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <div class="alert-icon mr-3">
                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading mb-2 text-danger">⚠️ Critical Warning</h5>
                <p class="mb-2">Deleting this report will permanently remove:</p>
                <ul class="mb-0 list-unstyled">
                    <li class="d-flex align-items-center mb-1">
                        <i class="fas fa-file-alt text-danger mr-2"></i>
                        All report data and information
                    </li>
                    <li class="d-flex align-items-center mb-1">
                        <i class="fas fa-images text-warning mr-2"></i>
                        All attached media files
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-history text-info mr-2"></i>
                        Historical records and timestamps
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="report-details mb-4">
        <h5 class="mb-3 d-flex align-items-center">
            <i class="fas fa-file-medical mr-2 text-primary"></i>
            Report Details
        </h5>

        <div class="row">
            <div class="col-md-6">
                <div class="info-item mb-3">
                    <label class="text-muted small font-weight-bold">REPORT ID</label>
                    <div class="value">
                        <code class="bg-light px-2 py-1 rounded"><?php echo htmlspecialchars($data['report']->report_code ?? 'N/A'); ?></code>
                    </div>
                </div>

                <div class="info-item mb-3">
                    <label class="text-muted small font-weight-bold">FARMER NIC</label>
                    <div class="value"><?php echo htmlspecialchars($data['report']->farmerNIC); ?></div>
                </div>

                <div class="info-item mb-3">
                    <label class="text-muted small font-weight-bold">PLR NUMBER</label>
                    <div class="value"><?php echo htmlspecialchars($data['report']->plrNumber ?? $data['report']->pirNumber ?? 'N/A'); ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item mb-3">
                    <label class="text-muted small font-weight-bold">TITLE</label>
                    <div class="value font-weight-bold"><?php echo htmlspecialchars($data['report']->title); ?></div>
                </div>

                <div class="info-item mb-3">
                    <label class="text-muted small font-weight-bold">SEVERITY</label>
                    <div class="value">
                        <?php
                        $severityClass = '';
                        $severityIcon = '';
                        switch ($data['report']->severity) {
                            case 'high':
                                $severityClass = 'badge-danger';
                                $severityIcon = 'fas fa-exclamation-circle';
                                break;
                            case 'medium':
                                $severityClass = 'badge-warning';
                                $severityIcon = 'fas fa-exclamation-triangle';
                                break;
                            case 'low':
                                $severityClass = 'badge-success';
                                $severityIcon = 'fas fa-info-circle';
                                break;
                        }
                        ?>
                        <span class="badge <?php echo $severityClass; ?> px-3 py-2">
                            <i class="<?php echo $severityIcon; ?> mr-1"></i>
                            <?php echo ucfirst($data['report']->severity); ?> Priority
                        </span>
                    </div>
                </div>

                <div class="info-item mb-3">
                    <label class="text-muted small font-weight-bold">CREATED</label>
                    <div class="value">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        <?php echo date('F d, Y \a\t g:i A', strtotime($data['report']->created_at)); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Confirmation Form -->
    <form method="POST" action="<?php echo URLROOT; ?>/disease/deleteReport/<?php echo htmlspecialchars($data['report']->report_code ?? ''); ?>" class="mt-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="confirmation-section bg-light p-4 rounded shadow-sm mb-4">
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-check-circle mr-2 text-success"></i>
                        Confirmation Required
                    </h6>

                    <div class="form-group mb-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="confirmDelete" name="confirmDelete" required>
                            <label class="custom-control-label text-danger font-weight-bold" for="confirmDelete">
                                I understand that this action is permanent and cannot be undone
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deleteReason" class="font-weight-bold text-dark">
                            <i class="fas fa-comment mr-1"></i>
                            Reason for deletion (optional)
                        </label>
                        <textarea class="form-control border-0 shadow-sm"
                                  id="deleteReason"
                                  name="deleteReason"
                                  rows="3"
                                  placeholder="Please provide a reason for deleting this report..."
                                  style="resize: vertical;"></textarea>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Providing a reason helps with record-keeping and audit trails.
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Safety Notice -->
                <div class="safety-notice bg-warning p-3 rounded shadow-sm text-dark">
                    <h6 class="font-weight-bold mb-3">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Safety Checklist
                    </h6>
                    <div class="checklist">
                        <div class="checklist-item d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                            <small>Backed up important information</small>
                        </div>
                        <div class="checklist-item d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                            <small>Documented deletion reason</small>
                        </div>
                        <div class="checklist-item d-flex align-items-start">
                            <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                            <small>Informed stakeholders if necessary</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="button" class="btn btn-danger btn-lg" id="deleteBtn" onclick="confirmDelete()">
                <i class="fas fa-trash-alt mr-2"></i>
                Delete Report Permanently
            </button>
            <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo htmlspecialchars($data['report']->report_code ?? ''); ?>"
               class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left mr-1"></i>
                Cancel
            </a>
            <a href="<?php echo URLROOT; ?>/disease/viewReports"
               class="btn btn-outline-primary btn-lg">
                <i class="fas fa-list mr-1"></i>
                Back to Reports
            </a>
        </div>
    </form>

    <!-- Hidden form for actual deletion -->
    <form id="deleteForm" method="POST" action="<?php echo URLROOT; ?>/disease/deleteReport/<?php echo htmlspecialchars($data['report']->report_code ?? ''); ?>" style="display: none;">
        <input type="hidden" name="confirmDelete" value="1">
        <input type="hidden" name="deleteReason" id="hiddenDeleteReason" value="">
    </form>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center;">
    <div style="background-color: white; padding: 30px; border-radius: 10px; width: 90%; max-width: 500px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div style="text-align: center; margin-bottom: 20px;">
            <h4 style="margin: 0 0 10px 0; color: #dc3545;"><i class="fas fa-exclamation-triangle fa-2x" style="display: block; margin-bottom: 10px;"></i>Final Confirmation</h4>
        </div>
        <div style="text-align: center; margin-bottom: 20px;">
            <p style="font-size: 18px; font-weight: bold; color: #dc3545; margin-bottom: 15px;">Are you absolutely sure you want to delete this report?</p>
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #dee2e6;">
                <p style="margin: 5px 0;"><strong>Report ID:</strong> <code><?php echo htmlspecialchars($data['report']->report_code ?? 'N/A'); ?></code></p>
                <p style="margin: 5px 0;"><strong>Title:</strong> <?php echo htmlspecialchars($data['report']->title ?? 'N/A'); ?></p>
            </div>
            <p style="color: #721c24; font-weight: bold; font-size: 16px;">⚠️ This action CANNOT be undone!</p>
        </div>
        <div style="text-align: center; border-top: 1px solid #dee2e6; padding-top: 20px;">
            <button type="button" onclick="closeModal()" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-right: 10px; cursor: pointer;">Cancel</button>
            <button type="button" onclick="proceedDelete()" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Yes, Delete Permanently</button>
        </div>
        <span onclick="closeModal()" style="position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 28px; font-weight: bold; color: #aaa;">&times;</span>
    </div>
</div>

<style>
/* Alert Customizations */
.alert-icon {
    color: #dc3545;
    opacity: 0.8;
}

/* Info Items */
.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    display: block;
    margin-bottom: 0.25rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item .value {
    font-size: 0.95rem;
    color: #495057;
}

/* Media Cards */
.media-card {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.media-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.media-thumbnail:hover .media-overlay {
    opacity: 1;
}

.media-thumbnail {
    transition: transform 0.3s ease;
}

.media-thumbnail:hover {
    transform: scale(1.05);
}

/* Confirmation Section */
.confirmation-section {
    border-left: 4px solid #dc3545;
}

/* Custom Controls */
.custom-control-input:checked ~ .custom-control-label {
    color: #dc3545 !important;
}

.custom-control-label {
    font-size: 0.95rem;
    line-height: 1.4;
}

/* Safety Notice */
.safety-notice .checklist-item {
    transition: color 0.2s ease;
}

.safety-notice .checklist-item:hover {
    color: #495057;
}

/* Modal Enhancements */
.modal-content {
    border-radius: 0.5rem;
    border: none;
}

.modal-header {
    border-radius: 0.5rem 0.5rem 0 0;
    border: none;
}

/* Code styling */
code {
    font-size: 0.85em;
    background: rgba(0, 0, 0, 0.05);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
}

/* Form enhancements */
.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
}

.custom-control-input:focus ~ .custom-control-label::before {
    box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
}

/* Button enhancements */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Responsive Design */
@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        align-items: stretch !important;
    }

    .action-buttons .btn {
        margin-bottom: 0.5rem;
    }

    .confirmation-section {
        margin-bottom: 2rem;
    }

    .safety-notice {
        order: -1;
        margin-bottom: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up event listeners');

    // Set up delete button click handler
    const deleteBtn = document.getElementById('deleteBtn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', confirmDelete);
        console.log('Delete button event listener attached');
    } else {
        console.error('Delete button not found');
    }
});

function confirmDelete() {
    console.log('confirmDelete called');

    // Check if checkbox is checked
    const checkbox = document.getElementById('confirmDelete');
    console.log('Checkbox element:', checkbox);
    console.log('Checkbox checked:', checkbox ? checkbox.checked : 'checkbox not found');

    if (!checkbox || !checkbox.checked) {
        alert('Please check the confirmation box before proceeding.');
        if (checkbox) checkbox.focus();
        return false;
    }

    // Show modal
    const modal = document.getElementById('confirmModal');
    console.log('Modal element:', modal);

    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        console.log('Modal displayed successfully');
    } else {
        console.error('Modal not found');
        alert('Error: Modal not found');
    }

    return false; // Prevent form submission
}

function closeModal() {
    console.log('closeModal called');
    const modal = document.getElementById('confirmModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
        console.log('Modal closed successfully');
    } else {
        console.error('Modal not found during close');
    }
}

function proceedDelete() {
    console.log('proceedDelete called');

    // Get the reason from textarea and set it in the hidden form
    const reason = document.getElementById('deleteReason');
    const reasonValue = reason ? reason.value : '';
    console.log('Deletion reason:', reasonValue);

    const hiddenReason = document.getElementById('hiddenDeleteReason');
    if (hiddenReason) {
        hiddenReason.value = reasonValue;
        console.log('Hidden reason field updated');
    }

    // Submit the hidden form
    const form = document.getElementById('deleteForm');
    console.log('Form to submit:', form);

    if (form) {
        console.log('Submitting form...');
        form.submit();
    } else {
        console.error('Form not found');
        alert('Error: Form not found');
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('confirmModal');
    if (event.target == modal) {
        closeModal();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>