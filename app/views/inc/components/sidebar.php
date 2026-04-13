<?php
/**
 * Sidebar Component — YouTube-style
 *
 * Clean, minimal sidebar with icon + label layout.
 * Collapsed = icons only. Expanded = icons + labels.
 * Role-specific navigation links with verified URLs.
 *
 * Requires: $_SESSION['user_type']
 * Dependencies: sidebar.css (loaded via minimalheader)
 */

$sidebarUserType = $_SESSION['user_type'] ?? '';
$sidebarLinks    = [];

switch ($sidebarUserType) {

    // ── Farmer ─────────────────────────────────────────────────────────────────
    case 'farmer':
        $sidebarLinks = [
            ['url' => URLROOT . '/FarmerDashboard',            'icon' => 'fas fa-house',          'text' => 'Home'],
            ['url' => URLROOT . '/FarmerProfile',              'icon' => 'fas fa-id-card',         'text' => 'My Profile'],
            ['url' => URLROOT . '/FarmerTimeline',             'icon' => 'fas fa-calendar-days',   'text' => 'Timeline'],
            ['url' => URLROOT . '/FertilizerCalculator',       'icon' => 'fas fa-calculator',      'text' => 'Fertilizer Calc'],
            ['url' => URLROOT . '/Disease/viewReports',        'icon' => 'fas fa-disease',         'text' => 'Disease Reports'],
            ['url' => URLROOT . '/Complaint/myComplaints',     'icon' => 'fas fa-comment-dots',    'text' => 'Complaints'],
            ['url' => URLROOT . '/Marketplace/farmer',         'icon' => 'fas fa-store',           'text' => 'Marketplace'],
            ['url' => URLROOT . '/Knowledgecenter',            'icon' => 'fas fa-book-open',       'text' => 'Knowledge Center'],
        ];
        break;

    // ── Officer ─────────────────────────────────────────────────────────────────
    case 'officer':
        $sidebarLinks = [
            ['url' => URLROOT . '/OfficerDashboard',               'icon' => 'fas fa-house',                   'text' => 'Home'],
            ['url' => URLROOT . '/Disease/viewReports',            'icon' => 'fas fa-disease',                 'text' => 'Disease Reports'],
            ['url' => URLROOT . '/Complaint/myComplaints',         'icon' => 'fas fa-comment-dots',            'text' => 'Complaints'],
            ['url' => URLROOT . '/officer/officertimeline',        'icon' => 'fas fa-calendar-days',           'text' => 'Farmer Timeline'],
            ['url' => URLROOT . '/officer/officerYellowCase',      'icon' => 'fas fa-file-circle-exclamation', 'text' => 'Yellow Cases'],
            ['url' => URLROOT . '/officer/CalculatorOfficer',      'icon' => 'fas fa-calculator',              'text' => 'Fertilizer Calc'],
            ['url' => URLROOT . '/Knowledgecenter',                'icon' => 'fas fa-book-open',               'text' => 'Knowledge Center'],
        ];
        break;

    // ── Seller ──────────────────────────────────────────────────────────────────
    case 'seller':
        $sidebarLinks = [
            ['url' => URLROOT . '/SellerDashboard',                        'icon' => 'fas fa-house',     'text' => 'Home'],
            ['url' => URLROOT . '/Marketplace/manageProduct',              'icon' => 'fas fa-box',       'text' => 'My Products'],
            ['url' => URLROOT . '/Marketplace/addProduct',                 'icon' => 'fas fa-plus',      'text' => 'Add Product'],
            ['url' => URLROOT . '/Marketplace/trackOrdersSeller',          'icon' => 'fas fa-truck',     'text' => 'Orders'],
            ['url' => URLROOT . '/Marketplace/seller',                     'icon' => 'fas fa-store',     'text' => 'Marketplace'],
            ['url' => URLROOT . '/Knowledgecenter',                        'icon' => 'fas fa-book-open', 'text' => 'Knowledge Center'],
        ];
        break;

    // ── Admin ───────────────────────────────────────────────────────────────────
    case 'admin':
        $sidebarLinks = [
            ['url' => URLROOT . '/AdminDashboard',                        'icon' => 'fas fa-house',          'text' => 'Home'],
            ['url' => URLROOT . '/Admin/UserList/sellerlist',             'icon' => 'fas fa-users',          'text' => 'User Management'],
            ['url' => URLROOT . '/Disease/viewReports',                   'icon' => 'fas fa-disease',        'text' => 'Disease Reports'],
            ['url' => URLROOT . '/Complaint/myComplaints',                'icon' => 'fas fa-comment-dots',   'text' => 'Complaints'],
            ['url' => URLROOT . '/Marketplace/admin',                     'icon' => 'fas fa-store',          'text' => 'Marketplace'],
            ['url' => URLROOT . '/Admin/CalculatorUpdate',                'icon' => 'fas fa-calculator',     'text' => 'Fertilizer Calc'],
            ['url' => URLROOT . '/Knowledgecenter',                       'icon' => 'fas fa-book-open',      'text' => 'Knowledge Center'],
        ];
        break;
}

if (empty($sidebarLinks)) return;

$currentPath = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
?>

<!-- Sidebar Toggle -->
<input type="checkbox" id="sidebar-toggle">

<!-- Sidebar -->
<aside class="sidebar" id="sidebar" role="navigation" aria-label="Sidebar">

    <ul class="sidebar-menu" role="menubar">
        <?php foreach ($sidebarLinks as $link):
            $linkPath = parse_url($link['url'], PHP_URL_PATH);
            $isActive = ($currentPath === $linkPath || strpos($currentPath, $linkPath . '/') === 0);
        ?>
        <li role="none">
            <a href="<?php echo htmlspecialchars($link['url']); ?>"
               class="sb-link<?php echo $isActive ? ' active' : ''; ?>"
               data-tooltip="<?php echo htmlspecialchars($link['text']); ?>"
               role="menuitem"
               aria-current="<?php echo $isActive ? 'page' : 'false'; ?>">
                <span class="sb-icon-wrap">
                    <i class="<?php echo htmlspecialchars($link['icon']); ?>"></i>
                </span>
                <span class="sb-link-text"><?php echo htmlspecialchars($link['text']); ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>

</aside>

<!-- Overlay -->
<label for="sidebar-toggle" class="sidebar-overlay" aria-hidden="true"></label>
