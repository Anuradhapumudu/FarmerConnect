<?php
/**
 * Sidebar Component
 *
 * Renders a role-specific sidebar based on the user's session type.
 * Include this component after the header on pages that need sidebar navigation.
 *
 * Requires: $_SESSION['user_type'] to be set
 * Dependencies: sidebar.css (loaded via minimalheader)
 */

$sidebarUserType = $_SESSION['user_type'] ?? '';

// Define sidebar links per role
$sidebarLinks = [];

switch ($sidebarUserType) {
    case 'farmer':
        $sidebarLinks = [
            ['url' => URLROOT . '/FarmerDashboard',         'icon' => 'fas fa-home',             'text' => 'Home',                  'tooltip' => 'Home'],
            ['url' => URLROOT . '/FarmerTimeline',           'icon' => 'fas fa-calendar-alt',     'text' => 'Cultivation Timeline',  'tooltip' => 'Cultivation Timeline'],
            ['url' => URLROOT . '/FertilizerCalculator',     'icon' => 'fas fa-calculator',       'text' => 'Fertilizer Calculator', 'tooltip' => 'Fertilizer Calculator'],
            ['url' => URLROOT . '/Disease/viewReports',      'icon' => 'fas fa-bug',              'text' => 'Disease Reports',       'tooltip' => 'Disease Reports'],
            ['url' => URLROOT . '/Knowledgecenter',          'icon' => 'fas fa-book',             'text' => 'Knowledge Center',      'tooltip' => 'Knowledge Center'],
            ['url' => URLROOT . '/Marketplace/farmer',       'icon' => 'fas fa-store',            'text' => 'Marketplace',           'tooltip' => 'Marketplace'],
            ['url' => URLROOT . '/Complaint/myComplaints',   'icon' => 'fas fa-comments',         'text' => 'Complaints',            'tooltip' => 'Complaints'],
        ];
        break;

    case 'officer':
        $sidebarLinks = [
            ['url' => URLROOT . '/OfficerDashboard',                    'icon' => 'fas fa-home',                        'text' => 'Home',                  'tooltip' => 'Home'],
            ['url' => URLROOT . '/officer/officertimeline',             'icon' => 'fas fa-calendar-alt',                'text' => 'Cultivation Timeline',  'tooltip' => 'Cultivation Timeline'],
            ['url' => URLROOT . '/officer/officerYellowCase',           'icon' => 'fa-solid fa-file-circle-exclamation', 'text' => 'Yellow Case Reports',   'tooltip' => 'Yellow Case Reports'],
            ['url' => URLROOT . '/officer/CalculatorOfficer',           'icon' => 'fas fa-calculator',                  'text' => 'Fertilizer Calculator', 'tooltip' => 'Fertilizer Calculator'],
            ['url' => URLROOT . '/Disease/viewReports',                 'icon' => 'fas fa-bug',                         'text' => 'Disease Reports',       'tooltip' => 'Disease Reports'],
            ['url' => URLROOT . '/Knowledgecenter',                     'icon' => 'fas fa-book',                        'text' => 'Knowledge Center',      'tooltip' => 'Knowledge Center'],
            ['url' => URLROOT . '/Complaint/myComplaints',              'icon' => 'fas fa-comments',                    'text' => 'Complaint Reports',     'tooltip' => 'Complaint Reports'],
        ];
        break;

    case 'seller':
        $sidebarLinks = [
            ['url' => URLROOT . '/SellerDashboard',                          'icon' => 'fas fa-home',  'text' => 'Home',             'tooltip' => 'Home'],
            ['url' => URLROOT . '/Marketplace/seller',                       'icon' => 'fas fa-store', 'text' => 'Marketplace',      'tooltip' => 'Marketplace'],
            ['url' => URLROOT . '/Knowledgecenter/KnowledgecenterSeller',    'icon' => 'fas fa-book',  'text' => 'Knowledge Center', 'tooltip' => 'Knowledge Center'],
        ];
        break;

    case 'admin':
        $sidebarLinks = [
            ['url' => URLROOT . '/AdminDashboard',                           'icon' => 'fas fa-home',               'text' => 'Home',                  'tooltip' => 'Home'],
            ['url' => URLROOT . '/Admin/CalculatorUpdate',                   'icon' => 'fas fa-calculator',         'text' => 'Fertilizer Calculator', 'tooltip' => 'Fertilizer Calculator'],
            ['url' => URLROOT . '/Disease/viewReports',                      'icon' => 'fas fa-bug',                'text' => 'Disease Reports',       'tooltip' => 'Disease Reports'],
            ['url' => URLROOT . '/Knowledgecenter/KnowledgecenterAdmin',     'icon' => 'fas fa-book',               'text' => 'Knowledge Center',      'tooltip' => 'Knowledge Center'],
            ['url' => URLROOT . '/Marketplace/admin',                        'icon' => 'fas fa-store',              'text' => 'Marketplace',           'tooltip' => 'Marketplace'],
            ['url' => URLROOT . '/Complaint/myComplaints',                   'icon' => 'fas fa-comments',           'text' => 'Complaints',            'tooltip' => 'Complaints'],
        ];
        break;
}

// Only render sidebar if the user has links
if (!empty($sidebarLinks)):
    // Determine active page from URL
    $currentUrl = $_SERVER['REQUEST_URI'] ?? '';
?>

<!-- Sidebar Toggle Checkbox -->
<input type="checkbox" id="sidebar-toggle">

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <ul class="sidebar-menu">
        <?php foreach ($sidebarLinks as $index => $link): ?>
            <li>
                <a href="<?php echo $link['url']; ?>"
                   data-tooltip="<?php echo htmlspecialchars($link['tooltip']); ?>"
                   <?php echo ($index === 0) ? 'class="active"' : ''; ?>>
                    <i class="<?php echo $link['icon']; ?>"></i>
                    <span class="menu-text"><?php echo htmlspecialchars($link['text']); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>

<!-- Overlay for closing sidebar -->
<label for="sidebar-toggle" class="sidebar-overlay"></label>

<?php endif; ?>
