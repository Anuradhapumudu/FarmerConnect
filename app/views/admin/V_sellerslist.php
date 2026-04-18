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
        <input type="text" id="searchInput" class="search-input" placeholder="Search Sellers by sellerId or Name...">
      </div>
      <select id="statusFilter" class="filter-select">
        <option value="all">All Status</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
        <option value="Pending">Pending</option>
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

        <?php if(!empty($data['sellers'])): ?>
        <?php foreach($data['sellers'] as $seller): ?>

      <tr class="userList"
      data-id="<?php echo strtolower(htmlspecialchars($seller->seller_id));?>"
      data-fname="<?php echo strtolower(htmlspecialchars($seller->first_name));?>"
      data-lname="<?php echo strtolower(htmlspecialchars($seller->last_name));?>"
      data-status="<?php echo strtolower(htmlspecialchars($seller->approval_status));?>">
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
        <?php else: ?>
                  <p>No sellers found.</p>
      <?php endif; ?>
        </tbody>
      </table>
      </div>
 
</main>


<script src="<?php echo URLROOT; ?>/js/admin/sellerlist.js?v=<?= time(); ?>"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>