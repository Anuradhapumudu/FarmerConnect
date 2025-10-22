  <?php require_once APPROOT . '/views/inc/adminheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">


<main>


<!-- PROFILE PICTURE -->


<div class="profile-pic">
    <div class="pic-wrapper">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Default User Icon" id="profileImage">

        <div class="buttons">
            <input type="file" id="uploadInput" accept="image/*" style="display:none;">
            <button type="button" class="btn upload-btn" onclick="document.getElementById('uploadInput').click();">Upload Photo</button>
            <button type="button" class="btn remove-btn" onclick="removeProfilePic()">Remove Photo</button>
        </div>
    </div>
</div>

<!-- SELLER DETAILS -->
<div class="page-title">
    <h2>Admin Details</h2>
</div>
<div class="profile-card">
    <div class="profile-info">
        <form id="sellerForm" method="POST" onsubmit="event.preventDefault(); alert('This is dummy data!');"></form>      
        
        
        
        <div class="form-group">
            <label for="AdminID">Admin ID</label>
            <input type="text" id="AdminID" name="AdminID" value="ADM001" readonly>
        </div>

        <div class="form-group">
            <label for="Name">Name</label>
            <input type="text" id="Name" name="Name" value="Nimali Weerasinghe">
        </div>

        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" id="Email" name="Email" value="nimali.admin@farmerconnect.lk">
        </div>

        <div class="form-group">
            <label for="Role">Role</label>
            <input type="text" id="Role" name="Role" value="System Administrator" readonly>
        </div>

        <div class="form-group">
            <label for="ContactNo">Contact Number</label>
            <input type="text" id="ContactNo" name="ContactNo" value="+94712345678">
        </div>

        <div class="form-group">
            <label for="JoinedDate">Joined Date</label>
            <input type="date" id="JoinedDate" name="JoinedDate" value="2021-05-12">
        </div>

        <div class="form-group">
            <label for="Status">Status</label>
            <select id="Status" name="Status">
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn save-btn">Save Changes</button>
        </div>
    </form>
</div>

</div>


</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>