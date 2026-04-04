<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/viewseller.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <!-- Header -->
    <div class="admin-header">
      <div>
        <h1>Seller Details</h1>
        <p>Complete information about the seller and their listed products</p>
      </div>
      <button class="back-btn" onclick="window.location='<?= URLROOT ?>/Admin/UserList/sellerlist'">
        <i class="fas fa-arrow-left"></i> Back to Sellers
      </button>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
      <!-- Seller Profile Section -->
       <div class="profile-card">
    <img src="<?= URLROOT ?>/uploads/sellers/<?= $data['seller']->image ?: 'https://cdn-icons-png.flaticon.com/512/847/847969.png' ?>" 
         alt="Seller Photo" class="profile-img">
    <h2 class="seller-name"><?= $data['seller']->first_name . ' ' . $data['seller']->last_name ?></h2>
    <p class="seller-id">Seller ID: <?= $data['seller']->seller_id ?></p>
    <p class="seller-nic">NIC: <?= $data['seller']->nic ?></p>
    <span class="status-badge <?= strtolower($data['seller']->approval_status) == 'approved' ? 'status-active' : (strtolower($data['seller']->approval_status) == 'rejected' ? 'status-rejected' : 'status-pending') ?>">
      <?= $data['seller']->approval_status ?>
    </span>
    
<div class="profile-details">
    <!-- Priority Details -->
    <div class="detail-item">
        <span class="detail-label">Seller ID:</span>
        <span class="detail-value"><?= $data['seller']->seller_id ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">First Name:</span>
        <span class="detail-value"><?= $data['seller']->first_name ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Last Name:</span>
        <span class="detail-value"><?= $data['seller']->last_name ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Email:</span>
        <span class="detail-value"><?= $data['seller']->email ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Phone No:</span>
        <span class="detail-value"><?= $data['seller']->phone_no ?></span>
    </div>

    <!-- Secondary Details -->
    <div class="detail-item">
        <span class="detail-label">Address:</span>
        <span class="detail-value"><?= $data['seller']->address ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Company Name:</span>
        <span class="detail-value"><?= $data['seller']->company_name ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">BRN:</span>
        <span class="detail-value"><?= $data['seller']->brn ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Account Created:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['seller']->created_at)) ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Last Updated:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['seller']->updated_at)) ?></span>
    </div>

</div>


        <!-- Dynamic Approve/Reject Buttons -->
<div class="action-buttons">
<?php 
$status = strtolower(trim($data['seller']->approval_status));
?>

<?php if($status == 'pending'): ?>
    <form action="<?= URLROOT ?>/Admin/UserList/approve/<?= $data['seller']->seller_id ?>" method="POST">
        <button type="submit" class="action-btn edit-btn">
            <i class="fas fa-check"></i> Approve
        </button>
    </form>
    <form action="<?= URLROOT ?>/Admin/UserList/reject/<?= $data['seller']->seller_id ?>" method="POST">
        <button type="submit" class="action-btn delete-btn">
            <i class="fas fa-times"></i> Reject
        </button>
    </form>
<?php elseif($status == 'approved'): ?>
    <form action="<?= URLROOT ?>/Admin/UserList/reject/<?= $data['seller']->seller_id ?>" method="POST">
        <button type="submit" class="action-btn delete-btn">
            <i class="fas fa-times"></i> Reject
        </button>
    </form>
<?php elseif($status == 'rejected'): ?>
    <form action="<?= URLROOT ?>/Admin/UserList/approve/<?= $data['seller']->seller_id ?>" method="POST">
        <button type="submit" class="action-btn edit-btn">
            <i class="fas fa-check"></i> Approve
        </button>
    </form>
<?php endif; ?>

        </div>

      </div>


    </div>
  </div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>
