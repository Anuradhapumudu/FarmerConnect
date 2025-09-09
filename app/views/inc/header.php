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
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <ul class="sidebar-menu">
      <li><a href="#" class="active" data-tooltip="Home">
        <i class="fas fa-home"></i>
        <span class="menu-text">Home</span>
      </a></li>
      <li><a href="#" data-tooltip="Cultivation Timeline">
        <i class="fas fa-calendar-alt"></i>
        <span class="menu-text">Cultivation Timeline</span>
      </a></li>
      <li><a href="#" data-tooltip="Fertilizer Calculator">
        <i class="fas fa-calculator"></i>
        <span class="menu-text">Fertilizer Calculator</span>
      </a></li>
      <li><a href="#" data-tooltip="Disease Detector">
        <i class="fas fa-bug"></i>
        <span class="menu-text">Disease Detector</span>
      </a></li>
      <li><a href="#" data-tooltip="Knowledge Center">
        <i class="fas fa-book"></i>
        <span class="menu-text">Knowledge Center</span>
      </a></li>
      <li><a href="#" data-tooltip="Marketplace">
        <i class="fas fa-store"></i>
        <span class="menu-text">Marketplace</span>
      </a></li>
      <li><a href="#" data-tooltip="Complain">
        <i class="fas fa-exclamation-circle"></i>
        <span class="menu-text">Complain</span>
      </a></li>
    </ul>
  </div>

  <!-- Overlay for sidebar -->
  <div class="overlay" id="overlay"></div>

  <!-- Header -->
  <header>
    <div class="header-container">
      <div class="logo-container">
        <button id="sidebarToggleNav" class="sidebar-toggle-nav">
          <i class="fas fa-bars"></i>
        </button>
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
          <a href="#"><i class="fa fa-question-circle"></i> Help</a>
          <a href="#"><i class="fa-regular fa-circle-user"></i> Profile</a>
        </div>

        <button id="mobileMenuBtn" class="mobile-menu-btn" aria-label="Toggle navigation menu">
          <i class="fas fa-bars"></i>
        </button>
      </nav>
    </div>
  </header>