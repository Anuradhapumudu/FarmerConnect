<?php require_once APPROOT . '/views/inc/officerheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/announcements.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="main-content" id="mainContent">
  <div class="topcontainer">
  <div class="container">
    <div class="top-actions">
      <button class="create-announcement-btn" onclick="window.location.href='<?php echo URLROOT; ?>/Announcements/create'"><i class="fas fa-bullhorn"></i> Create Announcement</button>
    </div>

    <h2 class="announcements-heading">Announcements</h2>

    <!--Search Section-->
    <div class="search-section" id="searchSection">
      <form method="GET" action="<?php echo URLROOT; ?>/Announcements#searchResults">
        <div class="search-row">
          <div class="search-group">
            <label for="search-term" class="search-label"></label>
              <input id="search-term" name="term" type="text" class="search-input" placeholder="Enter search term..." value="<?php echo isset($_GET['term']) ? htmlspecialchars($_GET['term']) : ''; ?>">
          </div>
          
          <div class="search-group">
            <label for="search-category" class="search-label"></label>
            <select id="search-category" class="search-select" name='category'>
              <option value="">Select Category</option>
              <option value="fertilizer" <?php echo isset($_GET['category']) && $_GET['category'] == 'fertilizer' ? 'selected' : ''; ?>>🌱 Fertilizer / Seeds Distribution Dates</option>
              <option value="warning" <?php echo isset($_GET['category']) && $_GET['category'] == 'warning' ? 'selected' : ''; ?>>⚠️ Disease or Pest Outbreak Warnings</option>
              <option value="training" <?php echo isset($_GET['category']) && $_GET['category'] == 'training' ? 'selected' : ''; ?>>📚 Training Workshops</option>
              <option value="policy" <?php echo isset($_GET['category']) && $_GET['category'] == 'policy' ? 'selected' : ''; ?>>📋 Policy Updates or New Government Schemas</option>
              <option value="other" <?php echo isset($_GET['category']) && $_GET['category'] == 'other' ? 'selected' : ''; ?>>📁 Other</option>
            </select>
          </div>
          <div class="search-group">
            <label for="search-date" class="search-label"></label>
            <select id="search-date" class="search-select" name='date'>
              <option value="">Select Date Range</option>
              <option value="today" <?php echo isset($_GET['date']) && $_GET['date'] == 'today' ? 'selected' : ''; ?>>Today</option>
              <option value="week" <?php echo isset($_GET['date']) && $_GET['date'] == 'week' ? 'selected' : ''; ?>>This Week</option>
              <option value="month" <?php echo isset($_GET['date']) && $_GET['date'] == 'month' ? 'selected' : ''; ?>>This Month</option>
            </select>
          </div>
          <div class="search-group">
            <button type="submit" class="search-btn">Search</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Search Results -->
    <div class="search-results" id="searchResults">
      <?php if (!empty($data['searchResults'])): ?>
          <div class="search-results">
              <div class="section-title">
                Search Results
                <a href="<?php echo URLROOT; ?>/Announcements#searchSection" class="clear-results">❌</a>
              </div>
              <div class="announcement-list" id="searchResults">
                  <?php foreach ($data['searchResults'] as $announcement): ?>
                      <div class="announcement-card" id="announcement-<?php echo $announcement->announcement_id; ?>">

                        <div class="category-options">
                          <i class="fas fa-ellipsis-v menu-dots" onclick="toggleOptions(this)"></i>
                          <div class="options-menu">
                              <a href="<?php echo URLROOT; ?>/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>" class="option-item">
                                  <i class="fas fa-thumbtack"></i> <?php echo $announcement->is_pinned ? 'Unpin' : 'Pin'; ?>
                              </a>
                              <a href="<?php echo URLROOT; ?>/Announcements/edit/<?php echo $announcement->announcement_id; ?>" class="option-item">
                                  <i class="fas fa-edit"></i> Edit
                              </a>
                              <a href="<?php echo URLROOT; ?>/Announcements/delete/<?php echo $announcement->announcement_id; ?>" 
                                class="option-item" 
                                onclick="return confirm('Are you sure you want to delete this announcement?');">
                                  <i class="fas fa-trash-alt"></i> Delete
                              </a>
                          </div>
                        </div>

                        <div class="announcement-header">
                          <h3 class="announcement-title">
                            <a href="<?php echo URLROOT; ?>/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                              <?php echo htmlspecialchars($announcement->title); ?>
                            </a>
                          </h3>
                          </div>
                          <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>
                          <?php if (!empty($announcement->attachment_path)): ?>
                              <div class="attachment-label">
                              Note : <i class="fas fa-paperclip"></i> Attachment available
                            </div>
                          <?php endif; ?>
                          <div class="announcement-bottom">
                            <div class="announcement-date-container">
                              <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                              <span class="announcement-posted-by"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                            </div>
                          </div>
                        </div>
                  <?php endforeach; ?>                
              </div>
          </div>
          <?php elseif (empty($data['searchResults']) && $data['searchPerformed']): ?>
            <div class="no-results">
              <div class="section-title">
                      Search Results 
                      <a href="<?php echo URLROOT; ?>/Announcements" class="clear-results">❌</a>
              </div>
              <div class="results-message">No results found.</div>
            </div>
          <?php endif; ?>
      </div>

    

    <!-- Pinned Announcements Section -->
    <?php if (!empty($data['pinnedAnnouncements'])): ?>
      <div class="pinned-section">
          <div class="section-title">📌 Pinned Announcements</div>
          <div class="announcement-list" id="pinnedAnnouncements">
              <?php foreach ($data['pinnedAnnouncements'] as $announcement): ?>
                  <div class="announcement-card" id="announcement-<?php echo $announcement->announcement_id; ?>">
                    
                  <div class="category-options">
                    <i class="fas fa-ellipsis-v menu-dots" onclick="toggleOptions(this)"></i>
                    <div class="options-menu">
                        <a href="<?php echo URLROOT; ?>/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>" class="option-item">
                            <i class="fas fa-thumbtack"></i> <?php echo $announcement->is_pinned ? 'Unpin' : 'Pin'; ?>
                        </a>
                        <a href="<?php echo URLROOT; ?>/Announcements/edit/<?php echo $announcement->announcement_id; ?>" class="option-item">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?php echo URLROOT; ?>/Announcements/delete/<?php echo $announcement->announcement_id; ?>" 
                          class="option-item" 
                          onclick="return confirm('Are you sure you want to delete this announcement?');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </div>
                  </div>
                    
                  <div class="announcement-header">
                      <h3 class="announcement-title">
                          <a href="<?php echo URLROOT; ?>/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                            <?php echo htmlspecialchars($announcement->title); ?>
                          </a>
                      </h3>
                    </div>
                      <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>
                      <?php if (!empty($announcement->attachment_path)): ?>
                        <div class="attachment-label">
                          Note : <i class="fas fa-paperclip"></i> Attachment available
                        </div>
                      <?php endif; ?>
                      <div class="announcement-bottom">
                        <div class="announcement-date-container">
                          <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                          <span class="announcement-posted-by"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                        </div>
                          
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
      </div>
    <?php endif; ?>

    <!-- Latest Announcements -->
    <div class="latest-section">
        <div class="section-title">Latest Announcements</div>
        <div class="announcement-list" id="latestAnnouncements">
            <?php if (!empty($data['latestAnnouncements'])): ?>
                <?php foreach ($data['latestAnnouncements'] as $announcement): ?>
                    <div class="announcement-card" id="announcement-<?php echo $announcement->announcement_id; ?>">

                    <div class="category-options">
                      <i class="fas fa-ellipsis-v menu-dots" onclick="toggleOptions(this)"></i>
                      <div class="options-menu">
                          <a href="<?php echo URLROOT; ?>/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>" class="option-item">
                              <i class="fas fa-thumbtack"></i> <?php echo $announcement->is_pinned ? 'Unpin' : 'Pin'; ?>
                          </a>
                          <a href="<?php echo URLROOT; ?>/Announcements/edit/<?php echo $announcement->announcement_id; ?>" class="option-item">
                              <i class="fas fa-edit"></i> Edit
                          </a>
                          <a href="<?php echo URLROOT; ?>/Announcements/delete/<?php echo $announcement->announcement_id; ?>" 
                            class="option-item" 
                            onclick="return confirm('Are you sure you want to delete this announcement?');">
                              <i class="fas fa-trash-alt"></i> Delete
                          </a>
                      </div>
                    </div>
                      <div class="announcement-header">
                        <h3 class="announcement-title">
                          <a href="<?php echo URLROOT; ?>/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                            <?php echo htmlspecialchars($announcement->title); ?>
                          </a>
                        </h3>
                        </div>
                        <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>

                        <?php if (!empty($announcement->attachment_path)): ?>
                          <div class="attachment-label">
                            Note : <i class="fas fa-paperclip"></i> Attachment available
                          </div>
                        <?php endif; ?>
                        <div class="announcement-bottom">
                          <div class="announcement-date-container">
                            <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                            <span class="announcement-posted-by"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                          </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p>No latest announcements.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Previous Announcements -->
    <div class="previous-section">
        <div class="section-title">Previous Announcements</div>
        <div class="announcement-list" id="previousAnnouncements">
            <?php if (!empty($data['previousAnnouncements'])): ?>
                <?php foreach ($data['previousAnnouncements'] as $announcement): ?>
                    <div class="announcement-card" id="announcement-<?php echo $announcement->announcement_id; ?>">

                    <div class="category-options">
                      <i class="fas fa-ellipsis-v menu-dots" onclick="toggleOptions(this)"></i>
                      <div class="options-menu">
                          <a href="<?php echo URLROOT; ?>/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>" class="option-item">
                              <i class="fas fa-thumbtack"></i> <?php echo $announcement->is_pinned ? 'Unpin' : 'Pin'; ?>
                          </a>
                          <a href="<?php echo URLROOT; ?>/Announcements/edit/<?php echo $announcement->announcement_id; ?>" class="option-item">
                              <i class="fas fa-edit"></i> Edit
                          </a>
                          <a href="<?php echo URLROOT; ?>/Announcements/delete/<?php echo $announcement->announcement_id; ?>" 
                            class="option-item" 
                            onclick="return confirm('Are you sure you want to delete this announcement?');">
                              <i class="fas fa-trash-alt"></i> Delete
                          </a>
                      </div>
                    </div>

                    <div class="announcement-header">
                        <h3 class="announcement-title">
                          <a href="<?php echo URLROOT; ?>/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                            <?php echo htmlspecialchars($announcement->title); ?>
                          </a>
                        </h3>
                        </div>
                        <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>

                        <?php if (!empty($announcement->attachment_path)): ?>
                          <div class="attachment-label">
                            Note : <i class="fas fa-paperclip"></i> Attachment available
                          </div>
                        <?php endif; ?>
                        <div class="announcement-bottom">
                          <div class="announcement-date-container">
                            <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                            <span class="announcement-posted-by"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                          </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No previous announcements.</p>
            <?php endif; ?>
        </div>
    </div>
  </div>
  </div>
</div>
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