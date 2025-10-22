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
        <tr>
          <td>YC-001</td>
          <td>02/25/00083/002/P/0006</td>
          <td>197940306V</td>
          <td>K.R. Aberathna</td>
          <td>2025-10-18</td>
          <td><span class="status pending">Pending</span></td>
          <td>
            <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
            <a href="#" class="btn-reply">Timeline</a>
          </td>
        </tr>
        <tr>
          <td>YC-002</td>
          <td>02/25/00083/002/P/0010</td>
          <td>200043211V</td>
          <td>S. Gunasekara</td>
          <td>2025-10-15</td>
          <td><span class="status replied">Replied</span></td>
          <td>
            <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
            <a href="#" class="btn-reply">Timeline</a>
          </td>
        </tr>
        <tr>
          <td>YC-003</td>
          <td>02/25/00083/002/P/0016</td>
          <td>196740336V</td>
          <td>R.A. Abesinghe</td>
          <td>2025-10-14</td>
          <td><span class="status pending">Pending</span></td>
          <td>
            <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
            <a href="#" class="btn-reply">Timeline</a>
          </td>
        </tr>
        <tr>
          <td>YC-004</td>
          <td>02/25/00083/002/P/0034</td>
          <td>198345606V</td>
          <td>R.A. Somarathne</td>
          <td>2025-10-12</td>
          <td><span class="status replied">Replied</span></td>
          <td>
            <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
            <a href="#" class="btn-reply">Timeline</a>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- ✅ Mobile Cards View -->
    <div class="case-cards">
      <!-- YC-001 -->
      <div class="case-card">
        <div class="case-card-header">
          <h4>YC-001 — 02/25/00083/002/P/0006</h4>
          <span class="status pending">Pending</span>
        </div>
        <div class="case-card-body">
          <p><strong>Farmer NIC:</strong> 197940306V</p>
          <p><strong>Name:</strong> K.R. Aberathna</p>
          <p><strong>Date:</strong> 2025-10-18</p>
        </div>
        <div class="case-card-actions">
          <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
          <a href="#" class="btn-reply">Timeline</a>
        </div>
      </div>

      <!-- YC-002 -->
      <div class="case-card">
        <div class="case-card-header">
          <h4>YC-002 — 02/25/00083/002/P/0010</h4>
          <span class="status replied">Replied</span>
        </div>
        <div class="case-card-body">
          <p><strong>Farmer NIC:</strong> 200043211V</p>
          <p><strong>Name:</strong> S. Gunasekara</p>
          <p><strong>Date:</strong> 2025-10-15</p>
        </div>
        <div class="case-card-actions">
          <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
          <a href="#" class="btn-reply">Timeline</a>
        </div>
      </div>

      <!-- ✅ YC-003 -->
      <div class="case-card">
        <div class="case-card-header">
          <h4>YC-003 — 02/25/00083/002/P/0016</h4>
          <span class="status pending">Pending</span>
        </div>
        <div class="case-card-body">
          <p><strong>Farmer NIC:</strong> 196740336V</p>
          <p><strong>Name:</strong> R.A. Abesinghe</p>
          <p><strong>Date:</strong> 2025-10-14</p>
        </div>
        <div class="case-card-actions">
          <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
          <a href="#" class="btn-reply">Timeline</a>
        </div>
      </div>

      <!-- ✅ YC-004 -->
      <div class="case-card">
        <div class="case-card-header">
          <h4>YC-004 — 02/25/00083/002/P/0034</h4>
          <span class="status replied">Replied</span>
        </div>
        <div class="case-card-body">
          <p><strong>Farmer NIC:</strong> 198345606V</p>
          <p><strong>Name:</strong> R.A. Somarathne</p>
          <p><strong>Date:</strong> 2025-10-12</p>
        </div>
        <div class="case-card-actions">
          <a href="<?php echo URLROOT; ?>/officer/Yellowcaseview" class="btn-view">View</a>
          <a href="#" class="btn-reply">Timeline</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

