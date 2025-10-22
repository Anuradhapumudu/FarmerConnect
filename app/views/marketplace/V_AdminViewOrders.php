<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/adminvieworders.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <div class="admin-header">
      <h1>Admin Dashboard</h1>
      <p>Manage orders and products in the marketplace</p>
    </div>
    

    <!-- Orders Management Page -->
    <div id="orders-page" class="admin-content active">
      <div class="filter-container">
        <div style="position: relative; flex: 1;">
          <input type="text" class="search-input" placeholder="Search orders by ID, customer, or product...">
        </div>
        <select class="filter-select">
          <option value="all">All Statuses</option>
          <option value="pending">Pending</option>
          <option value="processing">Processing</option>
          <option value="shipped">Shipped</option>
          <option value="delivered">Delivered</option>
          <option value="cancelled">Cancelled</option>
        </select>
        <select class="filter-select">
          <option value="all">All Sellers</option>
          <option value="seller1">GreenFarm Supplies</option>
          <option value="seller2">EcoFarm Solutions</option>
          <option value="seller3">FarmTech Equipment</option>
        </select>
      </div>
      

      
      <div class="data-table">
        <div class="table-header">
          <div class="table-title">All Orders</div>
        </div>
        
        <div class="table-content">
          <table>
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Seller</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#FM12345</td>
                <td>John Doe</td>
                <td>Premium Paddy Seeds (10 Kg)</td>
                <td>GreenFarm Supplies</td>
                <td>Dec 9, 2024</td>
                <td>LKR 5,000.00</td>
                <td><span class="status-badge status-shipped">Shipped</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i> View
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#FM12346</td>
                <td>Sarah Johnson</td>
                <td>Organic Fertilizer (2 Bags)</td>
                <td>EcoFarm Solutions</td>
                <td>Dec 5, 2024</td>
                <td>LKR 3,500.00</td>
                <td><span class="status-badge status-delivered">Delivered</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i> View
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#FM12347</td>
                <td>Robert Silva</td>
                <td>Agricultural Tools Set</td>
                <td>FarmTech Equipment</td>
                <td>Dec 3, 2024</td>
                <td>LKR 8,750.00</td>
                <td><span class="status-badge status-processing">Processing</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i> View
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#FM12348</td>
                <td>Amanda Perera</td>
                <td>Organic Pesticide (5 Liters)</td>
                <td>GreenFarm Supplies</td>
                <td>Today</td>
                <td>LKR 2,800.00</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i> View
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#FM12349</td>
                <td>David Brown</td>
                <td>Water Pump System</td>
                <td>FarmTech Equipment</td>
                <td>Dec 1, 2024</td>
                <td>LKR 12,500.00</td>
                <td><span class="status-badge status-cancelled">Cancelled</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i> View
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div class="pagination">
          <button class="page-btn active">1</button>
          <button class="page-btn">2</button>
          <button class="page-btn">3</button>
          <button class="page-btn">Next</button>
        </div>
      </div>
    </div>
    
    <!-- Products Management Page -->
    <div id="products-page" class="admin-content">
      <div class="search-box">
        <div style="position: relative; flex: 1;">
          <i class="fas fa-search search-icon"></i>
          <input type="text" class="search-input" placeholder="Search products by name, seller, or category...">
        </div>
        <select class="filter-select">
          <option value="all">All Categories</option>
          <option value="seeds">Seeds</option>
          <option value="fertilizer">Fertilizer</option>
          <option value="tools">Tools & Equipment</option>
          <option value="pesticide">Pesticides</option>
        </select>
        <select class="filter-select">
          <option value="all">All Status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="outofstock">Out of Stock</option>
        </select>
      </div>
      
      <div class="stats-cards">
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-box"></i>
          </div>
          <div class="stat-value">87</div>
          <div class="stat-label">Total Products</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-store"></i>
          </div>
          <div class="stat-value">15</div>
          <div class="stat-label">Active Sellers</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-seedling"></i>
          </div>
          <div class="stat-value">42</div>
          <div class="stat-label">Agricultural Products</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon">
            <i class="fas fa-tools"></i>
          </div>
          <div class="stat-value">25</div>
          <div class="stat-label">Tools & Equipment</div>
        </div>
      </div>
      
      <div class="data-table">
        <div class="table-header">
          <div class="table-title">All Products</div>
          <div class="table-actions">
            <button class="action-btn">
              <i class="fas fa-plus"></i> Add Product
            </button>
            <button class="action-btn">
              <i class="fas fa-download"></i> Export
            </button>
          </div>
        </div>
        
        <div class="table-content">
          <table>
            <thead>
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Seller</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#PRD1001</td>
                <td>Premium Paddy Seeds</td>
                <td>GreenFarm Supplies</td>
                <td>Seeds</td>
                <td>LKR 5,000.00</td>
                <td>45 Kg</td>
                <td><span class="status-badge status-active">Active</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="action-btn edit-btn">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="action-btn delete-btn">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#PRD1002</td>
                <td>Organic Fertilizer</td>
                <td>EcoFarm Solutions</td>
                <td>Fertilizer</td>
                <td>LKR 1,750.00</td>
                <td>22 Bags</td>
                <td><span class="status-badge status-active">Active</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="action-btn edit-btn">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="action-btn delete-btn">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#PRD1003</td>
                <td>Agricultural Tools Set</td>
                <td>FarmTech Equipment</td>
                <td>Tools</td>
                <td>LKR 8,750.00</td>
                <td>8 Sets</td>
                <td><span class="status-badge status-active">Active</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="action-btn edit-btn">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="action-btn delete-btn">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#PRD1004</td>
                <td>Organic Pesticide</td>
                <td>GreenFarm Supplies</td>
                <td>Pesticides</td>
                <td>LKR 2,800.00</td>
                <td>0 Liters</td>
                <td><span class="status-badge status-outofstock">Out of Stock</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="action-btn edit-btn">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="action-btn delete-btn">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              
              <tr>
                <td>#PRD1005</td>
                <td>Water Pump System</td>
                <td>FarmTech Equipment</td>
                <td>Equipment</td>
                <td>LKR 12,500.00</td>
                <td>3 Units</td>
                <td><span class="status-badge status-inactive">Inactive</span></td>
                <td>
                  <button class="action-btn view-btn">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="action-btn edit-btn">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="action-btn delete-btn">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div class="pagination">
          <button class="page-btn active">1</button>
          <button class="page-btn">2</button>
          <button class="page-btn">3</button>
          <button class="page-btn">Next</button>
        </div>
      </div>
    </div>

     <!-- Products Management Page -->
    <div id="products-page" class="admin-content">
      <!-- Products content would be here -->
    </div>
  </div>

  <!-- Order Detail Modal -->
  <div class="modal" id="order-detail-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Order Details: #FM12345</h2>
        <button class="close-modal">&times;</button>
      </div>
      
      <div class="modal-body">
        <div class="order-detail-grid">
          <div class="order-section">
            <h3 class="section-title">Order Information</h3>
            <div class="detail-item">
              <span class="detail-label">Order ID:</span>
              <span class="detail-value">#FM12345</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Order Date:</span>
              <span class="detail-value">Dec 9, 2024</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Status:</span>
              <span class="detail-value"><span class="status-badge status-shipped">Shipped</span></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Total Amount:</span>
              <span class="detail-value">LKR 5,000.00</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Payment Method:</span>
              <span class="detail-value">Credit Card</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Payment Status:</span>
              <span class="detail-value">Paid</span>
            </div>
          </div>
          
          <div class="order-section">
            <h3 class="section-title">Customer Information</h3>
            <div class="detail-item">
              <span class="detail-label">Name:</span>
              <span class="detail-value">John Doe</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Email:</span>
              <span class="detail-value">john.doe@example.com</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Phone:</span>
              <span class="detail-value">+94 71 234 5678</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Address:</span>
              <span class="detail-value">123 Main Street, Kandy, Sri Lanka</span>
            </div>
          </div>
        </div>
        
        <div class="order-section">
          <h3 class="section-title">Product Details</h3>
          <div class="product-detail">
            <div class="product-image">
              <img src="https://via.placeholder.com/80" alt="Premium Paddy Seeds">
            </div>
            <div class="product-info">
              <div class="product-name">Premium Paddy Seeds</div>
              <div class="product-meta">Quantity: 10 Kg</div>
              <div class="product-meta">Seller: GreenFarm Supplies</div>
            </div>
            <div class="product-price">LKR 5,000.00</div>
          </div>
        </div>
        
        <div class="order-section">
          <h3 class="section-title">Order Tracking</h3>
          <div class="timeline">
            <div class="timeline-step completed">
              <div class="timeline-content">
                <div class="timeline-date">Dec 9, 2024 - 10:30 AM</div>
                <div class="timeline-text">Order Placed</div>
              </div>
            </div>
            
            <div class="timeline-step completed">
              <div class="timeline-content">
                <div class="timeline-date">Dec 9, 2024 - 11:45 AM</div>
                <div class="timeline-text">Order Confirmed</div>
              </div>
            </div>
            
            <div class="timeline-step completed">
              <div class="timeline-content">
                <div class="timeline-date">Dec 10, 2024 - 09:15 AM</div>
                <div class="timeline-text">Order Processed</div>
              </div>
            </div>
            
            <div class="timeline-step active">
              <div class="timeline-content">
                <div class="timeline-date">Dec 11, 2024 - 02:20 PM</div>
                <div class="timeline-text">Shipped</div>
              </div>
            </div>
            
            <div class="timeline-step">
              <div class="timeline-content">
                <div class="timeline-text">Out for Delivery</div>
              </div>
            </div>
            
            <div class="timeline-step">
              <div class="timeline-content">
                <div class="timeline-text">Delivered</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal-actions">
        <button class="action-btn btn-secondary close-modal">Close</button>
      </div>
    </div>
  </div>

   </div>



  </main>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Navigation between pages
      const navLinks = document.querySelectorAll('.nav-link');
      const adminContents = document.querySelectorAll('.admin-content');
      
      navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          
          // Remove active class from all links and contents
          navLinks.forEach(l => l.classList.remove('active'));
          adminContents.forEach(c => c.classList.remove('active'));
          
          // Add active class to clicked link
          this.classList.add('active');
          
          // Show the corresponding content
          const target = this.getAttribute('data-target');
          document.getElementById(target).classList.add('active');
        });
      });
      
      // Modal functionality
      const orderModal = document.getElementById('order-detail-modal');
      const viewButtons = document.querySelectorAll('.view-btn');
      const closeModalButtons = document.querySelectorAll('.close-modal');
      
      // Open modal when view button is clicked
      viewButtons.forEach(button => {
        button.addEventListener('click', function() {
          const orderId = this.getAttribute('data-order');
          // In a real application, you would fetch order details based on orderId
          orderModal.style.display = 'flex';
        });
      });
      
      // Close modal when close button is clicked
      closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
          orderModal.style.display = 'none';
        });
      });
      
      // Close modal when clicking outside
      window.addEventListener('click', function(e) {
        if (e.target === orderModal) {
          orderModal.style.display = 'none';
        }
      });
      
      // Search functionality for orders
      const orderSearchInput = document.querySelector('#orders-page .search-input');
      const orderRows = document.querySelectorAll('#orders-page tbody tr');
      
      if (orderSearchInput) {
        orderSearchInput.addEventListener('input', function() {
          const searchTerm = this.value.toLowerCase();
          
          orderRows.forEach(row => {
            const orderId = row.querySelector('td:first-child').textContent.toLowerCase();
            const customer = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const product = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            
            if (orderId.includes(searchTerm) || customer.includes(searchTerm) || product.includes(searchTerm)) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });
        });
      }
      
      // Filter functionality
      const filterSelects = document.querySelectorAll('.filter-select');
      
      filterSelects.forEach(select => {
        select.addEventListener('change', function() {
          // This would be implemented based on specific filtering needs
          console.log('Filter changed:', this.value);
        });
      });
    });
  </script>
    



<?php require_once APPROOT . '/views/inc/footer.php'; ?>