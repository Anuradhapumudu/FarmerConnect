<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerProfile.css?v=<?= time(); ?>">


<main>

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

    <!-- FARMER DETAILS -->
    <div class="page-title">
        <h2>Farmer Details</h2>
    </div>
    <div class="profile-card">
        <div class="profile-info">
            <form id="farmerForm" action="<?php echo URLROOT; ?>/farmerprofile/update" method="POST">
                <div class="form-group">
                    <label for="NIC">NIC</label>
                    <input type="text" id="NIC" name="NIC" value="<?php echo $data['farmer']->NIC ?? ''; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input type="text" id="Name" name="Name" value="<?php echo $data['farmer']->Name ?? ''; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="Address">Address</label>
                    <input type="text" id="Address" name="Address" value="<?php echo $data['farmer']->Address ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="TelNo">Tel. No</label>
                    <input type="text" id="TelNo" name="TelNo" value="<?php echo $data['farmer']->TelNo ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="Birthday">Birthday</label>
                    <input type="date" id="Birthday" name="Birthday" value="<?php echo $data['farmer']->Birthday ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="Gender">Gender</label>
                    <select id="Gender" name="Gender">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" <?php echo (isset($data['farmer']->Gender) && $data['farmer']->Gender=='Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo (isset($data['farmer']->Gender) && $data['farmer']->Gender=='Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>


<!-- PADDY DETAILS -->
    <div class="page-title">
        <h2>Paddy Details</h2>
    </div>

    <div class="plr-selector">
        <div>
            <label for="plrSelect">Select Existing PLR:</label>
        </div>
        <div>
            <select id="plrSelect" onchange="loadPaddy(this.value)">
                <option value="">-- Select PLR --</option>
                <?php if(!empty($data['paddyFields'])): ?>
                    <?php foreach($data['paddyFields'] as $paddy): ?>
                        <option value="<?php echo $paddy->PLR; ?>"><?php echo $paddy->PLR; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <button type="button" class="btn add-btn" onclick="newPaddyForm()">+ Add New</button>
        </div>
    </div>

    <div class="profile-card">
        <div class="profile-info">
            <form id="paddyForm" method="POST" action="<?php echo URLROOT; ?>/farmerprofile/savePaddy">
                <input type="hidden" name="NIC" value="<?php echo $data['farmer']->NIC ?? ''; ?>">
                <div class="form-group">
                    <label for="PLR">PLR Number</label>
                    <input type="text" id="PLR" name="PLR" value="">
                </div>
                <div class="form-group">
                    <label for="Paddy_Seed_Variety">Paddy Seed Variety</label>
                    <input type="text" id="Paddy_Seed_Variety" name="Paddy_Seed_Variety" value="">
                </div>
                <div class="form-group">
                    <label for="Paddy_Size">Paddy Size (in acres)</label>
                    <input type="text" id="Paddy_Size" name="Paddy_Size" value="">
                </div>
                <div class="form-group">
                    <label for="Province">Province</label>
                    <input type="text" id="Province" name="Province" value="">
                </div>
                <div class="form-group">
                    <label for="District">District</label>
                    <input type="text" id="District" name="District" value="">
                </div>
                <div class="form-group">
                    <label for="Govi_Jana_Sewa_Division">Govi Jana Sewa Division</label>
                    <input type="text" id="Govi_Jana_Sewa_Division" name="Govi_Jana_Sewa_Division" value="">
                </div>
                <div class="form-group">
                    <label for="Grama_Niladhari_Division">Grama Niladhari Division</label>
                    <input type="text" id="Grama_Niladhari_Division" name="Grama_Niladhari_Division" value="">
                </div>
                <div class="form-group">
                    <label for="Yaya">Yaya Number</label>
                    <input type="text" id="Yaya" name="Yaya" value="">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
// Load paddy details when PLR is selected
function loadPaddy(plr) {
    if(plr === '') return;

    fetch('<?php echo URLROOT; ?>/farmerprofile/getPaddy/' + plr)
        .then(response => response.json())
        .then(data => {
            document.getElementById('PLR').value = data.PLR;
            document.getElementById('Paddy_Seed_Variety').value = data.Paddy_Seed_Variety;
            document.getElementById('Paddy_Size').value = data.Paddy_Size;
            document.getElementById('Province').value = data.Province;
            document.getElementById('District').value = data.District;
            document.getElementById('Govi_Jana_Sewa_Division').value = data.Govi_Jana_Sewa_Division;
            document.getElementById('Grama_Niladhari_Division').value = data.Grama_Niladhari_Division;
            document.getElementById('Yaya').value = data.Yaya;
        });
}

// Clear form for new paddy entry
function newPaddyForm() {
    document.getElementById('paddyForm').reset();
    document.getElementById('PLR').value = '';
}
</script>

<?php require_once APPROOT . '/views/inc/components/sidebarlink.php'; ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>