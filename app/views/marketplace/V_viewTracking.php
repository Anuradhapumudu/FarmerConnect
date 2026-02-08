<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/viewTracking.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<main class="main-content" id="mainContent">
    <div class="tracking-page-container">
        <?php if(!empty($data['order'])): 
            $order = $data['order'];
            $history = $data['history'];
            $rated = $data['rated'] ?? false;
            
            // Get status information
            $normalizedStatus = strtolower(trim($order->order_status));
            $statusClass = '';
            $statusText = '';
            
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
                    if (strpos($normalizedStatus, 'pick') !== false) {
                        $statusClass = 'status-picked'; 
                        $statusText = 'Picked Up';
                    } else {
                        $statusText = ucwords(str_replace('_', ' ', $order->order_status));
                        $statusClass = 'status-unknown';
                    }
            }
        ?>
        
        <!-- Header -->
        <div class="tracking-header">
            <h1><i class="fas fa-map-marked-alt"></i> Order Tracking</h1>
            <p>Track the progress of your order</p>
            <div class="order-id-display">#<?= htmlspecialchars($order->order_id) ?></div>
        </div>
        
        <!-- Tracking Content -->
        <div class="tracking-content">
            <!-- Order Status Badge -->
            <div style="padding: 20px 25px 0;">
                <div class="order-status <?= $statusClass ?>" style="display: inline-block;">
                    <?= $statusText ?>
                </div>
            </div>
            
            <!-- Order Information -->
            <div class="order-info-section">
                <h3 style="color: #2e7d32; margin-bottom: 15px;"><i class="fas fa-info-circle"></i> Order Summary</h3>
                <div class="order-info-grid">
                    <div class="order-info-item">
                        <h4>Order Date</h4>
                        <p><?= date('M d, Y', strtotime($order->order_create_date)) ?></p>
                    </div>
                    <div class="order-info-item">
                        <h4>Total Amount</h4>
                        <p>LKR <?= number_format($order->total_price, 2) ?></p>
                    </div>
                    <div class="order-info-item">
                        <h4>Payment Method</h4>
                        <p><?= htmlspecialchars(ucfirst(strtolower(str_replace('_', ' ', $order->payment_method)))) ?></p>
                    </div>
                    <div class="order-info-item">
                        <h4>Quantity</h4>
                        <p><?= htmlspecialchars($order->quantity) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Product Details -->
            <div class="details-section">
                <div class="product-display">
                    <h3><i class="fas fa-shopping-bag"></i> Product Details</h3>
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden;">
                            <img src="<?= URLROOT . '/uploads/' . htmlspecialchars($order->image_url) ?>" 
                                 alt="<?= htmlspecialchars($order->item_name) ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h4 style="margin: 0 0 5px 0; color: #333;"><?= htmlspecialchars(ucfirst(strtolower($order->item_name))) ?></h4>
                            <p style="margin: 0; color: #666;">Quantity: <?= htmlspecialchars($order->quantity) ?></p>
                            <p style="margin: 5px 0 0 0; font-weight: 600; color: #2e7d32;">
                                LKR <?= number_format($order->total_price, 2) ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Seller Details -->
                <div class="seller-display">
                    <h3><i class="fas fa-store"></i> Seller Information</h3>
                    <div>
                        <p><strong>Name:</strong> <?= htmlspecialchars($order->seller_first . ' ' . $order->seller_last) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($order->seller_address) ?></p>
                        <p><strong>Contact:</strong> <?= htmlspecialchars($order->seller_telNo) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Timeline -->
            <div class="tracking-timeline">
                <h3 class="timeline-title">Order Progress Timeline</h3>
                <div class="timeline">
                    <!-- Always show order placed -->
                    <div class="timeline-step completed">
                        <div class="timeline-content">
                            <div class="timeline-date"><?= date('M d, Y - h:i A', strtotime($order->order_create_date)) ?></div>
                            <div class="timeline-text">Order Placed</div>
                        </div>
                    </div>

                    <!-- Loop through order_history -->
                    <?php if(!empty($history)): ?>
                        <?php foreach($history as $log):
                            $status = strtolower($log->new_status);
                            $stepClass = "completed";
                            if ($status === $normalizedStatus) {
                                $stepClass = "active";
                            }
                        ?>
                            <div class="timeline-step <?= $stepClass ?>">
                                <div class="timeline-content">
                                    <div class="timeline-date"><?= date('M d, Y - h:i A', strtotime($log->changed_at)) ?></div>
                                    <div class="timeline-text"><?= ucwords(str_replace('_', ' ', $log->new_status)) ?></div>
                                    <?php if(!empty($log->notes)): ?>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;"><?= htmlspecialchars($log->notes) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Show default next step if no history -->
                        <div class="timeline-step <?= $normalizedStatus !== 'order_placed' ? 'active' : '' ?>">
                            <div class="timeline-content">
                                <div class="timeline-date">Awaiting</div>
                                <div class="timeline-text">Order Confirmation</div>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Waiting for seller to confirm your order</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- If order is picked up, show completion message -->
                    <?php if($normalizedStatus === 'order_picked'): ?>
                        <div class="timeline-step completed">
                            <div class="timeline-content">
                                <div class="timeline-date"><?= date('M d, Y - h:i A', strtotime($order->order_create_date . ' +2 days')) ?></div>
                                <div class="timeline-text">Order Completed</div>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Thank you for your purchase!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Rating Section (only for picked orders) -->
            <?php if($normalizedStatus === 'order_picked'): ?>
                <div class="rating-section">
                    <h3><i class="fas fa-star"></i> Rate Your Purchase</h3>
                    <?php if(!$rated): ?>
                        <form method="POST" action="<?= URLROOT ?>/Marketplace/submitRating" class="rating-form">
                            <input type="hidden" name="order_id" value="<?= $order->order_id ?>">
                            <input type="hidden" name="product_id" value="<?= $order->product_id ?>">
                            
                            <p style="margin-bottom: 15px;">How would you rate this product?</p>
                            
                            <div class="stars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
                                    <label for="star<?= $i ?>">★</label>
                                <?php endfor; ?>
                            </div>
                            
                            <div style="margin-top: 15px;">
                                <textarea name="review" placeholder="Optional: Write a review..." 
                                          style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; resize: vertical; min-height: 80px;"></textarea>
                            </div>
                            
                            <button type="submit" class="btn-submit" style="margin-top: 15px;">
                                <i class="fas fa-paper-plane"></i> Submit Rating
                            </button>
                        </form>
                    <?php else: ?>
                        <p class="rated-text">⭐ You have already rated this order</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="<?= URLROOT ?>/Marketplace/myOrders" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to My Orders
                </a>
                
                <button onclick="window.print()" class="btn-print">
                    <i class="fas fa-print"></i> Print Details
                </button>
                
                <?php if($normalizedStatus !== 'order_picked' && $normalizedStatus !== 'order_cancelled'): ?>
                    <a href="tel:<?= htmlspecialchars($order->seller_telNo) ?>" class="btn-print">
                        <i class="fas fa-phone"></i> Contact Seller
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php else: ?>
            <!-- Error Message -->
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);">
                <i class="fas fa-exclamation-triangle" style="font-size: 60px; color: #f44336; margin-bottom: 20px;"></i>
                <h2 style="color: #f44336; margin-bottom: 10px;">Order Not Found</h2>
                <p style="color: #666; margin-bottom: 20px;">The order you're looking for doesn't exist or you don't have permission to view it.</p>
                <a href="<?= URLROOT ?>/Marketplace/myOrders" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to My Orders
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    // Auto-refresh every 30 seconds for real-time updates
    setTimeout(() => {
        window.location.reload();
    }, 30000);
    
    // Print functionality
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            window.print();
        }
    });
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>