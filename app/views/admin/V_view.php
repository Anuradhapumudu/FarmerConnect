<?php require APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/viewfarmer.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <!-- Header -->
    <div class="admin-header">
      <div>
        <h1>Farmer Details</h1>
      </div>
      <but
      ton class="back-btn" onclick="window.location='<?= URLROOT ?>/Admin/UserList/farmerlist'">
        <i class="fas fa-arrow-left"></i> Back to Farmers
      </button>
    </div>

    <div class="stats">
      <div class="card"><h2><?= $data['counts']->confirm ?></h2><p>confirm</p></div>
      <div class="card"><h2><?= $data['counts']->cancel ?></h2><p>cancel</p></div>
      
    </div>

        <div class="search-box">
      <div style="position: relative; flex: 1;">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Search farmers by order id and PLR.">
      </div>
      <select id="statusFilter" class="filter-select">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      
      </select>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
      <!-- Farmer Profile Section -->
       <div class="profile-card">
              <img src="<?php 
            // Get the officer's image URL from the database
            $img = $data['farmer']->profile_image ?? '';

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

        alt="Officer Photo" 
        class="profile-img">
        <h2 class="farmer-name"><?= $data['farmer']->full_name ?></h2>
        <p class="farmer-nic">NIC: <?= $data['farmer']->nic ?></p>
        <span class="status-badge status-active"><?= $data['farmer']->status ?></span>
        
        <div class="profile-details">
          <div class="detail-item">
            <span class="detail-label">Phone:</span>
            <span class="detail-value"><?= $data['farmer']->phone_no ?></span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Address:</span>
            <span class="detail-value"><?= $data['farmer']->address ?></span>
          </div>
        <div class="detail-item">
        <span class="detail-label">Account Created:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['farmer']->created_at)) ?></span>
        </div>
        <!-- <div class="detail-item">
        <span class="detail-label">Last Updated:</span>
        <span class="detail-value"><?= date('d M Y, h:i A', strtotime($data['farmer']->updated_at)) ?></span>
       </div>  -->
        </div>
      
<?php if(!empty($data['orderDetails'])):?>
     
    <?php foreach ($data['orderDetails'] as $order): ?>
<div class="order-card" data-order="<?php echo strtolower(htmlspecialchars($order->order_id));?>" >
        <p>Order id:</p>
            <span class="detail-value"><?= htmlspecialchars($order->order_id) ?></span>
</div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No order details available.</p>
<?php endif; ?>
    
      <!-- Paddy Details Section -->
      <div class="paddy-details">
        <h2 class="section-title">Paddy Cultivation Details</h2>

        <!-- we use this because farmer can have lot of paddy fields -->
<div class="paddy-cards">

<?php if (!empty($data['paddyDetails'])): ?>
    <?php foreach ($data['paddyDetails'] as $paddy): ?>
        <div class="paddy-card"
            data-plr="<?php echo strtolower(htmlspecialchars($paddy->PLR));?>">
            <h3>PLR : <?= htmlspecialchars($paddy->PLR) ?></h3>

            <div class="paddy-detail-item">
                <span class="detail-label">Province:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Province) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">District:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->District) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Govi Jana Sewa Division:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Govi_Jana_Sewa_Division) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Grama Niladhari Division:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Grama_Niladhari_Division) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Yaya:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Yaya) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Paddy Size:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Paddy_Size) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Paddy Variety:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->Paddy_Seed_Variety) ?></span>
            </div>

            <div class="paddy-detail-item">
                <span class="detail-label">Created Date:</span>
                <span class="detail-value"><?= htmlspecialchars($paddy->CreatedDate) ?></span>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No paddy details available.</p>
<?php endif; ?>

</div>

        

    </div>

            <!-- Action Buttons -->
        <div class="action-buttons">
        <?php 
        $status = strtolower(trim($data['farmer']->status));
        ?>

        <?php if($status === 'active'): ?>
          <form action="<?= URLROOT ?>/Admin/UserList/inactivefarmer/<?= $data['farmer']->nic ?>" method="POST">
            <button type="submit" class="action-btn delete-btn">
            <i class="fas fa-times"></i> Inactive Farmer
        </button>
        </form>

        <?php elseif($status === 'inactive'): ?>
          <form action="<?= URLROOT ?>/Admin/UserList/activefarmer/<?= $data['farmer']->nic ?>" method="POST">
            <button type="submit" class="action-btn edit-btn">
            <i class="fas fa-check"></i> Active Farmer
        </button> 
        </form>                 
            <?php endif; ?>
      </div>

  </div>
</div>
</div>
</main>



    public function getOrdersByFarmer($id){
        $this->db->query("SELECT * FROM orders WHERE buyer_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }

    public function getOrderCount($id){
              $this->db->query("\n            SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN order_status='order_confirmed' THEN 1 ELSE 0 END) AS confirm,
                SUM(CASE WHEN order_status='order_cancelled' THEN 1 ELSE 0 END) AS cancel
            FROM orders  where buyer_id = :id
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

            public function showfarmer($id = null) {
            Auth::checkAdmin();
            // If no ID is provided, redirect back to the farmer list
        if (!$id) {
            header('Location: ' . URLROOT . '/Admin/UserList/farmerlist');
            exit;
        }


        $farmer = $this->adminModel->getFarmerById($id);
        // If the ID is invalid or the farmer was deleted, redirect back
        if (!$farmer) {
            header('Location: ' . URLROOT . '/Admin/UserList/farmerlist');
            exit;
        }

        $paddyDetails = $this->adminModel->getPaddyDetailsById($id);

        $orderDetails = $this->adminModel->getOrdersByFarmer($id);
        $counts = $this->adminModel->getOrderCount($id);
         $this->view('admin/V_sample', [
        'farmer' => $farmer,
        'paddyDetails' => $paddyDetails,
        'orderDetails'=>$orderDetails,
        'counts' =>$counts
    ]);
    }

ALTER TABLE farmers
ADD email VARCHAR(100);             
  ALTER TABLE farmers
ADD status VARCHAR(20) DEFAULT 'active';
ALTER TABLE orders
ADD status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending';
                <div class="order-actions">
              
                <a href="<?= URLROOT ?>/Marketplace/deleteOrder/<?= $order->order_id ?>" class="btn btn-primary"  onclick="return confirm('Product Deleted');">
                    <i class="fas fa-map-marked-alt"></i> delete order
                </a>
              
            </div>


              elseif(($data['category']) !== "Fertilizer") {
            $data['errors']['category'] = "Please select a only fertilizer.";
        }

                                 <!--    <div style="margin-top: 15px;">
                                <textarea name="review" placeholder="Optional: Write a review..." 
                                          style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; resize: vertical; min-height: 80px;"></textarea>
                            </div> -->
<script src="<?php echo URLROOT; ?>/js/admin/sample.js?v=<?= time(); ?>"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>