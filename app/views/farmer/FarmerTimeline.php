<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerTimeline.css?v=<?= time(); ?>">

<main class="timeline-container">
  <h2>Cultivation Timeline Tracker</h2>

  <div class="plr-selector">
    <label for="plrSelect">Select PLR Number:</label>
    <select id="plrSelect">
      <option value="">-- Select PLR --</option>
      <option value="PLR-001">PLR-001</option>
      <option value="PLR-002">PLR-002</option>
      <option value="PLR-003">PLR-003</option>
    </select>
  </div>

  <!-- STAGE 01 -->
  <div class="stage-section">
    <h3>Stage-01</h3>
    <div class="task-row">

      <!-- TASK 1 -->
      <div class="task pending">
        <div class="label">Ready the Field I</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/landpreparation1.jpg" alt="Ready the Field I">
        </div>
        <div class="info">Estimated date<br><span>2025.06.03</span></div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 2 -->
      <div class="task pending">
        <div class="label">Water Supply</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/watersupply.jpg" alt="Water Supply">
        </div>
        <div class="info">Estimated date<br><span>2025.06.07</span></div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 3 -->
      <div class="task pending">
        <div class="label">Prepare Land</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/readyfield2.webp" alt="Prepare Land">
        </div>
        <div class="info">Estimated date<br><span>2025.06.13</span></div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')">Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 4 -->
      <div class="task pending">
        <div class="label">Ready the Field II</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/landpreparetion2.jpg" alt="Ready the Field II">
        </div>
        <div class="info">Estimated date<br><span>2025.06.20</span></div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 5 -->
      <div class="task pending">
        <div class="label">Prepare Land II</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/readyfield1.jpg" alt="Prepare Land II">
        </div>
        <div class="info">Estimated date<br><span>2025.06.27</span></div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

    </div>
  </div>

  <!-- STAGE 02 -->
<div class="stage-section">
  <h3>Stage-02</h3>
  <div class="task-row">

    <!-- TASK 1 -->
    <div class="task pending">
      <div class="label">Sowing</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/sowing.jpg" alt="Sowing">
      </div>
      <div class="info">Estimated date<br><span>2025.07.01</span></div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 2 -->
    <div class="task pending">
      <div class="label">Fertilization I</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/fertilizer1.jpg" alt="Fertilization I">
      </div>
      <div class="info">Estimated date<br><span>2025.07.10</span></div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 3 -->
    <div class="task pending">
      <div class="label">Fertilization II</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/fertilizer2.jpg" alt="Fertilization II">
      </div>
      <div class="info">Estimated date<br><span>2025.07.20</span></div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 4 -->
    <div class="task pending">
      <div class="label">Fertilization III</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/fertilizer3.jpg" alt="Fertilization III">
      </div>
      <div class="info">Estimated date<br><span>2025.07.30</span></div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 5 -->
    <div class="task pending">
      <div class="label">Harvesting</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/harvesting.jpg" alt="Harvesting">
      </div>
      <div class="info">Estimated date<br><span>2025.08.15</span></div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

  </div>
</div>

</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

<!-- JavaScript -->
<script>
  function toggleStatusMenu(circleEl) {
    const task = circleEl.closest('.task');
    const menu = task.querySelector('.status-selector');

    // Close all other open menus
    document.querySelectorAll('.status-selector').forEach(m => {
      if (m !== menu) m.style.display = 'none';
    });

    // Toggle the current one
    menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
  }

  function setStatus(buttonEl, statusClass) {
    const task = buttonEl.closest('.task');

    // Remove any existing status
    task.classList.remove('done', 'problem', 'pending');

    // Add new one
    task.classList.add(statusClass);

    // Hide the selector
    task.querySelector('.status-selector').style.display = 'none';

    // ✅ Redirect farmer if “Have Problem” clicked
    if (statusClass === 'problem') {
      window.location.href = "<?php echo URLROOT; ?>/YellowCaseList";
    }
  }
</script>
