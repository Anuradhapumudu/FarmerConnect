<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/adminmarketplace.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

<div class="containers">
   <!-- Page heading -->
  <h2 class="marketplace-heading">Marketplace</h2>
  <p class="marketplace-description">
    Monitor and manage all marketplace activities.
  </p>

  <!-- Dashboard Cards -->
  <div class="dashboard">
    <div class="card">
      <div class="title">
        Total Revenue LKR
        <i class="fa-solid fa-money-bill"></i>
      </div>
      <div class="number" id="revenue" data-target="30232.89">LKR 0</div>
    </div>

    <div class="card">
      <div class="title">
        Active Products
        <i class="fas fa-box"></i>
      </div>
      <div class="number" id="products" data-target="2350">0</div>
    </div>

    <div class="card">
      <div class="title">
        Total Orders
        <i class="fas fa-shopping-cart"></i>
      </div>
      <div class="number" id="orders" data-target="12234">0</div>
    </div>
  </div>

  <!-- Marketplace Cards -->
  <div class="features_block">
    <div class="feature-card">
      <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/Manage_Products.jpg');"></div>
      <div class="feature-bottom">
        <h3>View All Products</h3>
        <p>Add, edit, or remove your listed items</p>
        <a href="<?php echo URLROOT; ?>/Marketplace/adminViewProducts" class="btn">View</a>
      </div>
    </div>

    <div class="feature-card">
      <div class="feature-top" style="background-image: url('<?php echo URLROOT; ?>/img/cart.jpg');"></div>
      <div class="feature-bottom">
        <h3>View All Orders</h3>
        <p>View and manage customer orders.</p>
        <a href="<?php echo URLROOT; ?>/Marketplace/adminViewOrders" class="btn">View</a>
      </div>
    </div>
  </div>

</div>

</main>

<script>
document.addEventListener("DOMContentLoaded", () => {

  // Side navigation
  const sideNav = document.getElementById("sideNav");
  const closeBtn = document.getElementById("closeBtn");

  const menuToggle = document.querySelector(".menu-toggle");
  if(menuToggle) {
    menuToggle.addEventListener("click", () => {
      const navbar = document.querySelector(".navbar");
      if(navbar) navbar.classList.toggle("active");
    });
  }

  if(closeBtn && sideNav) {
    closeBtn.addEventListener("click", () => {
      sideNav.style.left = "-260px";
    });
  }

  window.openNav = function() {
    if(sideNav) sideNav.style.left = "0";
  }

  // Count-up animation
  function countUp(elementId, duration = 2000) {
    const el = document.getElementById(elementId);
    if(!el) return; // safety check
    const target = parseFloat(el.getAttribute("data-target"));
    let startTime = null;

    function animate(timestamp) {
      if (!startTime) startTime = timestamp;
      const progress = timestamp - startTime;
      const current = Math.min(progress / duration * target, target);

      if(elementId === "revenue") {
        el.innerText = "LKR " + current.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
      } else {
        el.innerText = Math.floor(current).toLocaleString();
      }

      if (current < target) {
        requestAnimationFrame(animate);
      }
    }

    requestAnimationFrame(animate);
  }

  // Run count-up for all cards
  countUp("revenue", 2000); // 2 seconds
  countUp("products", 1500); // 1.5 seconds
  countUp("orders", 1500);   // 1.5 seconds

});
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
