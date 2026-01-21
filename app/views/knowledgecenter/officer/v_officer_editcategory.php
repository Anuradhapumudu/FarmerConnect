<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/addcategory.css">

<main class="main-content" id="mainContent">
    <h1>Edit Knowledge Category</h1>
    <form method="POST" action="<?php echo URLROOT; ?>/Knowledgecenter/editcategory/<?php echo $data['id']; ?>" enctype="multipart/form-data">
        <div class="input-group">
            <label for="category_name">Category Name<span class="required">*</span></label>
            <input type="text" name="category_name" id="category_name" required value="<?php echo $data['category_name']; ?>">
        </div>
        <div class="input-group">
            <label for="description">Description<span class="required">*</span></label>
            <textarea name="description" id="description" rows="3" style="resize:vertical;"  required><?php echo $data['description']; ?></textarea>
        </div>
        <div class="input-group">
            <label for="category_image">Cover Image</label>
            <input type="file" name="category_image" id="category_image">
        </div>
        <div class="btn-group">
            <button type="submit" class="create-btn">Update</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='<?= URLROOT ?>/Knowledgecenter'">Cancel</button>
        </div>
    </form>
</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>