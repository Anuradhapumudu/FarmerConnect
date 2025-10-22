<?php require APPROOT . '/views/inc/officerheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/fertilizerCalculator.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<main>
<h1>Update Fertilizer Calculator</h1>
<p class="page-subtitle">Update accurate fertilizer amounts for Arce.</p>

  <div class="calc-container">
    
    <!-- Left side -->
    <div id="calc">
      <form>
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
        <div class="info">
          <label>Enter Urea Amount for Acre:</label>
          <input type="text">
        </div>

        <div class="info">
          <label>Enter Pothash Amount for Acre:</label>
          <input type="text">
        </div>

        <div class="info">
          <label>Enter Phosphate Amount for Acre:</label>
          <input type="text">
        </div>

        <input type="submit" name="calbtn" value="Update Calculator">
      </form>
    </div>

</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>