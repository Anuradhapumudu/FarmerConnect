<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/addcategory.css">

<main class="main-content" id="mainContent">
    <h1>Edit Knowledge Article in <?php echo $data['category_name']; ?></h1>
    <form method="POST" action="<?php echo URLROOT; ?>/Knowledgecenter/editarticle/<?php echo $data['id']; ?>" enctype="multipart/form-data">
        <div class="input-group">
            <label for="category_name">Category</label>
            <input type="text" name="category_name" id="category_name" value="<?php echo $data['category_name']; ?>" readonly>
        </div>
        <div class="input-group">
            <label for="article_name">Article Name<span class="required">*</span></label>
            <input type="text" name="article_name" id="article_name" required value="<?php echo $data['article_name']; ?>">
        </div>
        <div class="input-group">
            <label for="description">Description<span class="required">*</span></label>
            <div class="toolbar">
                <label for="Toolbar" class="toolbar-label">Toolbar:</label>
                <button type="button" class="insert-image-btn" onclick="insertImage()"><i class="fas fa-image"></i> Insert Images</button>
                <button type="button" class="bold-btn" onclick="boldText()"><i class="fas fa-bold"></i></button>
            </div>
            <textarea name="description" id="description" rows="3" style="resize:vertical;"  required><?php echo $data['description']; ?></textarea>
            <input type="file" id="inlineImage" accept="image/*" style="display:none;">
        </div>
        <div class="input-group">
            <label for="category_image">Cover Image</label>
            <input type="file" name="category_image" id="category_image">
        </div>
        <div class="btn-group">
            <button type="submit" class="create-btn">Update</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='<?= URLROOT ?>/Knowledgecenter/category/<?php echo $data['category_id']; ?>'">Cancel</button>
        </div>
    </form>
</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>

<script>
    function insertImage() {
    document.getElementById('inlineImage').click();
    }

    document.getElementById('inlineImage').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('image', file);

    fetch('<?= URLROOT ?>/Knowledgecenter/uploadInlineImage', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        insertAtCursor(
        document.getElementById('description'),
        `<img src="${data.path}" alt="">`
        );
    });
    });

    function insertAtCursor(textarea, text) {
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const value = textarea.value;

    textarea.value =
        value.substring(0, start) +
        text +
        value.substring(end);

    textarea.selectionStart = textarea.selectionEnd = start + text.length;
    textarea.focus();
    }

    function boldText() {
        const textarea = document.getElementById('description');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        if (start === end) {
            alert('Please select text first');
            return;
        }
        const value = textarea.value;
        const selectedText = value.substring(start, end);
        let newText;

        if (selectedText.startsWith('<b>') && selectedText.endsWith('</b>')) {
            newText = selectedText.replace(/^<b>|<\/b>$/g, '');
        } else {
            newText = `<b>${selectedText}</b>`;
        }

        textarea.value =
            value.substring(0, start) +
            newText +
            value.substring(end);

        textarea.selectionStart = start;
        textarea.selectionEnd = start + newText.length;
        textarea.focus();
    }

</script>