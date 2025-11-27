<?php require_once APPROOT . '/views/inc/header.php'; ?>

<main class="main-content">
<div class="payment-status-container">
    <div class="status-card cancelled">
        <div class="status-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <h2>Payment Cancelled</h2>
        <p>Your payment was cancelled. No amount has been deducted from your account.</p>
        
        <div class="status-actions">
            <a href="<?= URLROOT ?>/Marketplace/onlinePayment?product_id=<?= $_SESSION['product_id'] ?? '' ?>&quantity=<?= $_SESSION['quantity'] ?? 1 ?>" class="btn btn-primary">
                <i class="fas fa-credit-card"></i> Try Again
            </a>
            <a href="<?= URLROOT ?>/Marketplace/farmer" class="btn btn-outline">
                <i class="fas fa-shopping-bag"></i> Continue Shopping
            </a>
        </div>
    </div>
</div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>