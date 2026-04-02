<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/fertilizerCalculator.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<main>
<h1>Fertilizer Calculator</h1>
<p class="page-subtitle">Get accurate fertilizer amounts based on your crop and field size.</p>

  <div class="calc-container">
    
    <!-- Left side -->
    <div id="calc">
      <form name ="FertilizerCaclulator" action ="<?php echo URLROOT; ?>/FertilizerCalculator/calculate" method="POST">
        <div class="info">
          <label>Enter Land Area:</label>
          <input type="text" name = "land_area" value = "<?php echo isset($data['land_area']) ? $data['land_area'] : ''; ?>">
          <?php if(!empty($data['errors']['land_area'])):?>
            <p class = "error"><?php echo $data['errors']['land_area'];?></p>
          <?php endif; ?>
        </div>

        <div class="info">
          <label>Select Crop Type:</label>
          <select id="crop-type" name = "crop_type">
              <option value="2" <?php echo (isset($data['crop_type']) && $data['crop_type']=='2') ? 'selected' : ''; ?>>2 month</option>
              <option value="3" <?php echo (isset($data['crop_type']) && $data['crop_type']=='3') ? 'selected' : ''; ?>>3 month</option>
              <option value="3.5" <?php echo (isset($data['crop_type']) && $data['crop_type']=='3.5') ? 'selected' : ''; ?>>3 1/2 month</option>
              <option value="4" <?php echo (isset($data['crop_type']) && $data['crop_type']=='4') ? 'selected' : ''; ?>>4 month</option>
          </select>
        </div>

        <div class="info">
          <label>Select Crop Stage:</label>
          <select id="crop-stage" name = "crop_stage">
            <option value = "1" <?php echo(isset($data['crop_stage']) && $data['crop_stage']=='1')? 'selected' : '' ;?>>1st stage</option>
            <option value = "2" <?php echo(isset($data['crop_stage']) && $data['crop_stage']=='2')? 'selected' : '' ;?>>2nd stage</option>
            <option value = "3" <?php echo(isset($data['crop_stage']) && $data['crop_stage']=='3')? 'selected' : '' ;?>>3rd stage</option>
          </select>
        </div>

        <input type="submit" name="calbtn" value="Calculate">
      </form>
    </div>

    <!-- Right side -->
    <div class="result-section">
      <div id="recommadtion">
            <div class="card-item">Urea <span>
              <?php echo isset($data['results']['urea'])? $data['results']['urea'].'kg':'-'; ?>
              </span></div>
            <div class="card-item">Potash <span>
              <?php echo isset($data['results']['potash'])? $data['results']['potash'].'kg':'-'; ?>
            </span></div>
            <div class="card-item">Phosphate <span>
              <?php echo isset($data['results']['superPhospate'])? $data['results']['superPhospate'].'kg':'-'; ?>
            </span></div>
      </div>

      <div class="link">
            <a href="<?php echo URLROOT; ?>/Knowledgecenter/KnowledgecenterFarmer"><i class="fa-solid fa-leaf"></i> Know more</a>
            <a href="<?php echo URLROOT; ?>/viewProduct/fertilizer"><i class="fa-solid fa-cart-shopping"></i> Buy Fertilizer</a>
      </div>
    </div>

  </div>
</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>