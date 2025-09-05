<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- Marketplace-specific CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/addsuccess.css?v=<?= time(); ?>">

<div class="sucess_wrapper">
<div class="sucess_card">
    <div class="sucess_icon">✔</div>
    <h2>Product Added Successfully!</h2>
    <p>Your product has been successfully added to the system. It will be reviewed and made available shortly.</p>

    <button 
  class="sucess sucess_btn-primary" 
  onclick="window.location.href='<?= URLROOT ?>/Marketplace/AddProduct';">
  Add Another Product
  </button>

<button 
  class="sucess sucess_btn-secondary" 
  onclick="window.location.href='<?= URLROOT ?>/Marketplace/ManageProduct';">
  View All Products
</button>

</div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
