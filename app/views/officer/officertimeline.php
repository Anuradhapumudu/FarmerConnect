<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/officertimeline.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

 <div class="container">
    <div class="officer-header">
      <h1>Farmer List</h1>
      <p>View farmers profile details or timeline of their paddy fields. </p>
    </div>

    <!-- Stats cards -->
    <div class="stats">
      <div class="card"><h2 id="totalCount">234</h2><p>Total Farmers</p></div>
      <div class="card"><h2 id="activeCount">223</h2><p>Active</p></div>
      <div class="card"><h2 id="inactiveCount">11</h2><p>Inactive</p></div>
    </div>

    <!-- Search + Filter -->
    <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search farmers by PLR number or NIC ...">
      </div>
      <select class="filter-select">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>

    <!-- Farmers Table -->
    <div class="farmer-table-wrapper">
      <div class="farmer-table-header">All Farmers</div>
      <table>
        <thead>
          <tr>
            <th>PLR Number</th>
            <th>NIC</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="farmerTable">
          <tr>
            <td>02/25/00083/002/P/0003</td>
            <td>992334567V</td>
            <td>Kamal Perera</td>
            <td><span class="status-badge status-active">Active</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View Timeline</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> View Profile Details</button>
            </td>
          </tr>
          <tr>
            <td>02/25/00083/002/P/0004</td>
            <td>993456789V</td>
            <td>Nimal Silva</td>
            <td><span class="status-badge status-inactive">Inactive</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View Timeline</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> View Profile Details</button>
            </td>
          </tr>
          <tr>
            <td>02/25/00083/002/P/0005</td>
            <td>994123456V</td>
            <td>Sanduni Fernando</td>
            <td><span class="status-badge status-active">Active</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View Timeline</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> View Profile Details</button>
            </td>
          </tr>
          <tr>
            <td>02/25/00083/002/P/0006</td>
            <td>995678912V</td>
            <td>Sunil Jayasuriya</td>
            <td><span class="status-badge status-active">Active</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View Timeline</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> View Profile Details</button>
            </td>
          </tr>
          <tr>
            <td>02/25/00083/002/P/0007</td>
            <td>996789123V</td>
            <td>Anusha Rajapaksa</td>
            <td><span class="status-badge status-inactive">Inactive</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View Timeline</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> View Profile Details</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">Next</button>
    </div>
  </div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>
