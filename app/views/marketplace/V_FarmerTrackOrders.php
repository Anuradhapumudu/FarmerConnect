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
                  <h3><?= htmlspecialchars(ucfirst(strtolower($order->item_name))) ?></h3>
                  <p><strong>Quantity:</strong> <?= htmlspecialchars($order->quantity) ?></p>
                  <div class="price">LKR <?= number_format($order->total_price, 2) ?></div>
                  <p><strong>Payment Method:</strong> <?= htmlspecialchars(ucfirst(strtolower(str_replace('_', ' ', $order->payment_method)))) ?></p>
                </div>
                <div class="divider-vertical"></div>
                <div class="seller-details">
                  <h3>Seller Info</h3>
                  <p><strong>Name:</strong> <?= htmlspecialchars($order->seller_first . ' ' . $order->seller_last) ?></p>
                  <p><strong>Location:</strong> <?= htmlspecialchars($order->seller_address) ?></p>
                  <p><strong>Contact:</strong> <?= htmlspecialchars($order->seller_telNo) ?></p>
                </div>
              </div>
            
              <hr class="divider"> 
              <div class="action-buttons">
                <button class="btn btn-primary" onclick="toggleOrderDetails('<?= $orderId ?>')">
                  <i class="fas fa-eye"></i> View Tracking Details
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="order-details-container" id="details-<?= $orderId ?>">
          <!-- You can also fetch real tracking info here if stored -->
          <div class="tracking-content">

<?php
$history = $data['history'][$order->order_id] ?? [];
$currentStatus = strtolower($order->order_status);
?>

<div class="tracking-timeline">
  <h3 class="timeline-title">Order Progress</h3>
  <div class="timeline">

    <!--Always show order placed -->
    <div class="timeline-step completed">
      <div class="timeline-content">
        <div class="timeline-date"><?= date('M d, Y - h:i A', strtotime($order->order_create_date)) ?></div>
        <div class="timeline-text">Order Placed</div>
      </div>
    </div>

    <!-- Loop through order_history -->
    <?php foreach ($history as $log):
      $status = strtolower($log->new_status);

      $stepClass = "completed";
      if ($status === $currentStatus) {
        $stepClass = "active";
      }
    ?>
      <div class="timeline-step <?= $stepClass ?>">
        <div class="timeline-content">
          <div class="timeline-date"><?= date('M d, Y - h:i A', strtotime($log->changed_at)) ?></div>
          <div class="timeline-text"><?= ucwords(str_replace('_', ' ', $log->new_status)) ?></div>
        </div>
      </div>
    <?php endforeach; ?>

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
</main>

<script>
  function toggleOrderDetails(orderId) {
    const detailsSection = document.getElementById(`details-${orderId}`);
    const isExpanding = !detailsSection.classList.contains('expanded');
    
    document.querySelectorAll('.order-details-container.expanded').forEach(d => d.classList.remove('expanded'));
    
    detailsSection.classList.toggle('expanded');
    
    if (isExpanding) {
      detailsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const filterSelect = document.querySelector('.filter-select');
    const orderCards = document.querySelectorAll('.order-card');

    searchInput.addEventListener('input', () => {
      const term = searchInput.value.toLowerCase();
      orderCards.forEach(card => {
        const orderId = card.querySelector('.order-id').textContent.toLowerCase();
        const productName = card.querySelector('.product-details h3').textContent.toLowerCase();
        const show = orderId.includes(term) || productName.includes(term);
        card.style.display = show ? 'block' : 'none';
        const detailsId = card.querySelector('.order-id').textContent.replace('#','').toLowerCase();
        const details = document.getElementById(`details-${detailsId}`);
        if (details) details.classList.remove('expanded');
      });
    });

    filterSelect.addEventListener('change', () => {
      const filter = filterSelect.value;
      orderCards.forEach(card => {
        const status = card.querySelector('.order-status').textContent.toLowerCase();
        const show = filter === 'all' || status.includes(filter);
        card.style.display = show ? 'block' : 'none';
        const detailsId = card.querySelector('.order-id').textContent.replace('#','').toLowerCase();
        const details = document.getElementById(`details-${detailsId}`);
        if (details) details.classList.remove('expanded');
      });
    });
  });
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
