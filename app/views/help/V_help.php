<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/help/help.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

   <!-- Help Section -->
    <section class="help-section">
        <div class="container">
            <div class="section-title">
                <h2>Help Center</h2>
                <p>Get in touch with our dedicated agricultural support team for assistance</p>
            </div>
            
            <div class="team-section">
                <div class="section-title">
                    <h2>Our Support Team</h2>
                    <p>Meet our dedicated agricultural experts ready to assist you</p>
                </div>
                
                <div class="team-grid">
                    <div class="team-member">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Rajesh Kumar" class="member-img">
                        <div class="member-name">Rajesh Kumar</div>
                        <div class="member-role">Agricultural Officer</div>
                        <div class="member-contact">
                            <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                           
                        </div>
                    </div>
                    
                    <div class="team-member">
                        <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Vikram Singh" class="member-img">
                        <div class="member-name">Vikram Singh</div>
                        <div class="member-role">Agricultural Officer</div>
                        <div class="member-contact">
                            <p><i class="fas fa-phone"></i> +91 96543 21098</p>
                            
                        </div>
                    </div>
                    
                    <div class="team-member">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sunita Patel" class="member-img">
                        <div class="member-name">Sunita Patel</div>
                        <div class="member-role">Admin Support</div>
                        <div class="member-contact">
                            <p><i class="fas fa-phone"></i> +91 95432 10987</p>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="emergency-contact">
                <h3>Emergency Contact</h3>
                <div class="emergency-number">+91 90000 12345</div>
                <p class="emergency-text">Available 24/7 for urgent agricultural issues requiring immediate assistance</p>
        </div>
    </section>
</main>

    <script>

        
        // Simulate loading of team member images with fallback
        document.querySelectorAll('.member-img').forEach(img => {
            img.onerror = function() {
                this.src = "data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%22%20height%3D%22100%22%20viewBox%3D%220%200%20100%20100%22%3E%3Crect%20width%3D%22100%22%20height%3D%22100%22%20fill%3D%22%234CAF50%22%20%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20font-size%3D%2236%22%20fill%3D%22white%22%3E%3Ctspan%20x%3D%2250%25%22%20dy%3D%22.35em%22%3E%3C%2Ftspan%3E%3C%2Ftext%3E%3C%2Fsvg%3E";
            };
        });
    </script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>