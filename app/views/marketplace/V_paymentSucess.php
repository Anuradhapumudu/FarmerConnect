<?php require_once APPROOT . '/views/inc/sellerheader.php'; ?>
<!-- Marketplace-specific CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/addsuccess.css?v=<?= time(); ?>">
<main class="main-content" id="mainContent">
  <div class="sucess_wrapper">
    <div class="sucess_card">
      

      <h2>Your Order Has Been Received!</h2>
      
      <p>Your order has been successfully added to the system. </p>
      
      <div class="button-group">
        <button class="sucess_btn-primary" onclick="window.location.href='<?= URLROOT ?>/Marketplace/trackOrdersFarmer';">
          <i class="fas fa-plus-circle"></i>View My Orders
        </button>
        
        <button class="sucess_btn-secondary" onclick="window.location.href='<?= URLROOT ?>/Marketplace/farmer';">
          <i class="fas fa-list"></i> Buy Another Product
        </button>
      </div>
    </div>
  </div>
</main>
  <script>
    // Add a subtle animation to the success icon
    document.addEventListener('DOMContentLoaded', function() {
      const successIcon = document.querySelector('.sucess_icon');
      
      // Animate the checkmark
      setTimeout(() => {
        successIcon.style.transform = 'scale(1.1)';
        successIcon.style.transition = 'transform 0.5s ease';
      }, 500);
      
      setTimeout(() => {
        successIcon.style.transform = 'scale(1)';
      }, 1000);
    });
  </script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>


