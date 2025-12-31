<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/list.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

 <div class="containers">
    <div class="admin-header">
      <h1>Officers Management</h1>
      <p>View and manage all registered farmers</p>
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
        <input type="text" class="search-input" placeholder="Search farmers by NIC or Name...">
      </div>
      <select class="filter-select">
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
            <th>NIC</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="farmerTable">
        <?php foreach($data['officers'] as $officer): ?>
          <tr>
            <td data-label="NIC"><?= $officer->officer_id ?></td>
            <td data-label="Name"><?= $officer->first_name . ' ' . $officer->last_name ?></td>
            <td data-label="Status">
              <span class="status-badge status-<?= strtolower($officer->status) ?>">
                  <?= $officer->status ?>
              </span>
            </td>
          <td data-label="Action">
              <a href="<?= URLROOT ?>/Admin/UserList/show/<?= $officer->officer_id ?>" class="action-btn view-btn">
                  <i class="fas fa-eye"></i> View
              </a>

              <a href="<?= URLROOT ?>/Admin/UserList/edit/<?= $officer->officer_id ?>" class="action-btn edit-btn">
                  <i class="fas fa-edit"></i> Edit
              </a>
          </td>

          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>


</main>



<?php require APPROOT . '/views/inc/footer.php'; ?>