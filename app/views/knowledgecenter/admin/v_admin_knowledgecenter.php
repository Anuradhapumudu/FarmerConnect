<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/knowledgecenter.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="containers">

    <div class="addcategory-button">
      <a href="<?php echo URLROOT; ?>/knowledgecenter/addcategory" class="btn btn-primary">Add New Category</a>
    </div>

    <h2 class="knowledgecenter-heading">Knowledge Center</h2>
    <p class="knowledgecenter-description">
      Explore expert insights, guides, and resources – empowering you with the knowledge to grow smarter and farm better.
    </p>

    <!--Search Section-->
    <div class="search-section" id="searchSection">
      <form action="<?php echo URLROOT; ?>/Knowledgecenter/searchcategory" method="GET" class="search-form">
        <input type="text" name="term" placeholder="Search categories..." class="search-input" required value="<?php echo isset($_GET['term']) ? htmlspecialchars($_GET['term']) : ''; ?>">
        <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
      </form>
    </div>
    <!-- Search Results -->
    <div class="search-results" id="searchResults">
      <?php if (isset($data['searchResults']) && !empty($data['searchResults'])): ?>
        <div class="section-title">Search Results <a href="<?php echo URLROOT; ?>/Knowledgecenter#searchSection" class="clear-results">❌</a></div>
      <!-- Results -->
        <div class="results-list">
          <?php foreach ($data['searchResults'] as $result): ?>
            <div class="feature-card">
            <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/public/<?php echo $result->image_path; ?>');"></div>
            <div class="feature-inner">
              <div class="category-options">
                <i class="fas fa-ellipsis-v menu-dots" onclick="toggleOptions(this)"></i>
                <div class="options-menu">
                  <a href="<?php echo URLROOT; ?>/Knowledgecenter/editcategory/<?php echo $result->id; ?>" class="option-item">Edit</a>
                  <a href="<?php echo URLROOT; ?>/Knowledgecenter/deletecategory/<?php echo $result->id; ?>" class="option-item" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                </div>
              </div>
            </div>
            <div class="feature-bottom">
              <h3><?php echo $result->category_name; ?></h3>
              <p><?php echo $result->description; ?></p>
              <a href="<?php echo URLROOT; ?>/Knowledgecenter/category/<?php echo $result->id; ?>" class="btn">Read More</a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      <!-- No Results -->
      <?php elseif (empty($data['searchResults']) && $data['searchPerformed']): ?>
        <div class="no-results">
          <div class="section-title">Search Results <a href="<?php echo URLROOT; ?>/Knowledgecenter#searchSection" class="clear-results">❌</a></div>
          <div class="results-message">No results found.</div>
        </div>
      <?php endif; ?>
    </div>

    <div class="features_block">
        <?php foreach($data['categories'] as $category): ?>
          <div class="feature-card">
            <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/public/<?php echo $category->image_path; ?>');"></div>
            <div class="feature-inner">
            <!-- Edit & Delete article -->
              <div class="category-options">
                <i class="fas fa-ellipsis-v menu-dots" onclick="toggleOptions(this)"></i>
                <div class="options-menu">
                  <a href="<?php echo URLROOT; ?>/Knowledgecenter/editcategory/<?php echo $category->id; ?>" class="option-item">Edit</a>
                  <a href="<?php echo URLROOT; ?>/Knowledgecenter/deletecategory/<?php echo $category->id; ?>" class="option-item" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                </div>
              </div>
            </div>

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