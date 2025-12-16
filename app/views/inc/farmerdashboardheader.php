<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo SITENAME; ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo URLROOT; ?>/img/logo.png">
  <link rel="apple-touch-icon" href="<?php echo URLROOT; ?>/img/logo.png">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/sidebar.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/translate.css">
  <script src="<?php echo URLROOT; ?>/js/movebtn.js" defer></script>
</head>
<body>

    
<!-- Hidden checkbox -->
  <input type="checkbox" id="mobile-menu-toggle" hidden>

  <!-- Mobile overlay -->
  <div class="mobile-overlay"></div>
  <header>
    <div class="header-container">
      <div class="logo-container notranslate">
        <!-- Sidebar toggle - uses label for checkbox -->
        <label for="sidebar-toggle" class="sidebar-toggle-label" aria-label="Toggle sidebar">
          <i class="fas fa-bars"></i>
        </label>
        <a href="<?php echo URLROOT; ?>" class="logo">
          <div class="logo-icon">
            <img src="<?php echo URLROOT; ?>/img/logo.png" alt="FarmerConnect.lk Logo" width="50" height="50">
          </div>
          <span class="logo-text">FarmerConnect.lk</span>
        </a>
      </div>

      <nav class="navbar">
        <div class="nav-links" id="navLinks">
          <!-- translator -->
          <?php require APPROOT . '/views/inc/components/translate.php'; ?>
          <!-- main links -->
          <a href="<?php echo URLROOT; ?>/farmerdashboard"><i class="fa fa-home"></i> Home</a>
          <a href="<?php echo URLROOT; ?>/Announcements"><i class="fa fa-bullhorn"></i> Announcement</a>
          <a href="<?php echo URLROOT; ?>/Help/help"><i class="fa fa-question-circle"></i> Help</a>
          <a href="<?php echo URLROOT; ?>/FarmerProfile"><i class="fa-regular fa-circle-user"></i> Profile</a>
        </div>

        

        

        <!-- Mobile menu toggle -->
        <label for="mobile-menu-toggle" class="mobile-menu-label" aria-label="Toggle navigation menu">
          <i class="fas fa-bars"></i>
        </label>
      </nav>
    </div>
  </header>
  <button id="toTopBtn">↑</button>
