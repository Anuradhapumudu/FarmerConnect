<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/new.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<main class="main-content" id="mainContent">
  <div class="track-order-container">
    <div class="header">
      <h1>Seller Order Management</h1>
      <p>Track and update your customer orders</p>
    </div>
    
    <div class="farmer-filter-container">
      <div class="filter-group">
        <label for="search"><i class="fas fa-search"></i> Search Orders</label>
        <input type="text" id="search" class="search-input" placeholder="Search by order ID, product, or customer...">
      </div>

      <div class="filter-group">
        <label for="statusFilter"><i class="fas fa-filter"></i> Filter by Status</label>
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
        <i class="fas fa-sync-alt"></i> Apply Filters
      </button>
    </div>
    
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

                  <div class="customer-info">
                <h4><i class="fas fa-user"></i> Customer Details</h4>
              <div class="customer-details">
                    <p><strong>Name:</strong> <?= htmlspecialchars($order->buyer_full) ?></p>
                    <p><strong>Contact:</strong> <?= htmlspecialchars($order->buyer_telNo) ?></p>
                  </div>
                </div>

              <div class="change-time">
                <p>
                  Latest Update at :
                  <?= date('M d, Y - h:i A', strtotime($order->order_create_date)) ?>
                </p>
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
              
                  <button type="button" class="btn btn-secondary update-status-btn" data-order="<?= $orderId ?>" data-status="<?= $normalizedStatus ?>">
                    <i class="fas fa-edit"></i> Update
                  </button>
              
            </div>

          <div class="rating">
            <?php 
                $rating = $order->rating ?? 0; // from JOIN
                for ($i = 1; $i <= 5; $i++): 
            ?>
                <span class="<?= ($i <= $rating) ? 'star filled' : 'star'; ?>">★</span>
            <?php endfor; ?>
        </div>

            </div>
            </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No orders found.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="modal1" id="status-modal1">
    <div class="modal1-content">
      <div class="modal1-header">
        <h3 class="modal1-title">Update Order Status</h3>
        <button class="close-modal1">&times;</button>
      </div>
      <div class="status-options">
        <label class="status-option">
          <input type="radio" name="order-status" value="order_placed">
          <span>Order Placed</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="order_confirmed">
          <span>Order Confirmed</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="order_cancelled">
          <span>Order Cancelled</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="ready_to_pickup">
          <span>Ready For Pickup</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="order_picked">
          <span>Picked Up</span>
        </label>
      </div>
      <div class="modal1-actions">
        <button type="button" class="btn btn-secondary" id="cancel-update">Cancel</button>
        <button type="button" class="btn btn-primary" id="save-status">Update Status</button>
      </div>
    </div>
  </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.querySelector('.search-input');
  const orderCards = document.querySelectorAll('.farmer-order-card');
  const statusModal = document.getElementById('status-modal1');
  const closeModalBtn = document.querySelector('.close-modal1');
  const cancelUpdateBtn = document.getElementById('cancel-update');
  const saveStatusBtn = document.getElementById('save-status');
  const updateStatusButtons = document.querySelectorAll('.update-status-btn');
  const statusOptions = document.querySelectorAll('.status-option');
  const filterSelect = document.getElementById('statusFilter');
  
  let currentOrderCard = null;
  let currentOrderId = null;
  let currentStatus = null;

  // Define allowed status transitions
  const allowedTransitions = {
    'order_placed': ['order_confirmed', 'order_cancelled'],
    'order_confirmed': ['ready_to_pickup'],
    'ready_to_pickup': ['order_picked'],
    'order_picked': [], // No further changes
    'order_cancelled': [] // No further changes
  };

  // Status display texts
  const statusTexts = {
    'order_placed': 'Order Placed',
    'order_confirmed': 'Order Confirmed',
    'order_prepared': 'Order Prepared',
    'ready_to_pickup': 'Ready For Pickup',
    'order_picked': 'Picked Up',
    'order_cancelled': 'Cancelled'
  };

  // Status CSS classes
  const statusClasses = {
    'order_placed': 'status-placed',
    'order_confirmed': 'status-confirmed',
    'order_prepared': 'status-prepared',
    'ready_to_pickup': 'status-ready',
    'order_picked': 'status-picked',
    'order_cancelled': 'status-cancelled'
  };

  // Search functionality
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    orderCards.forEach(card => {
      const orderId = card.querySelector('.order-id').textContent.toLowerCase();
      const productName = card.querySelector('.product-info h3').textContent.toLowerCase();
      const customerName = card.querySelector('.customer-details').textContent.toLowerCase();
      
      const shouldShow = orderId.includes(searchTerm) || productName.includes(searchTerm) || customerName.includes(searchTerm);
      card.style.display = shouldShow ? 'block' : 'none';
    });
  });

  // Filter functionality
