<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>

<?php 
$old = $_SESSION['old_input'] ?? [];
$errors = $_SESSION['profile_errors'] ?? [];
unset($_SESSION['old_input'], $_SESSION['profile_errors']);
?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">

<main>
    <div class="logout-container">
        <a href="<?php echo URLROOT; ?>/users/logout" class="btn logout-btn" title="Log out">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <form id="sellerForm" method="POST" action="<?= URLROOT ?>/ProfileView/updateSeller" enctype="multipart/form-data">
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


                <input type="hidden" name="existing_image" value="<?= $data['seller']->image_url ?? '' ?>">
                
                <div class="buttons">
                    <input type="file" id="uploadInput" name="profile_image" accept="image/*" style="display:none;">
                    <button type="button" class="btn upload-btn" onclick="document.getElementById('uploadInput').click();">
                        Upload Photo
                    </button>
                    <button type="button" class="btn remove-btn" onclick="removeProfilePic()">
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
                    <input type="text" id="SellerID" name="SellerID" value="<?= $data['seller']->seller_id ?>" readonly >
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
                    <input type="text" name="first_name" value="<?= $data['seller']->first_name ?>" required>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?= $data['seller']->last_name ?>" required>
                </div>

                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="company_name" value="<?= $data['seller']->company_name ?>" required>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="<?= $data['seller']->address ?>" required>
                </div>

                <div class="form-group">
                    <label>Telephone Number</label>
                    <input type="text" name="phone_no" value="<?= $data['seller']->phone_no ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= $data['seller']->email ?>" readonly>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn save-btn">Save Changes</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('uploadInput').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);

                const removeFlag = document.getElementById('removed_flag');
                if (removeFlag) removeFlag.remove();
            }
        });

        function removeProfilePic() {
            document.getElementById('profileImage').src = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
            document.getElementById('uploadInput').value = '';

            let removeFlag = document.getElementById('removed_flag');
            if (!removeFlag) {
                removeFlag = document.createElement('input');
                removeFlag.type = 'hidden';
                removeFlag.name = 'removed_flag';
                removeFlag.id = 'removed_flag';
                removeFlag.value = '1';
                document.getElementById('sellerForm').appendChild(removeFlag);
            } else {
                removeFlag.value = '1';
            }
        }
    </script>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
