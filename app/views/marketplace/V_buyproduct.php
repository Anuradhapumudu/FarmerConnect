<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/buyproduct.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

<?php 
$product = $data['product'];

$price       = floatval($product->price_per_unit);
$region      = htmlspecialchars($product->region);
$itemName    = htmlspecialchars($product->item_name);
$sellerName  = htmlspecialchars($product->seller_name);
$imageUrl    = URLROOT . '/uploads/' . htmlspecialchars($product->image_url);
$available   = intval($product->available_quantity);
$description = htmlspecialchars($product->description);
$seller_telNo = htmlspecialchars($product->seller_telNo);
$status       = htmlspecialchars($product->status);
$unit_type    = htmlspecialchars($product->unit_type ?? '');
$province     = htmlspecialchars($product->province ?? '');
$district     = htmlspecialchars($product->district ?? '');
$address      = htmlspecialchars($product->seller_address ?? '');
?>

<div class="buy-container">
    <h2><i class="fas fa-shopping-cart"></i> Confirm Buy Product</h2>

    <div class="product-card">
        <img src="<?= $imageUrl ?>" alt="<?= $itemName ?>">

        <div class="product-info">
            <p><b>Product Name:</b> <?= $itemName ?></p>
            <p><b>Price per Unit:</b> Rs. <?= number_format($price, 2) ?></p>
            <p><b>Available Quantity:</b> <?= $available ?></p>
            <p><b>Unit Type:</b> <?= $unit_type ?></p>
            <p><b>Seller Name:</b> <?= $sellerName ?></p>
            <p><b>Seller Address:</b> <?= $address ?>, <?= $district ?>, <?= $province ?></p>
            <p><b>Seller Contact:</b> <?= $seller_telNo ?></p>
            <p><b>Seller Region:</b> <?= $region ?></p>
            <p><b>Description:</b> <?= $description ?></p>
        </div>

        <form method="post" class="buy-form">
            <label>
                <b>Quantity:</b>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $available ?>" onchange="updateTotal()">
            </label>

            <p class="total-price">
                Total Price: Rs. <span id="total"><?= number_format($price, 2) ?></span>
            </p>

            <input type="submit" value="Buy Now" class="btn btn-primary">
        </form>

    </div>
</div>

<script>
function updateTotal() {
    let qty = document.getElementById("quantity").value;
    let price = <?= $price ?>;
    document.getElementById("total").innerText = (qty * price).toFixed(2);
}
</script>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/marketplace.css?v=<?= time(); ?>">

</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
