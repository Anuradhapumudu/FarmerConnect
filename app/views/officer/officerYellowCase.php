<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/officerYellowCase.css?v=<?= time(); ?>">

<main class="yellowcase-dashboard">

  <!-- Dashboard Header -->
  <div class="page-header">
    <h1>Yellow Case Management</h1>
    <p class="subtitle">Monitor, review, and respond to farmer-submitted yellow case reports</p>
  </div>

  <!-- Stats Overview -->
  <div class="stats-cards">
    <div class="stat-card total">
      <h3>Total Cases</h3>
      <p class="count">128</p>
    </div>
    <div class="stat-card pending">
      <h3>Pending Cases</h3>
      <p class="count">54</p>
    </div>
    <div class="stat-card replied">
      <h3>Replied Cases</h3>
      <p class="count">74</p>
    </div>
  </div>

  <!-- Search + Filter -->
  <div class="search-box">
    <div style="position: relative; flex: 1;">
      <i class="fas fa-search search-icon"></i>
      <input type="text" class="search-input" placeholder="Search farmers by PLR number or NIC ...">
    </div>
    <select class="filter-select">
      <option value="all">All Status</option>
      <option value="active">Pending</option>
      <option value="inactive">Replied</option>
    </select>
  </div>

  <!-- Case List -->
  <div class="case-table-container">
    <h2>All Yellow Case Reports</h2>
    <table class="case-table">
      <thead>
        <tr>
          <th>Case ID</th>
          <th>PLR Number</th>
          <th>Farmer NIC</th>
          <th>Farmer Name</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data['cases'])): ?>
            <?php foreach ($data['cases'] as $case): ?>
            <tr>
              <td><?php echo $case->case_id; ?></td>
              <td><?php echo htmlspecialchars($case->plr_number); ?></td>
              <td><?php echo htmlspecialchars($case->farmer_nic); ?></td>
              <td><?php echo htmlspecialchars($case->first_name . ' ' . $case->last_name); ?></td>
              <td><?php echo $case->observation_date; ?></td>
              <td><span class="status <?php echo strtolower($case->status); ?>"><?php echo ucfirst($case->status); ?></span></td>
              <td>
                <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview/show/<?php echo $case->case_id; ?>" class="btn-view">View</a>
                <a href="#" class="btn-reply">Timeline</a>
              </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No Yellow Cases Found</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- ✅ Mobile Cards View -->
    <div class="case-cards">
      <?php if (!empty($data['cases'])): ?>
          <?php foreach ($data['cases'] as $case): ?>
          <div class="case-card">
            <div class="case-card-header">
              <h4><?php echo $case->case_id; ?> — <?php echo htmlspecialchars($case->plr_number); ?></h4>
              <span class="status <?php echo strtolower($case->status); ?>"><?php echo ucfirst($case->status); ?></span>
            </div>
            <div class="case-card-body">
              <p><strong>Farmer NIC:</strong> <?php echo htmlspecialchars($case->farmer_nic); ?></p>
              <p><strong>Name:</strong> <?php echo htmlspecialchars($case->first_name . ' ' . $case->last_name); ?></p>
              <p><strong>Date:</strong> <?php echo $case->observation_date; ?></p>
            </div>
            <div class="case-card-actions">
              <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview/show/<?php echo $case->case_id; ?>" class="btn-view">View</a>
              <a href="#" class="btn-reply">Timeline</a>
            </div>
          </div>
          <?php endforeach; ?>
      <?php else: ?>
          <p>No Yellow Cases Found</p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

