<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/adminvieworders.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

  <div class="containers">
    <div class="header">
      <h1>Admin Dashboard</h1>
      <p>Manage orders and products in the marketplace</p>
    </div>
    

    <!-- Orders Management Page -->
    <div id="orders-page" class="admin-content active">

    <div class="filter-container">
        <div style="position: relative; flex: 1;">
          <input type="text" id="searchInput" class="search-input" placeholder="Search orders by ID, Seller ID, Customer NIC">
        </div>

        <select  id="statusFilter" class="filter-select">
          <option value="all">All Statuses</option>
          <option value="order_placed">Order Placed</option>
          <option value="order_confirmed">Confirmed</option>
          <option value="ready_to_pickup">Ready to Pickup</option>
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
                <th>Order Date</th>
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
          <a href="<?php echo URLROOT; ?>/Marketplace/adminVieworderDetails/<?php echo $order->order_id; ?>" 
            class="action-btn view-btn">
            <i class="fas fa-eye"></i> View
          </a>
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


  </main>

<script src="<?php echo URLROOT; ?>/js/marketplace/adminViewOrders.js?v=<?= time(); ?>"></script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>