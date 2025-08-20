/**
 * Enhanced FarmerConnect Script (Fixed)
 * Features:
 * - Improved header with better positioned auth buttons
 * - Scroll-triggered stat counter animations
 * - Responsive mobile navigation
 * - Smooth scrolling and slider functionality
 * - Fixed viewport detection and performance optimizations
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initMobileMenu();
    initHeroSlider();
    initInteractiveElements();
    initSmoothScrolling();
    
    // Initialize scroll animations after a short delay to ensure DOM is fully loaded
    setTimeout(() => {
        initScrollAnimations();
        // Manually trigger scroll check in case page loads with section already visible
        const scrollEvent = new Event('scroll');
        window.dispatchEvent(scrollEvent);
    }, 300);
});

// ---------------- MOBILE MENU ----------------
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainNav = document.getElementById('mainNav');
    
    if (mobileMenuBtn && mainNav) {
        mobileMenuBtn.addEventListener('click', () => {
            mainNav.classList.toggle('active');
            mobileMenuBtn.innerHTML = mainNav.classList.contains('active') ? 
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mainNav.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mainNav.classList.remove('active');
                mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
    }
}

// ---------------- HERO SLIDER ----------------
function initHeroSlider() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 0;
    let slideInterval;
    
    if (slides.length === 0) return; // Exit if no slides found
    
    function showSlide(n) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) {
            dots[currentSlide].classList.add('active');
        }
    }
    
    function nextSlide() {
        showSlide(currentSlide + 1);
    }
    
    function startSlider() {
        slideInterval = setInterval(nextSlide, 5000);
    }
    
    function stopSlider() {
        if (slideInterval) {
            clearInterval(slideInterval);
        }
    }
    
    // Auto slide functionality
    startSlider();
    
    // Pause on hover
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopSlider);
        heroSection.addEventListener('mouseleave', startSlider);
    }
    
    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            stopSlider();
            setTimeout(startSlider, 3000); // Restart after 3 seconds
        });
    });
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', stopSlider);
}

// ---------------- SCROLL ANIMATIONS ----------------
function initScrollAnimations() {
    let statsAnimated = false;
    
    function handleScroll() {
        // Animate stats when they come into view
        if (!statsAnimated) {
            const userCountSection = document.getElementById('user-count');
            if (userCountSection && isElementInViewport(userCountSection, 0.7)) {  // Increased threshold
                animateStats();
                statsAnimated = true;
            }
        }
        
        animateOnScroll();
    }
    
    function isElementInViewport(el, threshold = 0.5) {
        const rect = el.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        const windowWidth = window.innerWidth || document.documentElement.clientWidth;
        
        const vertInView = (rect.top <= windowHeight * (1 - threshold)) && (rect.bottom >= windowHeight * threshold);
        const horInView = (rect.left <= windowWidth) && (rect.right >= 0);
        
        return vertInView && horInView;
    }
    
    let ticking = false;
    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(() => {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', onScroll, { passive: true });
    setTimeout(handleScroll, 100); // Initial check
}

// ---------------- STATS COUNTER ----------------
function animateStats() {
    const statElements = document.querySelectorAll('#user-count .stat-value');
    const animationDuration = 2500;
    
    if (statElements.length === 0) return;
    
    statElements.forEach(element => {
        const targetValue = parseInt(element.getAttribute('data-target')) || parseInt(element.textContent) || 0;
        if (targetValue === 0) return;
        
        if (!element.getAttribute('data-target')) {
            element.setAttribute('data-target', targetValue);
        }
        
        // Reset to 0 for animation
        element.textContent = '0';
        
        animateValue({
            element,
            start: 0,
            end: targetValue,
            duration: animationDuration
        });
    });
}

function animateValue(config) {
    let startTimestamp = null;
    
    function step(timestamp) {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / config.duration, 1);
        
        const easedProgress = 1 - Math.pow(1 - progress, 3);
        const currentValue = Math.floor(easedProgress * (config.end - config.start) + config.start);
        
        config.element.textContent = currentValue.toLocaleString();
        
        const scaleValue = Math.max(1, 1 + (easedProgress * 0.1));
        const hueValue = Math.max(142, Math.min(162, 142 + (easedProgress * 20)));
        
        config.element.style.transform = `scale(${scaleValue})`;
        config.element.style.color = `hsl(${hueValue}, 71%, 45%)`;
        
        if (progress < 1) {
            requestAnimationFrame(step);
        } else {
            config.element.style.transform = 'scale(1)';
            config.element.textContent = config.end.toLocaleString();
            config.element.style.color = '';
        }
    }
    
    requestAnimationFrame(step);
}

// ---------------- SCROLL EFFECTS ----------------
function animateOnScroll() {
    const elements = document.querySelectorAll('.feature-card, .action-card, .seller-card, .advice-item');
    
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        
        if (elementPosition < screenPosition && elementPosition > -element.offsetHeight) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
}

// ---------------- SMOOTH SCROLLING ----------------
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '#!') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const header = document.querySelector('header');
                const headerHeight = header ? header.offsetHeight : 70;
                const targetPosition = targetElement.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: Math.max(0, targetPosition),
                    behavior: 'smooth'
                });
                
                const mainNav = document.getElementById('mainNav');
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                if (mainNav && mainNav.classList.contains('active')) {
                    mainNav.classList.remove('active');
                    if (mobileMenuBtn) {
                        mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            }
        });
    });
}

// ---------------- INTERACTIVE ELEMENTS ----------------
function initInteractiveElements() {
    // Only animate elements that are not in the user-count section
    const animatedElements = document.querySelectorAll('#features .feature-card, .action-card, .seller-card, .advice-item');
    animatedElements.forEach(element => {
        if (element) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'all 0.8s ease';
        }
    });
    
    const fab = document.querySelector('.fab');
    if (fab) {
        fab.addEventListener('click', () => {
            alert('Chat support feature coming soon!');
        });
    }
    
    const newsletter = document.querySelector('.newsletter');
    if (newsletter) {
        newsletter.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = e.target.querySelector('input[type="email"]');
            if (emailInput && emailInput.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailRegex.test(emailInput.value.trim())) {
                    alert('Thank you for subscribing! We\'ll send you farming tips and updates.');
                    emailInput.value = '';
                } else {
                    alert('Please enter a valid email address.');
                }
            } else {
                alert('Please enter your email address.');
            }
        });
    }
    
    document.querySelectorAll('.contact-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            try {
                const sellerCard = e.target.closest('.seller-card');
                const sellerNameElement = sellerCard ? sellerCard.querySelector('.seller-name') : null;
                const sellerName = sellerNameElement ? sellerNameElement.textContent : 'this seller';
                alert(`Contacting ${sellerName}... This feature will be available soon!`);
            } catch (error) {
                alert('Contact feature will be available soon!');
            }
        });
    });
    
    function handleHeaderScroll() {
        const header = document.querySelector('header');
        if (!header) return;
        
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        if (currentScroll > 100) {
            header.style.background = 'rgba(255,255,255,0.95)';
            header.style.boxShadow = '0 4px 20px rgba(34,197,94,0.15)';
            header.style.backdropFilter = 'blur(12px)';
        } else {
            header.style.background = 'var(--glass-bg)';
            header.style.boxShadow = '0 2px 10px rgba(34,197,94,0.08)';
            header.style.backdropFilter = 'var(--glass-blur)';
        }
    }
    
    let headerTicking = false;
    window.addEventListener('scroll', () => {
        if (!headerTicking) {
            requestAnimationFrame(() => {
                handleHeaderScroll();
                headerTicking = false;
            });
            headerTicking = true;
        }
    }, { passive: true });
    
    handleHeaderScroll(); // Initial
}

// ---------------- UTILITIES ----------------
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func.apply(this, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(this, args);
    };
}

window.addEventListener('resize', debounce(() => {
    const elements = document.querySelectorAll('.feature-card, .action-card, .seller-card, .advice-item');
    elements.forEach(element => {
        if (element.style.opacity === '1') {
            element.style.transform = 'translateY(0)';
        }
    });
}, 250), { passive: true });

window.addEventListener('error', (e) => {
    console.error('FarmerConnect Script Error:', e.error);
});

if (typeof window !== 'undefined') {
    window.FarmerConnect = {
        animateStats,
        initScrollAnimations,
        initHeroSlider
    };
}

// Dark Mode Toggle
document.addEventListener("DOMContentLoaded", function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    let darkMode = localStorage.getItem('darkMode') === 'true';

    if (darkMode) {
        document.body.classList.add('dark-mode');
        darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        darkModeToggle.style.background = 'var(--accent)';
    }

    darkModeToggle.addEventListener('click', function() {
        darkMode = !darkMode;
        document.body.classList.toggle('dark-mode');
        darkModeToggle.innerHTML = darkMode ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        darkModeToggle.style.background = darkMode ? 'var(--accent)' : 'var(--primary)';
        localStorage.setItem('darkMode', darkMode);
    });
});