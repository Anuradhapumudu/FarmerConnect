<?php require APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/farmerProfile.css?v=<?= time(); ?>">

<main class="main-content">

<div class="containers">

    <!-- Header -->
    <div class="admin-header">
        <div>
            <h1>Farmer Profile</h1>
            <p>View farmer details and manage paddy lands</p>
        </div>

        <button class="back-btn" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <!-- Content -->
    <div class="content-wrapper">

        <!-- ================= FARMER PROFILE ================= -->
        <div class="profile-card">
            <img src="https://i.pravatar.cc/150" class="profile-img">

            <h2 class="farmer-name"><?= $data['farmer']->full_name ?></h2>
            <p class="farmer-nic">NIC: <?= $data['farmer']->nic ?></p>

            <span class="status-badge status-active">Active</span>

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
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value"><?= $data['farmer']->phone_no ?></span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Gender:</span>
                    <span class="detail-value"><?= $data['farmer']->gender ?></span>
                </div>


            </div>
        </div>

        <!-- ================= PADDY DETAILS ================= -->
        <div class="paddy-details">

            <h2 class="section-title">Paddy Lands</h2>

            <!-- Dropdown -->
            <form method="POST" action="<?= URLROOT ?>/officer/FarmerProfile/show">
                
                <input type="hidden" name="nic" value="<?= $data['farmer']->nic ?>">

                <select name="selected_plr" onchange="this.form.submit()" 
                    style="padding:10px; border-radius:8px; margin-bottom:20px;">

                    <?php foreach ($data['paddies'] as $p): ?>
                        <option value="<?= $p->PLR ?>" 
                            <?= ($p->PLR == $data['selectedPLR']) ? 'selected' : '' ?>>
                            <?= $p->PLR ?>
                        </option>
                    <?php endforeach; ?>

                </select>

            </form>

            <!-- Cards -->
            <div class="paddy-cards">

                <?php if (!empty($data['paddies'])): ?>

                    <?php foreach ($data['paddies'] as $paddy): ?>
                    <?php if ($paddy->PLR == $data['selectedPLR']): ?>


                    <div class="paddy-card">

                        <h3>PLR : <?= $paddy->PLR ?></h3>

                        <div class="paddy-detail-item">
                            <span class="detail-label">Province:</span>
                            <span class="detail-value"><?= $paddy->Province ?></span>
                        </div>

                        <div class="paddy-detail-item">
                            <span class="detail-label">District:</span>
                            <span class="detail-value"><?= $paddy->District ?></span>
                        </div>

                        <div class="paddy-detail-item">
                            <span class="detail-label">Division:</span>
                            <span class="detail-value"><?= $paddy->Govi_Jana_Sewa_Division ?></span>
                        </div>

                        <div class="paddy-detail-item">
                            <span class="detail-label">GN Division:</span>
                            <span class="detail-value"><?= $paddy->Grama_Niladhari_Division ?></span>
                        </div>

                        <div class="paddy-detail-item">
                            <span class="detail-label">Yaya:</span>
                            <span class="detail-value"><?= $paddy->Yaya ?></span>
                        </div>

                        <div class="paddy-detail-item">
                            <span class="detail-label">Size:</span>
                            <span class="detail-value"><?= $paddy->Paddy_Size ?></span>
                        </div>

                        <div class="paddy-detail-item">
                            <span class="detail-label">Seed:</span>
                            <span class="detail-value"><?= $paddy->Paddy_Seed_Variety ?></span>
                        </div>

                        <div class="paddy-detail-item">
                            <span class="detail-label">Created:</span>
                            <span class="detail-value"><?= $paddy->CreatedDate ?></span>
                        </div>

                        <!-- 🔴 DELETE BUTTON (OFFICER PRIVILEGE) -->
                        <div class="action-buttons">
                            <form action="<?= URLROOT ?>/officer/FarmerProfile/deletePLR" method="POST">
                                <input type="hidden" name="plr" value="<?= $paddy->PLR ?>">

                                <button type="submit" class="action-btn delete-btn">
                                    <i class="fas fa-trash"></i> Delete PLR
                                </button>
                            </form>
                        </div>

                    </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No paddy lands found.</p>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>