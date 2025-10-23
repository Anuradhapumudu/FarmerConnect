<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/createannouncementnew.css">


<main class="main-content" id="mainContent">
    <h1>Edit Announcement</h1>
    <form method="POST" action="<?php echo URLROOT; ?>/Announcements/EditAnnouncements/edit/<?php echo $data['announcement_id']; ?>" enctype="multipart/form-data">
        <div class="input-group">
            <label for="title">Title<span class="required">*</span></label>
            <input type="text" name="title" id="title" required value="<?php echo $data['title']; ?>">
        </div>
        <div class="search-group">
          <label for="category">Category<span class="required">*</span></label>
          <select id="category" class="category" name="category" required value="<?php echo $data['category']; ?>">
            <option value="">Select Category</option>
            <option value="fertilizer" <?php echo ($data['category'] == 'fertilizer') ? 'selected' : ''; ?>>🌱 Fertilizer / Seeds Distribution Dates</option>
            <option value="warning" <?php echo ($data['category'] == 'warning') ? 'selected' : ''; ?>>⚠️ Disease or Pest Outbreak Warnings</option>
            <option value="training" <?php echo ($data['category'] == 'training') ? 'selected' : ''; ?>>📚 Training Workshops</option>
            <option value="policy" <?php echo ($data['category'] == 'policy') ? 'selected' : ''; ?>>📋 Policy Updates or New Government Schemas</option>
            <option value="other" <?php echo ($data['category'] == 'other') ? 'selected' : ''; ?>>📁 Other</option>
          </select>
        </div>
        <div class="input-group">
            <label for="content">Content<span class="required">*</span></label>
            <textarea name="content" id="content" rows="3" style="resize:vertical;"  required><?php echo $data['content']; ?></textarea>
        </div>
        <div class="input-group">
            <label for="attachFiles">Attach Files</label>
            <input type="file" name="attachFiles[]" id="attachFiles" multiple>
        </div>
        <div class="btn-group">
            <button type="submit" class="create-btn">Update</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='<?= URLROOT ?>/Announcements/Announcements'">Cancel</button>
        </div>
    </form>
</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>