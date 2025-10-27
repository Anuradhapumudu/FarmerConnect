<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/officer/create_announcements.css?v=<?php echo time(); ?>">

<main class="main-content" id="mainContent">
    <div class="success-container">
        <div class="success-header">
            <i class="fa-solid fa-circle-check"></i>
            <h2>Announcement Created Successfully!</h2>
            <p>Your announcement has been submitted and published successfully.</p>
        </div>

        <div class="announcement-preview">
            <h3><?php echo htmlspecialchars($data['title']); ?></h3>
            <p class="category">
                <strong>Category:</strong>
                <?php 
                    switch($data['category']) {
                        case 'fertilizer': echo '🌱 Fertilizer / Seeds Distribution Dates'; break;
                        case 'warning': echo '⚠️ Disease or Pest Outbreak Warnings'; break;
                        case 'training': echo '📚 Training Workshops'; break;
                        case 'policy': echo '📋 Policy Updates or New Government Schemas'; break;
                        default: echo '📁 Other';
                    }
                ?>
            </p>

            <div class="announcement-content">
                <?php echo nl2br(htmlspecialchars($data['content'])); ?>
            </div>

            <?php if (!empty($data['attachment_path'])): ?>
                <div class="attachments">
                    <h4>📎 Attachments</h4>
                    <ul>
                        <?php 
                        $files = explode(',', $data['attachment_path']);
                        foreach ($files as $file): 
                            $filename = basename($file);
                        ?>
                            <li><a href="<?php echo URLROOT . '/' . $file; ?>" target="_blank"><?php echo $filename; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="btn-section">
            <a href="<?php echo URLROOT; ?>/Announcements" class="back-btn">
                ← Back to Announcements
            </a>
        </div>
    </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
