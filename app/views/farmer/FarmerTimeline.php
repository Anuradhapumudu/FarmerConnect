<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerTimeline.css?v=<?= time(); ?>">

<main class="timeline-container">
  <h2>Cultivation Timeline Tracker</h2>
  <p class="timeline-subtext"> Monitor each stage of your cultivation process and track your field progress efficiently.</p>

  <div class="plr-selector">
    <form name ="Timeline" action ="<?php echo URLROOT; ?>/FarmerTimeline/getSeed" method="POST">
    <label for="plrSelect">Select PLR Number:</label>
        
    <select name="plr" id="plrSelect">
            <option value="">-- Select PLR --</option>

            <?php foreach($data['plrs'] as $row): ?>
                <option value="<?php echo $row->PLR; ?>"
                    <?php echo (!empty($data['selected_plr']) && $data['selected_plr'] == $row->PLR) ? 'selected' : ''; ?>>
                    <?php echo $row->PLR; ?>
                </option>
            <?php endforeach; ?>
    </select>

    <button type="submit">Select</button>
    </form>
  </div>
  

  <!-- STAGE 01 -->
  <div class="stage-section">
    <h3>Stage-01</h3>
    <div class="task-row">
              
      <!-- TASK 1 -->
      <?php
      $status = $data['progress'][1] ?? 'default';

      $today = date('Y-m-d');

      $nextUnlockDate = isset($data['estimatedDates'][2]) 
          ? date('Y-m-d', strtotime($data['estimatedDates'][2] . ' -2 days'))
          : null;

      // Step 1 becomes readonly when step 2 unlocks
      $readonly = ($status === 'done') ? 'readonly' : '';
      ?>
      <div class="task <?php echo $status . ' ' . $readonly; ?>" data-step="1">
        <div class="label">Ready the Field I</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/landpreparation1.jpg" alt="Ready the Field I">
        </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][1] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][1] ?? '--'; ?></span>
      </div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 2 -->
    <?php
    $status = $data['progress'][2] ?? 'default';
    $prevDone = (($data['progress'][1] ?? '') === 'done');

    $unlockDate = isset($data['estimatedDates'][2]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][2] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

    // NEW: readonly when step 3 unlocks
    $nextUnlockDate = isset($data['estimatedDates'][3]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][3] . ' -2 days'))
        : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="2">
        <div class="label">Water Supply</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/watersupply.jpg" alt="Water Supply">
        </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][2] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][2] ?? '--'; ?></span>
      </div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 3 -->
    <?php
    $status = $data['progress'][3] ?? 'default';
    $prevDone = (($data['progress'][2] ?? '') === 'done');

    $unlockDate = isset($data['estimatedDates'][3]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][3] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

    $nextUnlockDate = isset($data['estimatedDates'][4]) 
    ? date('Y-m-d', strtotime($data['estimatedDates'][4] . ' -2 days'))
    : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="3">
        <div class="label">Prepare Land</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/readyfield2.webp" alt="Prepare Land">
        </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][3] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][3] ?? '--'; ?></span>
      </div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')">Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 4 -->
    <?php
    $status = $data['progress'][4] ?? 'default';
        $prevDone = (($data['progress'][3] ?? '') === 'done');

        $unlockDate = isset($data['estimatedDates'][4]) 
            ? date('Y-m-d', strtotime($data['estimatedDates'][4] . ' -2 days'))
            : null;

        $today = date('Y-m-d');

        $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

          $nextUnlockDate = isset($data['estimatedDates'][5]) 
          ? date('Y-m-d', strtotime($data['estimatedDates'][5] . ' -2 days'))
          : null;

      $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
      ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="4">
        <div class="label">Ready the Field II</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/landpreparetion2.jpg" alt="Ready the Field II">
        </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][4] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][4] ?? '--'; ?></span>
      </div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>

      <!-- TASK 5 -->
    <?php
    $status = $data['progress'][5] ?? 'default';
    $prevDone = (($data['progress'][4] ?? '') === 'done');

    $unlockDate = isset($data['estimatedDates'][5]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][5] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

    $nextUnlockDate = isset($data['estimatedDates'][6]) 
    ? date('Y-m-d', strtotime($data['estimatedDates'][6] . ' -2 days'))
    : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="5">
        <div class="label">Prepare Land II</div>
        <div class="circle" onclick="toggleStatusMenu(this)">
          <img src="<?php echo URLROOT; ?>/img/readyfield1.jpg" alt="Prepare Land II">
        </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][5] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][5] ?? '--'; ?></span>
      </div>
        <div class="status-selector">
          <button onclick="setStatus(this, 'done')"> Done</button>
          <button onclick="setStatus(this, 'problem')"> Have Problem</button>
          <button onclick="setStatus(this, 'pending')"> Not Done Yet</button>
        </div>
      </div>



    </div>


    <?php
    $stage1Complete = true;

    for ($i = 1; $i <= 5; $i++) {
        if (($data['progress'][$i] ?? '') !== 'done') {
            $stage1Complete = false;
            break;
        }
    }
    ?>


        <div class="stage-action">

              <?php 
              $status1 = $data['stage1_request'] ?? 'none';

              $btnClass = '';
              if ($status1 == 'pending') $btnClass = 'pending';
              elseif ($status1 == 'approved') $btnClass = 'approved';

              if ($stage1Complete): ?>

                  <!-- INFORM BUTTON -->
                  <form action="<?php echo URLROOT; ?>/FarmerTimeline/informStage" method="POST" style="display:inline;">
                      
                      <input type="hidden" name="plr" value="<?php echo $data['selected_plr']; ?>">
                      <input type="hidden" name="stage" value="1">

                      <button type="submit" 
                              class="inform-btn <?php echo $btnClass; ?>"
                              <?php echo ($status1 != 'none') ? 'disabled' : ''; ?>>

                          <?php 
                              if ($status1 == 'pending') echo " Waiting for Officer...";
                              elseif ($status1 == 'approved') echo "✔ Approved";
                              else echo "Inform Officer";
                          ?>
                      </button>
                  </form>

                  <!--  CANCEL BUTTON (ONLY WHEN PENDING) -->
                  <?php if ($status1 == 'pending'): ?>
                      <form action="<?php echo URLROOT; ?>/FarmerTimeline/cancelWaitingStage" method="POST" style="display:inline;">
                          
                          <input type="hidden" name="plr" value="<?php echo $data['selected_plr']; ?>">
                          <input type="hidden" name="stage" value="1">

                          <button type="submit" class="cancel-btn">
                              Cancel
                          </button>
                      </form>
                  <?php endif; ?>

              <?php endif; ?>

        </div>

  </div>

  <!-- STAGE 02 -->
