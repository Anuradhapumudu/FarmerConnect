<?php require APPROOT . '/views/inc/minimalheader.php'; ?>

<style>
/* Farmer-friendly color scheme */
:root {
    --primary-green: #2e7d32;
    --secondary-green: #4caf50;
    --light-green: #e8f5e9;
    --accent-green: #8bc34a;
    --dark-green: #1b5e20;
    --light-beige: #f5f5dc;
    --warning-red: #f44336;
    --warning-orange: #ff9800;
    --warning-yellow: #ffeb3b;
}

body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
}

.container {
    max-width: 1400px;
    padding: 0 15px;
}

/* Header Styling */
.page-header {
    background: linear-gradient(to right, var(--primary-green), var(--dark-green));
    border-radius: 8px;
    padding: 1.5rem;
    color: white;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.page-header h2 {
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-header .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

/* Card Styling */
.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-bottom: 1.5rem;
    background-color: white;
}

.card-header {
    background-color: var(--light-green);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    font-weight: 600;
    color: var(--dark-green);
    padding: 0.75rem 1rem;
}

/* Button Styling */
.btn {
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    padding: 0.5rem 1rem;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
}

.btn-success {
    background: var(--primary-green);
}

.btn-success:hover {
    background: var(--dark-green);
}

.btn-primary {
    background: var(--secondary-green);
}

.btn-primary:hover {
    background: var(--dark-green);
}

.btn-info {
    background: var(--accent-green);
    color: #333;
}

.btn-info:hover {
    background: #7cb342;
}

.btn-danger {
    background: var(--warning-red);
}

.btn-danger:hover {
    background: #d32f2f;
}

.btn-outline-secondary {
    color: #6c757d;
    border: 1px solid #6c757d;
}

/* Form Styling */
.form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    transition: all 0.2s ease;
    padding: 0.5rem 0.75rem;
}

.form-control:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--dark-green);
}

.input-group-text {
    background-color: var(--light-green);
    border: 1px solid #ced4da;
    color: var(--dark-green);
}

/* Table Styling */
.table {
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    background: var(--primary-green) !important;
    border: none;
    color: white;
    font-weight: 600;
    padding: 0.75rem;
    font-size: 0.9rem;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(232, 245, 233, 0.5) !important;
}

/* Badge Styling */
.badge {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-weight: 500;
}

