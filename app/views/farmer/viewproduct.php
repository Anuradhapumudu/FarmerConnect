
<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/viewproduct.css?v=<?= time(); ?>">

<div id="mainContent">

  

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="<?= URLROOT ?>/pages/index">Home</a><span>/</span>
    <a href="<?= URLROOT ?>/marketplace">Marketplace</a><span>/</span>
    <h2 class="marketplace-heading"><?php echo $data['category']; ?> Products</h2>
    
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

   <div class="product-list">
      <?php if (!empty($data['products'])): ?>
        <?php foreach ($data['products'] as $product): ?>
          <div class="product-card">
            <h3><?php echo htmlspecialchars($product->product_name); ?></h3>
            <p><?php echo htmlspecialchars($product->description); ?></p>
            <p>Price: Rs. <?php echo htmlspecialchars($product->price); ?></p>
            <p>Seller: <?php echo htmlspecialchars($product->seller_name); ?></p>
            <a href="<?php echo URLROOT; ?>/buyProduct/<?php echo $product->item_id; ?>" class="btn">Buy Now</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No products found in this category.</p>
      <?php endif; ?>
    </div>
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
    let price = parseInt(product.querySelector(".price").textContent.replace(/\D/g, ""));
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