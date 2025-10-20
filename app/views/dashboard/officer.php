<?php require_once APPROOT . '/views/inc/officerdashboardheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/dashboard.css?v=<?= time(); ?>">

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1> Welcome Back to FarmerConnect.lk</h1>
    <p>Connect with agri experts, sellers, and a thriving farming community in Sri Lanka.</p>
    <!-- Get Started button -->
    <a href="#features" id="getStartedBtn" class="btn">Get Started</a>
  </div>
</section>

<!-- Features -->
<section id="features">
  <h2>Features</h2>
 
  <div class="features_block">

    <a href="<?php echo URLROOT; ?>/officer/officertimeline" class="feature">
      <i class="fa-solid fa-clock fa-2x"></i>
      <h3>Timeline</h3>
      <p>View assinged farmers timelines.</p>
    </a>

    <div class="feature">
      <i class="fa-solid fa-calculator fa-2x"></i>
      <h3>Yellow Case Reports</h3>
      <p>View Yellow case Reports and Reply to them.</p>
    </div>

    <div class="feature">
      <i class="fa-solid fa-virus fa-2x"></i>
      <h3>Disease Reports</h3>
      <p>View Disease Reports and Reply to them.</p>
    </div>

    <div class="feature">
      <i class="fa-solid fa-comments fa-2x"></i>
      <h3>Complain Reports</h3>
      <p>View Complaint Reports and Reply to them.</p>
    </div>

    <a href="<?php echo URLROOT; ?>/marketplace" class="feature">

      <i class="fa-solid fa-book-open fa-2x"></i>
      <h3>Knowledge Center</h3>
      <p>Make articles to Knowledge center.</p>
   
    </a>

    <div class="feature">
      <i class="fa fa-bullhorn"></i>
      <h3>Announcements</h3>
      <p>Make Announcements for farmers.</p>
    </div>

 

  </div>
</section>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>