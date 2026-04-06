<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/officer/view_announcements.css">

<div id="mainContent" class="announcement-view">
    <div class="announcement-detail-card">
        <a href="<?php echo URLROOT; ?>/Announcements#announcement-<?php echo $data['announcement']->announcement_id; ?>" class="clear-results">❌</a>
        <h1 class="announcement-title">
            
            <?php echo htmlspecialchars($data['announcement']->title); ?>
        </h1>
        
        <p class="announcement-date">
            Posted on: <?php echo date('d-m-Y', strtotime($data['announcement']->created_at)); ?>
        </p>

        <div class="announcement-content">
            <?php echo nl2br(htmlspecialchars($data['announcement']->content)); ?>
        </div>

        <?php if (!empty($data['announcement']->attachment_path)): ?>
            <div class="attachment-container">
            <?php 
                $attachments = explode(',', $data['announcement']->attachment_path);
                $imageCount = 0;

                foreach($attachments as $file): 
                    $fileUrl = URLROOT . '/' . $file;
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                    if(in_array($ext, ['jpg','jpeg','png','gif'])):
                        $imageCount++;
            ?>
                <div class="attachment-preview 
                    <?php echo ($imageCount > 4) ? 'extra-image hidden' : ''; ?>
                    <?php echo ($imageCount == 4) ? 'overlay-container' : ''; ?>">

                    <img src="<?php echo $fileUrl; ?>" alt="Attachment" class="preview-image">

                    <?php if($imageCount == 4): ?>
                        <div class="overlay" id="viewMoreBtn">View More</div>
                    <?php endif; ?>

                </div>

            <?php 
                    elseif($ext === 'pdf'): 
            ?>
                <div class="attachment-preview">
                    <embed src="<?php echo $fileUrl; ?>" type="application/pdf" class="preview-pdf">                          
                    <p><a href="<?php echo $fileUrl; ?>" target="_blank">📄 View PDF</a></p>
                </div>
            <?php 
                    endif;
                endforeach; 
            ?>
            </div>
        <?php endif; ?>

        <div class="back-link">
            <a href="<?php echo URLROOT; ?>/Announcements#announcement-<?php echo $data['announcement']->announcement_id; ?>">⬅ Back to Announcements</a>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

<script>
document.getElementById('viewMoreBtn')?.addEventListener('click', function() {
    document.querySelectorAll('.extra-image').forEach(el => {
        el.classList.remove('hidden');
    });
    this.style.display = 'none';
});
</script>