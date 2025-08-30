    <!-- Footer -->
    <footer role="contentinfo" style="width: 100vw; margin-left: calc(-50vw + 50%); position: relative;">
        <div class="container" style="max-width: 100%; width: 100%; margin: 0; padding: 0 20px;">
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
                        <li role="listitem"><a href="<?php echo URLROOT; ?>">Home</a></li>
                        <li role="listitem"><a href="#features">Crop Timeline</a></li>
                        <li role="listitem"><a href="#expert-advice">Ask Agri Officer</a></li>
                        <li role="listitem"><a href="#quick-actions">Report Issues</a></li>
                        <li role="listitem"><a href="#marketplace">Seller Network</a></li>
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
</body>
</html>