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

  <!-- Scripts -->
  <script src="<?php echo URLROOT; ?>/js/default.js" defer></script>
</head>
<body>

<!-- Hidden checkbox -->
  <input type="checkbox" id="mobile-menu-toggle" hidden>

  <!-- Mobile overlay -->
  <div class="mobile-overlay"></div>
  <!-- Header -->
  <header>
    <div class="header-container">
      <div class="logo-container">
        <a href="#" class="logo">
          <div class="logo-icon">
            <img src="<?php echo URLROOT; ?>/img/logo.png" alt="FarmerConnect.lk Logo" width="50" height="50">
          </div>
          <span class="logo-text">FarmerConnect.lk</span>
        </a>
      </div>

      <nav class="navbar">
        <div class="nav-links" id="navLinks">
          <a href="#"><i class="fa fa-home"></i> Home</a>
          <a href="#"><i class="fa fa-bullhorn"></i> Announcement</a>
          <a href="<?php echo URLROOT; ?>/Help/helpSeller"><i class="fa fa-question-circle"></i> Help</a>
          <a href="<?php echo URLROOT; ?>/ProfileView/sellerProfile"><i class="fa-regular fa-circle-user"></i> Profile</a>
        </div>

       <!-- Mobile menu toggle -->
        <label for="mobile-menu-toggle" id="mobileMenuBtn" class="mobile-menu-label">
          <i class="fas fa-bars"></i>
        </label>
      </nav>
    </div>
  </header>
