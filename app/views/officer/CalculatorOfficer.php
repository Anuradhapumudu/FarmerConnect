<?php require APPROOT . '/views/inc/officerheader.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/fertilizerCalculator.css?v=<?= time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<main>
<h1>Update Fertilizer Calculator</h1>
<p class="page-subtitle">Update accurate fertilizer amounts for Arce.</p>

  <div class="calc-container">
    
    <!-- Left side -->
    <div id="calc">
     <form action ="<?php echo URLROOT; ?>/officer/CalculatorOfficer/UpdateRecommendation" method = "post">
    <div class="info">
          
          <label>Select Crop Type:</label>
          <select id="crop-type" name ="crop_type">
            <option value = "2">2 month</option>
            <option value = "3">3 month</option>
            <option value = "3.5">3 1/2 month</option>
            <option value = "4">4 month</option>
          </select>
        </div>

        <div class="info">
          <label>Select Crop Stage:</label>
          <select id="crop-stage" name ="crop_stage">
            <option value = "1">1st stage</option>
            <option value = "2">2nd stage</option>
            <option value = "3">3rd stage</option>
          </select>
        </div>
        <div class="info">
          <label>Enter Urea Amount for Acre:</label>
          <input type="text" name = "urea" >
        </div>

        <div class="info">
          <label>Enter Pothash Amount for Acre:</label>
          <input type="text" name = "potash">
        </div>

        <div class="info">
          <label>Enter Phosphate Amount for Acre:</label>
          <input type="text" name = "phosphate">
        </div>

        <input type="submit" name="calbtn" value="Update Calculator">
      </form>
    </div>

    <!-- RIGHT: Table -->
     <div class="table-box">
      <h3>Current Recommendations (Per Arce)</h3>

      <table class="fertilizer-table">
        <thead>
          <tr>
            <th></th>
            <th>Stage 1</th>
            <th>Stage 2</th>
            <th>Stage 3</th>
          </tr>
        </thead>
        
              <tbody>

              <?php 
              $durations = ['2.0' => '2 month', '3.0' => '3 month', '3.5' => '3 1/2 month', '4.0' => '4 month'];

              foreach ($durations as $key => $label): ?>
                  
              <tr class="crop-row">

                  <!-- Crop Type -->
                  <td><?php echo $label; ?></td>

                  <!-- Stage 1 -->
                  <td>
                      <div class="fert-box">
                          <strong>Urea</strong>
                          <span><?= $data['tableData'][$key][1]['urea']; ?> kg</span>
                      </div>
                      <div class="fert-box">
                          <strong>Potash</strong>
                          <span><?= $data['tableData'][$key][1]['potash']; ?> kg</span>
                      </div>
                      <div class="fert-box">
                          <strong>Phosphate</strong>
                          <span><?= $data['tableData'][$key][1]['phosphate']; ?> kg</span>
                      </div>
                  </td>

                  <!-- Stage 2 -->
                  <td>
                      <div class="fert-box">
                          <strong>Urea</strong>
                          <span><?= $data['tableData'][$key][2]['urea']; ?> kg</span>
                      </div>
                      <div class="fert-box">
                          <strong>Potash</strong>
                          <span><?= $data['tableData'][$key][2]['potash']; ?> kg</span>
                      </div>
                      <div class="fert-box">
                          <strong>Phosphate</strong>
                          <span><?= $data['tableData'][$key][2]['phosphate']; ?> kg</span>
                      </div>
                  </td>

                  <!-- Stage 3 -->
                  <td>
                      <div class="fert-box">
                          <strong>Urea</strong>
                          <span><?= $data['tableData'][$key][3]['urea']; ?> kg</span>
                      </div>
                      <div class="fert-box">
                          <strong>Potash</strong>
                          <span><?= $data['tableData'][$key][3]['potash']; ?> kg</span>
                      </div>
                      <div class="fert-box">
                          <strong>Phosphate</strong>
                          <span><?= $data['tableData'][$key][3]['phosphate']; ?> kg</span>
                      </div>
                  </td>

              </tr>

              <?php endforeach; ?>

              </tbody>
    </table>

</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>