<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/buyproduct.css?v=<?= time(); ?>">



<main class="main-content" id="mainContent">

<div class="containers">
  <h2><i class="fas fa-shopping-cart"></i> Confirm Buy Product</h2>

  <img src="<?= URLROOT ?>/uploads/<?= htmlspecialchars($data['product']->image_url) ?>" alt="Product Image">

  <p><b>Product Name:</b> <?= htmlspecialchars($data['product']->item_name) ?></p>
  <p><b>Price per Unit:</b> Rs. <?= number_format($data['product']->price_per_unit,2) ?></p>
  <p><b>Available Quantity:</b> <?= $data['product']->available_quantity ?></p>

  <form method="post" class="button-container">
    <label><b>Quantity:</b> 
      <input type="number" id="quantity" name="quantity" value="1" min="1" 
             max="<?= $data['product']->available_quantity ?>" onchange="updateTotal()">
    </label>
    
    <p class="total">Total Price: Rs. 
      <span id="total"><?= number_format($data['product']->price_per_unit,2) ?></span>
    </p>
    
    <input type="submit" value="Buy Now">
  </form>

  <p class="note">This is a dummy buy system for testing orders only.</p>
</div>

<script>
function updateTotal() {
    let qty = document.getElementById("quantity").value;
    let price = <?= $data['product']->price_per_unit ?>;
    document.getElementById("total").innerText = (qty * price).toFixed(2);
}
</script>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/marketplace.css?v=<?= time(); ?>">

</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
