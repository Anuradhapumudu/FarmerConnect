<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- Marketplace-specific CSS -->

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/marketplace.css?v=<?= time(); ?>">



<main class="main-content" id="mainContent">
  <div class="container">
    <!-- My Orders Button -->
    <div class="myOrders">
      <button onclick="window.location.href='my_orders.php'">
        <i class="fa fa-shopping-cart"></i> My Orders
      </button>
    </div>

    <h2 class="marketplace-heading">Marketplace</h2>
    <p class="marketplace-description">
      Discover premium agricultural products and services - one of many powerful tools in
      your complete farming platform.
    </p>

    <!-- Marketplace Cards -->
    <div class="features_block">
      <div class="feature-card">
        <div class="feature-top" style="background-image: url('img/fertilizer.jpg');"></div>
        <div class="feature-bottom">
          <h3>Fertilizer</h3>
          <p>High-quality fertilizers for optimal crop growth</p>
          <a href="view_products.php" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('img/paddy seed.webp');"></div>
        <div class="feature-bottom">
          <h3>Paddy Seeds</h3>
          <p>Premium paddy seeds for better paddy fields</p>
          <a href="#" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('img/Agrochemicals.jpg');"></div>
        <div class="feature-bottom">
          <h3>Agrochemicals</h3>
          <p>Effective crop chemicals for crop disease</p>
          <a href="#" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('img/equipments.jpg');"></div>
        <div class="feature-bottom">
          <h3>Equipments</h3>
          <p>Buy essential farming tools and equipment</p>
          <a href="#" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('img/Agricultural_machinery.jpg');"></div>
        <div class="feature-bottom">
          <h3>Rent Machinery</h3>
          <p>Rent heavy machinery for your farming needs</p>
          <a href="#" class="btn">Shop Now</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('img/collage.jpg');"></div>
        <div class="feature-bottom">
          <h3>Others</h3>
          <p>Additional agricultural supplies and services</p>
          <a href="#" class="btn">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/components/sidebarlink.php'; ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>