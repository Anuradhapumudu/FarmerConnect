<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/help/help.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

   <!-- Help Section -->
    <section class="help-section">
        <div class="containers">
            <div class="section-title">
                <h1>Help Center</h1>
                <p>Get in touch with our dedicated agricultural support team for assistance</p>
            </div>
            
            <div class="team-section">
                <div class="section-title">
                    <h2>Our Support Team</h2>
                    <p>Meet our dedicated agricultural experts ready to assist you</p>
                </div>
                
                <div class="team-grid">
                     <?php foreach($data['members'] as $member): ?>
                        <?php
                            $img = $member->image ?? '';
                            if (empty($img)) {
                                $imgUrl = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
                            } elseif (strpos($img, 'http') === 0) {
                                $imgUrl = $img;
                            } else {
                                $imgUrl = URLROOT . '/' . $img;
                            }
                        ?>
                    <div class="team-member">
                        <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($member->name) ?>" class="member-img">
                        <div class="member-name"><?= htmlspecialchars($member->name) ?></div>
                        <div class="member-role"><?= htmlspecialchars($member->type) ?></div>
                        <div class="member-contact">
                        <p> <i class="fas fa-phone"></i> <?= htmlspecialchars($member->phone) ?></p>
                        
                           
                        </div>
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
        </div>
    </section>
</main>

<script src="<?php echo URLROOT; ?>/js/help.js?v=<?= time(); ?>"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>