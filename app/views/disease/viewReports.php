<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/disease/diseaseReport.css?v=<?= time(); ?>">

<div class="content-card">
    <div class="content-header">
        <h1><?php echo isset($data['farmerNIC']) && !empty($data['farmerNIC']) ? 'My Submitted Reports' : 'Disease Reports'; ?></h1>
        <?php if(isset($data['farmerNIC']) && !empty($data['farmerNIC'])): ?>
            <a href="<?php echo URLROOT; ?>/disease" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> New Report
            </a>
        <?php endif; ?>
    </div>

    <!-- Filter Section -->
  <filter>   
    <?php if(isset($data['farmerNIC']) && !empty($data['farmerNIC'])): ?>
    <div class="search-container">
        <div class="search-header">
            <h4><i class="fas fa-search"></i> Filter Reports</h4>
        </div>
        <form action="<?php echo URLROOT; ?>/disease/viewReports" method="get">
            <div class="search-grid">
                <div class="form-group">
                    <label for="reportCode">Report ID</label>
                    <div class="input-with-icon">
                        <i class="fas fa-hashtag"></i>
                        <input type="text" name="reportCode" id="reportCode" placeholder="Search by ID (e.g. DR001)" value="<?php echo isset($data['reportCode']) ? $data['reportCode'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="plrNumber">PLR Number</label>
                    <div class="input-with-icon">
                        <i class="fas fa-map-marker-alt"></i>
                        <select name="plrNumber" id="plrNumber">
                            <option value="">All PLR Numbers</option>
                            <?php if(isset($data['paddyFields']) && !empty($data['paddyFields'])): ?>
                                <?php foreach($data['paddyFields'] as $paddy): ?>
                                    <option value="<?php echo $paddy->PLR; ?>" <?php echo (isset($data['plrNumber']) && $data['plrNumber'] == $paddy->PLR) ? 'selected' : ''; ?>>
                                        <?php echo $paddy->PLR; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="search-actions">
                <?php if(isset($data['searched']) && $data['searched']): ?>
                    <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-secondary btn-sm">Clear Filters</a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>
    <?php endif; ?>
   </filter>

    <!-- Reports Table -->
    <div class="table-responsive">
        <?php if(empty($data['reports'])): ?>
            <div class="empty-state">
                <div class="empty-icon">📂</div>
                <h3>No Reports Found</h3>
                <p>Create a new report.</p>
                <?php if(isset($data['farmerNIC']) && !empty($data['farmerNIC'])): ?>
                    <a href="<?php echo URLROOT; ?>/disease" class="btn btn-primary" style="margin-top: 15px;">Create New Report</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Date</th>
                        <th>PLR Number</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['reports'] as $report): ?>
                        <tr class="clickable-row" onclick="window.location.href='<?php echo URLROOT; ?>/disease/viewReport/<?php echo $report->report_code; ?>'">
                            <td>
                                <span class="report-code"><?php echo $report->report_code; ?></span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($report->observationDate)); ?></td>
                            <td>
                                <span class="plr-text"><?php echo $report->plrNumber; ?></span>
                            </td>
                            <td>
                                <div class="title-cell" title="<?php echo $report->title; ?>">
                                    <?php echo (strlen($report->title) > 50) ? substr($report->title, 0, 50) . '...' : $report->title; ?>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($report->status); ?>">
                                    <?php echo ucwords(str_replace('_', ' ', $report->status)); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo $report->report_code; ?>" class="btn-icon view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'farmer' && $_SESSION['nic'] === $report->farmerNIC && $report->status === 'pending'): ?>
                                        <a href="<?php echo URLROOT; ?>/disease/editReport/<?php echo $report->report_code; ?>" class="btn-icon edit" title="Edit Report" onclick="event.stopPropagation()">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="event.stopPropagation(); confirmDelete('<?php echo $report->report_code; ?>')" class="btn-icon delete" title="Delete Report">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" style="color: #e74c3c; font-size: 2rem;"></i>
            <h3>Delete Report?</h3>
        </div>
        <p>Are you sure you want to delete report <b id="deleteReportCode"></b>?</p>
        <p class="modal-warning">This action cannot be undone.</p>
        
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
            <a id="confirmDeleteLink" href="#" class="btn btn-danger">Yes, Delete It</a>
        </div>
    </div>
</div>

<script>
    function confirmDelete(reportCode) {
        const modal = document.getElementById('deleteModal');
        const deleteLink = document.getElementById('confirmDeleteLink');
        const codeSpan = document.getElementById('deleteReportCode');
        
        codeSpan.textContent = reportCode;
        deleteLink.href = "<?php echo URLROOT; ?>/disease/deleteReport/" + reportCode;
        
        modal.style.display = "block";
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = "none";
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>