<div class="stage-section">
  <h3>Stage-02</h3>
  <div class="task-row">

    <!-- TASK 1 -->
    <?php
    $status = $data['progress'][6] ?? 'default';
    $prevDone = (($data['progress'][5] ?? '') === 'done');
    $approved = (($data['stage1_request'] ?? '') === 'approved');

    $unlockDate = isset($data['estimatedDates'][6]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][6] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $approved && $today >= $unlockDate) ? '' : 'locked';

    $nextUnlockDate = isset($data['estimatedDates'][7]) 
    ? date('Y-m-d', strtotime($data['estimatedDates'][7] . ' -2 days'))
    : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="6">
      <div class="label">Sowing</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/sowing.webp" alt="Sowing">
      </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][6] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][6] ?? '--'; ?></span>
      </div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 2 -->
    <?php
    $status = $data['progress'][7] ?? 'default';
    $prevDone = (($data['progress'][6] ?? '') === 'done');

    $unlockDate = isset($data['estimatedDates'][7]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][7] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

    $nextUnlockDate = isset($data['estimatedDates'][8]) 
    ? date('Y-m-d', strtotime($data['estimatedDates'][8] . ' -2 days'))
    : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="7">
      <div class="label">Fertilization I</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/fertilization1.jpg" alt="Fertilization I">
      </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][7] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][7] ?? '--'; ?></span>
      </div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 3 -->
    <?php
    $status = $data['progress'][8] ?? 'default';
    $prevDone = (($data['progress'][7] ?? '') === 'done');

    $unlockDate = isset($data['estimatedDates'][8]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][8] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

    $nextUnlockDate = isset($data['estimatedDates'][9]) 
    ? date('Y-m-d', strtotime($data['estimatedDates'][9] . ' -2 days'))
    : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="8">
      <div class="label">Fertilization II</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/fertilization2.jpeg" alt="Fertilization II">
      </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][8] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][8] ?? '--'; ?></span>
      </div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 4 -->
    <?php
    $status = $data['progress'][9] ?? 'default';
    $prevDone = (($data['progress'][8] ?? '') === 'done');

    $unlockDate = isset($data['estimatedDates'][9]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][9] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

    $nextUnlockDate = isset($data['estimatedDates'][10]) 
    ? date('Y-m-d', strtotime($data['estimatedDates'][10] . ' -2 days'))
    : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="9">
      <div class="label">Fertilization III</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/fertilization3.jpg" alt="Fertilization III">
      </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][9] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][9] ?? '--'; ?></span>
      </div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

    <!-- TASK 5 -->
    <?php
    $status = $data['progress'][10] ?? 'default';
    $prevDone = (($data['progress'][9] ?? '') === 'done');

    $unlockDate = isset($data['estimatedDates'][10]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][10] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $today >= $unlockDate) ? '' : 'locked';

    $nextUnlockDate = isset($data['estimatedDates'][11]) 
    ? date('Y-m-d', strtotime($data['estimatedDates'][11] . ' -2 days'))
    : null;

    $readonly = ($nextUnlockDate && $today >= $nextUnlockDate) ? 'readonly' : '';
    ?>
    <div class="task <?php echo $status . ' ' . $locked . ' ' . $readonly; ?>" data-step="10">
      <div class="label">Fertilization IV</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/harvesting.webp" alt="Harvesting">
      </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][10] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][10] ?? '--'; ?></span>
      </div>
      <div class="status-selector">
        <button onclick="setStatus(this, 'done')">Done</button>
        <button onclick="setStatus(this, 'problem')">Have Problem</button>
        <button onclick="setStatus(this, 'pending')">Not Done Yet</button>
      </div>
    </div>

  </div>

    <?php
    $stage2Complete = true;

    for ($i = 6; $i <= 10; $i++) {
        if (($data['progress'][$i] ?? '') !== 'done') {
            $stage2Complete = false;
            break;
        }
    }
    ?>

        <div class="stage-action">

              <?php 
              $status2 = $data['stage2_request'] ?? 'none';

              $btnClass = '';
              if ($status2 == 'pending') $btnClass = 'pending';
              elseif ($status2 == 'approved') $btnClass = 'approved';

              if ($stage2Complete): ?>

                  <!-- INFORM BUTTON -->
                  <form action="<?php echo URLROOT; ?>/FarmerTimeline/informStage" method="POST" style="display:inline;">
                      
                      <input type="hidden" name="plr" value="<?php echo $data['selected_plr']; ?>">
                      <input type="hidden" name="stage" value="2">

                      <button type="submit" 
                              class="inform-btn <?php echo $btnClass; ?>"
                              <?php echo ($status2 != 'none') ? 'disabled' : ''; ?>>

                          <?php 
                              if ($status2 == 'pending') echo " Waiting for Officer...";
                              elseif ($status2 == 'approved') echo "✔ Approved";
                              else echo "Inform Officer";
                          ?>
                      </button>
                  </form>

                  <!--  CANCEL BUTTON (ONLY WHEN PENDING) -->
                  <?php if ($status2 == 'pending'): ?>
                      <form action="<?php echo URLROOT; ?>/FarmerTimeline/cancelWaitingStage" method="POST" style="display:inline;">
                          
                          <input type="hidden" name="plr" value="<?php echo $data['selected_plr']; ?>">
                          <input type="hidden" name="stage" value="2">

                          <button type="submit" class="cancel-btn">
                              Cancel
                          </button>
                      </form>
                  <?php endif; ?>

              <?php endif; ?>

        </div>
 
