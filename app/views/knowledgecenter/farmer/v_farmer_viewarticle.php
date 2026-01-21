<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/knowledgearticles.css">

<main class="main-content" id="mainContent">
    <div class="container">
        <div class="article-container">
            <div class="article-box expanded">
                <div class="article-inner">
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
