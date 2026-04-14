<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/list.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

 <div class="containers">
    <div class="admin-header">
      <h1>Farmers Management</h1>
      <p>View and manage all registered farmers</p>
    </div>

    <!-- Stats cards -->
    <div class="stats">
      <div class="card"><h2><?= $data['counts']->total ?></h2><p>Total Farmers</p></div>
      <div class="card"><h2><?= $data['counts']->active ?></h2><p>Active</p></div>
      <div class="card"><h2><?= $data['counts']->inactive ?></h2><p>Inactive</p></div>
    </div>

    <!-- Search + Filter -->
    <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Search farmers by NIC or Name...">
      </div>
      <select id="statusFilter" class="filter-select">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      
      </select>
    </div>

    <!-- Farmers Table -->
    <div class="data-table">
      <div class="table-header">All Farmers</div>
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

      <?php if(!empty($data['farmers'])): ?>
    <?php foreach($data['farmers'] as $farmer): ?>

      <tr class="userList"
      data-id="<?php echo strtolower(htmlspecialchars($farmer->nic));?>"
      data-name="<?php echo strtolower(htmlspecialchars($farmer->full_name));?>"
      data-status="<?php echo strtolower(htmlspecialchars($farmer->status));?>">

         
            <td data-label="NIC"><?= $farmer->nic ?></td>
            <td data-label="Name"><?= $farmer->full_name  ?></td>
  
            <td data-label="Status">
              <span class="status-badge status-<?= strtolower($farmer->status) ?>">
                  <?= $farmer->status ?>
              </span>
            </td>
          <td data-label="Action">
              <a href="<?= URLROOT ?>/Admin/UserList/showfarmer/<?= $farmer->nic ?>" class="action-btn view-btn">
                  <i class="fas fa-eye"></i> View
              </a>

          </td>

          </tr>
        <?php endforeach; ?>
        <?php else: ?>
                  <p>No farmers found.</p>
      <?php endif; ?>

        </tbody>
      </table>
    </div>



</main>


<script src="<?php echo URLROOT; ?>/js/admin/farmerlist.js?v=<?= time(); ?>"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>