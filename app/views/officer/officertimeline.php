<?php require APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/officertimeline.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

 <div class="containers">
    <div class="officer-header">
      <h1>Farmer List</h1>
      <p>View farmers profile details or timeline of their paddy fields. </p>
    </div>

    <!-- Stats cards -->
    <div class="stats">
      <div class="card"><h2 id="totalCount">234</h2><p>Total Farmers</p></div>
      <div class="card"><h2 id="activeCount">223</h2><p>Active</p></div>
      <div class="card"><h2 id="inactiveCount">11</h2><p>Inactive</p></div>
    </div>  

    <!-- Search + Filter -->
    <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search farmers by PLR number or NIC ...">
      </div>
      <select class="filter-select">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>

    <!-- Farmers Table -->
    <div class="farmer-table-wrapper">
      <div class="farmer-table-header">All Farmers</div>
      <table>
        <thead>
          <tr>
            <th>PLR Number</th>
            <th>NIC</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
          <tbody id="farmerTable">
          <?php if (!empty($data['farmers'])): ?>
              <?php foreach ($data['farmers'] as $farmer): ?>
              <tr>
                  <td><?php echo $farmer->PLR; ?></td>
                  <td><?php echo $farmer->NIC_FK; ?></td>
                  <td><?php echo $farmer->full_name; ?></td>
                  <td><span class="status-badge status-active">Active</span></td>
                  <td>

                  <form action="<?php echo URLROOT; ?>/officer/OfficerTimeline/show" method="POST">
                      <input type="hidden" name="plr" value="<?php echo $farmer->PLR; ?>">
                      <button type="submit" class="action-btn view-btn">
                          View Timeline
                      </button>
                  </form>

                  <form action="<?php echo URLROOT; ?>/officer/FarmerProfile/show" method="POST">
                    <input type="hidden" name="nic" value="<?php echo $farmer->NIC_FK; ?>">
                    <button type="submit" class="action-btn edit-btn">
                        Profile Details
                    </button>
                 </form>

                  </td>
              </tr>
              <?php endforeach; ?>
          <?php else: ?>
              <tr>
                  <td colspan="5">No Farmers Found</td>
              </tr>
          <?php endif; ?>
          </tbody>
      </table>
            <!-- ✅ Mobile View -->
      <div class="farmer-cards">

      <?php if (!empty($data['farmers'])): ?>
          <?php foreach ($data['farmers'] as $farmer): ?>
          
          <div class="farmer-card">
              <div class="farmer-card-header">
                  <h4><?php echo $farmer->PLR; ?></h4>
                  <span class="status-badge status-active">Active</span>
              </div>

              <div class="farmer-card-body">
                  <p><strong>NIC:</strong> <?php echo $farmer->NIC_FK; ?></p>
                  <p><strong>Name:</strong> 
                      <?php echo $farmer->full_name; ?>
                  </p>
              </div>

              <div class="farmer-card-actions">

<form action="<?php echo URLROOT; ?>/officer/OfficerTimeline/show" method="POST">
    <input type="hidden" name="plr" value="<?php echo $farmer->PLR; ?>">
    <button type="submit" class="action-btn view-btn">
        View Timeline
    </button>
</form>


                  <button class="action-btn edit-btn">
                      <i class="fas fa-id-card"></i> Profile
                  </button>
              </div>
          </div>

          <?php endforeach; ?>
      <?php else: ?>

    <p style="text-align:center;">No Farmers Found</p>

<?php endif; ?>

</div>

        <!-- You can repeat for the rest of the farmers -->
      </div>

    </div>

  </div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>
