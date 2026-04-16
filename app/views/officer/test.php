

<h2>.................Test Page reached!</h2>
<dev>
<form name ="test" action ="<?php echo URLROOT; ?>/officer/test/calculate" method="POST">

                    <label for="Select oprtation">Select Operation</label>

                      <select id="operation" name="operation">
                            
                            <option value="+">addition</option>
                            <option value="-">Substraction</option>
                            <option value="*">Multiplication</option>
                            <option value="/">Devision</option>
                      </select>

    <input type="text" name="num1" placeholder="Number 1">
    <input type="text" name="num2" placeholder="Number 2">
    <input type="submit" name="calbtn" value="Calculate">
    <input type="text" name="result" placeholder="result" value = "<?php echo isset($data['finResult'] )? $data['finResult'] : ' ' ;?>" >
    <?php echo isset($data['error'])? $data['error'] : '' ;?>
</form>

</dev>

<br><br><br>

<dev>
    <form name ="farmernote" action ="<?php echo URLROOT; ?>/officer/test/create" method="POST">
    <input type="text" name="farmer_ID" placeholder= "Farmer ID"><br><br>
    <textarea name = "note" rows ="4" cols = "50" placeholder = "Enter Note Here..."></textarea><br>
    <input type="submit" name="subbtn" value="Submit">
    </form>

    <form name ="farmernote" action ="<?php echo URLROOT; ?>/officer/test/search" method="POST">
    <input type="text" name="farmer_ID" placeholder= "Farmer ID"><br><br>
    <input type="submit" name="search" value="Search">
    </form>

            <table>
            <thead>
                <tr>
                    <th>Farmer ID</th>
                    <th>Note</th>
                <tr>
            <thead>

           <tbody>
                    <?php if (!empty($data['result'])):?>
                        <?php foreach($data['result'] as $item): ?>

                            <tr>
                                <td><?php echo $item->farmer_id; ?></td>
                                <td><?php echo $item->note; ?></td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td >No Notes</td>
                        </tr>
                    <?php endif; ?>
           </tbody>

</dev>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>