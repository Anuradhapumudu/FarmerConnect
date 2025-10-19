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
                    <?php if (!empty($data['errors']['Address'])): ?>
                        <small class="error" style="color: #d93025;"><?php echo htmlspecialchars($data['errors']['Address']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="TelNo">Tel. No</label>
                    <input type="text" id="TelNo" name="TelNo" 
                        value="<?php echo htmlspecialchars($data['farmer']->TelNo ?? '', ENT_QUOTES); ?>"
                        placeholder="0711234567 or +94711234567">
                    <?php if (!empty($data['errors']['TelNo'])): ?>
                        <small class="error" style="color: #d93025;"><?php echo htmlspecialchars($data['errors']['TelNo']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="Birthday">Birthday</label>
                    <input type="date" id="Birthday" name="Birthday" 
                        value="<?php echo htmlspecialchars($data['farmer']->Birthday ?? '', ENT_QUOTES); ?>">
                    <?php if (!empty($data['errors']['Birthday'])): ?>
                        <small class="error" style="color: #d93025;"><?php echo htmlspecialchars($data['errors']['Birthday']); ?></small>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="Gender">Gender</label>
                    <select id="Gender" name="Gender">
                        <option value="" disabled selected>-- Select Gender --</option>
                        <option value="Male" <?php echo (isset($data['farmer']->Gender) && $data['farmer']->Gender=='Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo (isset($data['farmer']->Gender) && $data['farmer']->Gender=='Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                    <?php if (!empty($data['errors']['Gender'])): ?>
                        <small class="error" style="color: #d93025;"><?php echo htmlspecialchars($data['errors']['Gender']); ?></small>
                    <?php endif; ?>
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
                <option value="">.. Select PLR ..</option>
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
                    <input type="text" id="PLR" name="PLR" value="<?php echo $_POST['PLR'] ?? ''; ?>">
                    <?php if(!empty($data['errors']['PLR'])): ?>
                        <small class="error" style="color:#d93025;"><?php echo $data['errors']['PLR']; ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="Paddy_Seed_Variety">Paddy Seed Variety</label>
                      <select id="Paddy_Seed_Variety" name="Paddy_Seed_Variety" required>
                            <option value="" disabled selected>-- Select Seed Variety --</option>
                            <option value="B-352">B-352</option>
                            <option value="BW-367">BW-367</option>
                            <option value="BW-375">BW-375</option>
                            <option value="BG-300">BG-300</option>
                      </select>
                </div>

                <div class="form-group">
                    <label for="Paddy_Size">Paddy Size (in acres)</label>
                    <input type="text" id="Paddy_Size" name="Paddy_Size" value="" required>
                </div>

                <div class="form-group">
                <label for="Province">Province</label>
                <select id="Province" name="Province" required onchange="updateDistricts()">
                    <option value="" disabled selected>-- Select Province --</option>
                    <option value="Central">Central Province</option>
                    <option value="Eastern">Eastern Province</option>
                    <option value="North Central">North Central Province</option>
                    <option value="Northern">Northern Province</option>
                    <option value="North Western">North Western Province</option>
                    <option value="Sabaragamuwa">Sabaragamuwa Province</option>
                    <option value="Southern">Southern Province</option>
                    <option value="Uva">Uva Province</option>
                    <option value="Western">Western Province</option>
                </select>
                </div>

                <div class="form-group">
                <label for="District">District</label>
                <select id="District" name="District" required>
                    <option value="" disabled selected>-- Select District --</option>
                </select>
                </div>

                <div class="form-group">
                    <label for="Govi_Jana_Sewa_Division">Govi Jana Sewa Division</label>
                    <select id="Govi_Jana_Sewa_Division" name="Govi_Jana_Sewa_Division" required>
                        <option value="" disabled selected>-- Select Govi Jana Sewa Division --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Grama_Niladhari_Division">Grama Niladhari Division</label>
                    <input type="text" id="Grama_Niladhari_Division" name="Grama_Niladhari_Division" value="" required>
                </div>

                <div class="form-group">
                    <label for="Yaya">Yaya Number</label>
                    <input type="text" id="Yaya" name="Yaya" value="" required>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn delete-btn" onclick="deletePaddy()">Delete</button>
                    <button type="submit" class="btn save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>

document.getElementById('farmerForm').addEventListener('submit', function(e) {
    const tel = document.getElementById('TelNo').value.trim();
    const birthday = document.getElementById('Birthday').value;
    const pattern = /^(?:\+94|0)(7\d{8}|1\d{8})$/;

    // Validate telephone
    if (!pattern.test(tel)) {
        e.preventDefault();
        alert('Please enter a valid telephone number (e.g. 0711234567 or +94711234567).');
        document.getElementById('TelNo').focus();
        return;
    }

    // Validate birthday
    if (!birthday) {
        e.preventDefault();
        alert('Please select a birthday.');
        document.getElementById('Birthday').focus();
        return;
    }

    const birthDate = new Date(birthday);
    const today = new Date();

    if (birthDate > today) {
        e.preventDefault();
        alert('Birthday cannot be in the future.');
        document.getElementById('Birthday').focus();
        return;
    }

    // Validate address
    const address = document.getElementById('Address').value.trim();
    if (!address) {
        e.preventDefault();
        alert('Please enter the address.');
        document.getElementById('Address').focus();
        return;
    }

    // Validate gender
    const gender = document.getElementById('Gender').value;
    if (!gender) {
        e.preventDefault();
        alert('Please select the gender.');
        document.getElementById('Gender').focus();
        return;
    }
});

 //validate Paddy form

 //validate PLR

    document.getElementById('paddyForm').addEventListener('submit', function(e) {
        const plr = document.getElementById('PLR').value.trim();
        const plrPattern = /^\d{2}\/\d{2}\/\d{5}\/\d{3}\/[A-Za-z]\/\d{4}$/;

        if (!plr) {
            e.preventDefault();
            alert('Please enter a PLR number.');
            document.getElementById('PLR').focus();
            return;
        }

        if (!plrPattern.test(plr)) {
            e.preventDefault();
            alert('Invalid PLR format. Use format: 02/25/00083/001/P/0066');
            document.getElementById('PLR').focus();
            return;
        }

        // ✅ Validate Paddy Size (Option 3)
        const size = document.getElementById('Paddy_Size').value.trim();
        if (!size || isNaN(size) || size <= 0) {
            e.preventDefault();
            alert('Paddy size must be a number greater than 0.');
            document.getElementById('Paddy_Size').focus();
            return;
        }
    });



// Load paddy details when PLR is selected
function loadPaddy(plr) {
  if (plr === '') return;

  fetch('<?php echo URLROOT; ?>/farmerprofile/getPaddy?plr=' + encodeURIComponent(plr))
    .then(response => response.json())
    .then(data => {
      // Fill basic fields
      document.getElementById('PLR').value = data.PLR;
      document.getElementById('Paddy_Seed_Variety').value = data.Paddy_Seed_Variety;
      document.getElementById('Paddy_Size').value = data.Paddy_Size;
      document.getElementById('Province').value = data.Province;

      // First, update districts (this is sync)
      updateDistricts(data.District);

      // 🔹 Now fetch centers for that district and set the selected one
      const divisionSelect = document.getElementById('Govi_Jana_Sewa_Division');
      divisionSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

      fetch('<?php echo URLROOT; ?>/farmerprofile/getCenters?district=' + encodeURIComponent(data.District))
        .then(response => response.json())
        .then(centers => {
          divisionSelect.innerHTML = '<option value="" disabled selected>-- Select Govi Jana Sewa Division --</option>';

          centers.forEach(center => {
            const option = document.createElement('option');
            option.value = center.center_name;
            option.textContent = center.center_name;

            // ✅ Set selected value correctly
            if (center.center_name === data.Govi_Jana_Sewa_Division) {
              option.selected = true;
            }

            divisionSelect.appendChild(option);
          });
        });

      // Continue with remaining fields
      document.getElementById('Grama_Niladhari_Division').value = data.Grama_Niladhari_Division;
      document.getElementById('Yaya').value = data.Yaya;
    });
}

// Clear form for new paddy entry

function newPaddyForm() {
    document.getElementById('paddyForm').reset();
    document.getElementById('PLR').value = '';
}

function updateDistricts(selectedDistrict = '') {
  const province = document.getElementById('Province').value;
  const districtSelect = document.getElementById('District');
  districtSelect.innerHTML = '<option value="" disabled selected>-- Select District --</option>';

  const districts = {
    "Central": ["Kandy", "Matale", "Nuwara Eliya"],
    "Eastern": ["Ampara", "Batticaloa", "Trincomalee"],
    "North Central": ["Anuradhapura", "Polonnaruwa"],
    "Northern": ["Jaffna", "Kilinochchi", "Mannar", "Mullaitivu", "Vavuniya"],
    "North Western": ["Kurunegala", "Puttalam"],
    "Sabaragamuwa": ["Kegalle", "Ratnapura"],
    "Southern": ["Galle", "Matara", "Hambantota"],
    "Uva": ["Badulla", "Monaragala"],
    "Western": ["Colombo", "Gampaha", "Kalutara"]
  };

  if (districts[province]) {
    districts[province].forEach(district => {
      const option = document.createElement('option');
      option.value = district;
      option.textContent = district;

      // ✅ Preselect the district if matches saved value
      if (district === selectedDistrict) option.selected = true;

      districtSelect.appendChild(option);
    });
  }
}

// 🔹 Fetch Agrarian (Govi Jana Sewa) centers when district changes
document.getElementById('District').addEventListener('change', function() {
    const district = this.value;
    const divisionSelect = document.getElementById('Govi_Jana_Sewa_Division');
    divisionSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

    fetch('<?php echo URLROOT; ?>/farmerprofile/getCenters?district=' + encodeURIComponent(district))
        .then(response => response.json())
        .then(data => {
            divisionSelect.innerHTML = '<option value="" disabled selected>-- Select Govi Jana Sewa Division --</option>';

            data.forEach(center => {
                const option = document.createElement('option');
                option.value = center.center_name;
                option.textContent = center.center_name;
                divisionSelect.appendChild(option);
            });
        })
        .catch(err => {
            console.error(err);
            divisionSelect.innerHTML = '<option value="" disabled selected>Error loading data</option>';
        });
});




function deletePaddy() {
    const plr = document.getElementById('PLR').value;

    if (!plr) {
        alert('Please select a PLR to delete.');
        return;
    }

    if (!confirm(`Are you sure you want to delete PLR: ${plr}?`)) {
        return;
    }

    fetch('<?php echo URLROOT; ?>/farmerprofile/deletePaddy?plr=' + encodeURIComponent(plr))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Paddy row deleted successfully.');
                newPaddyForm(); // Clear the form
                location.reload(); // Refresh to update PLR dropdown
            } else {
                alert('Failed to delete Paddy row.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error occurred while deleting.');
        });
}

</script>

<?php require_once APPROOT . '/views/inc/components/sidebarlink.php'; ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>