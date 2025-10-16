<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/list.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

 <div class="containers">
    <div class="admin-header">
      <h1>Officers Management</h1>
      <p>View and manage all registered farmers</p>
    </div>

    <!-- Stats cards -->
    <div class="stats">
      <div class="card"><h2 id="totalCount">0</h2><p>Total Officers</p></div>
      <div class="card"><h2 id="activeCount">0</h2><p>Active</p></div>
      <div class="card"><h2 id="inactiveCount">0</h2><p>Inactive</p></div>
    </div>

    <!-- Search + Filter -->
    <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search farmers by NIC or Name...">
      </div>
      <select class="filter-select">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="pending">Pending</option>
      </select>
    </div>

    <!-- Farmers Table -->
    <div class="data-table">
      <div class="table-header">All Officers</div>
      <table>
        <thead>
          <tr>
            <th>NIC</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="farmerTable">
          <tr>
            <td>992334567V</td>
            <td>Kamal Perera</td>
            <td><span class="status-badge status-active">Active</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>993456789V</td>
            <td>Nimal Silva</td>
            <td><span class="status-badge status-inactive">Inactive</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>994123456V</td>
            <td>Sanduni Fernando</td>
            <td><span class="status-badge status-pending">Pending</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>995678912V</td>
            <td>Sunil Jayasuriya</td>
            <td><span class="status-badge status-active">Active</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </td>
          </tr>
          <tr>
            <td>996789123V</td>
            <td>Anusha Rajapaksa</td>
            <td><span class="status-badge status-pending">Pending</span></td>
            <td>
              <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
              <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
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

  <!-- Delete Modal -->
  <div class="modal" id="deleteModal">
    <div class="modal-content">
      <h3>Confirm Delete</h3>
      <p>Are you sure you want to delete this farmer?</p>
      <div class="modal-actions">
        <button class="cancel-btn">Cancel</button>
        <button class="confirm-btn">Yes, Delete</button>
      </div>
    </div>
  </div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>