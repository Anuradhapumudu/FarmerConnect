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

   
          <tr>
            <td rowspan = "3" > 2 month </td>
            <td class = "value">Urea : <?= $data['tableData']['2.0'][1]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['2.0'][2]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['2.0'][3]['urea'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Potash : <?= $data['tableData']['2.0'][1]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['2.0'][2]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['2.0'][3]['potash'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Super Phospate : <?= $data['tableData']['2.0'][1]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['2.0'][2]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['2.0'][3]['phosphate'];?> kg</td>
          </tr>

          <tr>
            <td rowspan = "3" > 3 month </td>
            <td class = "value">Urea : <?= $data['tableData']['3.0'][1]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['3.0'][2]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['3.0'][3]['urea'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Potash : <?= $data['tableData']['3.0'][1]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['3.0'][2]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['3.0'][3]['potash'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Super Phospate : <?= $data['tableData']['3.0'][1]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['3.0'][2]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['3.0'][3]['phosphate'];?> kg</td>
          </tr>

          <tr>
          <tr>
            <td rowspan = "3" > 3 1/2 month </td>
            <td class = "value">Urea : <?= $data['tableData']['3.5'][1]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['3.5'][2]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['3.5'][3]['urea'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Potash : <?= $data['tableData']['3.5'][1]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['3.5'][2]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['3.5'][3]['potash'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Super Phospate : <?= $data['tableData']['3.5'][1]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['3.5'][2]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['3.5'][3]['phosphate'];?> kg</td>
          </tr>

          <tr>
            <td rowspan = "3" > 4 month </td>
            <td class = "value">Urea : <?= $data['tableData']['4.0'][1]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['4.0'][2]['urea'];?> kg</td>
            <td class = "value">Urea : <?= $data['tableData']['4.0'][3]['urea'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Potash : <?= $data['tableData']['4.0'][1]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['4.0'][2]['potash'];?> kg</td>
            <td class = "value">Potash : <?= $data['tableData']['4.0'][3]['potash'];?> kg</td>
          </tr>
          <tr>
            <td class = "value">Super Phospate : <?= $data['tableData']['4.0'][1]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['4.0'][2]['phosphate'];?> kg</td>
            <td class = "value">Super Phospate : <?= $data['tableData']['4.0'][3]['phosphate'];?> kg</td>
          </tr>
    </tbody>
    </table>

</main>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>