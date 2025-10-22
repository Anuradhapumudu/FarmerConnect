<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/farmertrackorders.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <div class="header">
      <h1>My Orders</h1>
    </div>
    
     <div class="filter-container">
      <div style="position: relative; flex: 1;">
        <input type="text" class="search-input" placeholder="Search orders by ID, product, or date...">
      </div>
      <select class="filter-select">
        <option value="all">All Statuses</option>
        <option value="ready">Ready for Pickup</option>
        <option value="picked">Picked Up</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>
    
    <div class="orders-container">

      <!-- Order Card 1 -->
      <div class="order-card">
        <div class="order-main-content">
          <div class="order-image">
            <img src="<?php echo URLROOT; ?>/img/paddy seed.webp" alt="Premium Paddy Seeds">
          </div>
          
          <div class="order-content-wrapper">
            <div class="order-header">
              <div>
                <div class="order-id">#FM12345</div>
                <div class="order-date">Dec 9, 2024</div>
              </div>
              <div class="order-status status-ready">Ready for Pickup</div>
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

                <!-- Seller Details -->
                <div class="seller-details">
                  <h3>Seller Info</h3>
                  <p><strong>Name:</strong> Green Agro Farm</p>
                  <p><strong>Location:</strong> Kandy, Sri Lanka</p>
                  <p><strong>Contact:</strong> +94 71 123 4567</p>
                </div>

              </div>
            
              <hr class="divider"> 
              <div class="action-buttons">
                <button class="btn btn-primary" onclick="toggleOrderDetails('fm12345')">
                  <i class="fas fa-eye"></i> View Details
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Order Details Section -->
        <div class="order-details-container" id="details-fm12345">
          <div class="tracking-content">
            <div class="product-info">
              <div class="product-image">
                <i class="fas fa-seedling"></i>
              </div>
              <div class="product-details">
                <h3>Premium Paddy Seeds</h3>
                <p>Quantity: 10 Kg</p>
                <p>Seller: GreenFarm Supplies</p>
                <div class="price">LKR 5,000.00</div>
              </div>
            </div>

            <div class="tracking-timeline">
              <h3 class="timeline-title">Order Progress</h3>
              <div class="timeline">
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 9, 2024 - 9:15 AM</div>
                    <div class="timeline-text">Order Placed</div>
                  </div>
                </div>
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 9, 2024 - 2:15 PM</div>
                    <div class="timeline-text">Order Confirmed</div>
                  </div>
                </div>
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 10, 2024 - 10:00 AM</div>
                    <div class="timeline-text">Order Prepared</div>
                  </div>
                </div>
                <div class="timeline-step active">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 12, 2024</div>
                    <div class="timeline-text">Ready for Pickup</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="pickup-info">
              <h3 class="info-title"><i class="fas fa-store"></i> Pickup Information</h3>
              <div class="info-details">
                <div class="info-item">
                  <span class="info-label">Pickup Location</span>
                  <span class="info-value">EcoFarmer Supplies Store, Galle</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Pickup Date</span>
                  <span class="info-value">Dec 12, 2024</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Contact Person</span>
                  <span class="info-value">Sarah Johnson (+94 77 987 6543)</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Card 2 -->
      <div class="order-card">
        <div class="order-main-content">
           <div class="order-image">
            <img src="<?php echo URLROOT; ?>/img/fertilizer.jpg" alt="Premium Paddy Seeds">
          </div>
          
          <div class="order-content-wrapper">
            <div class="order-header">
              <div>
                <div class="order-id">#FM12346</div>
                <div class="order-date">Dec 5, 2024</div>
              </div>
              <div class="order-status status-picked">Picked Up</div>
            </div>
            
            <div class="order-content">
              <div class="product-info">
                <div class="product-details">
                  <h3>Organic Fertilizer - 25kg Bag</h3>
                  <p>Quantity: 2 Bags</p>
                  <div class="price">LKR 3,500.00</div>
                </div>
              </div>
              
              <div class="order-progress">
                <div class="progress-text">Order date: 2024/12/05</div>
              </div>
              
              <div class="action-buttons">
                <button class="btn btn-primary" onclick="toggleOrderDetails('fm12346')">
                  <i class="fas fa-eye"></i> View Details
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Order Details Section -->
        <div class="order-details-container" id="details-fm12346">
          <div class="tracking-content">
            <div class="product-info">
              <div class="product-image">
                <i class="fas fa-leaf"></i>
              </div>
              <div class="product-details">
                <h3>Organic Fertilizer - 25kg Bag</h3>
                <p>Quantity: 2 Bags</p>
                <p>Seller: EcoFarm Solutions</p>
                <div class="price">LKR 3,500.00</div>
              </div>
            </div>

            <div class="tracking-timeline">
              <h3 class="timeline-title">Order Progress</h3>
              <div class="timeline">
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 5, 2024 - 9:15 AM</div>
                    <div class="timeline-text">Order Placed</div>
                  </div>
                </div>
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 5, 2024 - 1:30 PM</div>
                    <div class="timeline-text">Order Confirmed</div>
                  </div>
                </div>
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 6, 2024 - 10:00 AM</div>
                    <div class="timeline-text">Order Prepared</div>
                  </div>
                </div>
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 7, 2024 - 11:20 AM</div>
                    <div class="timeline-text">Ready for Pickup</div>
                  </div>
                </div>
                <div class="timeline-step completed">
                  <div class="timeline-content">
                    <div class="timeline-date">Dec 7, 2024 - 3:45 PM</div>
                    <div class="timeline-text">Picked Up</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="pickup-info">
              <h3 class="info-title"><i class="fas fa-store"></i> Pickup Information</h3>
              <div class="info-details">
                <div class="info-item">
                  <span class="info-label">Pickup Location</span>
                  <span class="info-value">EcoFarm Supplies Store, Galle</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Pickup Date</span>
                  <span class="info-value">Dec 7, 2024</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Contact Person</span>
                  <span class="info-value">Sarah Johnson (+94 77 987 6543)</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</main>