</div>

  <!-- STAGE 03 -->
<div class="stage-section">
  <h3>Stage-03</h3>
  <div class="task-row">

    <!-- TASK 1 -->
    <?php
    $status = $data['progress'][11] ?? 'default';
    $prevDone = (($data['progress'][10] ?? '') === 'done');
    $approved = (($data['stage1_request'] ?? '') === 'approved');

    $unlockDate = isset($data['estimatedDates'][11]) 
        ? date('Y-m-d', strtotime($data['estimatedDates'][11] . ' -2 days'))
        : null;

    $today = date('Y-m-d');

    $locked = ($prevDone && $approved && $today >= $unlockDate) ? '' : 'locked';
    ?>
    <div class="task <?php echo $status . ' ' . $locked; ?>" data-step="11">
      <div class="label">Harvesting</div>
      <div class="circle" onclick="toggleStatusMenu(this)">
        <img src="<?php echo URLROOT; ?>/img/harvesting.webp" alt="Harvesting">
      </div>
        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][11] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][11] ?? '--'; ?></span>
      </div>
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

  //  block if locked OR readonly
  if (task.classList.contains('locked') || task.classList.contains('readonly')) {
    return;
  }

  const menu = task.querySelector('.status-selector');

  document.querySelectorAll('.status-selector').forEach(m => {
    if (m !== menu) m.style.display = 'none';
  });

  menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
}

