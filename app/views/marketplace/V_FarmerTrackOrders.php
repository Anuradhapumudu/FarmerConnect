<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/new.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   

<main class="main-content" id="mainContent">
  
  <div class="track-orders-container">
    
    <!-- Header Section -->
    <div class="header">
      <h1> My Orders</h1>
      <p>Monitor and manage all your product orders in one place</p>
    </div>
    
    <!-- Filter Section -->
    <div class="farmer-filter-container">
      <div class="filter-group">
        
        <input type="text" id="search" class="search-input" placeholder="Search by order ID, product, or customer...">
      </div>
      
      <div class="filter-group">
       
        <select id="statusFilter" class="filter-select">
          <option value="all">All Statuses</option>
          <option value="order_placed">Order Placed</option>
          <option value="order_confirmed">Confirmed</option>
          <option value="ready_to_pickup">Ready for Pickup</option>
          <option value="order_picked">Picked Up</option>
          <option value="order_cancelled">Cancelled</option>
        </select>
      </div>
      
      <button class="btn-filter" id="applyFilters">
         Apply Filters
      </button>
    </div>
    
    <!-- Orders Grid -->
    <div class="orders-grid" id="ordersGrid">
      <?php if(!empty($data['orders'])): ?>
        <?php foreach($data['orders'] as $order): 
          $orderId = strtolower($order->order_id);
          $statusClass = '';
          $statusText = '';
          $progressPercent = 0;
          
          // Normalize the status
          $normalizedStatus = strtolower(trim($order->order_status));
          
          // Determine status, progress, and class
          switch($normalizedStatus) {
              case 'order_placed': 
                $statusClass = 'status-placed'; 
                $statusText = 'Order Placed';
                $progressPercent = 25;
                break;
              case 'order_confirmed': 
                $statusClass = 'status-confirmed'; 
                $statusText = 'Order Confirmed';
                $progressPercent = 50;
                break;
              case 'ready_to_pickup': 
              case 'ready_for_pickup':
                $statusClass = 'status-ready'; 
                $statusText = 'Ready For Pickup';
                $progressPercent = 75;
                break;
              case 'order_picked': 
              case 'picked_up':
              case 'picked':
                $statusClass = 'status-picked'; 
                $statusText = 'Picked Up';
                $progressPercent = 100;
                break;
              case 'order_cancelled': 
              case 'cancelled': 
                $statusClass = 'status-cancelled'; 
                $statusText = 'Cancelled';
                $progressPercent = 0;
                break;
              default:
                  // If status contains "pick", assume it's picked up
                  if (strpos($normalizedStatus, 'pick') !== false) {
                      $statusClass = 'status-picked'; 
                      $statusText = 'Picked Up';
                      $progressPercent = 100;
                  } else {
                      $statusText = ucwords(str_replace('_', ' ', $order->order_status));
                      $statusClass = 'status-unknown';
                      $progressPercent = 25;
                  }
          }
        ?>
        
        <div class="farmer-order-card" data-order-id="<?= htmlspecialchars($order->order_id) ?>" 
             data-status="<?= $normalizedStatus ?>"
             data-date="<?= date('Y-m-d', strtotime($order->order_create_date)) ?>">
          
          <div class="order-card-header">
            <div>
              <div class="order-id">#<?= htmlspecialchars($order->order_id) ?></div>
              <div class="order-date">
                <i class="far fa-calendar"></i> 
                <?= date('M d, Y', strtotime($order->order_create_date)) ?>
              </div>
            </div>
            <div class="order-status <?= $statusClass ?>"><?= $statusText ?></div>
          </div>
          
          <div class="order-content">
            <!-- Product Information -->
            <div class="product-section">
              <div class="product-image">
                <img src="<?= URLROOT . '/uploads/' . htmlspecialchars($order->image_url) ?>" 
                     alt="<?= htmlspecialchars($order->item_name) ?>">
              </div>
              <div class="product-info">
                <h3><?= htmlspecialchars(ucfirst(strtolower($order->item_name))) ?></h3>
                <p><strong>Quantity:</strong> <?= htmlspecialchars($order->quantity) ?></p>
                <div class="product-price">
                  LKR <?= number_format($order->total_price, 2) ?>
                </div>
                <p><small><i class="fas fa-money-bill-wave"></i> 
                  <?= htmlspecialchars(ucfirst(strtolower(str_replace('_', ' ', $order->payment_method)))) ?>
                </small></p>
              </div>
            </div>
            
            <!-- Customer Information -->
            <div class="customer-info">
              <h4><i class="fas fa-user"></i> Seller Details</h4>
              <div class="customer-details">
                  <p><strong>Name:</strong> <?= htmlspecialchars($order->seller_first . ' ' . $order->seller_last) ?></p>
                  <p><strong>Location:</strong> <?= htmlspecialchars($order->seller_address) ?></p>
                  <p><strong>Contact:</strong> <?= htmlspecialchars($order->seller_telNo) ?></p>
              </div>
            </div>
            
            <!-- Progress Bar -->
            <?php if($normalizedStatus !== 'order_cancelled'): ?>
            <div class="progress-section">
              <div class="progress-header">
                <h4>Order Progress</h4>
                <span class="progress-percent"><?= $progressPercent ?>%</span>
              </div>
              <div class="progress-bar">
                <div class="progress-fill" style="width: <?= $progressPercent ?>%"></div>
              </div>
              
              <div class="progress-steps">
                <div class="progress-step <?= $progressPercent >= 25 ? 'active' : '' ?>">
                  <div class="step-dot <?= $progressPercent >= 25 ? 'completed' : '' ?>"></div>
                  <div class="step-label <?= $progressPercent >= 25 ? 'active' : '' ?>">Placed</div>
                </div>
                <div class="progress-step <?= $progressPercent >= 50 ? 'active' : '' ?>">
                  <div class="step-dot <?= $progressPercent >= 50 ? 'completed' : '' ?>"></div>
                  <div class="step-label <?= $progressPercent >= 50 ? 'active' : '' ?>">Confirmed</div>
                </div>
                <div class="progress-step <?= $progressPercent >= 75 ? 'active' : '' ?>">
                  <div class="step-dot <?= $progressPercent >= 75 ? 'completed' : '' ?>"></div>
                  <div class="step-label <?= $progressPercent >= 75 ? 'active' : '' ?>">Ready</div>
                </div>
                <div class="progress-step <?= $progressPercent >= 100 ? 'active' : '' ?>">
                  <div class="step-dot <?= $progressPercent >= 100 ? 'completed' : '' ?>"></div>
                  <div class="step-label <?= $progressPercent >= 100 ? 'active' : '' ?>">Picked Up</div>
                </div>
              </div>
            </div>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <div class="order-actions">
              
                <a href="<?= URLROOT ?>/Marketplace/viewOrderTracking/<?= $order->order_id ?>" class="btn btn-primary">
                    <i class="fas fa-map-marked-alt"></i> View Tracking Details
                </a>
              
            </div>

            <!-- Rating Section -->
            <?php if ($normalizedStatus === 'order_picked'): ?>
              <div class="rating-section">
                <?php if (empty($data['ratedOrders'][$order->order_id])): ?>
                  <form method="POST" action="<?= URLROOT ?>/Marketplace/submitRating" class="rating-form">
                    <input type="hidden" name="order_id" value="<?= $order->order_id ?>">
                    <label><strong>Rate this product:</strong></label>
                    <div class="stars">
                      <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>-<?= $orderId ?>" required>
                        <label for="star<?= $i ?>-<?= $orderId ?>">★</label>
                      <?php endfor; ?>
                    </div>
                    <button type="submit" class="btn-success">Submit Rating</button>
                  </form>
                <?php else: ?>
                  <p class="rated-text">⭐ You have already rated this order</p>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-state">
          <i class="fas fa-box-open"></i>
          <h3>No Orders Found</h3>
          <p>You haven't received any orders yet. When customers purchase your products, they will appear here.</p>
          <button class="btn-refresh" onclick="window.location.reload()">
            <i class="fas fa-redo"></i> Refresh
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<script>
document.getElementById('applyFilters').addEventListener('click', function() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    
    const orders = document.querySelectorAll('.farmer-order-card');

    orders.forEach(order => {
        const orderId = order.dataset.orderId.toLowerCase();
        const status = order.dataset.status.toLowerCase();

        // Check search match (order ID, product name)
        const productName = order.querySelector('.product-info h3').textContent.toLowerCase();
        const matchesSearch = orderId.includes(searchTerm) || productName.includes(searchTerm);

        // Check status match
        const matchesStatus = statusFilter === 'all' || status === statusFilter;

        // Show or hide order card
        if (matchesSearch && matchesStatus) {
            order.style.display = 'block';
        } else {
            order.style.display = 'none';
        }
    });
});
</script>




  