<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">



<main>

    <div class="logout-container">
        <a href="<?php echo URLROOT; ?>/users/logout" class="btn logout-btn" title="Log out">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <div class="profile-pic">
        <div class="pic-wrapper">
            <img src="<?php echo !empty($data['farmer']->profile_image) 
                ? URLROOT . $data['farmer']->profile_image 
                : 'https://cdn-icons-png.flaticon.com/512/847/847969.png'; ?>" 
                alt="Profile Photo" id="profileImage">

            <div class="buttons">
                <input type="file" id="uploadInput" accept="image/*" style="display:none;">
                <button type="button" class="btn upload-btn" onclick="document.getElementById('uploadInput').click();">
                    Upload Photo
                </button>
                <button type="button" class="btn remove-btn" onclick="removeProfilePic()">
                    Remove Photo
                </button>
            </div>
        </div>
    </div>

<!-- SELLER DETAILS -->
<div class="page-title">
    <h2>Admin Details</h2>
</div>
<div class="profile-card">
    <div class="profile-info">
        <form id="sellerForm" method="POST" onsubmit="event.preventDefault(); alert('This is dummy data!');">
            <div class="form-group">
                <label for="SellerID">Admin ID</label>
                <input type="text" id="SellerID" name="SellerID" value="AD0003" readonly>
            </div>

            <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" id="Name" name="Name" value="Amal Perera">
            </div>

            <div class="form-group">
                <label for="TelNo">Tel. No</label>
                <input type="text" id="TelNo" name="TelNo" value="+94771234567">
            </div>

            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" value="kamalperera@gmail.com">
            </div>

            <div class="form-group">
                <label for="RegistrationDate">Registration Date</label>
                <input type="date" id="RegistrationDate" name="RegistrationDate" value="2022-08-15">
            </div>

            <div class="form-group">
                <label for="Email">Bithday Date</label>
                <input type="email" id="Email" name="Email" value="1998-05-20">
            </div>

            

            <div class="form-actions">
                <button type="submit" class="btn save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</div>






</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>