function setStatus(buttonEl, statusClass) {
  const task = buttonEl.closest('.task');

  //  block editing if readonly
  if (task.classList.contains('readonly')) {
    return;
  }

  const stepOrder = task.dataset.step;
  const plr = document.getElementById('plrSelect').value;

  task.classList.remove('done','problem','pending','default');
  task.classList.add(statusClass);
  task.querySelector('.status-selector').style.display = 'none';

  fetch("<?php echo URLROOT; ?>/FarmerTimeline/saveStep", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
          plr: plr,
          step_order: stepOrder,
          status: statusClass
      })
  });

 // checkStageCompletion(task);

if (statusClass === 'problem') {
    goToProblemPage(plr);
    return;
}
}

  function goToProblemPage(plr) {
      const form = document.createElement("form");
      form.method = "POST";
      form.action = "<?php echo URLROOT; ?>/YellowCaseList";

      const plrInput = document.createElement("input");
      plrInput.type = "hidden";
      plrInput.name = "plr";
      plrInput.value = plr;

      form.appendChild(plrInput);
  
      document.body.appendChild(form);
      form.submit();
  }

  function unlockNextTask(currentTask) {
  // Find all tasks in order
  const allTasks = document.querySelectorAll('.task');

  for (let i = 0; i < allTasks.length; i++) {
    if (allTasks[i] === currentTask) {
      // Unlock next task if exists
      if (allTasks[i + 1]) {
        allTasks[i + 1].classList.remove('locked');
      }
      break;
    }
  }
}


/*function checkStageCompletion(taskElement) {
  const stageSection = taskElement.closest('.stage-section');
  const tasks = stageSection.querySelectorAll('.task');

  let allDone = true;

  tasks.forEach(task => {
    if (!task.classList.contains('done')) {
      allDone = false;
    }
  });

  const button = stageSection.querySelector('.inform-btn');

}

  function informOfficer(button) {

      const stage = button.dataset.stage;
      const plr = document.getElementById('plrSelect').value;

      fetch("?php echo URLROOT; ?>/FarmerTimeline/informStage", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({
              plr: plr,
              stage: stage
          })
      })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              button.innerText = "Waiting for Officer...";
              button.disabled = true;
          }
      });
  }*/

</script>
