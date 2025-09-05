<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- Marketplace-specific CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/adderror.css?v=<?= time(); ?>">

<div class="error_wrapper">
<div class="error_card">
    <div class="error_icon">❌</div>
    <h2>Product Not Added!</h2>
    <p>Please check your inputs and try again!</p>

    <button 
  class="sucess error_btn-primary" 
  onclick="window.location.href='<?= URLROOT ?>/Marketplace/AddProduct';">
  Add Another Product
  </button>

<button 
  class="sucess error_btn-secondary" 
  onclick="window.location.href='<?= URLROOT ?>/Marketplace/ManageProduct';">
  View All Products
</button>

</div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
