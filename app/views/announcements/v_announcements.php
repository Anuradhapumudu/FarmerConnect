<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/announcements.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="main-content" id="mainContent">
  <div class="topcontainer">
  <div class="container">
    <div class="top-actions">
      <button class="create-announcement-btn" onclick="window.location.href='<?php echo URLROOT; ?>/Announcements/CreateAnnouncements/create'"><i class="fas fa-bullhorn"></i> Create Announcement</button>
    </div>

    <h2 class="announcements-heading">Announcements</h2>

    <!-- Pinned Announcements Section -->
    <?php if (!empty($data['pinnedAnnouncements'])): ?>
      <div class="pinned-section">
          <div class="section-title">📌 Pinned Announcements</div>
          <div class="announcement-list" id="pinnedAnnouncements">
              <?php foreach ($data['pinnedAnnouncements'] as $announcement): ?>
                  <div class="announcement-card" id="announcement-<?php echo $announcement->announcement_id; ?>">
                    <div class="pin-icon">
                          <a href="<?php echo URLROOT; ?>/Announcements/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>">
                              📌 Unpin
                          </a>
                      </div>
                      <h3 class="announcement-title">
                          <a href="<?php echo URLROOT; ?>/Announcements/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                            <?php echo htmlspecialchars($announcement->title); ?>
                          </a>
                        </h3>
                      <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>
                      <!-- Date, Edit and Delete buttons -->
                      <div class="announcement-bottom">
                        <div class="announcement-date-container">
                          <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                          <span class="announcement-posted-by">Posted by: <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                        </div>
                          <div class="announcement-actions">
                              <button class="edit-btn" onclick="window.location.href='<?php echo URLROOT; ?>/Announcements/EditAnnouncements/edit/<?php echo $announcement->announcement_id; ?>'">Edit</button>
                              <form method="POST" action="<?php echo URLROOT; ?>/Announcements/DeleteAnnouncements/delete/<?php echo $announcement->announcement_id; ?>" onsubmit="return confirm('Are you sure you want to delete the announcement ?');">
                                  <button type="submit" class="delete-btn">Delete</button>
                              </form>
                          </div>
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
      </div>
    <?php endif; ?>

    <!--Search Section-->
    <div class="search-section" id="searchSection">
      <form method="GET" action="<?php echo URLROOT; ?>/Announcements/Announcements#searchResults">
        <div class="search-row">
          <div class="search-group">
            <label for="search-term" class="search-label">Search Term</label>
            <div class="input-btn-wrap">
              <input id="search-term" name="term" type="text" class="search-input" placeholder="Enter search term..." value="<?php echo isset($_GET['term']) ? htmlspecialchars($_GET['term']) : ''; ?>">
              <button type="submit" class="search-btn">Search</button>
            </div>
          </div>
          
        </div>

        <div class="search-row">
          <div class="search-group">
            <label for="search-category" class="search-label">Category</label>
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
            <label for="search-date" class="search-label">Date</label>
            <select id="search-date" class="search-select" name='date'>
              <option value="">Select Date Range</option>
              <option value="today" <?php echo isset($_GET['date']) && $_GET['date'] == 'today' ? 'selected' : ''; ?>>📅 Today</option>
              <option value="week" <?php echo isset($_GET['date']) && $_GET['date'] == 'week' ? 'selected' : ''; ?>>📊 This Week</option>
              <option value="month" <?php echo isset($_GET['date']) && $_GET['date'] == 'month' ? 'selected' : ''; ?>>🗓️ This Month</option>
            </select>
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
                <a href="<?php echo URLROOT; ?>/Announcements/Announcements#searchSection" class="clear-results">❌</a>
              </div>
              <div class="announcement-list" id="searchResults">
                  <?php foreach ($data['searchResults'] as $announcement): ?>
                      <div class="announcement-card" id="announcement-<?php echo $announcement->announcement_id; ?>">
                        <div class="pin-icon">
                            <a href="<?php echo URLROOT; ?>/Announcements/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>">
                                <?php echo $announcement->is_pinned ? '📌 Unpin' : '📌 Pin'; ?>
                            </a>
                        </div>
                          <h3 class="announcement-title">
                            <a href="<?php echo URLROOT; ?>/Announcements/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                              <?php echo htmlspecialchars($announcement->title); ?>
                            </a>
                          </h3>
                          <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>
                          <!-- Date, Edit and Delete buttons -->
                          <div class="announcement-bottom">
                            <div class="announcement-date-container">
                              <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                              <span class="announcement-posted-by">Posted by: <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                            </div>
                              <div class="announcement-actions">
                                  <button class="edit-btn" onclick="window.location.href='<?php echo URLROOT; ?>/Announcements/EditAnnouncements/edit/<?php echo $announcement->announcement_id; ?>'">Edit</button>
                                  <form method="POST" action="<?php echo URLROOT; ?>/Announcements/DeleteAnnouncements/delete/<?php echo $announcement->announcement_id; ?>" onsubmit="return confirm('Are you sure you want to delete the announcement ?');">
                                      <button type="submit" class="delete-btn">Delete</button>
                                  </form>
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
                      <a href="<?php echo URLROOT; ?>/Announcements/Announcements" class="clear-results">❌</a>
              </div>
              <div class="results-message">No results found.</div>
            </div>
          <?php endif; ?>
      </div>

    <!-- Latest Announcements -->
    <div class="latest-section">
        <div class="section-title">Latest Announcements</div>
        <div class="announcement-list" id="latestAnnouncements">
            <?php if (!empty($data['latestAnnouncements'])): ?>
                <?php foreach ($data['latestAnnouncements'] as $announcement): ?>
                    <div class="announcement-card" id="announcement-<?php echo $announcement->announcement_id; ?>">
                      <div class="pin-icon">
                          <a href="<?php echo URLROOT; ?>/Announcements/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>">
                              <?php echo $announcement->is_pinned ? '📌 Unpin' : '📌 Pin'; ?>
                          </a>
                      </div>

                        <h3 class="announcement-title">
                          <a href="<?php echo URLROOT; ?>/Announcements/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                            <?php echo htmlspecialchars($announcement->title); ?>
                          </a>
                        </h3>
                        <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>

                        <!-- Date, Edit and Delete buttons -->
                        <div class="announcement-bottom">
                          <div class="announcement-date-container">
                            <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                            <span class="announcement-posted-by">Posted by: <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                          </div>
                            <div class="announcement-actions">
                                <button class="edit-btn" onclick="window.location.href='<?php echo URLROOT; ?>/Announcements/EditAnnouncements/edit/<?php echo $announcement->announcement_id; ?>'">Edit</button>
                                <form method="POST" action="<?php echo URLROOT; ?>/Announcements/DeleteAnnouncements/delete/<?php echo $announcement->announcement_id; ?>" onsubmit="return confirm('Are you sure you want to delete the announcement ?');">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
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

                    <!-- icon for pin the announcement -->
                      <div class="pin-icon">
                          <a href="<?php echo URLROOT; ?>/Announcements/Announcements/togglePin/<?php echo $announcement->announcement_id; ?>">
                              <?php echo $announcement->is_pinned ? '📌 Unpin' : '📌 Pin'; ?>
                          </a>
                      </div>

                        <h3 class="announcement-title">
                          <a href="<?php echo URLROOT; ?>/Announcements/Announcements/details/<?php echo $announcement->announcement_id; ?>">
                            <?php echo htmlspecialchars($announcement->title); ?>
                          </a>
                        </h3>
                        <p class="announcement-content"><?php echo htmlspecialchars($announcement->content); ?></p>

                        <!-- Date, Edit and Delete buttons -->
                        <div class="announcement-bottom">
                          <div class="announcement-date-container">
                            <span class="announcement-date"><?php echo date('d-m-Y', strtotime($announcement->created_at)); ?></span>
                            <span class="announcement-posted-by">Posted by: <?php echo htmlspecialchars($announcement->posted_by); ?></span>
                          </div>
                            <div class="announcement-actions">
                                <button class="edit-btn" onclick="window.location.href='<?php echo URLROOT; ?>/Announcements/EditAnnouncements/edit/<?php echo $announcement->announcement_id; ?>'">Edit</button>
                                <form method="POST" action="<?php echo URLROOT; ?>/Announcements/DeleteAnnouncements/delete/<?php echo $announcement->announcement_id; ?>" onsubmit="return confirm('Are you sure you want to delete the announcement ?');">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
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
