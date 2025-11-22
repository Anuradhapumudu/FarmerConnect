<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/sellertrackoders.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="containers">
    <div class="header">
      <h1>Seller Order Management</h1>
      <p>Track and update your customer orders</p>
    </div>
    
    <div class="filter-container">
      <div style="position: relative; flex: 1;">
        <input type="text" class="search-input" placeholder="Search orders by ID, product, or customer...">
      </div>
      <select class="filter-select">
        <option value="all">All Statuses</option>
        <option value="order_placed">Order Placed</option>
        <option value="order_confirmed">Confirmed</option>
        <option value="ready_to_pickup">Ready for Pickup</option>
        <option value="order_picked">Picked Up</option>
        <option value="order_cancelled">Cancelled</option>
      </select>
    </div>
    
    <div class="orders-container">
      <?php if(!empty($data['orders'])): ?>
        <?php foreach($data['orders'] as $order): 
          $orderId = strtolower($order->order_id);
          $statusClass = '';
          $statusText = '';
          
          // Normalize the status
          $normalizedStatus = strtolower(trim($order->order_status));
          
          switch($normalizedStatus) {
              case 'order_placed': 
                $statusClass = 'status-placed'; 
                $statusText = 'Order Placed';
                break;
              case 'order_confirmed': 
                $statusClass = 'status-confirmed'; 
                $statusText = 'Order Confirmed';
                break;
              case 'order_prepared': 
                $statusClass = 'status-prepared'; 
                $statusText = 'Order Prepared';
                break;
              case 'ready_to_pickup': 
              case 'ready_for_pickup':
                $statusClass = 'status-ready'; 
                $statusText = 'Ready For Pickup';
                break;
              case 'order_picked': 
              case 'picked_up':
              case 'picked':
                $statusClass = 'status-picked'; 
                $statusText = 'Picked Up';
                break;
              case 'order_cancelled': 
              case 'cancelled': 
                $statusClass = 'status-cancelled'; 
                $statusText = 'Cancelled';
                break;
              default:
                  // If status contains "pick", assume it's picked up
                  if (strpos($normalizedStatus, 'pick') !== false) {
                      $statusClass = 'status-picked'; 
                      $statusText = 'Picked Up';
                  } else {
                      $statusText = ucwords(str_replace('_', ' ', $order->order_status));
                      $statusClass = 'status-unknown';
                  }
          }
        ?>

        <div class="order-card">
          <div class="order-main-content">
            <div class="order-image">
              <img src="<?= URLROOT . '/uploads/' . htmlspecialchars($order->image_url) ?>" alt="<?= htmlspecialchars($order->item_name) ?>">
            </div>
            
            <div class="order-content-wrapper">
              <div class="order-header">
                <div>
                  <div class="order-id">#<?= htmlspecialchars($order->order_id) ?></div>
                  <div class="order-date"><?= date('M d, Y', strtotime($order->order_create_date)) ?></div>
                </div>
                <div class="order-status <?= $statusClass ?>"><?= $statusText ?></div>
              </div>
          
              <div class="order-content"> 
                <div class="product-info">
                  <div class="product-details">
                    <h3><?= htmlspecialchars($order->item_name) ?></h3>
                    <p>Quantity: <?= htmlspecialchars($order->quantity) ?></p>
                    <div class="price">LKR <?= number_format($order->total_price, 2) ?></div>
                  </div>
                  <div class="divider-vertical"></div>

                  <div class="customer-details">
                    <h3>Customer Info</h3>
                    <p><strong>Name:</strong> <?= htmlspecialchars($order->buyer_full) ?></p>
                    <p><strong>Contact:</strong> <?= htmlspecialchars($order->buyer_telNo) ?></p>
                  </div>
                </div>
              
                <hr class="divider">
                <div class="action-buttons">
                  <button type="button" class="btn btn-secondary update-status-btn" data-order="<?= $orderId ?>" data-status="<?= $normalizedStatus ?>">
                    <i class="fas fa-edit"></i> Update
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No orders found.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="modal" id="status-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Update Order Status</h3>
        <button class="close-modal">&times;</button>
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
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" id="cancel-update">Cancel</button>
        <button type="button" class="btn btn-primary" id="save-status">Update Status</button>
      </div>
    </div>
  </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.querySelector('.search-input');
  const orderCards = document.querySelectorAll('.order-card');
  const statusModal = document.getElementById('status-modal');
  const closeModalBtn = document.querySelector('.close-modal');
  const cancelUpdateBtn = document.getElementById('cancel-update');
  const saveStatusBtn = document.getElementById('save-status');
  const updateStatusButtons = document.querySelectorAll('.update-status-btn');
  const statusOptions = document.querySelectorAll('.status-option');
  
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
      const productName = card.querySelector('.product-details h3').textContent.toLowerCase();
      const customerName = card.querySelector('.customer-details p').textContent.toLowerCase();
      
      const shouldShow = orderId.includes(searchTerm) || productName.includes(searchTerm) || customerName.includes(searchTerm);
      card.style.display = shouldShow ? 'block' : 'none';
    });
  });

  // Filter functionality
  const filterSelect = document.querySelector('.filter-select');
  filterSelect.addEventListener('change', function() {
    const filterValue = this.value;
    orderCards.forEach(card => {
      const statusElement = card.querySelector('.order-status');
      const statusClass = Array.from(statusElement.classList).find(cls => cls.startsWith('status-'));
      const shouldShow = filterValue === 'all' || statusClass.includes(filterValue.replace('_', '-'));
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
      currentOrderCard = this.closest('.order-card');
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