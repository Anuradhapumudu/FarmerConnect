<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/viewseller.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

<div class="containers">

<!-- HEADER -->
<div class="admin-header">
    <div>
        <h1>Seller Details</h1>
    </div>

    <button class="back-btn"
        onclick="window.location='<?= URLROOT ?>/Admin/UserList/sellerlist'">
        <i class="fas fa-arrow-left"></i> Back to Sellers
    </button>
</div>

<!-- ALERTS -->
<?php if(!empty($data['errors'])): ?>
    <div class="alert error">
        <ul>
            <?php foreach($data['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(!empty($data['success'])): ?>
    <div class="alert success">
        <?= $data['success']; ?>
    </div>
<?php endif; ?>

<!-- ================= MAIN UPDATE FORM ================= -->
<form method="POST"
      action="<?= URLROOT ?>/Admin/UserList/updateSeller/<?= $data['seller']->seller_id ?>">

<div class="content-wrapper">

    <!-- PROFILE CARD -->
    <div class="profile-card">

        <img src="<?= !empty($data['seller']->image_url)
            ? URLROOT . '/' . $data['seller']->image_url
            : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' ?>"
            class="profile-img">

        <h2 class="seller-name">
            <?= $data['seller']->first_name . ' ' . $data['seller']->last_name ?>
        </h2>

        <p class="seller-id">Seller ID: <?= $data['seller']->seller_id ?></p>
        <p class="seller-nic">NIC: <?= $data['seller']->nic ?></p>

        <span class="status-badge <?= strtolower($data['seller']->approval_status) == 'approved'
            ? 'status-active'
            : (strtolower($data['seller']->approval_status) == 'rejected'
                ? 'status-rejected'
                : 'status-pending') ?>">
            <?= $data['seller']->approval_status ?>
        </span>

    

    <!-- DETAILS -->
    <div class="profile-details">

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
            <input type="text" name="email"
                   value="<?= htmlspecialchars($data['seller']->email) ?>">
        </div>

        <div class="detail-item">
            <span class="detail-label">Phone No:</span>
            <span class="detail-value"><?= $data['seller']->phone_no ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Address:</span>
            <span class="detail-value"><?= $data['seller']->address ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Company Name:</span>
            <input type="text" name="company_name"
                   value="<?= htmlspecialchars($data['seller']->company_name) ?>">
        </div>

        <div class="detail-item">
            <span class="detail-label">BRN:</span>
            <input type="text" name="brn"
                   value="<?= htmlspecialchars($data['seller']->brn) ?>">
        </div>

        <div class="detail-item">
            <span class="detail-label">Created:</span>
            <span class="detail-value">
                <?= date('d M Y, h:i A', strtotime($data['seller']->created_at)) ?>
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Updated:</span>
            <span class="detail-value">
                <?= date('d M Y, h:i A', strtotime($data['seller']->updated_at)) ?>
            </span>
        </div>

    </div>



<!-- SAVE BUTTON (ONLY ONE FORM BUTTON) -->
<div class="action-buttons">
    <button type="submit" class="action-btn save-btn">
        Save Changes
    </button>
    </div>
</div>
</div>
</form>
<!-- ================= END FORM ================= -->


<!-- APPROVE / REJECT (NO NESTED FORMS) -->
<div class="action-buttons">

<?php $status = strtolower(trim($data['seller']->approval_status)); ?>

<?php if($status == 'pending'): ?>

    <button type="button"
        onclick="location.href='<?= URLROOT ?>/Admin/UserList/approve/<?= $data['seller']->seller_id ?>'"
        class="action-btn edit-btn">
        <i class="fas fa-check"></i> Approve
    </button>

    <button type="button"
        onclick="location.href='<?= URLROOT ?>/Admin/UserList/reject/<?= $data['seller']->seller_id ?>'"
        class="action-btn delete-btn">
        <i class="fas fa-times"></i> Reject
    </button>

<?php elseif($status == 'approved'): ?>

    <button type="button"
        onclick="location.href='<?= URLROOT ?>/Admin/UserList/reject/<?= $data['seller']->seller_id ?>'"
        class="action-btn delete-btn">
        Reject
    </button>

<?php else: ?>

    <button type="button"
        onclick="location.href='<?= URLROOT ?>/Admin/UserList/approve/<?= $data['seller']->seller_id ?>'"
        class="action-btn edit-btn">
        Approve
    </button>

<?php endif; ?>

</div>

</div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>