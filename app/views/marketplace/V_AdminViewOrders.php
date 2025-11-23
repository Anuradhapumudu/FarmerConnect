<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
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
<?php if (!empty($data['orders'])): ?>
  <?php foreach ($data['orders'] as $order): ?>
    <tr>
      <td>#<?= htmlspecialchars($order->order_id) ?></td>
      <td><?= htmlspecialchars($order->farmer_full ?? '') ?></td>
      <td>
        <div class="product-cell" style="display:flex;align-items:center;gap:8px;">
          <img
            src="<?= htmlspecialchars(URLROOT . '/uploads/' . ($order->image_url ?? 'placeholder.png')) ?>"
            alt="<?= htmlspecialchars($order->item_name ?? '') ?>"
            class="product-thumb"
            style="width:56px;height:56px;object-fit:cover;border-radius:6px;"
          />
          <span><?= htmlspecialchars(ucfirst(strtolower($order->item_name ?? ''))) ?></span>
        </div>
      </td>
      <td><?= htmlspecialchars(($order->seller_first ?? '') . ' ' . ($order->seller_last ?? '')) ?></td>
      <td><?= htmlspecialchars(isset($order->order_create_date) ? date('M j, Y', strtotime($order->order_create_date)) : '') ?></td>
      <td>LKR <?= number_format($order->total_price ?? 0, 2) ?></td>
      <td>
        <span class="status-badge status-<?= htmlspecialchars(str_replace('_', '-', strtolower($order->order_status ?? 'unknown'))) ?>">
          <?= htmlspecialchars(ucwords(str_replace('_', ' ', $order->order_status ?? 'Unknown'))) ?>
        </span>
      </td>
      <td>
        <button
          class="action-btn view-btn"
          data-order="<?= htmlspecialchars($order->order_id) ?>"
         data-image="<?= htmlspecialchars(URLROOT . '/uploads/' . ($order->image_url ?? '')) ?>"
          data-customer="<?= htmlspecialchars($order->farmer_full ?? '') ?>"
          data-product="<?= htmlspecialchars($order->item_name ?? '') ?>"
          data-seller="<?= htmlspecialchars(($order->seller_first ?? '') . ' ' . ($order->seller_last ?? '')) ?>"
          data-date="<?= htmlspecialchars(isset($order->order_create_date) ? date('M j, Y', strtotime($order->order_create_date)) : '') ?>"
          data-amount="<?= htmlspecialchars(number_format($order->total_price ?? 0, 2)) ?>"
          data-status="<?= htmlspecialchars(ucwords(str_replace('_', ' ', $order->order_status ?? 'Unknown'))) ?>"
          data-payment-method="<?= htmlspecialchars(ucwords(str_replace('_', ' ', $order->payment_method ?? ''))) ?>"
          data-payment-status="<?= htmlspecialchars($order->payment_status ?? '') ?>"
          data-phone="<?= htmlspecialchars($order->farmer_telNo ?? '') ?>"
          data-address="<?= htmlspecialchars($order->farmer_address ?? '') ?>"
        >
          <i class="fas fa-eye"></i> View
        </button>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="8">No orders found.</td>
  </tr>
<?php endif; ?>
            </tbody>
          </table>
        </div>
        

      </div>
    </div>
    
  </div>

  <!-- Order Detail Modal -->
  <div class="modal" id="order-detail-modal" style="display:none;">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Order Details: #<span id="modal-order-id"></span></h2>
        <button class="close-modal">&times;</button>
      </div>
      
      <div class="modal-body">
        <div class="order-detail-grid">
          <div class="order-section">
            <h3 class="section-title">Order Information</h3>
            <div class="detail-item">
              <span class="detail-label">Order ID:</span>
              <span class="detail-value" id="modal-order-id-2">#</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Order Date:</span>
              <span class="detail-value" id="modal-order-date"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Status:</span>
              <span class="detail-value" id="modal-order-status"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Total Amount:</span>
              <span class="detail-value" id="modal-order-amount"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Payment Method:</span>
              <span class="detail-value" id="modal-payment-method"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Payment Status:</span>
              <span class="detail-value" id="modal-payment-status"></span>
            </div>
          </div>
          
          <div class="order-section">
            <h3 class="section-title">Customer Information</h3>
            <div class="detail-item">
              <span class="detail-label">Name:</span>
              <span class="detail-value" id="modal-customer-name"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Phone:</span>
              <span class="detail-value" id="modal-customer-phone"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Address:</span>
              <span class="detail-value" id="modal-customer-address"></span>
            </div>
          </div>
        </div>
        
        <div class="order-section">
          <h3 class="section-title">Product Details</h3>
          <div class="product-detail">
            <div class="product-image">
              <img id="modal-product-image" src="https://via.placeholder.com/80" alt="">
            </div>
            <div class="product-info">
              <div class="product-name" id="modal-product-name"></div>
              <div class="product-meta" id="modal-product-meta"></div>
            </div>
            <div class="product-price" id="modal-product-price"></div>
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

      function openOrderModal(data) {
        document.getElementById('modal-order-id').textContent = data.order;
        document.getElementById('modal-order-id-2').textContent = '#' + data.order;
        document.getElementById('modal-order-date').textContent = data.date || '';
        document.getElementById('modal-order-status').textContent = data.status || '';
        document.getElementById('modal-order-amount').textContent = data.amount ? ('LKR ' + data.amount) : '';
        document.getElementById('modal-payment-method').textContent = data['paymentMethod'] || '';
        document.getElementById('modal-payment-status').textContent = data['paymentStatus'] || '';

        document.getElementById('modal-customer-name').textContent = data.customer || '';
        document.getElementById('modal-customer-phone').textContent = data.phone || '';
        document.getElementById('modal-customer-address').textContent = data.address || '';

        document.getElementById('modal-product-name').textContent = data.product || '';
        document.getElementById('modal-product-meta').textContent = 'Seller: ' + (data.seller || '');
        document.getElementById('modal-product-price').textContent = data.amount ? ('LKR ' + data.amount) : '';

        // set modal image (use placeholder if not provided)
        const modalImg = document.getElementById('modal-product-image');
        if (data.image && data.image.trim() !== '') {
          modalImg.src = data.image;
          modalImg.alt = data.product || 'Product image';
        } else {
          modalImg.src = "<?= htmlspecialchars(URLROOT . '/images/placeholder.png') ?>";
          modalImg.alt = 'No image';
        }
        orderModal.style.display = 'flex';
      }

      // Open modal when view button is clicked
      viewButtons.forEach(button => {
        button.addEventListener('click', function() {
          const ds = this.dataset;
          openOrderModal({
            order: ds.order,
            customer: ds.customer,
            product: ds.product,
            seller: ds.seller,
            date: ds.date,
            amount: ds.amount,
            status: ds.status,
            paymentMethod: ds.paymentMethod,
            paymentStatus: ds.paymentStatus,
            phone: ds.phone,
            address: ds.address
          });
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