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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/translate.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/minimalheader-modern.css">
  <script src="<?php echo URLROOT; ?>/js/minimalheader-modern.js" defer></script>
</head>

<?php
$userType = $_SESSION['user_type'] ?? '';
$userId = $_SESSION['user_id'] ?? ($_SESSION['nic'] ?? 'Guest');
$sessionFirstName = trim((string) ($_SESSION['first_name'] ?? ''));
$sessionFullName = trim((string) ($_SESSION['full_name'] ?? ''));

$dashboardUrl = URLROOT . '/';
$profileUrl = URLROOT . '/ProfileView';
$roleLabel = 'User';

switch ($userType) {
  case 'farmer':
    $dashboardUrl = URLROOT . '/FarmerDashboard';
    $profileUrl = URLROOT . '/FarmerProfile';
    $roleLabel = 'Verified Farmer';
    break;
  case 'officer':
    $dashboardUrl = URLROOT . '/OfficerDashboard';
    $profileUrl = URLROOT . '/ProfileView';
    $roleLabel = 'Agriculture Officer';
    break;
  case 'seller':
    $dashboardUrl = URLROOT . '/SellerDashboard';
    $profileUrl = URLROOT . '/ProfileView';
    $roleLabel = 'Marketplace Seller';
    break;
  case 'admin':
    $dashboardUrl = URLROOT . '/AdminDashboard';
    $profileUrl = URLROOT . '/ProfileView';
    $roleLabel = 'Administrator';
    break;
}

$displayName = 'FarmerConnect User';
if ($sessionFirstName !== '') {
  $displayName = $sessionFirstName;
} elseif ($sessionFullName !== '') {
  $displayName = strtok($sessionFullName, ' ');
} elseif (trim((string) $userId) !== '') {
  $displayName = (string) $userId;
}

if ($userType === 'farmer' && preg_match('/^\d{8,}$/', $displayName)) {
  $displayName = 'Farmer';
}

$initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $displayName), 0, 2));
if ($initials === '') {
  $initials = 'FC';
}
?>

<body class="minimal-layout">
  <input type="checkbox" id="mobile-menu-toggle">
  <label for="mobile-menu-toggle" class="mobile-overlay"></label>

  <header id="mainHeader">
    <div class="header-container">
      <div class="logo-container notranslate">
        <a href="<?php echo URLROOT; ?>" class="logo">
          <div class="logo-icon">
            <img src="<?php echo URLROOT; ?>/img/logo.png" alt="FarmerConnect.lk Logo" width="42" height="42">
          </div>
          <span class="logo-text">Farmer<em>Connect</em>.lk</span>
        </a>
      </div>

      <nav class="navbar" aria-label="Main navigation">
        <div class="nav-links" id="navLinks">
          <?php require APPROOT . '/views/inc/components/translate.php'; ?>
          <span class="nav-divider"></span>
          <a href="<?php echo $dashboardUrl; ?>" data-nav="true"><i class="fas fa-home"></i> Home</a>
          <a href="<?php echo URLROOT; ?>/Announcements" data-nav="true"><i class="fas fa-bullhorn"></i> Announcements</a>
          <a href="<?php echo URLROOT; ?>/Help/help" data-nav="true"><i class="fas fa-circle-question"></i> Help</a>
        </div>

        <div class="user-menu-wrapper" id="userMenuWrapper">
          <button class="user-trigger" id="userTrigger" aria-haspopup="true" aria-expanded="false" type="button">
            <div class="user-avatar"><?php echo htmlspecialchars($initials); ?></div>
            <div class="user-info">
              <span class="user-name"><?php echo htmlspecialchars($displayName); ?></span>
              <span class="user-role"><?php echo htmlspecialchars($roleLabel); ?></span>
            </div>
            <i class="fas fa-chevron-down user-chevron"></i>
          </button>

          <div class="user-dropdown" id="userDropdown" role="menu">
            <div class="dropdown-header">
              <div class="dropdown-avatar"><?php echo htmlspecialchars($initials); ?></div>
              <div class="dropdown-user-info">
                <div class="dropdown-user-name"><?php echo htmlspecialchars($displayName); ?></div>
                <div class="dropdown-user-id"><?php echo htmlspecialchars(strtoupper($userType)); ?> account</div>
                <span class="dropdown-user-badge"><i class="fas fa-circle-check"></i> <?php echo htmlspecialchars($roleLabel); ?></span>
              </div>
            </div>

            <div class="dropdown-section">
              <div class="dropdown-label">Account</div>
              <a href="<?php echo $profileUrl; ?>" class="dropdown-item" role="menuitem">
                <span class="item-icon"><i class="fas fa-user"></i></span>
                <span class="item-text">My Profile<span class="item-sub">View and edit your details</span></span>
                <span class="item-trail"><i class="fas fa-chevron-right"></i></span>
              </a>
              <a href="<?php echo $dashboardUrl; ?>" class="dropdown-item" role="menuitem">
                <span class="item-icon"><i class="fas fa-chart-line"></i></span>
                <span class="item-text">Dashboard<span class="item-sub">Quick access to your workspace</span></span>
                <span class="item-trail"><i class="fas fa-chevron-right"></i></span>
              </a>
              <a href="<?php echo URLROOT; ?>/Announcements" class="dropdown-item" role="menuitem">
                <span class="item-icon"><i class="fas fa-bell"></i></span>
                <span class="item-text">Announcements<span class="item-sub">Latest platform updates</span></span>
                <span class="item-trail"><i class="fas fa-chevron-right"></i></span>
              </a>
            </div>

            <div class="dropdown-section">
              <div class="dropdown-label">Support</div>
              <a href="<?php echo URLROOT; ?>/Help/help" class="dropdown-item" role="menuitem">
                <span class="item-icon"><i class="fas fa-circle-question"></i></span>
                <span class="item-text">Help Center<span class="item-sub">Guides and support tickets</span></span>
                <span class="item-trail"><i class="fas fa-chevron-right"></i></span>
              </a>
            </div>

            <div class="dropdown-section">
              <a href="<?php echo URLROOT; ?>/users/logout" class="dropdown-item danger" role="menuitem">
                <span class="item-icon"><i class="fas fa-right-from-bracket"></i></span>
                <span class="item-text">Sign Out</span>
              </a>
            </div>
          </div>
        </div>

        <label for="mobile-menu-toggle" class="mobile-menu-label" aria-label="Toggle navigation menu">
          <i class="fas fa-bars"></i>
        </label>
      </nav>
    </div>
  </header>

  <button id="toTopBtn" aria-label="Back to top"></button>
