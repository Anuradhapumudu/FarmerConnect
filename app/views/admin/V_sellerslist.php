<?php require APPROOT . '/views/inc/header.php'; ?>
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

    <!-- Sellers Table -->
    <div class="data-table">
      <div class="table-header">All Sellers</div>
      <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>NIC</th>
            <th>Name</th>
            <th>Company</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data['sellers'] as $seller): ?>
          <tr>
            <td data-label="NIC"><?= $seller->nic ?></td>
            <td data-label="Name"><?= $seller->first_name . ' ' . $seller->last_name ?></td>
            <td data-label="Company"><?= $seller->company_name ?></td>
            <td data-label="Status">
              <span class="status-badge status-<?= strtolower($seller->approval_status) ?>">
                  <?= $seller->approval_status ?>
              </span>
            </td>
          <td data-label="Action">
              <a href="<?= URLROOT ?>/Admin/SellersList/show/<?= $seller->seller_id ?>" class="action-btn view-btn">
                  <i class="fas fa-eye"></i> View
              </a>

              <a href="<?= URLROOT ?>/Admin/SellersList/edit/<?= $seller->seller_id ?>" class="action-btn edit-btn">
                  <i class="fas fa-edit"></i> Edit
              </a>
          </td>

          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    </div>
 </div>
</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>