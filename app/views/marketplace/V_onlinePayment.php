<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="buy-container">
    <h2>Online Payment 🔗</h2>
    <p>Redirecting to sandbox payment...</p>

    <form action="SANDBOX_PAYMENT_URL" method="POST" id="sandboxForm">
        <input type="hidden" name="item_id" value="<?= htmlspecialchars($data['product_id']) ?>">
        <input type="hidden" name="quantity" value="<?= htmlspecialchars($data['quantity']) ?>">
        <input type="hidden" name="amount" value="<?= htmlspecialchars($data['quantity'] * $data['price'] ?? 0) ?>">
        <button type="submit">Proceed to Payment</button>
    </form>
</div>
<script>
document.getElementById('sandboxForm').submit();
</script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
