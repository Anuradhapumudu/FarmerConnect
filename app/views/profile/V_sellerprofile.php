<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>

<?php 

$user = $data['user'] ?? [];
$errors = $data['errors'] ?? [];

?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">

<main>


    <div class="logout-container">
        <a href="<?php echo URLROOT; ?>/users/logout" class="btn logout-btn" title="Log out">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <?php if(!empty($errors['general'])): ?>
            <div class="error error-field"><?= $errors['general'] ?></div>
    <?php endif; ?>

    <form id="form" method="POST" action="<?= URLROOT ?>/ProfileView/updateSeller" enctype="multipart/form-data">
        
        <div class="profile-pic">
            <div class="pic-wrapper">
        <img src="<?php 
            // Get the seller's image URL from the database
            $img = $data['seller']->image_url ?? '';

            // use default profile image
            if (empty($img)) {
                echo 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
            } 
            // The image URL is an external link (starts with http or https) ,,use as-is
            elseif (strpos($img, 'http') === 0) {
                echo $img; 
            } 
            // The image URL is a local file path,, prepend URLROOT to generate full URL
            else {
                echo URLROOT . '/' . $img; 
            }
        ?>" 

        alt="Profile Photo" id="profileImage">


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

        <div class="page-title">
            <h2>Seller Details</h2>
        </div>
        
        <div class="profile-card">
            <div class="profile-info">
                <div class ="form-group">
                    <label for="SellerID">Seller ID</label>
                    <input type="text" id="SellerID" name="seller_id" value="<?= $data['seller']->seller_id ?>" readonly >
                </div>

                <div class="form-group">
                    <label>BRN number:</label>
                    <input type="text" name="brn" value="<?= $data['seller']->brn ?>" readonly>
                </div>

                <div class="form-group">
                    <label>NIC:</label>
                    <input type="text" name="nic" value="<?= $data['seller']->nic ?>" readonly>
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
                    <label>Company Name</label>
                    <input type="text" name="company_name" value="<?= htmlspecialchars($user['company_name'] ?? '') ?>" required>
                     <?php if(!empty($errors['company_name'])): ?>
                        <div class="error error-field"><?= $errors['company_name'] ?></div>
                    <?php endif; ?>                   
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>
                     <?php if(!empty($errors['address'])): ?>
                        <div class="error error-field"><?= $errors['address'] ?></div>
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
