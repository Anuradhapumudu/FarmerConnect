<?php require_once APPROOT . '/views/inc/sellerdashboardheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/dashboard.css?v=<?= time(); ?>">

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1>Welcome to FarmerConnect.lk</h1>
    <p>Connect with agri experts, sellers, and a thriving farming community in Sri Lanka.</p>
    <!-- Get Started button -->
    <a href="#features" id="getStartedBtn" class="btn">Get Started</a>
  </div>
</section>

<!-- Features -->
<section id="features">
  <h2>Features</h2>

  <div class="features_block">

    <a href="<?php echo URLROOT; ?>/Marketplace/seller" class="feature">
      <i class="fa-solid fa-store fa-2x"></i>
      <h3>Marketplace</h3>
      <p>Sell and rent produce, equipment, and services with ease.</p>
    </a>

    <a href="<?php echo URLROOT; ?>/Knowledgecenter/KnowledgecenterSeller" class="feature">
      <i class="fa-solid fa-book-open fa-2x"></i>
      <h3>Knowledge Center</h3>
      <p>Access guides, tutorials, and expert advice on agriculture.</p>
    </a>

  </div>
</section>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>