document.getElementById('applyFilters').addEventListener('click', function() {
    const filterValue = filterSelect.value;

    orderCards.forEach(card => {
        const status = card.dataset.status;
        const shouldShow = filterValue === 'all' || status === filterValue;
        card.style.display = shouldShow ? 'block' : 'none';
    });
});

  // Function to update available status options based on current status
  function updateStatusOptions(currentStatus) {
    const allowedNextStatuses = allowedTransitions[currentStatus] || [];
    
    statusOptions.forEach(option => {
      const statusValue = option.querySelector('input').value;
      const isAllowed = allowedNextStatuses.includes(statusValue);
      
      // Enable/disable based on allowed transitions
      option.querySelector('input').disabled = !isAllowed;
      
      // Visual indication for disabled options
      if (!isAllowed) {
        option.style.opacity = '0.5';
        option.style.cursor = 'not-allowed';
      } else {
        option.style.opacity = '1';
        option.style.cursor = 'pointer';
      }
    });
  }

  // Update status button click handlers
  updateStatusButtons.forEach(button => {
    button.addEventListener('click', function() {
      currentOrderCard = this.closest('.farmer-order-card');
      currentOrderId = this.dataset.order;
      currentStatus = this.dataset.status;
      
      // Update available status options based on current status
      updateStatusOptions(currentStatus);
      
      // Set current status as checked and disable it (can't stay in same status)
      const radioButtons = document.querySelectorAll('input[name="order-status"]');
      radioButtons.forEach(radio => {
        if (radio.value === currentStatus) {
          radio.checked = true;
          radio.disabled = true;
          // Find the parent label and style it
          const parentLabel = radio.closest('.status-option');
          parentLabel.style.opacity = '0.5';
          parentLabel.style.cursor = 'not-allowed';
        } else {
          radio.checked = false;
        }
      });

      statusModal.style.display = 'flex';
    });
  });

  // Close modal handlers
  closeModalBtn.addEventListener('click', function() {
    statusModal.style.display = 'none';
    resetStatusOptions();
  });

  cancelUpdateBtn.addEventListener('click', function() {
    statusModal.style.display = 'none';
    resetStatusOptions();
  });

  // Function to reset all status options to default state
  function resetStatusOptions() {
    statusOptions.forEach(option => {
      const radio = option.querySelector('input');
      radio.disabled = false;
      option.style.opacity = '1';
      option.style.cursor = 'pointer';
    });
  }

  // Save status handler
  saveStatusBtn.addEventListener('click', function() {
    const selectedRadio = document.querySelector('input[name="order-status"]:checked');
    
    if (selectedRadio && currentOrderCard && currentOrderId) {
      const selectedStatus = selectedRadio.value;
      
      // Validate if the transition is allowed
      const allowedNextStatuses = allowedTransitions[currentStatus] || [];
      if (!allowedNextStatuses.includes(selectedStatus) && selectedStatus !== currentStatus) {
        alert(`Invalid status transition! From "${statusTexts[currentStatus]}" you can only transition to: ${allowedNextStatuses.map(s => statusTexts[s]).join(' or ')}`);
        return;
      }

      // Update database via AJAX
      fetch('<?= URLROOT ?>/marketplace/updateOrderStatus', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          order_id: currentOrderId,
          status: selectedStatus
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Update the UI
          const statusElement = currentOrderCard.querySelector('.order-status');
          statusElement.textContent = statusTexts[selectedStatus];
          statusElement.className = 'order-status ' + statusClasses[selectedStatus];
          
          // Update the button data-status attribute
          const updateButton = currentOrderCard.querySelector('.update-status-btn');
          updateButton.dataset.status = selectedStatus;
          
          // Show success message
          alert('Order status updated successfully!');
          
          // Force page refresh after 1 second to sync with database
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          alert('Error updating order status: ' + (data.message || 'Unknown error'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error updating order status. Please try again.');
      });
    }

    statusModal.style.display = 'none';
    resetStatusOptions();
  });

  // Close modal when clicking outside
  window.addEventListener('click', function(e) {
    if (e.target === statusModal) {
      statusModal.style.display = 'none';
      resetStatusOptions();
    }
  });
});


</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>