<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/viewproduct.css?v=<?= time(); ?>">

<div id="mainContent">

  <!-- Filter -->
  <div class="filter-container">
    <input type="text" id="searchInput" placeholder="Search product...">
    <input type="number" id="minPrice" placeholder="Min Price">
    <input type="number" id="maxPrice" placeholder="Max Price">

    <!-- Province Dropdown -->
    <select id="provinceFilter" onchange="updateRegions()">
      <option value="">All Provinces</option>
      <option value="Western">Western</option>
      <option value="Central">Central</option>
      <option value="Southern">Southern</option>
      <option value="Northern">Northern</option>
      <option value="Eastern">Eastern</option>
      <option value="North Western">North Western</option>
      <option value="North Central">North Central</option>
      <option value="Uva">Uva</option>
      <option value="Sabaragamuwa">Sabaragamuwa</option>
    </select>

    <!-- Region Dropdown (was district) -->
    <select id="regionFilter">
      <option value="">All Regions</option>
      <!-- Western -->
      <option value="Colombo" data-province="Western">Colombo</option>
      <option value="Gampaha" data-province="Western">Gampaha</option>
      <option value="Kalutara" data-province="Western">Kalutara</option>
      <!-- Central -->
      <option value="Kandy" data-province="Central">Kandy</option>
      <option value="Matale" data-province="Central">Matale</option>
      <option value="Nuwara Eliya" data-province="Central">Nuwara Eliya</option>
      <!-- Southern -->
      <option value="Galle" data-province="Southern">Galle</option>
      <option value="Matara" data-province="Southern">Matara</option>
      <option value="Hambantota" data-province="Southern">Hambantota</option>
      <!-- Northern -->
      <option value="Jaffna" data-province="Northern">Jaffna</option>
      <option value="Kilinochchi" data-province="Northern">Kilinochchi</option>
      <option value="Mannar" data-province="Northern">Mannar</option>
      <option value="Vavuniya" data-province="Northern">Vavuniya</option>
      <option value="Mullaitivu" data-province="Northern">Mullaitivu</option>
      <!-- Eastern -->
      <option value="Trincomalee" data-province="Eastern">Trincomalee</option>
      <option value="Batticaloa" data-province="Eastern">Batticaloa</option>
      <option value="Ampara" data-province="Eastern">Ampara</option>
      <!-- North Western -->
      <option value="Kurunegala" data-province="North Western">Kurunegala</option>
      <option value="Puttalam" data-province="North Western">Puttalam</option>
      <!-- North Central -->
      <option value="Anuradhapura" data-province="North Central">Anuradhapura</option>
      <option value="Polonnaruwa" data-province="North Central">Polonnaruwa</option>
      <!-- Uva -->
      <option value="Badulla" data-province="Uva">Badulla</option>
      <option value="Monaragala" data-province="Uva">Monaragala</option>
      <!-- Sabaragamuwa -->
      <option value="Ratnapura" data-province="Sabaragamuwa">Ratnapura</option>
      <option value="Kegalle" data-province="Sabaragamuwa">Kegalle</option>
    </select>

    <button onclick="applyFilter()">Filter</button>
    <button onclick="resetFilter()">Reset</button>
  </div>

  <!-- Products Section -->
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
        $unit_type = htmlspecialchars($row->unit_type ?? '');
        $province  = htmlspecialchars($row->province ?? '');
        $address   = htmlspecialchars($row->seller_address ?? '');
    ?>

    <div class="order-card product-card" 
         data-name="<?= strtolower($itemName) ?>" 
         data-price="<?= $price ?>" 
         data-province="<?= strtolower($province) ?>"
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
              <div class="product-details">
                <div class="price">Rs. <?= number_format($price, 2) ?></div>
                <p><?= $description ?></p>
                <p><strong>Unit Type:</strong> <?= $unit_type ?></p>
                <p><strong>Available Quantity:</strong> <?= $available ?> units</p>
                <p><strong>Province:</strong> <?= $province ?></p>
                <p><strong>Region:</strong> <?= $region ?></p>
              </div>

              <div class="divider-vertical"></div>

              <div class="customer-details">
                <h3>Seller Info</h3>
                <p><strong>Name:</strong> <?= $sellerName ?></p>
                <p><strong>Address:</strong> <?= $address ?>, Sri Lanka</p>
                <p><strong>Contact:</strong> <?= $seller_telNo ?></p>
              </div>
            </div>

            <hr class="divider">

            <div class="action-buttons">
              <a href="<?php echo URLROOT; ?>/Marketplace/buyProduct/<?php echo $row->item_id; ?>" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Buy
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

</div>

<!-- JS Filter Script -->
<script>
function applyFilter() {
  const search = document.getElementById("searchInput").value.toLowerCase().trim();
  const minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
  const maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;
  const province = document.getElementById("provinceFilter").value.toLowerCase();
  const region = document.getElementById("regionFilter").value.toLowerCase();

  const products = document.querySelectorAll(".product-card");

  products.forEach(product => {
    const name = product.dataset.name;
    const price = parseFloat(product.dataset.price);
    const productProvince = product.dataset.province;
    const productRegion = product.dataset.region;

    let visible = true;

    if (search && !name.includes(search)) visible = false;
    if (price < minPrice || price > maxPrice) visible = false;
    if (province && productProvince !== province) visible = false;
    if (region && productRegion !== region) visible = false;

    product.style.display = visible ? "flex" : "none";
  });
}

function updateRegions() {
  const province = document.getElementById("provinceFilter").value;
  const regionSelect = document.getElementById("regionFilter");
  const options = regionSelect.querySelectorAll("option");

  options.forEach(opt => {
    if (!opt.value) return; // Keep "All Regions"
    opt.style.display = (!province || opt.dataset.province === province) ? "block" : "none";
  });

  regionSelect.value = "";
}

function resetFilter() {
  document.getElementById("searchInput").value = "";
  document.getElementById("minPrice").value = "";
  document.getElementById("maxPrice").value = "";
  document.getElementById("provinceFilter").value = "";
  document.getElementById("regionFilter").value = "";

  document.querySelectorAll(".product-card").forEach(product => {
    product.style.display = "flex";
  });
}
</script>
