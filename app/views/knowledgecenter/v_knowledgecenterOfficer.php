<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>
<!-- Knowledge Center-specific CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/knowledgecenter.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<main class="main-content" id="mainContent">
  <div class="containers">

    <div class="top-actions">
      <button class="add-article-btn"><i class="fa-solid fa-pen-to-square"></i> Add Article</button>
    </div>

    <h2 class="knowledgecenter-heading">Knowledge Center</h2>
    <p class="knowledgecenter-description">
      Explore expert insights, guides, and resources – empowering you with the knowledge to grow smarter and farm better.
    </p>

    <!-- knowledgecenter Cards -->
    <div class="features_block">
      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/rice-varieties.jpg');"></div>
        <div class="feature-bottom">
          <h3>Rice Varieties</h3>
          <p>Explore high-yield and climate-smart rice types.</p>
          <a href="<?php echo URLROOT; ?>/knowledgecenter/KnowledgecenterOfficer/ricevarieties" class="btn">Read More</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/fertilizer.jpg');"></div>
        <div class="feature-bottom">
          <h3>Fertilizer Management</h3>
          <p>Smart fertilizer use for better crop nutrition.</p>
          <a href="<?php echo URLROOT; ?>/knowledgecenter/KnowledgecenterOfficer/fertilizer" class="btn">Read More</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/pest-control.jpg');"></div>
        <div class="feature-bottom">
          <h3>Pest Control</h3>
          <p>Best practices to control pests and protect your crops.</p>
          <a href="<?php echo URLROOT; ?>/Knowledgecenter/viewproduct" class="btn">Read More</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/cultivation-techniques.png');"></div>
        <div class="feature-bottom">
          <h3>Cultivation Techniques</h3>
          <p>Methods for efficient land preparation, sowing, and harvesting.</p>
          <a href="<?php echo URLROOT; ?>/Knowledgecenter/viewproduct" class="btn">Read More</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/soil-health.jpg');"></div>
        <div class="feature-bottom">
          <h3>Soil Health</h3>
          <p>Tips on maintaining soil fertility and long-term health.</p>
          <a href="<?php echo URLROOT; ?>/Knowledgecenter/viewproduct" class="btn">Read More</a>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/collage.jpg');"></div>
        <div class="feature-bottom">
          <h3>Others</h3>
          <p>Extra resources to support your farming.</p>
          <a href="<?php echo URLROOT; ?>/Knowledgecenter/viewproduct" class="btn">Read More</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>