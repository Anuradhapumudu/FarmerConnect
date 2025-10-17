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
</head>

<body>
  <!-- Hidden checkboxes for state management -->
  <input type="checkbox" id="sidebar-toggle">
  <input type="checkbox" id="mobile-menu-toggle">

  <!-- Header -->
  <header>
    <div class="header-container">
      <div class="logo-container">
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
          <a href="<?php echo URLROOT; ?>/farmerdashboard"><i class="fa fa-home"></i> Home</a>
          <a href="<?php echo URLROOT; ?>/Announcements/Announcements"><i class="fa fa-bullhorn"></i> Announcement</a>
          <a href="<?php echo URLROOT; ?>/Help/V_help"><i class="fa fa-question-circle"></i> Help</a>
          <a href="<?php echo URLROOT; ?>/FarmerProfile"><i class="fa-regular fa-circle-user"></i> Profile</a>
        </div>

        <!-- Mobile menu toggle -->
        <label for="mobile-menu-toggle" class="mobile-menu-label" aria-label="Toggle navigation menu">
          <i class="fas fa-bars"></i>
        </label>
      </nav>
    </div>
  </header>

  <!-- Mobile menu overlay -->
  <label for="mobile-menu-toggle" class="mobile-overlay"></label>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <ul class="sidebar-menu">
      <li><a href="<?php echo URLROOT; ?>/FarmerDashboard" class="active" data-tooltip="Home">
        <i class="fas fa-home"></i>
        <span class="menu-text">Home</span>
      </a></li>
      <li><a href="<?php echo URLROOT; ?>/FarmerTimeline" data-tooltip="Cultivation Timeline">
        <i class="fas fa-calendar-alt"></i>
        <span class="menu-text">Cultivation Timeline</span>
      </a></li>
      <li><a href="<?php echo URLROOT; ?>/FertilizerCalculator" data-tooltip="Fertilizer Calculator">
        <i class="fas fa-calculator"></i>
        <span class="menu-text">Fertilizer Calculator</span>
      </a></li>
      <li><a href="<?php echo URLROOT; ?>/Disease" data-tooltip="Disease Detector">
        <i class="fas fa-bug"></i>
        <span class="menu-text">Disease Detector</span>
      </a></li>
      <li><a href="<?php echo URLROOT; ?>/Knowledgecenter/KnowledgecenterFarmer" data-tooltip="Knowledge Center">
        <i class="fas fa-book"></i>
        <span class="menu-text">Knowledge Center</span>
      </a></li>
      <li><a href="<?php echo URLROOT; ?>/Marketplace/MarketplaceFarmer" data-tooltip="Marketplace">
        <i class="fas fa-store"></i>
        <span class="menu-text">Marketplace</span>
      </a></li>
      <li><a href="<?php echo URLROOT; ?>/Help/help" data-tooltip="Complain">
        <i class="fas fa-exclamation-circle"></i>
        <span class="menu-text">Complain</span>
      </a></li>
    </ul>
  </aside>

  <!-- Overlay for closing sidebar -->
  <label for="sidebar-toggle" class="sidebar-overlay"></label>
