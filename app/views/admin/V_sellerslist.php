<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/list.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
 <div class="containers">
    <div class="admin-header">
      <h1>Sellers Management</h1>
      <p>View and manage all registered sellers</p>
    </div>

    <!-- Stats cards -->
    <div class="stats">
      <div class="card"><h2><?= $data['counts']->total ?></h2><p>Total Sellers</p></div>
      <div class="card"><h2><?= $data['counts']->approved ?></h2><p>Approved</p></div>
      <div class="card"><h2><?= $data['counts']->rejected ?></h2><p>Rejected</p></div>
      <div class="card"><h2><?= $data['counts']->pending ?></h2><p>Pending</p></div>
    </div>

       <!-- Search + Filter -->
    <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search farmers by NIC or Name...">
      </div>
      <select class="filter-select">
        <option value="all">All Status</option>
        <option value="active">Approved</option>
        <option value="inactive">Rejected</option>
        <option value="pending">Pending</option>
      </select>
    </div>

    <!-- Sellers Table -->
    <div class="data-table">
      <div class="table-header">All Sellers</div>
      <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Seller ID</th>
            <th>Name</th>
            <th>Company</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data['sellers'] as $seller): ?>
          <tr>
            <td data-label="Seller ID"><?= $seller->seller_id ?></td>
            <td data-label="Name"><?= $seller->first_name . ' ' . $seller->last_name ?></td>
            <td data-label="Company"><?= $seller->company_name ?></td>
            <td data-label="Status">
              <span class="status-badge status-<?= strtolower($seller->approval_status) ?>">
                  <?= $seller->approval_status ?>
              </span>
            </td>
          <td data-label="Action">
              <a href="<?= URLROOT ?>/Admin/UserList/showseller/<?= $seller->seller_id ?>" class="action-btn view-btn">
                  <i class="fas fa-eye"></i> View
              </a>

          </td>

          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      </div>
 
</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>