<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/viewseller.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <!-- Header -->
    <div class="admin-header">
      <div>
        <h1>Officer Details</h1>
        <p>Complete information about the officer </p>
      </div>
      <button class="back-btn" onclick="window.location='<?= URLROOT ?>/Admin/UserList/officerlist'">
        <i class="fas fa-arrow-left"></i> Back to Officers
      </button>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
      <!-- Officer Profile Section -->
       <div class="profile-card">
    <img src="<?= URLROOT ?>/uploads/officer/<?= $data['officer']->image ?: 'https://cdn-icons-png.flaticon.com/512/847/847969.png' ?>" 
         alt="Officer Photo" class="profile-img">
    <h2 class="officer-name"><?= $data['officer']->first_name . ' ' . $data['officer']->last_name ?></h2>
    <p class="officer-id">Officer ID: <?= $data['officer']->officer_id ?></p>
    <p class="officer-nic">NIC: <?= $data['officer']->nic ?></p>
    <span class="status-badge <?= strtolower($data['officer']->status) == 'active' ? 'status-active' : (strtolower($data['officer']->status) == 'inactive' ? 'status-inactive' : 'status-pending') ?>">
      <?= $data['officer']->status ?>
    </span>
    
<div class="profile-details">
    <!-- Priority Details -->
    <div class="detail-item">
        <span class="detail-label">Officer ID:</span>
        <span class="detail-value"><?= $data['officer']->officer_id ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">First Name:</span>
        <span class="detail-value"><?= $data['officer']->first_name ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Last Name:</span>
        <span class="detail-value"><?= $data['officer']->last_name ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Email:</span>
        <span class="detail-value"><?= $data['officer']->email ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Phone No:</span>
        <span class="detail-value"><?= $data['officer']->phone_no ?></span>
    </div>


    <div class="detail-item">
        <span class="detail-label">Account Created:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['officer']->created_at)) ?></span>
    </div>
    <div class="detail-item">
        <span class="detail-label">Last Updated:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['officer']->updated_at)) ?></span>
    </div>

</div>


        <!-- Dynamic Approve/Reject Buttons -->
<div class="action-buttons">
<?php 
$status = strtolower(trim($data['officer']->status));
?>

<?php if($status == 'active'): ?>
    <form action="<?= URLROOT ?>/Admin/UserList/inactiveofficer/<?= $data['officer']->officer_id ?>" method="POST">
        <button type="submit" class="action-btn delete-btn">
            <i class="fas fa-times"></i> Inactive Officer
        </button>
    </form>
<?php elseif($status == 'inactive'): ?>
    <form action="<?= URLROOT ?>/Admin/UserList/activeofficer/<?= $data['officer']->officer_id ?>" method="POST">
        <button type="submit" class="action-btn edit-btn">
            <i class="fas fa-check"></i> Active Officer
        </button>
    </form>
<?php endif; ?>

        </div>

      </div>


    </div>
  </div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>
