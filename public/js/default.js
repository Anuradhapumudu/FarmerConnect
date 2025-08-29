// Initialize all components
document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initSidebar();
});

// ---------------- SIDEBAR ----------------
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggleNav = document.getElementById('sidebarToggleNav');
    const mainContent = document.getElementById('mainContent');
    const footer = document.getElementById('footer');
    const overlay = document.getElementById('overlay');
    
    if (!sidebar || !sidebarToggleNav) return;
    
    function toggleSidebar() {
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            // Mobile behavior - slide in/out from left
            sidebar.classList.toggle('expanded');
            if (overlay) {
                overlay.classList.toggle('active');
            }
            // Prevent body scrolling when sidebar is open on mobile
            if (sidebar.classList.contains('expanded')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        } else {
            // Desktop behavior - expand/collapse in place
            sidebar.classList.toggle('expanded');
            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }
            if (footer) {
                footer.classList.toggle('expanded');
            }
        }
    }
    
    function closeSidebar() {
        sidebar.classList.remove('expanded');
        if (mainContent) {
            mainContent.classList.remove('expanded');
        }
        if (footer) {
            footer.classList.remove('expanded');
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
        document.body.style.overflow = 'auto';
    }
    
    sidebarToggleNav.addEventListener('click', toggleSidebar);
    
    // Close sidebar when clicking on overlay (mobile)
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar when clicking on sidebar links (mobile)
    const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768 && sidebar.classList.contains('expanded')) {
                closeSidebar();
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', () => {
        const isMobile = window.innerWidth <= 768;
        
        if (!isMobile) {
            // Reset mobile states when switching to desktop
            if (overlay) {
                overlay.classList.remove('active');
            }
            document.body.style.overflow = 'auto';
        } else {
            // Reset desktop states when switching to mobile
            if (mainContent) {
                mainContent.classList.remove('expanded');
            }
            if (footer) {
                footer.classList.remove('expanded');
            }
        }
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('expanded') && window.innerWidth <= 768) {
            closeSidebar();
        }
    });
}

// ---------------- MOBILE MENU ----------------
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    const overlay = document.getElementById('overlay');
    
    if (!mobileMenuBtn || !navLinks) return;
    
    // Initialize aria-expanded attribute
    mobileMenuBtn.setAttribute('aria-expanded', 'false');
    
    function openMobileMenu() {
        navLinks.classList.add('active');
        mobileMenuBtn.setAttribute('aria-expanded', 'true');
        mobileMenuBtn.innerHTML = '<i class="fas fa-times" aria-hidden="true"></i>';
        document.body.style.overflow = 'hidden';
        if (overlay) {
            overlay.classList.add('active');
        }
    }
    
    function closeMobileMenu() {
        navLinks.classList.remove('active');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenuBtn.innerHTML = '<i class="fas fa-bars" aria-hidden="true"></i>';
        document.body.style.overflow = 'auto';
        if (overlay) {
            overlay.classList.remove('active');
        }
    }
    
    function toggleMobileMenu() {
        const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
        if (isExpanded) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }
    
    mobileMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileMenu();
    });
    
    // Close menu when clicking on links
    const navLinksItems = document.querySelectorAll('.nav-links a');
    navLinksItems.forEach(link => {
        link.addEventListener('click', () => {
            if (navLinks.classList.contains('active')) {
                closeMobileMenu();
            }
        });
    });
    
    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navLinks.classList.contains('active')) {
            closeMobileMenu();
        }
    });
    
    // Close mobile menu when clicking on overlay
    if (overlay) {
        overlay.addEventListener('click', () => {
            if (navLinks.classList.contains('active')) {
                closeMobileMenu();
            }
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.navbar') && !e.target.closest('.nav-links') && navLinks.classList.contains('active')) {
            closeMobileMenu();
        }
    });
    
    // Handle window resize - close mobile menu when switching to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
            closeMobileMenu();
        }
    });
}

// Note: Active link management is now handled by sidebarlink.js for sidebar links
// Only handle header navigation links here if needed
const activePage = window.location.pathname.split("/").pop();
const navLinks = document.querySelectorAll('.nav-links a');
navLinks.forEach(link => {
    if (link.href.includes(`${activePage}`)) {
        link.classList.add('active');
    }
});