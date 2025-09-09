<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">


<main>
<!-- FARMER DETAILS -->
<div class="page-title">
    <h2>Farmer Details</h2>
</div>
<div class="profile-card">
    <div class="profile-info">
        <form id="farmerForm">
            <div class="form-group">
                <label for="NIC">NIC</label>
                <input type="text" id="NIC" name="NIC" placeholder="Enter NIC number">
            </div>
            <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" id="Name" name="Name" placeholder="Enter full name">
            </div>
            <div class="form-group">
                <label for="Address">Address</label>
                <input type="text" id="Address" name="Address" placeholder="Enter address">
            </div>
            <div class="form-group">
                <label for="TelNo">Tel. No</label>
                <input type="text" id="TelNo" name="TelNo" placeholder="Enter telephone number">
            </div>
            <div class="form-group">
                <label for="Birthday">Birthday</label>
                <input type="date" id="Birthday" name="Birthday">
            </div>
            <div class="form-group">
                <label for="Gender">Gender</label>
                <select id="Gender" name="Gender">
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-actions">
                <button class="btn edit-btn">Edit</button>
                <button type="submit" class="btn save-btn">Save Changes</button>
            </div>
        </form>
    </div>
    <div class="profile-pic">
         <div class="pic-wrapper">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Default User Icon" id="profileImage">

        <div class="buttons">
            <!-- Hidden file input for upload -->
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
</div>

<!-- PADDY DETAILS -->
<div class="page-title">
    <h2>Paddy Details</h2>
</div>

<div class="plr-selector">
  <dev> 
    <label for="plrSelect">Select Existing PLR:</label>
  </dev>

  <dev>
  <select id="plrSelect" onchange="loadPaddyDetails(this.value)">
    <option value=""> Select PLR Number&nbsp;&nbsp;&nbsp; </option>
    <?php foreach ($paddyFields as $field): ?>
      <option value="<?php echo $field->PLR; ?>"><?php echo $field->PLR; ?></option>
    <?php endforeach; ?>
  </select>
  </dev>

  <dev>
  <button type="button" class="btn add-btn" onclick="addNewPaddyForm()">+ Add New</button>
  </dev>
</div>

<!-- Dynamic form container -->
<div id="paddyFormContainer">
  <!-- JS will fill this based on PLR selected or for new entries -->
</div>

<div class="profile-card">
    <div class="profile-info">
        <form id="paddyForm">
            <div class="form-group">
                <label for="PLR">PLR Number</label>
                <input type="text" id="PLR" name="PLR" placeholder="Enter PLR number">
            </div>
            <div class="form-group">
                <label for="NIC_FK">Farmer NIC</label>
                <input type="text" id="NIC_FK" name="NIC" placeholder="Enter Farmer NIC">
            </div>
            <div class="form-group">
                <label for="Paddy_Seed_Variety">Paddy Seed Variety</label>
                <input type="text" id="Paddy_Seed_Variety" name="Paddy_Seed_Variety" placeholder="Enter seed variety">
            </div>
            <div class="form-group">
                <label for="Paddy_Size">Paddy Size (in acres)</label>
                <input type="text" id="Paddy_Size" name="Paddy_Size" placeholder="Enter paddy area size">
            </div>
            <div class="form-group">
                <label for="Province">Province</label>
                <input type="text" id="Province" name="Province" placeholder="Enter province">
            </div>
            <div class="form-group">
                <label for="District">District</label>
                <input type="text" id="District" name="District" placeholder="Enter district">
            </div>
            <div class="form-group">
                <label for="Govi_Jana_Sewa_Division">Govi Jana Sewa Division</label>
                <input type="text" id="Govi_Jana_Sewa_Division" name="Govi_Jana_Sewa_Division" placeholder="Enter division">
            </div>
            <div class="form-group">
                <label for="Grama_Niladhari_Division">Grama Niladhari Division</label>
                <input type="text" id="Grama_Niladhari_Division" name="Grama_Niladhari_Division" placeholder="Enter GN division">
            </div>
            <div class="form-group">
                <label for="Yaya">Yaya Number</label>
                <input type="text" id="Yaya" name="Yaya" placeholder="Enter yaya group/number">
            </div>
            <div class="form-actions">
                <button class="btn edit-btn">Edit</button>
                <button type="submit" class="btn save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</div>
</main>

<?php require_once APPROOT . '/views/inc/components/sidebarlink.php'; ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>