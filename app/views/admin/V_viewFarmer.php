<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/viewfarmer.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="container">
    <!-- Header -->
    <div class="admin-header">
      <div>
        <h1>Farmer Details</h1>
        <p>Complete information about the farmer and their paddy cultivation</p>
      </div>
      <button class="back-btn" onclick="goBack()">
        <i class="fas fa-arrow-left"></i> Back to Farmers
      </button>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
      <!-- Farmer Profile Section -->
      <div class="profile-card">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" 
             alt="Farmer Photo" class="profile-img">
        <h2 class="farmer-name">Kamal Perera</h2>
        <p class="farmer-nic">NIC: 992334567V</p>
        <span class="status-badge status-active">Active</span>
        
        <div class="profile-details">
          <div class="detail-item">
            <span class="detail-label">Phone:</span>
            <span class="detail-value">+94 77 123 4567</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Email:</span>
            <span class="detail-value">kamal.perera@example.com</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Address:</span>
            <span class="detail-value">123/A, Galle Road, Colombo</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Registered:</span>
            <span class="detail-value">15 Jan 2022</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Last Updated:</span>
            <span class="detail-value">20 Aug 2023</span>
          </div>
        </div>
      </div>

      <!-- Paddy Details Section -->
      <div class="paddy-details">
        <h2 class="section-title">Paddy Cultivation Details</h2>
        
        <div class="paddy-cards">
          <!-- Paddy Field 1 -->
          <div class="paddy-card">
            <h3>Field 01 - Samba Season</h3>
            <div class="paddy-detail-item">
              <span class="detail-label">Field Location:</span>
              <span class="detail-value">Colombo North</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Area (Acres):</span>
              <span class="detail-value">2.5</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Paddy Variety:</span>
              <span class="detail-value">BG 358</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Sowing Date:</span>
              <span class="detail-value">15 May 2023</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Expected Harvest:</span>
              <span class="detail-value">15 Sep 2023</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Status:</span>
              <span class="detail-value">Growing</span>
            </div>
          </div>
          
          <!-- Paddy Field 2 -->
          <div class="paddy-card">
            <h3>Field 02 - Maha Season</h3>
            <div class="paddy-detail-item">
              <span class="detail-label">Field Location:</span>
              <span class="detail-value">Colombo South</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Area (Acres):</span>
              <span class="detail-value">1.8</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Paddy Variety:</span>
              <span class="detail-value">BG 300</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Sowing Date:</span>
              <span class="detail-value">10 Oct 2022</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Harvested Date:</span>
              <span class="detail-value">20 Feb 2023</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Yield (kg):</span>
              <span class="detail-value">2200</span>
            </div>
            <div class="paddy-detail-item">
              <span class="detail-label">Status:</span>
              <span class="detail-value">Harvested</span>
            </div>
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
          <button class="action-btn edit-btn">
            <i class="fas fa-edit"></i> Edit Farmer
          </button>
          <button class="action-btn delete-btn">
            <i class="fas fa-trash"></i> Delete Farmer
          </button>
        </div>
      </div>
    </div>
  </div>

</main>

  <script>
    function goBack() {
      // In a real application, this would redirect to the farmers list page
      alert("Redirecting back to farmers list page...");
      // window.location.href = 'farmers-list.html';
    }
    
    // In a real application, you would fetch farmer data based on ID from URL parameters
    // For demonstration, we're using static data
    
    // Simulate loading data
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Farmer details page loaded');
      // You would typically fetch data from an API here
    });
  </script>

<?php require APPROOT . '/views/inc/footer.php'; ?>