<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/knowledgearticles.css">

<main class="main-content" id="mainContent">
    <div class="container">
        <div class="article-container">
            <div class="article-box expanded">
                <div class="article-inner">
                    <div class="article-options">
                        <i class="fas fa-ellipsis-v menu-dots" onclick="toggleOptions(this)"></i>
                        <div class="options-menu">
                            <a href="<?php echo URLROOT; ?>/Knowledgecenter/editarticle/<?php echo $data['article']->id; ?>" class="option-item">Edit</a>
                            <a href="<?php echo URLROOT; ?>/Knowledgecenter/deletearticle/<?php echo $data['article']->id; ?>" class="option-item" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                        </div>
                    </div>
                    
                    <div class="feature-top">
                        <img src="<?php echo URLROOT; ?>/public/<?php echo $data['article']->image_path; ?>" alt="<?php echo $data['article']->article_name; ?>" class="article-image">
                    </div>
                    <div class="article-text-container">
                        <h3><?php echo $data['article']->article_name; ?></h3>
                        <div class="article-text"><?php echo nl2br($data['article']->description); ?></div>
                    </div>
                </div>
            </div>
            <a href="<?php echo URLROOT; ?>/Knowledgecenter/category/<?php echo $data['article']->category_id; ?>" class="back-btn">← Back to Articles</a>
        </div>
    </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

<script>
  function toggleOptions(element) {
    const options = element.nextElementSibling;
    const isOpen = options.style.display === 'block';
    document.querySelectorAll('.options-menu').forEach(menu => {
      menu.style.display = 'none';
    });
    options.style.display = isOpen ? 'none' : 'block';
  }
  document.addEventListener('click', function(event) {
    if (!event.target.classList.contains('menu-dots')) {
      document.querySelectorAll('.options-menu').forEach(menu => {
        menu.style.display = 'none';
      });
    }
  });
</script>