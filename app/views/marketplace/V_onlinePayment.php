<script src="https://www.payhere.lk/lib/payhere.js"></script>

<h3>Online Payment</h3>
<button id="payBtn" class="btn btn-success">Pay Online</button>

<script>
payhere.onCompleted = function(orderId) {
    window.location.href = "<?= URLROOT ?>/Marketplace/paymentSuccess";
};

payhere.onDismissed = function() {
    alert("Payment cancelled");
};

payhere.onError = function(error) {
    alert("PayHere error: " + error);
};

var payment = <?= json_encode($payhere, JSON_UNESCAPED_SLASHES) ?>;

document.getElementById("payBtn").onclick = function () {
    payhere.startPayment(payment);
};
</script>
