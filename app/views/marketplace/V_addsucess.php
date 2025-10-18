<?php require_once APPROOT . '/views/inc/header.php'; ?>
<!-- Marketplace-specific CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/addsuccess.css?v=<?= time(); ?>">
<main class="main-content" id="mainContent">
  <div class="sucess_wrapper">
    <div class="sucess_card">
      

      <h2>Product Added Successfully!</h2>
      
      <p>Your product has been successfully added to the system. It will be reviewed and made available shortly.</p>
      
      <div class="button-group">
        <button class="sucess_btn-primary" onclick="window.location.href='<?= URLROOT ?>/Marketplace/addProduct';">
          <i class="fas fa-plus-circle"></i> Add Another Product
        </button>
        
        <button class="sucess_btn-secondary" onclick="window.location.href='<?= URLROOT ?>/Marketplace/manageProduct';">
          <i class="fas fa-list"></i> View All Products
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
