<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/list.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

 <div class="containers">
    <div class="admin-header">
      <h1>Officers Management</h1>
      <p>View and manage all registered Officers</p>
    </div>

    <!-- Stats cards -->
    <div class="stats">
      <div class="card"><h2><?= $data['counts']->total ?></h2><p>Total Officers</p></div>
      <div class="card"><h2><?= $data['counts']->active ?></h2><p>Active</p></div>
      <div class="card"><h2><?= $data['counts']->inactive ?></h2><p>Inactive</p></div>
    </div>

    <!-- Search + Filter -->
    <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Search Officers by officerId or Name...">
      </div>
      <select id="statusFilter" class="filter-select">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option><option value="pending">Pending</option>
      </select>
    </div>

    <!-- Farmers Table -->
    <div class="data-table">
      <div class="table-header">All Officers</div>
      <table>
        <thead>
          <tr>
            <th>Officer ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="farmerTable">

    <?php if(!empty($data['officers'])): ?>
    <?php foreach($data['officers'] as $officer): ?>

      <tr class="userList"
      data-id="<?php echo strtolower(htmlspecialchars($officer->officer_id));?>"
      data-fname="<?php echo strtolower(htmlspecialchars($officer->first_name));?>"
      data-lname="<?php echo strtolower(htmlspecialchars($officer->last_name));?>"
      data-status="<?php echo strtolower(htmlspecialchars($officer->status));?>">
            <td data-label="NIC"><?= $officer->officer_id ?></td>
            <td data-label="Name"><?= $officer->first_name . ' ' . $officer->last_name ?></td>
            <td data-label="Status">
              <span class="status-badge status-<?= strtolower($officer->status) ?>">
                  <?= $officer->status ?>
              </span>
            </td>
          <td data-label="Action">
              <a href="<?= URLROOT ?>/Admin/UserList/showofficer/<?= $officer->officer_id ?>" class="action-btn view-btn">
                  <i class="fas fa-eye"></i> View
              </a>

          </td>

          </tr>
   
        <?php endforeach; ?>
        <?php else: ?>
                  <p>No officer found.</p>
      <?php endif; ?>
        </tbody>
      </table>
    </div>


</main>


<script src="<?php echo URLROOT; ?>/js/admin/officerlist.js?v=<?= time(); ?>"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>