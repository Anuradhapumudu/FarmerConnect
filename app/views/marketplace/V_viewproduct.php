<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/viewproduct.css?v=<?= time(); ?>">

<div id="mainContent">

  <!-- Filter -->
  <div class="filter-container">
    <input type="text" id="searchInput" placeholder="Search product...">
    <input type="number" id="minPrice" placeholder="Min Price">
    <input type="number" id="maxPrice" placeholder="Max Price">
    <select id="regionFilter">
      <option value="">All Regions</option>
      <option value="Colombo">Colombo</option>
      <option value="Kandy">Kandy</option>
      <option value="Galle">Galle</option>
      <option value="Jaffna">Jaffna</option>
    </select>
    <button onclick="applyFilter()">Filter</button>
    <button onclick="resetFilter()">Reset</button>
  </div>

  <!-- Products Section -->
  <?php if (!empty($data['products'])): ?>
    <div class="orders-container" id="productList">
      <?php foreach ($data['products'] as $row): ?>
        <?php 
          $price = floatval($row->price_per_unit);
          $region = htmlspecialchars($row->region);
          $itemName = htmlspecialchars($row->item_name);
          $sellerName = htmlspecialchars($row->seller_name);
          $imageUrl = URLROOT . '/uploads/' . htmlspecialchars($row->image_url);
          $available = intval($row->available_quantity);
          $description = htmlspecialchars($row->description);
          $seller_telNo = htmlspecialchars($row->seller_telNo);
          $status = htmlspecialchars($row->status);
        ?>

        <div class="order-card product-card" 
             data-name="<?= strtolower($itemName) ?>" 
             data-price="<?= $price ?>" 
             data-region="<?= strtolower($region) ?>">

          <div class="order-main-content">
            
            <!-- Product Image -->
            <div class="order-image">
              <img src="<?= $imageUrl ?>" alt="<?= $itemName ?>">
            </div>

            <!-- Product Info -->
            <div class="order-content-wrapper">
              
              <div class="order-header">
                <div class="order-id"><?= $itemName ?></div>
                <div class="status <?= strtolower($status) === 'in stock' ? 'status-instock' : 'status-outstock' ?>">
                    <?= $status ?>
                </div>
                </div>

              <div class="order-content">
                <div class="product-info">
                  
                  <!-- Product Details -->
                  <div class="product-details">
                    <p><?= $description ?></p>
                    <p><strong>Available Quantity:</strong> <?= $available ?> units</p>
                    <p><strong>Region:</strong> <?= $region ?> </p>
                    <div class="price">Rs. <?= number_format($price, 2) ?></div>
                  </div>

                  <!-- Divider -->
                  <div class="divider-vertical"></div>

                  <!-- Seller Details -->
                  <div class="customer-details">
                    <h3>Seller Info</h3>
                    <p><strong>Name:</strong> <?= $sellerName ?></p>
                    <p><strong>Region:</strong> <?= $region ?>, Sri Lanka</p>
                    <p><strong>Contact:</strong> <?= $seller_telNo ?></p>
                  </div>
                </div>

                <hr class="divider">

            <div class="action-buttons">
                <a href="<?php echo URLROOT; ?>/Marketplace/BuyProduct/<?php echo $row->item_id; ?>" class="btn btn-primary">
                  <i class="fas fa-shopping-cart"></i> Buy
                </a>
              </div>
               

              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php else: ?>
    <div class="no-orders">
      <i class="fas fa-box-open"></i>
      <h3>No Fertilizer Products Found</h3>
      <p>Try adjusting your filters or check again later.</p>
    </div>
  <?php endif; ?>

</div>

<!-- JS Filter Script -->
<script>
function applyFilter() {
  const search = document.getElementById("searchInput").value.toLowerCase().trim();
  const minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
  const maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;
  const region = document.getElementById("regionFilter").value.toLowerCase();
  const products = document.querySelectorAll(".product-card");

  products.forEach(product => {
    const name = product.dataset.name;
    const price = parseFloat(product.dataset.price);
    const productRegion = product.dataset.region;

    let visible = true;

    if (search && !name.includes(search)) visible = false;
    if (price < minPrice || price > maxPrice) visible = false;
    if (region && productRegion !== region) visible = false;

    product.style.display = visible ? "flex" : "none";
  });
}

function resetFilter() {
  document.getElementById("searchInput").value = "";
  document.getElementById("minPrice").value = "";
  document.getElementById("maxPrice").value = "";
  document.getElementById("regionFilter").value = "";

  document.querySelectorAll(".product-card").forEach(product => {
    product.style.display = "flex";
  });
}
</script>