<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/login.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/help/publicHelp.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="<?php echo URLROOT; ?>/js/register.js" defer></script>
    <title>Login | FarmerConnect</title>
</head>
<body>
    <main>
        <div class="container">
            <!-- Left Side (Image Section) -->
            <div class="image-section">
                <img src="<?php echo URLROOT; ?>/img/login_img_desktop.jpeg" class="desktop-img" alt="Farmer Connect">
                <img src="<?php echo URLROOT; ?>/img/login_img_mobile.jpeg" class="mobile-img" alt="Farmer Connect">
            </div>
            <!-- Right Side (Form Section) -->
             <div class="form-section">
   
            <div class="signin">
                    <h1>Help</h1>
            </div>

          <section class="help-section">

            
            <div class="team-section">

                
                <div class="team-grid">
                     <?php foreach($data['members'] as $member): ?>
                    <div class="team-member">
                        <div class="member-name"><?= htmlspecialchars($member->name) ?></div>
                        <div class="member-role"><?= htmlspecialchars($member->type) ?></div>
                        <div class="member-contact">
                        <p> <i class="fas fa-phone"></i> <?= htmlspecialchars($member->phone) ?></p></div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
            
            
            <div class="emergency-contact">
                <h3>Emergency Contact</h3>
                <div class="emergency-number">
                    <?= htmlspecialchars($data['emergencyNumber']->phone ?? 'Not set') ?>
                </div>
                <p class="emergency-text">
                    Available 24/7 for urgent agricultural issues requiring immediate assistance
                </p>
      
              </section>
                

                <hr class="horizontal-line">
                    <div class="new-account">
                    <p>Don't have an account ? <a href="<?php echo URLROOT; ?>/users/register">Register Here</a></p>

                </div>
            </div> 
        </div>
    </main>
</body>
