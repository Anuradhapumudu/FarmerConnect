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
        <option value="placed">Placed</option>
        <option value="confirmed">Confirmed</option>
        <option value="prepared">Prepared</option>
        <option value="ready">Ready For Pickup</option>
        <option value="picked">Picked Up</option>
      </select>
    </div>
    
    <div class="orders-container">

      <!-- Order Card 1 -->
      <div class="order-card">
        <div class="order-main-content">
          <div class="order-image">
            <img src="<?php echo URLROOT; ?>/img/collage.jpg" alt="Premium Paddy Seeds">
          </div>
          
          <div class="order-content-wrapper">
            <div class="order-header">
              <div>
                <div class="order-id">#FM12345</div>
                <div class="order-date">Dec 9, 2024</div>
              </div>
              <div class="order-status status-confirmed">Confirmed</div>
            </div>
        
            <div class="order-content"> 
              <div class="product-info">
                <div class="product-details">
                  <h3>Premium Paddy Seeds</h3>
                  <p>Quantity: 10 Kg</p>
                  <div class="price">LKR 5,000.00</div>
                </div>
              
                <!-- Divider -->
                <div class="divider-vertical"></div>

                 <!-- Customer Details -->
                <div class="customer-details">
                  <h3>Customer Info</h3>
                  <p><strong>Name:</strong> <span class="customer-name">A.J.K Athukorala</span></p>
                  <p><strong>Location:</strong> Kandy, Sri Lanka</p>
                  <p><strong>Contact:</strong> +94 71 123 4567</p>
                </div>
              </div>
            
              <hr class="divider">
              <div class="action-buttons">
                <button type="button" class="btn btn-secondary update-status-btn" data-order="fm12345">
                  <i class="fas fa-edit"></i> Update
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Card 2 -->
      <div class="order-card">
        <div class="order-main-content">
          <div class="order-image">
            <i class="fas fa-tools product-icon"></i>
          </div>
          
          <div class="order-content-wrapper">
            <div class="order-header">
              <div>
                <div class="order-id">#FM12347</div>
                <div class="order-date">Dec 3, 2024</div>
              </div>
              <div class="order-status status-ready">Ready For Pickup</div>
            </div>
            
            <div class="order-content">
              <div class="product-info">
                <div class="product-details">
                  <h3>Agricultural Tools Set</h3>
                  <p>Quantity: 1 Set</p>
                  <div class="price">LKR 8,750.00</div>
                </div>
              
                <!-- Divider -->
                <div class="divider-vertical"></div>

                <!-- Customer Details -->
                <div class="customer-details">
                  <h3>Customer Info</h3>
                  <p><strong>Name:</strong> <span class="customer-name">Fernando</span></p>
                  <p><strong>Location:</strong> Kandy, Sri Lanka</p>
                  <p><strong>Contact:</strong> +94 71 123 4567</p>
                </div>
              </div>
              
              <hr class="divider"> 
              <div class="action-buttons">
                <button class="btn btn-secondary update-status-btn" data-order="fm12347">
                  <i class="fas fa-edit"></i> Update
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Update Status Modal -->
  <div class="modal" id="status-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Update Order Status</h3>
        <button class="close-modal">&times;</button>
      </div>
      <div class="status-options">
        <label class="status-option">
          <input type="radio" name="order-status" value="placed">
          <span>Order Placed</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="confirmed">
          <span>Order Confirmed</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="prepared">
          <span>Order Prepared</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="ready">
          <span>Ready For Pickup</span>
        </label>
        <label class="status-option">
          <input type="radio" name="order-status" value="picked">
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
  
  let currentOrderCard = null;

  // Search functionality
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    orderCards.forEach(card => {
      const orderId = card.querySelector('.order-id').textContent.toLowerCase();
      const productName = card.querySelector('.product-details h3').textContent.toLowerCase();
      
      // Check if customer name element exists
      const customerNameElement = card.querySelector('.customer-name');
      const customerName = customerNameElement ? customerNameElement.textContent.toLowerCase() : '';
      
      const shouldShow = orderId.includes(searchTerm) || productName.includes(searchTerm) || customerName.includes(searchTerm);
      card.style.display = shouldShow ? 'block' : 'none';
    });
  });

  // Filter functionality
  const filterSelect = document.querySelector('.filter-select');
  filterSelect.addEventListener('change', function() {
    const filterValue = this.value;
    orderCards.forEach(card => {
      const status = card.querySelector('.order-status').textContent.toLowerCase().replace(/\s+/g, '');
      const shouldShow = filterValue === 'all' || status.includes(filterValue);
      card.style.display = shouldShow ? 'block' : 'none';
    });
  });

  // Modal functionality
  updateStatusButtons.forEach(button => {
    button.addEventListener('click', function() {
      currentOrderCard = this.closest('.order-card');
      
      // Pre-select current status in modal
      const currentStatus = currentOrderCard.querySelector('.order-status').textContent.trim().toLowerCase().replace(/\s+/g, '');
      const radioButtons = document.querySelectorAll('input[name="order-status"]');
      
      radioButtons.forEach(radio => {
        // Normalize the value for comparison
        const radioValue = radio.value.toLowerCase().replace(/\s+/g, '');
        if (radioValue === currentStatus) {
          radio.checked = true;
        }
      });

      statusModal.style.display = 'flex';
    });
  });

  // Close modal events
  closeModalBtn.addEventListener('click', function() {
    statusModal.style.display = 'none';
  });

  cancelUpdateBtn.addEventListener('click', function() {
    statusModal.style.display = 'none';
  });

  // Save status event - FIXED
  saveStatusBtn.addEventListener('click', function() {
    const selectedRadio = document.querySelector('input[name="order-status"]:checked');
    
    if (selectedRadio && currentOrderCard) {
      const selectedStatus = selectedRadio.value;
      const statusElement = currentOrderCard.querySelector('.order-status');
      
      // Update status text
      let statusText = '';
      switch(selectedStatus) {
        case 'placed': statusText = 'Placed'; break;
        case 'confirmed': statusText = 'Confirmed'; break;
        case 'prepared': statusText = 'Prepared'; break;
        case 'ready': statusText = 'Ready For Pickup'; break;
        case 'picked': statusText = 'Picked Up'; break;
      }
      statusElement.textContent = statusText;

      // Update status class - remove all status classes first
      statusElement.classList.remove('status-placed', 'status-confirmed', 'status-prepared', 'status-ready', 'status-picked', 'status-cancelled');
      
      // Add the correct status class
      statusElement.classList.add(`status-${selectedStatus}`);
    }

    statusModal.style.display = 'none';
  });

  // Close modal when clicking outside
  window.addEventListener('click', function(e) {
    if (e.target === statusModal) {
      statusModal.style.display = 'none';
    }
  });
});
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>