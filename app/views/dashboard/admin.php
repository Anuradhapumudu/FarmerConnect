<?php require_once APPROOT . '/views/inc/admindashboardheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/dashboard2.css?v=<?= time(); ?>">

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1> Welcome Back to FarmerConnect.lk</h1>
    <p>Connect with agri experts, sellers, and a thriving farming community in Sri Lanka.</p>
    <!-- Get Started button -->
    <a href="#features" id="getStartedBtn" class="btn">Get Started</a>
  </div>
</section>


<!-- User Roles -->
  <section>
    <h2>Who We Serve</h2>
    <div class="user_Information">

      <a href="<?php echo URLROOT; ?>/Admin/UserList/farmerlist" class="actor-link">
        <div class="actor">
          <i class="fa-solid fa-tractor fa-2x"></i>
          <h3>Farmers</h3>
          <p>Grow better with expert advice and resources.</p>
        </div>
      </a>

      <a href="<?php echo URLROOT; ?>/Admin/UserList/officerlist" class="actor-link">
      <div class="actor">
        <i class="fa-solid fa-seedling fa-2x"></i>
        <h3>Agri Officers</h3>
        <p>Guide farmers with reliable tools and updates.</p>
      </div>
      </a>

      <a href="<?php echo URLROOT; ?>/Admin/UserList/sellerlist" class="actor-link">
      <div class="actor">
        <i class="fa-solid fa-store fa-2x"></i>
        <h3>Seller Agents</h3>
        <p>Expand your market and connect with farmers.</p>
      </div>
      </a>
    </div>
  </section>

  
<!-- Features -->
<section id="features">
  <h2>Features</h2>
 
  <div class="features_block">



    <a href="<?php echo URLROOT; ?>/admin/CalculatorUpdate" class="feature">
      <i class="fa-solid fa-calculator fa-2x"></i>
      <h3>Fertilizer Calculator</h3>
      <p>Get accurate fertilizer recommendations based on crop and soil.</p>
    </a>

   <a href="<?php echo URLROOT; ?>/disease/viewReports" class="feature">
      <i class="fa-solid fa-virus fa-2x"></i>
      <h3>Disease Reports</h3>
      <p>Stay informed about pest and crop disease outbreaks in your area.</p>
    </a>

    <a href="<?php echo URLROOT; ?>/Knowledgecenter/KnowledgecenterAdmin" class="feature">
      <i class="fa-solid fa-book-open fa-2x"></i>
      <h3>Knowledge Center</h3>
      <p>Access guides, tutorials, and expert advice on agriculture.</p>
    </a>

    <a href="<?php echo URLROOT; ?>/Marketplace/admin" class="feature">

      <i class="fa-solid fa-store fa-2x"></i>
      <h3>Marketplace</h3>
      <p>Buy and sell produce, equipment, and services with ease.</p>
   
    </a>

    <a href="<?php echo URLROOT; ?>/complain/admincomplaints" class="feature">
      <i class="fa-solid fa-comments fa-2x"></i>
      <h3>Complain</h3>
      <p>Report issues directly to the relevant agricultural authorities.</p>
    </a>

 

  </div>
</section>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>