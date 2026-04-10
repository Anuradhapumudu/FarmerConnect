<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/marketplaceDashboard.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">

<div class="containers">

  <h2 class="marketplace-heading">Marketplace</h2>
  <p class="marketplace-description">
    Monitor and manage all marketplace activities.
  </p>


  <div class="admindashboard">

    <div class="card">
      <div class="title">
        Total Revenue LKR
        <i class="fa-solid fa-money-bill"></i>
      </div>
      <?php $rev = $data['revenue']->revenue ?? 0;?>
     <div class="number">
          LKR <?= number_format($rev, 2) ?>
      </div>
    </div>

    <div class="card">
      <div class="title">
        Active Products
        <i class="fas fa-box"></i>
          </div>
    <?php $prodCount = $data['activeProducts']->active_products ?? 0;?>
    <div class="number">
        <?= number_format($prodCount) ?>
    </div>
    </div>

    <div class="card">
      <div class="title">
        Total Orders
        <i class="fas fa-shopping-cart"></i>
      </div>
    <?php $ordersCount = $data['totalOrders']->total_orders ?? 0;?>
    <div class="number">
        <?= number_format($ordersCount) ?>
    </div>
    </div>
  </div>

  <!-- Marketplace Cards -->
  <div class="adminfeatures_block">
    <div class="adminfeature-card">
      <div class="adminfeature-top" style="background-image: url('<?php echo URLROOT; ?>/img/def.png');"></div>
      <div class="feature-bottom">
        <h3>View All Products</h3>
        <p>Add, edit, or remove your listed items</p>
        <a href="<?php echo URLROOT; ?>/Marketplace/adminViewProducts" class="btn">View</a>
      </div>
    </div>

    <div class="adminfeature-card">
      <div class="adminfeature-top" style="background-image: url('<?php echo URLROOT; ?>/img/abc.jpg');"></div>
      <div class="feature-bottom">
        <h3>View All Orders</h3>
        <p>View and manage customer orders.</p>
        <a href="<?php echo URLROOT; ?>/Marketplace/adminViewOrders" class="btn">View</a>
      </div>
    </div>
  </div>

</div>

</main>

</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