.bg-danger { background: var(--warning-red) !important; }
.bg-warning { background: var(--warning-orange) !important; color: #000; }
.bg-success { background: var(--primary-green) !important; }
.bg-info { background: var(--accent-green) !important; color: #000; }
.bg-secondary { background: #6c757d !important; }

/* Alert Styling */
.alert {
    border: none;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-left: 4px solid;
}

.alert-success {
    background: #e8f5e9;
    color: #1b5e20;
    border-left-color: var(--primary-green);
}

.alert-danger {
    background: #ffebee;
    color: #c62828;
    border-left-color: var(--warning-red);
}

.alert-info {
    background: #e8f5e9;
    color: #2e7d32;
    border-left-color: var(--accent-green);
}

/* Filter Section */
.filter-section {
    background-color: var(--light-green);
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.filter-section h5 {
    color: var(--dark-green);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

/* Quick Filter Buttons */
.quick-filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}

.quick-filter-btn {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 1px solid var(--primary-green);
    background: white;
    color: var(--primary-green);
}

.quick-filter-btn:hover,
.quick-filter-btn.active {
    background: var(--primary-green);
    color: white;
}

/* No Reports State */
.no-reports {
    background: white;
    border-radius: 8px;
    margin: 1.5rem 0;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.no-reports i {
    color: var(--secondary-green);
    margin-bottom: 1rem;
    font-size: 3rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 1rem;
        text-align: center;
    }
    
    .header-actions {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .header-actions .btn {
        width: 100%;
    }
    
    .table-responsive {
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow-x: auto;
    }
    
    .table {
        min-width: 600px;
    }
    
    .filter-grid {
        grid-template-columns: 1fr !important;
    }
}

/* Animation for page load */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.container {
    animation: fadeIn 0.4s ease-out;
}

/* Custom elements */
.report-id {
    background: var(--primary-green);
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-weight: 600;
    font-size: 0.8rem;
}

/* Filter Grid Layout */
.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.filter-card {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.filter-card h6 {
    color: var(--dark-green);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: all 0.2s ease;
}

/* Icon colors */
.fa-clipboard-list {
    color: white;
}

.fa-filter {
    color: var(--dark-green);
}

.fa-bolt {
    color: var(--accent-green);
}

.fa-calendar {
    color: var(--primary-green);
}

.fa-table {
    color: var(--dark-green);
}

/* Status indicators */
.status-badge {
    padding: 0.35rem 0.65rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* Results count */
.results-count {
    background: var(--light-green);
    padding: 0.5rem 1rem;
    border-radius: 4px;
    color: var(--dark-green);
    font-weight: 500;
    margin-bottom: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <div class="text-center text-md-start mb-2 mb-md-0">
                        <h2 class="mb-1">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Disease Reports Management
                        </h2>
                        <p class="text-muted mb-0">Manage and monitor all disease reports in the system</p>
                    </div>
                    <div class="header-actions d-flex flex-column flex-sm-row gap-2">
                        <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i> New Report
                        </a>
                        <a href="<?php echo URLROOT; ?>/disease/dashboard" class="btn btn-primary">
                            <i class="fas fa-chart-bar me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="card">
                <div class="card-body p-3">
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <h5><i class="fas fa-filter me-2"></i>Filter Reports</h5>
                        
                        <!-- Search Form -->
                        <form method="POST" action="<?php echo URLROOT; ?>/disease/viewReports">
                            <div class="filter-grid">
                                <div class="filter-card">
                                    <h6><i class="fas fa-hashtag"></i> Report ID</h6>
                                    <input type="text" 
                                           class="form-control" 
                                           name="reportId" 
                                           placeholder="Enter Report ID"
                                           value="<?php echo $data['reportId']; ?>">
                                </div>
                                
                                <div class="filter-card">
                                    <h6><i class="fas fa-user"></i> Farmer NIC</h6>
                                    <input type="text" 
                                           class="form-control" 
                                           name="farmerNIC" 
                                           placeholder="Enter Farmer NIC"
                                           value="<?php echo $data['farmerNIC']; ?>">
                                </div>
                                
                                <div class="filter-card">
                                    <h6><i class="fas fa-id-card"></i> PLR Number</h6>
                                    <input type="text" 
                                           class="form-control" 
                                           name="plrNumber" 
                                           placeholder="Enter PLR Number"
                                           value="<?php echo $data['plrNumber']; ?>">
                                </div>
                                
                                <div class="filter-card">
                                    <h6><i class="fas fa-calendar"></i> Date Range</h6>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="date" class="form-control" name="startDate" id="startDate">
                                        </div>
                                        <div class="col-6">
                                            <input type="date" class="form-control" name="endDate" id="endDate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search me-1"></i> Apply Filters
                                </button>
                                <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh me-1"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Filters -->
                    <div class="filter-section">
                        <h5><i class="fas fa-bolt me-2"></i>Quick Filters</h5>
                        
                        <div class="mb-3">
                            <h6 class="mb-2">By Severity</h6>
                            <div class="quick-filters">
                                <a href="<?php echo URLROOT; ?>/disease/getBySeverity/high" 
                                   class="quick-filter-btn">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    High
                                </a>
                                <a href="<?php echo URLROOT; ?>/disease/getBySeverity/medium" 
                                   class="quick-filter-btn">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Medium
                                </a>
                                <a href="<?php echo URLROOT; ?>/disease/getBySeverity/low" 
                                   class="quick-filter-btn">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Low
                                </a>
                            </div>
                        </div>
                        
                        <div>
                            <h6 class="mb-2">By Status</h6>
                            <div class="quick-filters">
                                <a href="<?php echo URLROOT; ?>/disease/getByStatus/pending" 
                                   class="quick-filter-btn">
                                    <i class="fas fa-clock me-1"></i>
                                    Pending
                                </a>
                                <a href="<?php echo URLROOT; ?>/disease/getByStatus/under_review" 
                                   class="quick-filter-btn">
                                    <i class="fas fa-eye me-1"></i>
                                    Under Review
                                </a>
                                <a href="<?php echo URLROOT; ?>/disease/getByStatus/resolved" 
                                   class="quick-filter-btn">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Resolved
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Display Messages -->
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                <?php 
                                echo $_SESSION['success_message']; 
                                unset($_SESSION['success_message']);
                                ?>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div>
                                <?php 
                                echo $_SESSION['error_message']; 
                                unset($_SESSION['error_message']);
                                ?>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Results Info -->
                    <?php if (isset($data['message'])): ?>
                        <div class="alert alert-info d-flex align-items-center mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <div><?php echo $data['message']; ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Reports Table -->
                    <?php if (!empty($data['reports'])): ?>
                        <div class="reports-table">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="results-count">
                                    <i class="fas fa-table"></i>
                                    <?php echo count($data['reports']); ?> Reports Found
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Report ID</th>
                                            <th>Farmer Details</th>
                                            <th>Report Info</th>
                                            <th class="text-center">Severity</th>
                                            <th class="text-center">Area</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['reports'] as $report): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <code class="report-id"><?php echo htmlspecialchars($report->reportId); ?></code>
                                                </td>
                                                <td>
                                                    <div class="farmer-info">
                                                        <div class="fw-bold"><?php echo htmlspecialchars($report->farmerNIC); ?></div>
                                                        <small class="text-muted">PLR: <?php echo htmlspecialchars($report->plrNumber); ?></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="report-info">
                                                        <div class="fw-bold" title="<?php echo htmlspecialchars($report->title); ?>">
                                                            <?php echo htmlspecialchars(substr($report->title, 0, 30)); ?>
                                                            <?php if (strlen($report->title) > 30): ?>...<?php endif; ?>
                                                        </div>
                                                        <small class="text-muted">
                                                            <?php echo htmlspecialchars(substr($report->description ?? '', 0, 50)); ?>
                                                            <?php if (strlen($report->description ?? '') > 50): ?>...<?php endif; ?>
                                                        </small>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $severityClass = '';
                                                    $severityIcon = '';
                                                    switch ($report->severity) {
                                                        case 'high':
                                                            $severityClass = 'danger';
                                                            $severityIcon = 'exclamation-triangle';
                                                            break;
                                                        case 'medium':
                                                            $severityClass = 'warning';
                                                            $severityIcon = 'exclamation-circle';
                                                            break;
                                                        case 'low':
                                                            $severityClass = 'success';
                                                            $severityIcon = 'info-circle';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge bg-<?php echo $severityClass; ?> status-badge">
                                                        <i class="fas fa-<?php echo $severityIcon; ?> me-1"></i>
                                                        <?php echo ucfirst($report->severity); ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-bold">
                                                        <?php echo number_format($report->affectedArea, 1); ?>
                                                    </span>
                                                    <small class="text-muted d-block">acres</small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="date-info">
                                                        <div class="fw-bold">
                                                            <?php echo date('M d', strtotime($report->observationDate)); ?>
                                                        </div>
                                                        <small class="text-muted">
                                                            <?php echo date('Y', strtotime($report->observationDate)); ?>
                                                        </small>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (isset($report->status)): ?>
                                                        <?php
                                                        $statusClass = '';
                                                        $statusIcon = '';
                                                        switch ($report->status) {
                                                            case 'pending':
                                                                $statusClass = 'warning';
                                                                $statusIcon = 'clock';
                                                                break;
                                                            case 'under_review':
                                                                $statusClass = 'info';
                                                                $statusIcon = 'eye';
                                                                break;
                                                            case 'resolved':
                                                                $statusClass = 'success';
                                                                $statusIcon = 'check-circle';
                                                                break;
                                                            case 'rejected':
                                                                $statusClass = 'danger';
                                                                $statusIcon = 'times-circle';
                                                                break;
                                                            default:
                                                                $statusClass = 'secondary';
                                                                $statusIcon = 'question-circle';
                                                        }
                                                        ?>
                                                        <span class="badge bg-<?php echo $statusClass; ?> status-badge">
                                                            <i class="fas fa-<?php echo $statusIcon; ?> me-1"></i>
                                                            <?php echo ucfirst(str_replace('_', ' ', $report->status)); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary status-badge">
                                                            <i class="fas fa-question-circle me-1"></i>Unknown
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-buttons justify-content-center">
                                                        <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo $report->reportId; ?>" 
                                                           class="action-btn btn-info" 
                                                           title="View Details"
                                                           data-bs-toggle="tooltip">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $report->reportId; ?>" 
                                                           class="action-btn btn-primary" 
                                                           title="Edit Report"
                                                           data-bs-toggle="tooltip">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?php echo URLROOT; ?>/disease/confirmDelete/<?php echo $report->reportId; ?>" 
                                                           class="action-btn btn-danger" 
                                                           title="Delete Report"
                                                           data-bs-toggle="tooltip">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="no-reports">
                            <div class="mb-3">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h4 class="text-muted mb-2">No Reports Found</h4>
                            <p class="text-muted mb-3">
                                No disease reports match your search criteria.<br>
                                Try adjusting your search terms or create a new report.
                            </p>
                            <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Create New Report
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Set default dates for date filter
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
    
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    
    if (startDateInput && endDateInput) {
        endDateInput.value = today.toISOString().split('T')[0];
        startDateInput.value = thirtyDaysAgo.toISOString().split('T')[0];
    }
});

// Add loading state to buttons
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
            submitBtn.disabled = true;
        }
    });
});
</script>

<?php require APPROOT . '/views/inc/minimalfooter.php'; ?>