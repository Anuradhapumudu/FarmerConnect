<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/editfarmer.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="container">
    <!-- Header -->
    <div class="admin-header">
      <div>
        <h1>Edit Farmer Details</h1>
        <p>Update farmer information and paddy cultivation details</p>
      </div>
      <div class="header-actions">
        <button class="action-btn back-btn" onclick="goBack()">
          <i class="fas fa-arrow-left"></i> Back
        </button>
        <button class="action-btn save-btn" onclick="saveFarmer()">
          <i class="fas fa-save"></i> Save Changes
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
      <!-- Farmer Profile Section -->
      <div class="profile-card">
        <div class="profile-img-container">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80" 
               alt="Farmer Photo" class="profile-img" id="profileImage">
          <button class="change-img-btn" onclick="changeImage()">
            <i class="fas fa-camera"></i>
          </button>
        </div>
        
        <div class="profile-details">
          <div class="form-group">
            <label for="farmerName">Full Name</label>
            <input type="text" id="farmerName" class="form-control" value="Kamal Perera">
          </div>
          
          <div class="form-group">
            <label for="farmerNIC">NIC Number</label>
            <input type="text" id="farmerNIC" class="form-control" value="992334567V">
          </div>
          
          <div class="form-group">
            <label for="farmerPhone">Phone Number</label>
            <input type="tel" id="farmerPhone" class="form-control" value="+94 77 123 4567">
          </div>
          
          <div class="form-group">
            <label for="farmerEmail">Email Address</label>
            <input type="email" id="farmerEmail" class="form-control" value="kamal.perera@example.com">
          </div>
          
          <div class="form-group">
            <label for="farmerAddress">Address</label>
            <textarea id="farmerAddress" class="form-control" rows="3">123/A, Galle Road, Colombo</textarea>
          </div>
          
          <div class="form-group">
            <label for="farmerStatus">Status</label>
            <select id="farmerStatus" class="form-control">
              <option value="active" selected>Active</option>
              <option value="inactive">Inactive</option>
              <option value="pending">Pending</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Paddy Details Section -->
      <div class="paddy-details">
        <div class="section-title">
          <h2>Paddy Cultivation Details</h2>
          <button class="add-field-btn" onclick="addPaddyField()">
            <i class="fas fa-plus"></i> Add Field
          </button>
        </div>
        
        <div class="paddy-cards" id="paddyFieldsContainer">
          <!-- Paddy Field 1 -->
          <div class="paddy-card">
            <button class="remove-field-btn" onclick="removeField(this)">
              <i class="fas fa-times"></i>
            </button>
            <h3>Field 01 - Samba Season</h3>
            
            <div class="form-group">
              <label>Field Location</label>
              <input type="text" class="form-control" value="Colombo North">
            </div>
            
            <div class="form-group">
              <label>Area (Acres)</label>
              <input type="number" class="form-control" value="2.5" step="0.1">
            </div>
            
            <div class="form-group">
              <label>Paddy Variety</label>
              <select class="form-control">
                <option>BG 358</option>
                <option>BG 300</option>
                <option>BG 352</option>
                <option>LD 365</option>
                <option>Other</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Sowing Date</label>
              <input type="date" class="form-control" value="2023-05-15">
            </div>
            
            <div class="form-group">
              <label>Expected Harvest Date</label>
              <input type="date" class="form-control" value="2023-09-15">
            </div>
            
            <div class="form-group">
              <label>Status</label>
              <select class="form-control">
                <option>Planned</option>
                <option selected>Growing</option>
                <option>Harvested</option>
                <option>Abandoned</option>
              </select>
            </div>
          </div>
          
          <!-- Paddy Field 2 -->
          <div class="paddy-card">
            <button class="remove-field-btn" onclick="removeField(this)">
              <i class="fas fa-times"></i>
            </button>
            <h3>Field 02 - Maha Season</h3>
            
            <div class="form-group">
              <label>Field Location</label>
              <input type="text" class="form-control" value="Colombo South">
            </div>
            
            <div class="form-group">
              <label>Area (Acres)</label>
              <input type="number" class="form-control" value="1.8" step="0.1">
            </div>
            
            <div class="form-group">
              <label>Paddy Variety</label>
              <select class="form-control">
                <option>BG 358</option>
                <option selected>BG 300</option>
                <option>BG 352</option>
                <option>LD 365</option>
                <option>Other</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Sowing Date</label>
              <input type="date" class="form-control" value="2022-10-10">
            </div>
            
            <div class="form-group">
              <label>Harvested Date</label>
              <input type="date" class="form-control" value="2023-02-20">
            </div>
            
            <div class="form-group">
              <label>Yield (kg)</label>
              <input type="number" class="form-control" value="2200">
            </div>
            
            <div class="form-group">
              <label>Status</label>
              <select class="form-control">
                <option>Planned</option>
                <option>Growing</option>
                <option selected>Harvested</option>
                <option>Abandoned</option>
              </select>
            </div>
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
          <button class="action-btn delete-btn" onclick="showDeleteModal()">
            <i class="fas fa-trash"></i> Delete Farmer
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete confirmation modal -->
  <div class="modal" id="deleteModal">
    <div class="modal-content">
      <h3>Confirm Delete</h3>
      <p>Are you sure you want to delete this farmer? This action cannot be undone.</p>
      <div class="modal-actions">
        <button class="cancel-btn" onclick="hideDeleteModal()">Cancel</button>
        <button class="confirm-btn" onclick="deleteFarmer()">Yes, Delete</button>
      </div>
    </div>
  </div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>