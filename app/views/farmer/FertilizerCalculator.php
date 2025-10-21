<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/fertilizerCalculator.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<main>
<h1>Fertilizer Calculator</h1>
<p class="page-subtitle">Get accurate fertilizer amounts based on your crop and field size.</p>

  <div class="calc-container">
    
    <!-- Left side -->
    <div id="calc">
      <form>
        <div class="info">
          <label>Enter Land Area:</label>
          <input type="text">
        </div>

        <div class="info">
          <label>Select Crop Type:</label>
          <select id="crop-type">
            <option>2 month</option>
            <option>3 month</option>
            <option>3 1/2 month</option>
            <option>4 month</option>
          </select>
        </div>

        <div class="info">
          <label>Select Crop Stage:</label>
          <select id="crop-stage">
            <option>1st stage</option>
            <option>2nd stage</option>
            <option>3rd stage</option>
          </select>
        </div>

        <input type="submit" name="calbtn" value="Calculate">
      </form>
    </div>

    <!-- Right side -->
    <div class="result-section">
      <div id="recommadtion">
            <div class="card-item">Urea <span>20kg</span></div>
            <div class="card-item">Potash <span>15kg</span></div>
            <div class="card-item">Phosphate <span>12kg</span></div>
      </div>

      <div class="link">
            <a href="<?php echo URLROOT; ?>/Knowledgecenter/KnowledgecenterFarmer"><i class="fa-solid fa-leaf"></i> Know more</a>
            <a href="<?php echo URLROOT; ?>/viewProduct/fertilizer"><i class="fa-solid fa-cart-shopping"></i> Buy Fertilizer</a>
      </div>
    </div>

  </div>
</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>