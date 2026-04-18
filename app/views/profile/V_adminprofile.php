<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">

<?php 

$user = $data['user'] ?? [];
$errors = $data['errors'] ?? [];

?>

<main>

<div class="logout-container">
    <a href="<?php echo URLROOT; ?>/users/adminlogout" class="btn logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<?php if(!empty($errors['general'])): ?>
            <div class="error error-field"><?= $errors['general'] ?></div>
<?php endif; ?>

<form id="form" method="POST" 
      action="<?= URLROOT ?>/ProfileView/updateAdmin" 
      enctype="multipart/form-data">

<!-- PROFILE IMAGE -->
<div class="profile-pic">
    <div class="pic-wrapper">
        <img id="profileImage"
             src="<?php
                $img = $data['admin']->image_url ?? '';
                if (empty($img)) {
                    echo 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
                } elseif (strpos($img, 'http') === 0) {
                    echo $img;
                } else {
                    echo URLROOT . '/' . $img;
                }
             ?>"

alt="Profile Photo"  id="profileImage">

                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($user['image_url'] ?? '') ?>">
                <?php if(!empty($errors['image'])): ?>
                    <div class="error error-field"><?= $errors['image'] ?></div>
                <?php endif; ?>


                <div class="buttons">
                    <input type="file" id="uploadInput" name="profile_image" accept="image/*" style="display:none;">
                    <button type="button" class="btn upload-btn" onclick="document.getElementById('uploadInput').click();">
                        Upload Photo
                    </button>
                    <button type="submit" name="remove_image" value="1" class="btn remove-btn">
                        Remove Photo
                    </button>
                </div>
            </div>
</div>

<!-- ADMIN DETAILS -->
<div class="page-title">
    <h2>Admin Details</h2>
</div>

<div class="profile-card">
<div class="profile-info">

    <div class="form-group">
        <label>Admin ID</label>
        <input type="text" name="admin_id"
               value="<?= $data['admin']->admin_id ?? '' ?>" readonly>
    </div>

    <div class="form-group">
        <label>First Name</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
                  <?php if(!empty($errors['fname'])): ?>
                        <div class="error error-field"><?= $errors['fname'] ?></div>
                    <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Last Name</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required>
                    <?php if(!empty($errors['lname'])): ?>
                        <div class="error error-field"><?= $errors['lname'] ?></div>
                    <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Telephone Number</label>
                    <input type="text" name="phone_no" value="<?= htmlspecialchars($user['phone_no'] ?? '') ?>" required>
                     <?php if(!empty($errors['phone_no'])): ?>
                        <div class="error error-field"><?= $errors['phone_no'] ?></div>
                    <?php endif; ?> 
    </div>

    <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
            <?php if(!empty($errors['email'])): ?>
                        <div class="error error-field"><?= $errors['email'] ?></div>
            <?php endif; ?>
            </div>

    <div class="form-actions">
        <button type="submit" class="btn save-btn">Save Changes</button>
    </div>

</div>
</div>

</form>

<script src="<?php echo URLROOT; ?>/js/profileView/profile.js?v=<?= time(); ?>"></script>

</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
