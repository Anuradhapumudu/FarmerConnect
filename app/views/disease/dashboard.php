<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/diseaseDashboard.css?v=<?= time(); ?>">
<script src="<?php echo URLROOT; ?>/js/disease/diseaseDashboard.js?v=<?= time(); ?>" defer></script>

<?php
// ─── Helpers ──────────────────────────────────────────────────────────────────

/** Returns the Bootstrap badge class for a given severity level. */
function severityBadgeClass(string $severity): string
{
    return match (strtolower($severity)) {
        'high' => 'badge-danger',
        'medium' => 'badge-warning',
        'low' => 'badge-success',
        default => 'badge-secondary',
    };
}

/** Truncates a string and appends '…' if it exceeds $max characters. */
function truncate(string $text, int $max = 40): string
{
    return mb_strlen($text) > $max ? mb_substr($text, 0, $max) . '…' : $text;
}

// ─── Data ─────────────────────────────────────────────────────────────────────

// Stat cards are driven by this array — add/remove/reorder in one place.
$statCards = [
    [
        'label' => 'Total Reports',
        'value' => $data['totalReports'],
        'color' => 'primary',
        'icon' => 'fa-file-medical',
        'detailUrl' => null,
    ],
    [
        'label' => 'High Severity',
        'value' => $data['highSeverity'],
        'color' => 'danger',
        'icon' => 'fa-exclamation-triangle',
        'detailUrl' => URLROOT . '/disease/getBySeverity/high',
    ],
    [
        'label' => 'Medium Severity',
        'value' => $data['mediumSeverity'],
        'color' => 'warning',
        'icon' => 'fa-exclamation-circle',
        'detailUrl' => URLROOT . '/disease/getBySeverity/medium',
    ],
    [
        'label' => 'Low Severity',
        'value' => $data['lowSeverity'],
        'color' => 'success',
        'icon' => 'fa-info-circle',
        'detailUrl' => URLROOT . '/disease/getBySeverity/low',
    ],
];

// Quick-action buttons driven by an array — same idea.
$quickActions = [
    [
        'label' => 'Submit New Report',
        'icon' => 'fa-plus-circle',
        'color' => 'success',
        'href' => URLROOT . '/disease',
        'onclick' => null,
    ],
    [
        'label' => 'High Priority Reports',
        'icon' => 'fa-exclamation-triangle',
        'color' => 'danger',
        'href' => URLROOT . '/disease/getBySeverity/high',
        'onclick' => null,
    ],
    [
        'label' => 'Search Reports',
        'icon' => 'fa-search',
        'color' => 'info',
        'href' => URLROOT . '/disease/viewReports',
        'onclick' => null,
    ],
    [
        'label' => 'Reports by Date',
        'icon' => 'fa-calendar-alt',
        'color' => 'secondary',
        'href' => null,
        'onclick' => 'showDateRangeModal()',
    ],
];
?>

<div class="container mt-4">

    <!-- ═══ Page Header ═══ -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
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

    <!-- ═══ Statistics Cards ═══ -->
    <div class="row mb-4">
        <?php foreach ($statCards as $card): ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card bg-<?php echo $card['color']; ?> text-white shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    <?php echo $card['label']; ?>
                                </div>
                                <div class="h5 mb-0 font-weight-bold">
                                    <?php echo number_format($card['value']); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas <?php echo $card['icon']; ?> fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <?php if ($card['detailUrl']): ?>
                        <div class="card-footer bg-transparent">
                            <a href="<?php echo $card['detailUrl']; ?>" class="text-white small">
                                View Details <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- ═══ Charts + Recent Reports ═══ -->
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

                    <!-- Custom legend -->
                    <div class="row mt-3">
                        <?php
                        $legendItems = [
                            ['label' => 'High', 'class' => 'badge-danger', 'value' => $data['highSeverity']],
                            ['label' => 'Medium', 'class' => 'badge-warning', 'value' => $data['mediumSeverity']],
                            ['label' => 'Low', 'class' => 'badge-success', 'value' => $data['lowSeverity']],
                        ];
                        foreach ($legendItems as $item): ?>
                            <div class="col-4 text-center">
                                <span class="badge <?php echo $item['class']; ?> p-2">
                                    <i class="fas fa-circle"></i> <?php echo $item['label']; ?>
                                </span>
                                <div class="mt-1">
                                    <strong><?php echo number_format($item['value']); ?></strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                                            <?php echo htmlspecialchars(truncate($report->title)); ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?php echo date('M d', strtotime($report->created_at)); ?>
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <code><?php echo htmlspecialchars($report->reportId); ?></code>
                                        </small>
                                        <span class="badge <?php echo severityBadgeClass($report->severity); ?> badge-sm">
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

    <!-- ═══ Quick Actions ═══ -->
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
                        <?php foreach ($quickActions as $action): ?>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <?php if ($action['href']): ?>
                                    <a href="<?php echo $action['href']; ?>"
                                        class="btn btn-<?php echo $action['color']; ?> btn-lg btn-block">
                                        <i class="fas <?php echo $action['icon']; ?>"></i><br>
                                        <small><?php echo $action['label']; ?></small>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-<?php echo $action['color']; ?> btn-lg btn-block"
                                        onclick="<?php echo htmlspecialchars($action['onclick']); ?>">
                                        <i class="fas <?php echo $action['icon']; ?>"></i><br>
                                        <small><?php echo $action['label']; ?></small>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ═══ Date Range Modal ═══ -->
<div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel"
    aria-hidden="true">
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

<!-- ═══ JavaScript ═══ -->
<script>
    // Chart data injected safely via json_encode — no raw PHP echoes inside JS
    const chartData = {
        high: <?php echo json_encode((int) $data['highSeverity']); ?>,
        medium: <?php echo json_encode((int) $data['mediumSeverity']); ?>,
        low: <?php echo json_encode((int) $data['lowSeverity']); ?>
    };

    // Severity Distribution Doughnut Chart
    new Chart(document.getElementById('severityChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['High', 'Medium', 'Low'],
            datasets: [{
                data: [chartData.high, chartData.medium, chartData.low],
                backgroundColor: ['#dc3545', '#ffc107', '#28a745'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } } // Custom legend rendered in PHP above
        }
    });

    // Open date-range modal (Bootstrap 4)
    function showDateRangeModal() {
        $('#dateRangeModal').modal('show');
    }

    // Pre-fill date inputs to the last 30 days
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date();
        const thirtyDaysAgo = new Date(today - 30 * 24 * 60 * 60 * 1000);

        const fmt = d => d.toISOString().split('T')[0];

        document.getElementById('endDate').value = fmt(today);
        document.getElementById('startDate').value = fmt(thirtyDaysAgo);
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>