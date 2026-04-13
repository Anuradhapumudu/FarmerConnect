

<h2>.................Test Page reached!</h2>

<form name ="test" action ="<?php echo URLROOT; ?>/officer/test/calculate" method="POST">
    <input type="text" name="num1" placeholder="Number 1">
    <input type="text" name="num2" placeholder="Number 2">
    <input type="submit" name="calbtn" value="Calculate">
    <input type="text" name="result" placeholder="result" value = "<?php echo isset($data['finResult'] )? $data['finResult'] : 'no_data' ;?>" >
</form>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>