<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/dashboard.css?v=<?= time(); ?>">

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1>Welcome to FarmerConnect.lk</h1>
    <p>Connect with agri experts, sellers, and a thriving farming community in Sri Lanka.</p>
    <!-- Get Started button -->
    <a href="#features" id="getStartedBtn" class="btn">Get Started</a>
  </div>
</section>

<!-- Features Section -->
<section id="features">
  <h2>Features</h2>

  <div class="features_block">
    <a href="<?php echo URLROOT; ?>/Farmertimeline" class="feature">
      <i class="fa-solid fa-clock fa-2x"></i>
      <h3>Timeline</h3>
      <p>Track planting, harvesting, and seasonal activities efficiently.</p>
</a>

    <a href="<?php echo URLROOT; ?>/FertilizerCalculator" class="feature">
      <i class="fa-solid fa-calculator fa-2x"></i>
      <h3>Fertilizer Calculator</h3>
      <p>Get accurate fertilizer recommendations based on crop and soil.</p>
</a>

    <a href="<?php echo URLROOT; ?>/Disease" class="feature">
      <i class="fa-solid fa-virus fa-2x"></i>
      <h3>Disease Reports</h3>
      <p>Stay informed about pest and crop disease outbreaks in your area.</p>
</a>

    <a href="<?php echo URLROOT; ?>/Knowledgecenter/KnowledgecenterFarmer" class="feature">
      <i class="fa-solid fa-book-open fa-2x"></i>
      <h3>Knowledge Center</h3>
      <p>Access guides, tutorials, and expert advice on agriculture.</p>
</a>

    <a href="<?php echo URLROOT; ?>/Marketplace/MarketplaceFarmer" class="feature">
      <i class="fa-solid fa-store fa-2x"></i>
      <h3>Marketplace</h3>
      <p>Buy and sell produce, equipment, and services with ease.</p>
    </a>

    <div class="feature">
      <i class="fa-solid fa-comments fa-2x"></i>
      <h3>Complain</h3>
      <p>Report issues directly to the relevant agricultural authorities.</p>
    </div>
  </div>
</section>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>

<!-- Optional JS for smooth scrolling -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  function wrapLetters(elId) {
    const el = document.getElementById(elId);
    if (!el) return;
    el.innerHTML = el.textContent.split('').map(char => {
      if (char === ' ') return '&nbsp;';
      return `<span class="letter">${char}</span>`;
    }).join('');
  }

  wrapLetters('heroTitle');
  wrapLetters('heroDesc');

  // Animate each letter individually
  document.querySelectorAll('.letter').forEach((letter, i) => {
    letter.style.animation = `slideUpIn 0.6s forwards ${i * 0.05}s`;
  });
});
</script>
