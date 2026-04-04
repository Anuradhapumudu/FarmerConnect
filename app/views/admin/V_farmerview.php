<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/viewfarmer.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <!-- Header -->
    <div class="admin-header">
      <div>
        <h1>Farmer Details</h1>
        <p>Complete information about the farmer and their paddy cultivation</p>
      </div>
      <button class="back-btn" onclick="window.location='<?= URLROOT ?>/Admin/UserList/farmerlist'">
        <i class="fas fa-arrow-left"></i> Back to Farmers
      </button>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
      <!-- Farmer Profile Section -->
      <div class="profile-card">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" 
             alt="Farmer Photo" class="profile-img">
        <h2 class="farmer-name"><?= $data['farmer']->full_name ?></h2>
        <p class="farmer-nic">NIC: <?= $data['farmer']->nic ?></p>
        <span class="status-badge status-active"><?= $data['farmer']->status ?></span>
        
        <div class="profile-details">
          <div class="detail-item">
            <span class="detail-label">Phone:</span>
            <span class="detail-value"><?= $data['farmer']->phone_no ?></span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Address:</span>
            <span class="detail-value"><?= $data['farmer']->address ?></span>
          </div>
        <div class="detail-item">
        <span class="detail-label">Account Created:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['farmer']->created_at)) ?></span>
        </div>
        <!-- <div class="detail-item">
        <span class="detail-label">Last Updated:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['farmer']->updated_at)) ?></span>
       </div>  -->
        </div>
      

      <!-- Paddy Details Section -->
      <div class="paddy-details">
        <h2 class="section-title">Paddy Cultivation Details</h2>

        <!-- we use this because farmer can have lot of paddy fields -->
<div class="paddy-cards">

<?php if (!empty($data['paddyDetails'])): ?>
    <?php foreach ($data['paddyDetails'] as $paddy): ?>
        <div class="paddy-card">
            <h3>PLR : <?= htmlspecialchars($paddy->PLR) ?></h3>

            <div class="paddy-detail-item">
                <span class="detail-label">Province:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Province) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">District:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->District) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Govi Jana Sewa Division:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Govi_Jana_Sewa_Division) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Grama Niladhari Division:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Grama_Niladhari_Division) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Yaya:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Yaya) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Paddy Size:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Paddy_Size) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Paddy Variety:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Paddy_Seed_Variety) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Created Date:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->CreatedDate) ?></span>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No paddy details available.</p>
<?php endif; ?>

</div>

        

    </div>

            <!-- Action Buttons -->
        <div class="action-buttons">
        <?php 
        $status = strtolower(trim($data['farmer']->status));
        ?>

        <?php if($status === 'active'): ?>
          <form action="<?= URLROOT ?>/Admin/UserList/inactivefarmer/<?= $data['farmer']->nic ?>" method="POST">
            <button type="submit" class="action-btn delete-btn">
            <i class="fas fa-times"></i> Inactive Farmer
        </button>
        </form>

        <?php elseif($status === 'inactive'): ?>
          <form action="<?= URLROOT ?>/Admin/UserList/activefarmer/<?= $data['farmer']->nic ?>" method="POST">
            <button type="submit" class="action-btn edit-btn">
            <i class="fas fa-check"></i> Active Farmer
        </button> 
        </form>                 
            <?php endif; ?>
      </div>

  </div>
</div>
</div>
</main>


<?php require APPROOT . '/views/inc/footer.php'; ?>