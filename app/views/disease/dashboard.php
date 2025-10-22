<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/diseaseDashboard.css?v=<?= time(); ?>">
<script src="<?php echo URLROOT; ?>/js/disease/diseaseDashboard.js?v=<?= time(); ?>" defer></script>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-chart-line text-primary"></i>
                    Disease Reports Dashboard
                </h2>
                <div>
                    <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success">
                        <i class="fas fa-plus"></i> New Report
                    </a>
                    <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-primary">
                        <i class="fas fa-list"></i> View All Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Reports -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Total Reports
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo number_format($data['totalReports']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-medical fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- High Severity -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-danger text-white shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                High Severity
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo number_format($data['highSeverity']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="<?php echo URLROOT; ?>/disease/getBySeverity/high" class="text-white small">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Medium Severity -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Medium Severity
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo number_format($data['mediumSeverity']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="<?php echo URLROOT; ?>/disease/getBySeverity/medium" class="text-white small">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Low Severity -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Low Severity
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo number_format($data['lowSeverity']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="<?php echo URLROOT; ?>/disease/getBySeverity/low" class="text-white small">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Severity Distribution Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie text-info"></i>
                        Severity Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="severityChart" height="300"></canvas>
                    
                    <!-- Legend -->
                    <div class="row mt-3">
                        <div class="col-4 text-center">
                            <span class="badge badge-danger p-2">
                                <i class="fas fa-circle"></i> High
                            </span>
                            <div class="mt-1">
                                <strong><?php echo $data['highSeverity']; ?></strong>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <span class="badge badge-warning p-2">
                                <i class="fas fa-circle"></i> Medium
                            </span>
                            <div class="mt-1">
                                <strong><?php echo $data['mediumSeverity']; ?></strong>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <span class="badge badge-success p-2">
                                <i class="fas fa-circle"></i> Low
                            </span>
                            <div class="mt-1">
                                <strong><?php echo $data['lowSeverity']; ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock text-success"></i>
                        Recent Reports
                    </h5>
                    <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($data['recentReports'])): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($data['recentReports'] as $report): ?>
                                <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo $report->reportId; ?>" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <?php echo htmlspecialchars(substr($report->title, 0, 40)); ?>
                                            <?php if (strlen($report->title) > 40): ?>...<?php endif; ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?php echo date('M d', strtotime($report->created_at)); ?>
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <code><?php echo $report->reportId; ?></code>
                                        </small>
                                        <?php
                                        $severityClass = '';
                                        switch ($report->severity) {
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
                                        <span class="badge <?php echo $severityClass; ?> badge-sm">
                                            <?php echo ucfirst($report->severity); ?>
                                        </span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <h6>No recent reports</h6>
                            <p>No reports have been submitted in the last 30 days.</p>
                            <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success">
                                <i class="fas fa-plus"></i> Submit First Report
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-warning"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="<?php echo URLROOT; ?>/disease" class="btn btn-success btn-lg btn-block">
                                <i class="fas fa-plus-circle"></i><br>
                                <small>Submit New Report</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="<?php echo URLROOT; ?>/disease/getBySeverity/high" class="btn btn-danger btn-lg btn-block">
                                <i class="fas fa-exclamation-triangle"></i><br>
                                <small>High Priority Reports</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-info btn-lg btn-block">
                                <i class="fas fa-search"></i><br>
                                <small>Search Reports</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-secondary btn-lg btn-block" onclick="showDateRangeModal()">
                                <i class="fas fa-calendar-alt"></i><br>
                                <small>Reports by Date</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Range Modal -->
<div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateRangeModalLabel">Filter Reports by Date Range</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo URLROOT; ?>/disease/getByDateRange">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Filter Reports</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Severity Distribution Pie Chart
const ctx = document.getElementById('severityChart').getContext('2d');
const severityChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['High', 'Medium', 'Low'],
        datasets: [{
            data: [
                <?php echo $data['highSeverity']; ?>,
                <?php echo $data['mediumSeverity']; ?>,
                <?php echo $data['lowSeverity']; ?>
            ],
            backgroundColor: [
                '#dc3545', // Red for high
                '#ffc107', // Yellow for medium
                '#28a745'  // Green for low
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false // We have custom legend below
            }
        }
    }
});

function showDateRangeModal() {
    $('#dateRangeModal').modal('show');
}

// Set default date range (last 30 days)
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
    
    document.getElementById('endDate').value = today.toISOString().split('T')[0];
    document.getElementById('startDate').value = thirtyDaysAgo.toISOString().split('T')[0];
});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>