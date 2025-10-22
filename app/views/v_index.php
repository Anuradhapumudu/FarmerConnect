<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmerConnect.lk - Smart Farming Made Easy</title>
    <meta name="description" content="Connect with agricultural experts, track crop growth, and find trusted sellers. Your complete farming solution platform.">
    <meta name="keywords" content="farming, agriculture, crop timeline, agricultural officers, farming equipment, Sri Lanka">
    <meta name="author" content="FarmerConnect.lk">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="FarmerConnect.lk - Smart Farming Made Easy">
    <meta property="og:description" content="Connect with agricultural experts, track crop growth, and find trusted sellers.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://farmerconnect.lk">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo URLROOT; ?>/img/download.png">
    <link rel="apple-touch-icon" href="<?php echo URLROOT; ?>/img/logo.png">

    <!-- Preload critical resources -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/homepage.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/translate.css">

    <script src="<?php echo URLROOT; ?>/js/homepage.js" defer></script>
    <script src="<?php echo URLROOT; ?>/js/translate.js" defer></script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" defer></script>
</head>

<body>
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content" class="sr-only sr-only-focusable">Skip to main content</a>

    <!-- Header -->
    <header role="banner" style="position: fixed; top: 0; left: 0; right: 0; z-index: 2000;">
        <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>
        <div class="container header-container">
            <a href="#home" class="logo" aria-label="FarmerConnect.lk Homepage">
                <div class="logo-icon">
                    <img src="<?php echo URLROOT; ?>/img/logo.png" alt="FarmerConnect.lk Logo" width="50" height="50">
                </div>
                <div class="logo-text">FarmerConnect.lk</div>
            </a>

            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mainNav">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>

            <nav id="mainNav" role="navigation" aria-label="Main navigation">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Services</a></li>
                    <li><a href="#quick-actions">Quick Actions</a></li>
                    <li><a href="#expert-advice">Expert Advice</a></li>
                    <li><a href="#marketplace">Marketplace</a></li>
                </ul>
            </nav>

            <div class="nav-signup-buttons">
                <a href="<?php echo URLROOT; ?>/users/login" class="btn" aria-label="Login to your account">
                    <span>Login</span>
                </a>
                <p aria-hidden="true">or</p>
                <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline" aria-label="Create new account">
                    <span>Register</span>
                </a>
            </div>

            <!-- Language Selector -->
            <?php require APPROOT . '/views/inc/components/translate.php'; ?>
        </div>
    </header>

    <!-- Floating signup buttons for mobile -->
    <div class="signup-buttons" aria-label="Account actions">
    <a href="<?php echo URLROOT; ?>/users/login" class="btn" aria-label="Login to your account">
            <span>Login</span>
        </a>
        <p aria-hidden="true">or</p>
    <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline" aria-label="Create new account">
            <span>Register</span>
        </a>
    </div>

    <!-- Main Content -->
    <main id="main-content">
        <!-- Hero Slider -->
        <section class="hero" id="home" aria-label="Hero section with featured content">
            <div class="slider" role="region" aria-label="Image slider" aria-live="polite">
                <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');" role="img" aria-label="Smart farming landscape">
                    <div class="slide-content">
                        <h1>Smart Farming Made Easy</h1>
                        <p>Get expert agricultural advice, track your crop growth, and connect with trusted sellers all in one place.</p>
                        <div class="hero-btns">
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn" aria-label="Login to explore crop timeline">
                                <span>Explore Crop Timeline</span>
                            </a>
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-outline" aria-label="Login to ask agricultural experts">
                                <span>Ask an Expert</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');" role="img" aria-label="Agricultural officers helping farmers">
                    <div class="slide-content">
                        <h1>Connect With Agri Officers</h1>
                        <p>Get real-time solutions to your farming problems from certified agricultural officers.</p>
                        <div class="hero-btns">
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn" aria-label="Login to report farming issue">
                                <span>Report an Issue</span>
                            </a>
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-outline" aria-label="Login to view answered questions">
                                <span>View Questions</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1464226184884-fa280b87c399?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');" role="img" aria-label="Farmers connecting with trusted sellers">
                    <div class="slide-content">
                        <h1>Find Trusted Sellers</h1>
                        <p>Connect with verified sellers for seeds, fertilizers, equipment and market your produce.</p>
                        <div class="hero-btns">
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn" aria-label="Login to browse marketplace">
                                <span>Browse Sellers</span>
                            </a>
                            <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline" aria-label="Register as a seller">
                                <span>Register as Seller</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-nav" role="tablist" aria-label="Slider navigation">
                <button class="slider-dot active" role="tab" aria-selected="true" aria-label="Go to slide 1" data-slide="0"></button>
                <button class="slider-dot" role="tab" aria-selected="false" aria-label="Go to slide 2" data-slide="1"></button>
                <button class="slider-dot" role="tab" aria-selected="false" aria-label="Go to slide 3" data-slide="2"></button>
            </div>
        </section>

        <!-- User Count Section -->
        <section class="features" id="user-count" aria-labelledby="user-count-title">
            <div class="container">
                <h2 id="user-count-title" class="section-title">Join Our Growing Community</h2>

                <div class="features-grid" role="list">
                    <div class="stat-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Active Farmers</h3>
                        <p>Dedicated farmers using our platform to improve their agricultural practices and productivity.</p>
                        <div class="stat-value" data-target="2847" aria-label="2847 active farmers">0</div>
                    </div>

                    <div class="stat-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3>Agri Officers</h3>
                        <p>Certified agricultural officers ready to help solve your farming challenges 24/7.</p>
                        <div class="stat-value" data-target="156" aria-label="156 agricultural officers">0</div>
                    </div>

                    <div class="stat-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-store"></i>
                        </div>
                        <h3>Verified Sellers</h3>
                        <p>Trusted sellers providing quality inputs and buying produce with verified ratings.</p>
                        <div class="stat-value" data-target="892" aria-label="892 verified sellers">0</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Marketplace -->
        <section class="marketplace" id="marketplace" aria-labelledby="marketplace-title">
            <div class="container">
                <h2 id="marketplace-title" class="section-title">Buy Agricultural Products</h2>
                <p class="marketplace-description">Discover premium agricultural products and services - you can buy everything you need for successful farming.</p>

                <!-- Marketplace Cards -->
                <div class="features-grid" role="list">
                    <div class="feature-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <img src="<?php echo URLROOT; ?>/img/fertilizer.jpg" alt="Fertilizer" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <h3>Fertilizer</h3>
                        <p>High-quality fertilizers for optimal crop growth</p>
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn">Shop Now</a>
                    </div>

                    <div class="feature-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <img src="<?php echo URLROOT; ?>/img/paddy seed.webp" alt="Paddy Seeds" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <h3>Paddy Seeds</h3>
                        <p>Premium paddy seeds for better paddy fields</p>
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn">Shop Now</a>
                    </div>

                    <div class="feature-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <img src="<?php echo URLROOT; ?>/img/Agrochemicals.jpg" alt="Agrochemicals" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <h3>Agrochemicals</h3>
                        <p>Effective crop chemicals for crop disease</p>
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn">Shop Now</a>
                    </div>

                    <div class="feature-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <img src="<?php echo URLROOT; ?>/img/equipments.jpg" alt="Equipments" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <h3>Equipments</h3>
                        <p>Buy essential farming tools and equipment</p>
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn">Shop Now</a>
                    </div>

                    <div class="feature-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <img src="<?php echo URLROOT; ?>/img/Agricultural_machinery.jpg" alt="Machinery" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <h3>Rent Machinery</h3>
                        <p>Rent heavy machinery for your farming needs</p>
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn">Shop Now</a>
                    </div>

                    <div class="feature-card" role="listitem">
                        <div class="feature-icon" aria-hidden="true">
                            <img src="<?php echo URLROOT; ?>/img/collage.jpg" alt="Others" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <h3>Others</h3>
                        <p>Additional agricultural supplies and services</p>
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn">Shop Now</a>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 40px;">
                    <a href="<?php echo URLROOT; ?>/users/login" class="btn" aria-label="Login to browse all products">
                        <span>Browse All Products</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FarmerConnect.lk</h3>
                    <p>Empowering farmers with technology and expert knowledge to improve agricultural productivity and connect with markets across Sri Lanka.</p>
                    <div class="social-links">
                        <a href="#" class="social-facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="#" class="social-twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" class="social-instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        <a href="#" class="social-youtube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links" role="list">
                        <li role="listitem"><a href="#home">Home</a></li>
                        <li role="listitem"><a href="#features">Crop Timeline</a></li>
                        <li role="listitem"><a href="#expert-advice">Ask Agri Officer</a></li>
                        <li role="listitem"><a href="#quick-actions">Report Issues</a></li>
                        <li role="listitem"><a href="#marketplace">Seller Network</a></li>
                        <li role="listitem"><a href="./pages/about.html">About Us</a></li>
                        <li role="listitem"><a href="<?php echo URLROOT; ?>/pages/about.html">About Us</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul class="footer-links" role="list">
                        <li role="listitem"><a href="<?php echo URLROOT; ?>/pages/farming-guides.html">Farming Guides</a></li>
                        <li role="listitem"><a href="<?php echo URLROOT; ?>/pages/weather.html">Weather Forecast</a></li>
                        <li role="listitem"><a href="<?php echo URLROOT; ?>/pages/market-prices.html">Market Prices</a></li>
                        <li role="listitem"><a href="<?php echo URLROOT; ?>/pages/government-schemes.html">Government Schemes</a></li>
                        <li role="listitem"><a href="<?php echo URLROOT; ?>/pages/faq.html">FAQ</a></li>
                        <li role="listitem"><a href="<?php echo URLROOT; ?>/pages/contact.html">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Newsletter</h3>
                    <p>Subscribe to get farming tips, weather updates, and agricultural news.</p>
                    <form class="newsletter" action="<?php echo URLROOT; ?>/api/newsletter-signup" method="POST" aria-label="Newsletter signup">
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input type="email" id="newsletter-email" name="email" placeholder="Enter your email address" required aria-describedby="newsletter-help">
                        <small id="newsletter-help" class="sr-only">We'll send you helpful farming tips and updates. You can unsubscribe anytime.</small>
                        <button type="submit" class="btn" style="width: 100%; padding: 10px; margin-top: 8px;">
                            <span>Subscribe</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 FarmerConnect.lk. All Rights Reserved. |
                    <a href="<?php echo URLROOT; ?>/pages/privacy-policy.html" style="color: var(--primary);">Privacy Policy</a> |
                    <a href="<?php echo URLROOT; ?>/pages/terms-of-service.html" style="color: var(--primary);">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Floating Action Button -->
    <!-- <button class="fab" title="Chat with our support team" aria-label="Open chat support" id="chatSupport">
        <i class="fas fa-comment-dots" aria-hidden="true"></i>
    </button> -->

    <!-- Dark Mode Toggle Button -->
    <!-- <button class="dark-mode-toggle" id="darkModeToggle" aria-label="Toggle between light and dark mode" title="Toggle dark mode">
        <i class="fas fa-moon" aria-hidden="true"></i>
    </button> -->

    <!-- Screen reader only styles -->
    <noscript>
        <style>
            .slider-nav { display: none; }
            .mobile-menu-btn { display: none; }
            .dark-mode-toggle { display: none; }
        </style>
        <div style="background: #fef3cd; color: #856404; padding: 10px; text-align: center; border: 1px solid #ffeaa7;">
            For the best experience, please enable JavaScript in your browser.
        </div>
    </noscript>
</body>
</html>