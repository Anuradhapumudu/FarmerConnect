<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- Marketplace-specific CSS -->

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/marketplace.css?v=<?= time(); ?>">


<main class="main-content" id="mainContent">
  <div class="containers">
    <div class="marketplace-header">
      <h1 class="marketplace-heading">Marketplace</h1>
    </div>

    <p class="marketplace-description">
      Discover premium agricultural products and services - one of many powerful tools in
      your complete farming platform.
    </p>

    <div class="marketplace-actions">
      <div class="myOrders">
        <a href="<?php echo URLROOT; ?>/Marketplace/trackOrdersFarmer">
          <button>
            <i class="fa fa-shopping-cart"></i> My Orders
          </button>
        </a>
      </div>
    </div>

    <!-- Marketplace Cards -->
    <div class="features_block">
      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/fertilizer.jpg');"></div>
        <div class="feature-bottom">
          <h3>Fertilizer</h3>
          <p>High-quality fertilizers for optimal crop growth</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/viewProduct/fertilizer" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/paddy seed.webp');"></div>
        <div class="feature-bottom">
          <h3>Paddy Seeds</h3>
          <p>Premium paddy seeds for better paddy fields</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/viewProduct/paddy-seeds" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/Agrochemicals.jpg');"></div>
        <div class="feature-bottom">
          <h3>Agrochemicals</h3>
          <p>Effective crop chemicals for crop disease</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/viewProduct/agrochemicals" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/equipments.jpg');"></div>
        <div class="feature-bottom">
          <h3>Equipments</h3>
          <p>Buy essential farming tools and equipment</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/viewProduct/equipments" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/Agricultural_machinery.jpg');"></div>
        <div class="feature-bottom">
          <h3>Rent Machinery</h3>
          <p>Rent heavy machinery for your farming needs</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/viewProduct/machinery" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/collage.jpg');"></div>
        <div class="feature-bottom">
          <h3>Others</h3>
          <p>Additional agricultural supplies and services</p>
          <a href="<?php echo URLROOT; ?>/Marketplace/viewProduct/others" class="btn">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>