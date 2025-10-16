// Initialize all components
document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    // Note: Sidebar initialization is handled by sidebarlink.js
});

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