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
            <h1><i class="fas fa-map-marked-alt"></i> Order Update</h1>
            <p>Update the progress of your order</p>
            <div class="order-id-display">#<?= htmlspecialchars($order->order_id) ?></div>
        </div>
        
        <!-- Tracking Content -->
        <div class="tracking-content">
            <!-- Order Status Badge -->
       
<?php
$currentStatus = strtolower(trim($order->order_status));
?>

<!-- STATUS TRACKER -->
<div class="status-container">

    <!-- Placed -->
    <div class="status-step <?= ($currentStatus == 'order_placed') ? 'active' : 'completed' ?>">
        <div class="circle">1</div>
        <p>Placed</p>
    </div>

    <!-- Confirmed -->
    <div class="status-step 
        <?= ($currentStatus == 'order_confirmed') ? 'active' : 
        (($currentStatus == 'ready_to_pickup' || $currentStatus == 'order_picked') ? 'completed' : '') ?>">
        <div class="circle">2</div>
        <p>Confirmed</p>
    </div>

    <!-- Ready -->
    <div class="status-step 
        <?= ($currentStatus == 'ready_to_pickup') ? 'active' : 
        (($currentStatus == 'order_picked') ? 'completed' : '') ?>">
        <div class="circle">3</div>
        <p>Ready</p>
    </div>

    <!-- Picked -->
    <div class="status-step <?= ($currentStatus == 'order_picked') ? 'active' : '' ?>">
        <div class="circle">4</div>
        <p>Picked</p>
    </div>

</div>

<!-- ACTION BUTTONS -->
<div class="action-buttons" style="margin-top:30px; text-align:center;">

<?php if($currentStatus == 'order_placed'): ?>

    <a href="<?= URLROOT ?>/Marketplace/updateStatus/<?= $order->order_id ?>/order_confirmed" class="btn btn-confirm">Confirm Order</a>

    <a href="<?= URLROOT ?>/Marketplace/updateStatus/<?= $order->order_id ?>/order_cancelled" class="btn btn-cancel">Cancel Order</a>

<?php elseif($currentStatus == 'order_confirmed'): ?>

    <a href="<?= URLROOT ?>/Marketplace/updateStatus/<?= $order->order_id ?>/ready_to_pickup" class="btn btn-ready">Ready to Pickup</a>

<?php elseif($currentStatus == 'ready_to_pickup'): ?>

    <a href="<?= URLROOT ?>/Marketplace/updateStatus/<?= $order->order_id ?>/order_picked" class="btn btn-picked">Picked Up</a>

<?php elseif($currentStatus == 'order_cancelled'): ?>

    <p style="color:red; font-weight:bold;">Cancelled </p>

<?php elseif($currentStatus == 'order_confirmed'): ?>

    <p style="color:red; font-weight:bold;">Order Confirmed </p>


<?php elseif($currentStatus == 'ready_to_pickup'): ?>

    <p style="color:red; font-weight:bold;">Ready For Pickup</p>

<?php elseif($currentStatus == 'order_picked'): ?>

    <p style="color:green; font-weight:bold;">Picked Up </p>

<?php endif; ?>

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
                    
                </div>
            </div>
            
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="<?= URLROOT ?>/Marketplace/trackOrdersSeller" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Seller Order Management
                </a>
                
                
                <?php if($normalizedStatus !== 'order_picked' && $normalizedStatus !== 'order_cancelled'): ?>

                <?php endif; ?>
            </div>
        </div>
        
        <?php else: ?>
            <!-- Error Message -->
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);">
                <i class="fas fa-exclamation-triangle" style="font-size: 60px; color: #f44336; margin-bottom: 20px;"></i>
                <h2 style="color: #f44336; margin-bottom: 10px;">Order Not Found</h2>
                <p style="color: #666; margin-bottom: 20px;">The order you're looking for doesn't exist or you don't have permission to view it.</p>
                <a href="<?= URLROOT ?>/Marketplace/trackOrdersSeller" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Seller Order Management
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