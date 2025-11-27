<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/online-payment.css">

<main class="main-content">
<div class="payment-container">
    <h2><i class="fab fa-paypal"></i> PayPal Payment</h2>

    <div class="payment-card">
        <div class="product-summary">
            <h3>Order Summary</h3>
            <div class="summary-item">
                <span>Product:</span>
                <strong><?= htmlspecialchars($data['product']->item_name) ?></strong>
            </div>
            <div class="summary-item">
                <span>Quantity:</span>
                <strong><?= $data['quantity'] ?> <?= $data['product']->unit_type ?></strong>
            </div>
            <div class="summary-item">
                <span>Unit Price:</span>
                <strong>Rs. <?= number_format($data['product']->price_per_unit, 2) ?></strong>
            </div>
            <div class="summary-item total">
                <span>Total Amount:</span>
                <strong>$<?= number_format($data['total_price'] / 300, 2) ?> USD</strong>
                <small style="display: block; color: #666;">(Rs. <?= number_format($data['total_price'], 2) ?> LKR)</small>
            </div>
        </div>

<div class="paypal-instructions">
    <h4><i class="fas fa-info-circle"></i> PayPal Sandbox Testing</h4>
    
    <div class="test-credentials">
        <h5>Test Account:</h5>
        <p><strong>Email:</strong> sb-43d7po30289391@personal.example.com</p>
        <p><strong>Password:</strong> ]r%0#C0%</p>
    </div>

    <div class="test-cards" style="background: #fff3cd; padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid #ffeaa7;">
        <h5 style="color: #856404; margin-top: 0;">Working Test Cards:</h5>
        
        <div class="card-option" style="margin-bottom: 10px; padding: 10px; background: white; border-radius: 5px;">
            <strong>Visa:</strong> 4032 0337 5149 9299<br>
            <small>Exp: 12/2025 | CVV: 123 | Name: John Doe</small>
        </div>
        
        <div class="card-option" style="margin-bottom: 10px; padding: 10px; background: white; border-radius: 5px;">
            <strong>MasterCard:</strong> 5425 2334 3010 9903<br>
            <small>Exp: 11/2024 | CVV: 123 | Name: John Doe</small>
        </div>
        
        <div class="card-option" style="padding: 10px; background: white; border-radius: 5px;">
            <strong>Amex:</strong> 3742 510187 20889<br>
            <small>Exp: 12/2026 | CVV: 1234 | Name: John Doe</small>
        </div>
    </div>

    <p class="note" style="color: #856404; font-style: italic;">
        💡 <strong>Tip:</strong> Use the Visa card above - it works best with PayPal sandbox.
    </p>
</div>

        <!-- PayPal Button Container -->
        <div id="paypal-button-container"></div>

        <div id="payment-status" style="display: none;">
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i> Processing your payment...
            </div>
        </div>

        <div class="payment-actions">
            <a href="<?= URLROOT ?>/Marketplace/buyProduct/<?= $data['product']->item_id ?>" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Order
            </a>
        </div>
    </div>
</div>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=<?= $data['paypal_client_id'] ?>&currency=USD"></script>

<script>
// Convert LKR to USD (approximate rate for demo)
const exchangeRate = 300;
const amountUSD = <?= number_format($data['total_price'] / 300, 2, '.', '') ?>;

// Store order data first
fetch('<?= URLROOT ?>/Marketplace/preparePayPalOrder', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
        'product_id': '<?= $data['product']->item_id ?>',
        'quantity': '<?= $data['quantity'] ?>'
    })
})
.then(response => response.json())
.then(data => {
    if (!data.success) {
        console.error('Failed to prepare order:', data.message);
    }
})
.catch(error => {
    console.error('Error preparing order:', error);
});

// Initialize PayPal Buttons
paypal.Buttons({
    style: {
        shape: 'rect',
        color: 'gold',
        layout: 'vertical',
        label: 'paypal'
    },

    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                description: "Purchase: <?= htmlspecialchars($data['product']->item_name) ?>",
                invoice_id: "INV-<?= uniqid() ?>",
                amount: {
                    value: amountUSD,
                    currency_code: "USD",
                    breakdown: {
                        item_total: {
                            value: amountUSD,
                            currency_code: "USD"
                        }
                    }
                },
                items: [{
                    name: "<?= htmlspecialchars($data['product']->item_name) ?>",
                    description: "Quantity: <?= $data['quantity'] ?> <?= $data['product']->unit_type ?>",
                    quantity: "1",
                    unit_amount: {
                        value: amountUSD,
                        currency_code: "USD"
                    }
                }]
            }]
        });
    },

    onApprove: function(data, actions) {
        // Show processing status
        document.getElementById('payment-status').style.display = 'block';
        
        return actions.order.capture().then(function(details) {
            console.log('Payment completed:', details);
            
            // Send payment data to server
            return fetch('<?= URLROOT ?>/Marketplace/paypalSuccess', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'payment_id': details.id,
                    'payer_id': details.payer.payer_id,
                    'status': details.status
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Redirect to success page
                    window.location.href = '<?= URLROOT ?>/Marketplace/paymentSuccess';
                } else {
                    throw new Error(result.message);
                }
            });
        });
    },

    onError: function(err) {
        console.error('PayPal Error:', err);
        alert('Payment failed: ' + err.message);
        window.location.href = '<?= URLROOT ?>/Marketplace/paypalCancel';
    },

    onCancel: function(data) {
        console.log('Payment cancelled by user');
        window.location.href = '<?= URLROOT ?>/Marketplace/paypalCancel';
    }

}).render('#paypal-button-container');
</script>

<style>
.payment-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 0 1rem;
}
.payment-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    border: 1px solid #e1e5e9;
}
.product-summary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
}
.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
.summary-item.total {
    border-bottom: none;
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 0.5rem;
    padding-top: 1rem;
    border-top: 2px solid rgba(255,255,255,0.3);
}
.paypal-instructions {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    border-left: 4px solid #0070ba;
}
.test-credentials {
    background: white;
    padding: 1rem;
    border-radius: 6px;
    margin: 1rem 0;
    border: 1px solid #dee2e6;
}
.btn-outline {
    background: transparent;
    border: 2px solid #6c757d;
    color: #6c757d;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    border-radius: 8px;
    display: inline-block;
    transition: all 0.3s ease;
}
.btn-outline:hover {
    background: #6c757d;
    color: white;
    text-decoration: none;
}
.note {
    font-style: italic;
    color: #6c757d;
    margin-top: 1rem;
}
</style>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>