<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/viewproduct.css?v=<?= time(); ?>">

<div id="mainContent">

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="<?= URLROOT ?>/index">Home</a><span>/</span>
    <a href="<?= URLROOT ?>/marketplace">Marketplace</a><span>/</span>
    <span>Fertilizer</span>
  </div>

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

  <!-- Products -->
  <?php if (!empty($data['products'])): ?>
      <?php foreach ($data['products'] as $row): ?>
          <?php 
              $price = floatval($row->price_per_unit);
              $region = htmlspecialchars($row->region);
              $itemName = htmlspecialchars($row->item_name);
              $sellerName = htmlspecialchars($row->seller_name);
              $imageUrl = URLROOT . '/uploads/' . htmlspecialchars($row->image_url);
              $available = intval($row->available_quantity);
              $itemId = intval($row->item_id);
          ?>
          <div class="product-container" data-region="<?= $region ?>">
            <img src="<?= $imageUrl ?>" alt="<?= $itemName ?>">
            <div class="product-details">
              <span class="in-stock">In Stock</span>
              <h2><?= $itemName ?></h2>
              <div><span class="price">Rs. <?= number_format($price, 2) ?></span></div>
              <p class="description">Available Quantity: <?= $available ?><br>Seller: <?= $sellerName ?></p>
              <div class="quantity-add">
                <a class="add-to-cart" href="<?= URLROOT ?>/marketplace/buyProduct/<?= $itemId ?>">Buy Now</a>
              </div>
              <hr class="divider">
              <div class="product_quality">
                <div class="quality_box">
                  <div class="quality_icon"><i class="fa-solid fa-truck"></i></div>
                  <div class="quality">Delivery Info</div>
                </div>
                <div class="quality_box">
                  <div class="quality_icon"><i class="fa-solid fa-shield-heart"></i></div>
                  <div class="quality">Quality Guarantee</div>
                </div>
              </div>
            </div>
          </div>
      <?php endforeach; ?>
  <?php else: ?>
      <p style="text-align:center;margin-top:30px;">No Fertilizer products found.</p>
  <?php endif; ?>

</div>

<script>
function applyFilter() {
  let search = document.getElementById("searchInput").value.toLowerCase();
  let minPrice = document.getElementById("minPrice").value;
  let maxPrice = document.getElementById("maxPrice").value;
  let region = document.getElementById("regionFilter").value;
  let products = document.querySelectorAll(".product-container");

  products.forEach(product => {
    let name = product.querySelector("h2").textContent.toLowerCase();
    let price = parseFloat(product.querySelector(".price").textContent.replace(/\D/g, "")) || 0;
    let location = product.getAttribute("data-region");
    let match = true;

    if (search && !name.includes(search)) match = false;
    if (minPrice && price < minPrice) match = false;
    if (maxPrice && price > maxPrice) match = false;
    if (region && location !== region) match = false;

    product.style.display = match ? "flex" : "none";
  });
}

function resetFilter() {
  document.getElementById("searchInput").value = "";
  document.getElementById("minPrice").value = "";
  document.getElementById("maxPrice").value = "";
  document.getElementById("regionFilter").value = "";
  document.querySelectorAll(".product-container").forEach(p => p.style.display = "flex");
}
</script>

<?php require_once APPROOT . '/views/inc/components/sidebarlink.php'; ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
