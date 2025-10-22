<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/editseller.css?v=<?= time(); ?>">

<main class="main-content">
  <div class="container">
    <div class="admin-header">
      <h1>Edit Seller</h1>
      <button class="back-btn" onclick="window.location='<?= URLROOT ?>/Admin/SellersList'">
        <i class="fas fa-arrow-left"></i> Back to Sellers
      </button>
    </div>

    <div class="form-wrapper">
      <form action="<?= URLROOT ?>/Admin/SellersList/edit/<?= $data['seller']->seller_id ?>" method="POST">
        <input type="hidden" name="seller_id" value="<?= $data['seller']->seller_id ?>">

        <div class="form-group">
          <label>First Name</label>
          <input type="text" name="first_name" value="<?= htmlspecialchars($data['seller']->first_name) ?>" required>
        </div>

        <div class="form-group">
          <label>Last Name</label>
          <input type="text" name="last_name" value="<?= htmlspecialchars($data['seller']->last_name) ?>" required>
        </div>

        <div class="form-group">
          <label>NIC</label>
          <input type="text" name="nic" value="<?= htmlspecialchars($data['seller']->nic) ?>" required>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($data['seller']->email) ?>" required>
        </div>

        <div class="form-group">
          <label>Phone No</label>
          <input type="text" name="phone_no" value="<?= htmlspecialchars($data['seller']->phone_no ?? '') ?>">
        </div>

        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" value="<?= htmlspecialchars($data['seller']->address ?? '') ?>">
        </div>

        <div class="form-group">
          <label>Company Name</label>
          <input type="text" name="company_name" value="<?= htmlspecialchars($data['seller']->company_name ?? '') ?>">
        </div>

        <div class="form-group">
          <label>BRN</label>
          <input type="text" name="brn" value="<?= htmlspecialchars($data['seller']->brn) ?>" required>
        </div>

        <div class="form-group">
          <label>Status</label>
          <select name="approval_status" required>
            <option value="Pending" <?= $data['seller']->approval_status == 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Approved" <?= $data['seller']->approval_status == 'Approved' ? 'selected' : '' ?>>Approved</option>
            <option value="Rejected" <?= $data['seller']->approval_status == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
          </select>
        </div>

<div class="form-actions">
    <button type="submit" class="action-btn edit-btn">
        <i class="fas fa-save"></i> Save Changes
    </button>

    <a href="<?= URLROOT ?>/Admin/SellersList" class="action-btn cancel-btn">
        <i class="fas fa-times"></i> Cancel
    </a>
</div>


      </form>
    </div>
  </div>
</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>