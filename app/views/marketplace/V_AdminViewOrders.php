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
          <input type="text" class="search-input" placeholder="Search orders by ID, Seller ID, Customer NIC">
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
    <tr
      data-order="<?= htmlspecialchars($order->order_id) ?>"
      data-seller="<?= htmlspecialchars($order->seller_id ?? $order->seller_code ?? '') ?>"
      data-customer="<?= htmlspecialchars($order->farmer_id ?? $order->buyer_id ?? '') ?>"
      data-status="<?= htmlspecialchars(strtolower($order->order_status ?? '')) ?>"
    >
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
          data-product="<?= htmlspecialchars(ucfirst(strtolower($order->item_name ?? ''))) ?>"
          data-category="<?= htmlspecialchars(ucfirst(strtolower($order->category ?? ''))) ?>"
          data-seller="<?= htmlspecialchars(($order->seller_first ?? '') . ' ' . ($order->seller_last ?? '')) ?>"
          data-date="<?= htmlspecialchars(isset($order->order_create_date) ? date('M j, Y', strtotime($order->order_create_date)) : '') ?>"
          data-quantity="<?= htmlspecialchars($order->quantity ?? '') ?>"
          data-amount="<?= htmlspecialchars(number_format($order->total_price ?? 0, 2)) ?>"
          data-status="<?= htmlspecialchars(ucwords(str_replace('_', ' ', $order->order_status ?? 'Unknown'))) ?>"
          data-payment-method="<?= htmlspecialchars(ucwords(str_replace('_', ' ', $order->payment_method ?? ''))) ?>"
          data-phone="<?= htmlspecialchars($order->farmer_telNo ?? '') ?>"
          data-address="<?= htmlspecialchars($order->farmer_address ?? '') ?>"
          data-seller-phone="<?= htmlspecialchars($order->seller_telNo ?? '') ?>"
          data-seller-address="<?= htmlspecialchars($order->seller_address ?? '') ?>"
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
              <span class="detail-label">Quantity:</span>
              <span class="detail-value" id="modal-order-quantity"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Category:</span>
              <span class="detail-value" id="modal-order-category"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Total Amount:</span>
              <span class="detail-value" id="modal-order-amount"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Payment Method:</span>
              <span class="detail-value" id="modal-payment-method"></span>
            </div>
          </div>
          
          <div class="order-section">
            <h3 class="section-title">Seller Information</h3>
            <div class="detail-item">
              <span class="detail-label">Name:</span>
              <span class="detail-value" id="modal-seller-name"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Phone:</span>
              <span class="detail-value" id="modal-seller-phone"></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Address:</span>
              <span class="detail-value" id="modal-seller-address"></span>
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
        document.getElementById('modal-order-quantity').textContent = data.quantity || '';
        document.getElementById('modal-order-category').textContent = data.category || '';
        document.getElementById('modal-order-amount').textContent = data.amount ? ('LKR ' + data.amount) : '';
        document.getElementById('modal-payment-method').textContent = data['paymentMethod'] || '';

        document.getElementById('modal-customer-name').textContent = data.customer || '';
        document.getElementById('modal-customer-phone').textContent = data.phone || '';
        document.getElementById('modal-customer-address').textContent = data.address || '';

        document.getElementById('modal-seller-name').textContent = data.seller || '';
        document.getElementById('modal-seller-phone').textContent = data.sellerPhone || '';
        document.getElementById('modal-seller-address').textContent = data.sellerAddress || '';

        // show modal
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
            category: ds.category,
            seller: ds.seller,
            date: ds.date,
            quantity: ds.quantity,
            amount: ds.amount,
            status: ds.status,
            paymentMethod: ds.paymentMethod,
            phone: ds.phone,
            address: ds.address,
            sellerPhone: ds.sellerPhone,
            sellerAddress: ds.sellerAddress
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
      
      // Search + filter functionality for orders
      const orderSearchInput = document.querySelector('#orders-page .search-input');
      const orderRows = Array.from(document.querySelectorAll('#orders-page tbody tr'));
      const statusFilterSelect = document.querySelector('#orders-page .filter-select');

      function getRowField(row, key, fallbackSelector) {
        const ds = row.dataset || {};
        const v = (ds[key] || '');
        if (v) return v.toString().toLowerCase();
        if (fallbackSelector) {
          const el = row.querySelector(fallbackSelector);
          return el ? el.textContent.trim().toLowerCase() : '';
        }
        return '';
      }

      function applyOrderFilters() {
        const searchTerm = (orderSearchInput && orderSearchInput.value || '').trim().toLowerCase();
        const statusFilter = (statusFilterSelect && statusFilterSelect.value) ? statusFilterSelect.value.toLowerCase() : 'all';

        orderRows.forEach(row => {
          const orderId = getRowField(row, 'order', 'td:first-child');
          const sellerId = getRowField(row, 'seller', 'td:nth-child(4)');
          const customerId = getRowField(row, 'customer', 'td:nth-child(2)');
          const status = getRowField(row, 'status', 'td:nth-child(7)');

          const matchesSearch = !searchTerm ||
            orderId.includes(searchTerm) ||
            sellerId.includes(searchTerm) ||
            customerId.includes(searchTerm) ||
            status.includes(searchTerm);

          const matchesStatus = !statusFilter || statusFilter === 'all' ||
            status === statusFilter ||
            status.includes(statusFilter) ||
            statusFilter.includes(status);

          row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
      }

      if (orderSearchInput) {
        orderSearchInput.addEventListener('input', applyOrderFilters);
      }
      if (statusFilterSelect) {
        statusFilterSelect.addEventListener('change', applyOrderFilters);
      }

      // Run once on load to apply default filter
      applyOrderFilters();
    });
  </script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>