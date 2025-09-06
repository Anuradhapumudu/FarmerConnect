<?php require_once APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?= URLROOT ?>/css/marketplace/paymentGateway.css?v=<?= time(); ?>">

<?php
// Dummy gateways for UI only
$gateways = [
    ['id'=>1, 'name'=>'PayPal', 'logo'=>'paypal.png'],
    ['id'=>2, 'name'=>'Stripe', 'logo'=>'stripe.png'],
    ['id'=>3, 'name'=>'Razorpay', 'logo'=>'razorpay.png']
];
?>

<main>
  <div class="form-wrapper">
    <h2><i class="fas fa-credit-card"></i> Payment Gateway</h2>

    <div class="success" id="successMsg" style="display:none;">Gateway saved successfully!</div>
    <div class="error" id="errorMsg" style="display:none;">Please fill all required fields.</div>

    <form method="post" action="#" enctype="multipart/form-data">
      <label>Gateway Name: <span class="required">*</span></label>
      <input type="text" name="gateway_name" required>

      <label>Upload Logo:</label>
      <input type="file" name="logo" accept="image/*">
      <img id="logoPreview" src="#" style="display:none; max-width:100px; margin-top:10px;" class="logo-preview">

      <button type="submit">Save Gateway</button>
      <a href="#" class="back-button">Back to List</a>
    </form>
  </div>

  <!-- Gateway List -->
  <div class="gateway-list">
    <?php foreach($gateways as $gateway): ?>
      <div class="gateway-item">
        <?php if(!empty($gateway['logo'])): ?>
          <img src="<?= URLROOT ?>/uploads/<?= $gateway['logo'] ?>" alt="<?= $gateway['name'] ?>" class="gateway-logo">
        <?php endif; ?>
        <p><?= $gateway['name'] ?></p>
        <a href="#" class="edit-btn">Edit</a>
        <a href="#" class="delete-btn">Delete</a>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<script>
  const logoInput = document.querySelector('input[name="logo"]');
  const logoPreview = document.getElementById('logoPreview');

  logoInput.addEventListener('change', function(){
    const file = this.files[0];
    if(file){
      const reader = new FileReader();
      reader.onload = e => {
        logoPreview.src = e.target.result;
        logoPreview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    }
  });
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
