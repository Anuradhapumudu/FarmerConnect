<?php require APPROOT . '/views/inc/officerheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/plrReqView.css?v=<?= time(); ?>">

<main class="main-content">

<div class="form-container <?php echo $data['request']->status; ?>">

    <h2>PLR Request Details</h2>

    <h2>PLR Request Details</h2>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert success">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

    <div class="form-grid">

        <div class="form-group">
            <label>PLR Number</label>
            <input type="text" value="<?php echo $data['request']->PLR; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Farmer NIC</label>
            <input type="text" value="<?php echo $data['request']->NIC_FK; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Farmer Name</label>
            <input type="text" value="<?php echo $data['request']->full_name; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Seed Variety</label>
            <input type="text" value="<?php echo $data['request']->Paddy_Seed_Variety; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Land Size</label>
            <input type="text" value="<?php echo $data['request']->Paddy_Size; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Province</label>
            <input type="text" value="<?php echo $data['request']->Province; ?>" readonly>
        </div>

        <div class="form-group">
            <label>District</label>
            <input type="text" value="<?php echo $data['request']->District; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Govi Jana Sewa Division</label>
            <input type="text" value="<?php echo $data['request']->Govi_Jana_Sewa_Division; ?>" readonly>
        </div>

        <div class="form-group">
            <label>GN Division</label>
            <input type="text" value="<?php echo $data['request']->Grama_Niladhari_Division; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Yaya</label>
            <input type="text" value="<?php echo $data['request']->Yaya; ?>" readonly>
        </div>

    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-buttons">

    <?php if ($data['request']->status == 'approved'): ?>

        <a href="<?php echo URLROOT; ?>/officer/plrReqList/reject/<?php echo $data['request']->id; ?>" 
        class="btn reject"
        onclick="return confirm('Reject this request?')">
            Reject
        </a>

    <?php elseif ($data['request']->status == 'rejected'): ?>

        <a href="<?php echo URLROOT; ?>/officer/plrReqList/approve/<?php echo $data['request']->id; ?>" 
        class="btn approve"
        onclick="return confirm('Approve this request?')">
            Approve
        </a>

    <?php else: ?> <!-- pending -->

        <a href="<?php echo URLROOT; ?>/officer/plrReqList/approve/<?php echo $data['request']->id; ?>" 
        class="btn approve">
            Approve
        </a>

        <a href="<?php echo URLROOT; ?>/officer/plrReqList/reject/<?php echo $data['request']->id; ?>" 
        class="btn reject">
            Reject
        </a>

    <?php endif; ?>

    </div>

</div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>