
<?php require APPROOT . '/views/inc/officerheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/FarmerTimeline.css?v=<?= time(); ?>">

<main class="timeline-container">
  <h2>Farmer Cultivation Timeline</h2>
  <p class="timeline-subtext">
    Viewing farmer progress (Read Only Mode)
  </p>

  <!-- Show PLR -->
  <div class="plr-selector">
    <label>PLR Number:</label>
    <strong><?php echo $data['plr']; ?></strong>
  </div>

  <?php
  $stepImages = [
      1 => 'landpreparation1.jpg',
      2 => 'watersupply.jpg',
      3 => 'readyfield2.webp',
      4 => 'landpreparetion2.jpg',
      5 => 'readyfield1.jpg',
      6 => 'sowing.webp',
      7 => 'fertilization1.jpg',
      8 => 'fertilization2.jpeg',
      9 => 'fertilization3.jpg',
      10 => 'harvesting.webp',
      11 => 'harvesting.webp'
  ];
?>

  <!-- ================= STAGE 01 ================= -->
  <div class="stage-section">
    <h3>Stage-01</h3>
    <div class="task-row">

      <?php for ($i = 1; $i <= 5; $i++): 
        $status = $data['progress'][$i] ?? 'default';
      ?>

      <div class="task <?php echo $status; ?>">
        <div class="label">Step <?php echo $i; ?></div>

        <div class="circle">
          <?php $image = $stepImages[$i] ?? 'default.jpg'; ?>
          <img src="<?php echo URLROOT; ?>/img/<?php echo $image; ?>">
        </div>

        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][$i] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][$i] ?? '--'; ?></span>
        </div>

      </div>

      <?php endfor; ?>

    </div>
  </div>

  <!-- ================= STAGE 02 ================= -->
  <div class="stage-section">
    <h3>Stage-02</h3>
    <div class="task-row">

      <?php for ($i = 6; $i <= 10; $i++): 
        $status = $data['progress'][$i] ?? 'default';
      ?>

      <div class="task <?php echo $status; ?>">
        <div class="label">Step <?php echo $i; ?></div>

        <div class="circle">
          <?php $image = $stepImages[$i] ?? 'default.jpg'; ?>
          <img src="<?php echo URLROOT; ?>/img/<?php echo $image; ?>">
        </div>

        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][$i] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][$i] ?? '--'; ?></span>
        </div>

      </div>

      <?php endfor; ?>

    </div>
  </div>

  <!-- ================= STAGE 03 ================= -->
  <div class="stage-section">
    <h3>Stage-03</h3>
    <div class="task-row">

      <?php 
        $i = 11;
        $status = $data['progress'][$i] ?? 'default';
      ?>

      <div class="task <?php echo $status; ?>">
        <div class="label">Harvesting</div>

        <div class="circle">
          <?php $image = $stepImages[$i] ?? 'default.jpg'; ?>
          <img src="<?php echo URLROOT; ?>/img/<?php echo $image; ?>">
        </div>

        <div class="info">
          Estimated date<br><span><?php echo $data['estimatedDates'][$i] ?? '--'; ?></span><br><br>
          Updated date<br><span><?php echo $data['updatedDates'][$i] ?? '--'; ?></span>
        </div>

      </div>

    </div>
  </div>

</main>

<?php require APPROOT . '/views/inc/footer.php'; ?>
