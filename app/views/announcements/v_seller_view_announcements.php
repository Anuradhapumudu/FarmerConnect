<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/officer/view_announcements.css">

<div id="mainContent" class="announcement-view">
    <div class="announcement-detail-card">
        <a href="<?php echo URLROOT; ?>/Announcements/Announcements#announcement-<?php echo $data['announcement']->announcement_id; ?>" class="clear-results">❌</a>
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
            <p><a href="<?php echo URLROOT . '/' . $data['announcement']->attachment_path; ?>" target="_blank">📎 View Attachment</a></p>
        <?php endif; ?>

        <div class="back-link">
            <a href="<?php echo URLROOT; ?>/Announcements/Announcements#announcement-<?php echo $data['announcement']->announcement_id; ?>">⬅ Back to Announcements</a>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
