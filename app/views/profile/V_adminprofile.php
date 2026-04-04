<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">

<?php 
$old = $_SESSION['old_input'] ?? [];
$errors = $_SESSION['profile_errors'] ?? [];
unset($_SESSION['old_input'], $_SESSION['profile_errors']);
?>

<main>

<div class="logout-container">
    <a href="<?php echo URLROOT; ?>/users/logout" class="btn logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<form id="adminForm" method="POST" 
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
             alt="Profile Photo">

        <input type="hidden" name="existing_image"
               value="<?= $data['admin']->image_url ?? '' ?>">

        <div class="buttons">
            <input type="file" id="uploadInput" name="profile_image"
                   accept="image/*" hidden>

            <button type="button" class="btn upload-btn"
                    onclick="document.getElementById('uploadInput').click()">
                Upload Photo
            </button>

            <button type="button" class="btn remove-btn"
                    onclick="removeProfilePic()">
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
        <input type="text" name="first_name"
               value="<?= $data['admin']->first_name ?? '' ?>" required>
    </div>

    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name"
               value="<?= $data['admin']->last_name ?? '' ?>" required>
    </div>

    <div class="form-group">
        <label>Telephone Number</label>
        <input type="text" name="phone_no"
               value="<?= $data['admin']->phone_no ?? '' ?>" required>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn save-btn">Save Changes</button>
    </div>

</div>
</div>

</form>

<script>
document.getElementById('uploadInput').addEventListener('change', e => {
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('profileImage').src = e.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);

        const flag = document.getElementById('removed_flag');
        if (flag) flag.remove();
    }
});

function removeProfilePic() {
    document.getElementById('profileImage').src =
        'https://cdn-icons-png.flaticon.com/512/847/847969.png';
    document.getElementById('uploadInput').value = '';

    let flag = document.getElementById('removed_flag');
    if (!flag) {
        flag = document.createElement('input');
        flag.type = 'hidden';
        flag.name = 'removed_flag';
        flag.id = 'removed_flag';
        flag.value = '1';
        document.getElementById('adminForm').appendChild(flag);
    }
}
</script>

</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
