<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/knowledgearticles.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="container">

    <h2 class="article-heading"><?php echo $data['category']->category_name; ?></h2>
    <p class="article-description"><?php echo $data['category']->description; ?></p>

    <!--Search Section-->
    <div class="search-section" id="searchSection">
      <form action="<?php echo URLROOT; ?>/Knowledgecenter/searcharticle/<?php echo $data['category']->id; ?>" method="GET" class="search-form">
        <input type="text" name="term" placeholder="Search articles..." class="search-input" required value="<?php echo isset($_GET['term']) ? htmlspecialchars($_GET['term']) : ''; ?>">
        <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
      </form>
    </div>
    <!-- Search Results -->
    <div class="search-results" id="searchResults">
      <?php if (isset($data['searchResults']) && !empty($data['searchResults'])): ?>
        <div class="section-title">Search Results <a href="<?php echo URLROOT; ?>/Knowledgecenter/category/<?php echo $data['category']->id; ?>#searchSection" class="clear-results">❌</a></div>
      <!-- Results -->
        <div class="results-list">
          <?php foreach ($data['searchResults'] as $result): ?>
            <div class="article-box">
              <div class="article-inner">
                <div class="feature-top">
                  <img src="<?php echo URLROOT; ?>/public/<?php echo $result->image_path; ?>" alt="<?php echo $result->article_name; ?>" class="article-image">
                </div>
                <div class="article-text-container">
                  <h3><?php echo $result->article_name; ?></h3>
                  <div class="article-text"><?php echo nl2br($result->description); ?></div>
                  <a href="<?php echo URLROOT; ?>/Knowledgecenter/viewarticle/<?php echo $result->id; ?>" class="read-more-btn">View Full Article →</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <!-- No Results -->
      <?php elseif (empty($data['searchResults']) && $data['searchPerformed']): ?>
        <div class="no-results">
          <div class="section-title">Search Results <a href="<?php echo URLROOT; ?>/Knowledgecenter/category/<?php echo $data['category']->id; ?>#searchSection" class="clear-results">❌</a></div>
          <div class="results-message">No results found.</div>
        </div>
      <?php endif; ?>

    <div class="article-content">
      <?php if (!empty($data['articles'])): ?>
        <?php foreach($data['articles'] as $article): ?>
          <div class="article-box">
            <div class="article-inner">
              <div class="feature-top">
                <img src="<?php echo URLROOT; ?>/public/<?php echo $article->image_path; ?>" alt="<?php echo $article->article_name; ?>" class="article-image">
              </div>
              <div class="article-text-container">
                <h3><?php echo $article->article_name; ?></h3>
                <div class="article-text"><?php echo nl2br($article->description); ?></div>
                <a href="<?php echo URLROOT; ?>/Knowledgecenter/viewarticle/<?php echo $article->id; ?>" class="read-more-btn">View Full Article →</a>
                <!--<button class="read-more-btn">Read More</button>-->
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No articles found for this category yet.</p>
      <?php endif; ?>
    </div>

    <a href="<?php echo URLROOT; ?>/knowledgecenter" class="back-btn">← Back to Knowledge Center</a>
  </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

