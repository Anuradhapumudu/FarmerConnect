<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/knowledgecenter.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="containers">

    <h2 class="knowledgecenter-heading">Knowledge Center</h2>
    <p class="knowledgecenter-description">
      Explore expert insights, guides, and resources – empowering you with the knowledge to grow smarter and farm better.
    </p>

    <div class="features_block">
        <?php foreach($data['categories'] as $category): ?>
          <div class="feature-card">
            <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/public/<?php echo $category->image_path; ?>');"></div>
            <div class="feature-bottom">
              <h3><?php echo $category->category_name; ?></h3>
              <p><?php echo $category->description; ?></p>
              <a href="<?php echo URLROOT; ?>/Knowledgecenter/category/<?php echo $category->id; ?>" class="btn">Read More</a>
            </div>
          </div>
        <?php endforeach; ?>
    </div>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>