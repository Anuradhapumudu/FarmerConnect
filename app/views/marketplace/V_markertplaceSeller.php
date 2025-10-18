<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- Marketplace-specific CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/seller/marketplaceSeller.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
     <div class="container">
    <!-- Page heading -->
    <h2 class="marketplace-heading">Marketplace</h2>
    <p class="marketplace-description">
      Discover premium agricultural products and services - one of many powerful tools in
      your complete farming platform.
    </p>

    <!-- Marketplace Cards -->
    <div class="features_block">
      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/Manage_Products.jpg');"></div>
        <div class="feature-bottom">
          <h3>Manage Products</h3>
          <p>Add, edit, or remove your listed items</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/ManageProduct" class="btn">Manage</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/track.webp');"></div>
        <div class="feature-bottom">
          <h3>Track Orders</h3>
          <p>View and manage customer orders.</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/SellerTrackOrders" class="btn">Shop Now</a>
        </div>
      </div>


      </div>
 </main>   

    <!-- Marketplace-specific JS -->
<?php require_once APPROOT . '/views/inc/footer.php'; ?>