<script>
  function toggleOrderDetails(orderId) {
    const detailsSection = document.getElementById(`details-${orderId}`);
    const isExpanding = !detailsSection.classList.contains('expanded');
    
    // Close all other expanded details
    const allDetails = document.querySelectorAll('.order-details-container');
    allDetails.forEach(detail => {
      if (detail.id !== `details-${orderId}` && detail.classList.contains('expanded')) {
        detail.classList.remove('expanded');
      }
    });
    
    // Toggle the clicked details section
    detailsSection.classList.toggle('expanded');
    
    // Scroll to the details if expanding
    if (isExpanding) {
      setTimeout(() => {
        detailsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }, 100);
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const orderCards = document.querySelectorAll('.order-card');

    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      orderCards.forEach(card => {
        const orderId = card.querySelector('.order-id').textContent.toLowerCase();
        const productName = card.querySelector('.product-details h3').textContent.toLowerCase();
        const shouldShow = orderId.includes(searchTerm) || productName.includes(searchTerm);
        card.style.display = shouldShow ? 'block' : 'none';
        
        // Also hide details if parent card is hidden
        const orderNum = card.querySelector('.order-id').textContent.replace('#', '').toLowerCase();
        const detailsSection = document.getElementById(`details-${orderNum}`);
        if (detailsSection) {
          detailsSection.style.display = shouldShow ? 'block' : 'none';
          if (!shouldShow) {
            detailsSection.classList.remove('expanded');
          }
        }
      });
    });

    const filterSelect = document.querySelector('.filter-select');
    filterSelect.addEventListener('change', function() {
      const filterValue = this.value;
      orderCards.forEach(card => {
        const status = card.querySelector('.order-status').textContent.toLowerCase();
        const shouldShow = filterValue === 'all' || status.includes(filterValue);
        card.style.display = shouldShow ? 'block' : 'none';
        
        // Also hide details if parent card is hidden
        const orderNum = card.querySelector('.order-id').textContent.replace('#', '').toLowerCase();
        const detailsSection = document.getElementById(`details-${orderNum}`);
        if (detailsSection) {
          detailsSection.style.display = shouldShow ? 'block' : 'none';
          if (!shouldShow) {
            detailsSection.classList.remove('expanded');
          }
        }
      });
    });
  });
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>