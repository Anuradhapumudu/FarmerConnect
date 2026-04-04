
<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/marketplaceDashboard.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
     <div class="containers">
    
    <h2 class="marketplace-heading">Marketplace</h2>
    <p class="marketplace-description">
     Expand your agricultural business reach - connect with thousands of farmers seeking quality products. 
    </p>

    <!-- Marketplace Cards -->
    <div class="sellerfeatures_block">
      <div class="sellerfeature-card">
        <div class="sellerfeature-top" style="background-image: url('<?php echo URLROOT; ?>/img/Manage_Products.jpg');"></div>
        <div class="sellerfeature-bottom">
          <h3>Manage Products</h3>
          <p>Add, edit, or remove your listed items</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/manageProduct" class="btn">Manage</a>
        </div>
      </div>

      <div class="sellerfeature-card">
        <div class="sellerfeature-top" style="background-image: url('<?php echo URLROOT; ?>/img/track.webp');"></div>
        <div class="sellerfeature-bottom">
          <h3>Track Orders</h3>
          <p>View and manage customer orders.</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/trackOrdersSeller" class="btn">Shop Now</a>
        </div>
      </div>


      </div>
 </main>   


<?php require_once APPROOT . '/views/inc/footer.php'; ?>