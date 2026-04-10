<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/adminviewproducts.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="containers">
    <div class="header">
      <h1>Product Management</h1>
    </div>

    <!-- Filter -->
    <div class="filter-container center-content">
      <div class="filter-wrapper">
        <input type="text" id="searchInput" placeholder="Product Name / Seller ID...">
        <input type="number" id="minPrice" placeholder="Min Price">
        <input type="number" id="maxPrice" placeholder="Max Price">

        <select id="categoryFilter">
          <option value="">All Items</option>
          <option value="Fertilizer">Fertilizer</option>
          <option value="Seeds">Paddy seeds</option>
          <option value="Tools">Agrochemicals</option>
          <option value="Tools">Equipments</option>
          <option value="Tools">Rent Machinery</option>
          <option value="Others">Others</option>
        </select>

        <select id="provinceFilter" onchange="updateRegions()">
          <option value="">All Provinces</option>
          <option value="Central">Central</option>
          <option value="Eastern">Eastern</option>
          <option value="North Central">North Central</option>
          <option value="North Western">North Western</option>
          <option value="Northern">Northern</option>
          <option value="Sabaragamuwa">Sabaragamuwa</option>
          <option value="Southern">Southern</option>
          <option value="Uva">Uva</option>
          <option value="Western">Western</option>
        </select>

        <select id="regionFilter">
          <option value="">All Regions</option>
          <!-- Regions grouped by province -->
          <option value="Colombo" data-province="Western">Colombo</option>
          <option value="Gampaha" data-province="Western">Gampaha</option>
          <option value="Kalutara" data-province="Western">Kalutara</option>
          <option value="Kandy" data-province="Central">Kandy</option>
          <option value="Matale" data-province="Central">Matale</option>
          <option value="Nuwara Eliya" data-province="Central">Nuwara Eliya</option>
          <option value="Galle" data-province="Southern">Galle</option>
          <option value="Matara" data-province="Southern">Matara</option>
          <option value="Hambantota" data-province="Southern">Hambantota</option>
          <option value="Jaffna" data-province="Northern">Jaffna</option>
          <option value="Kilinochchi" data-province="Northern">Kilinochchi</option>
          <option value="Mannar" data-province="Northern">Mannar</option>
          <option value="Vavuniya" data-province="Northern">Vavuniya</option>
          <option value="Mullaitivu" data-province="Northern">Mullaitivu</option>
          <option value="Trincomalee" data-province="Eastern">Trincomalee</option>
          <option value="Batticaloa" data-province="Eastern">Batticaloa</option>
          <option value="Ampara" data-province="Eastern">Ampara</option>
          <option value="Kurunegala" data-province="North Western">Kurunegala</option>
          <option value="Puttalam" data-province="North Western">Puttalam</option>
          <option value="Anuradhapura" data-province="North Central">Anuradhapura</option>
          <option value="Polonnaruwa" data-province="North Central">Polonnaruwa</option>
          <option value="Badulla" data-province="Uva">Badulla</option>
          <option value="Monaragala" data-province="Uva">Monaragala</option>
          <option value="Ratnapura" data-province="Sabaragamuwa">Ratnapura</option>
          <option value="Kegalle" data-province="Sabaragamuwa">Kegalle</option>
        </select>

        <select id="statusFilter">
          <option value="">Any Status</option>
          <option value="Instock">In Stock</option>
          <option value="Outstock">Out Stock</option>
        </select>

        <button onclick="applyFilter()">Filter</button>
        <button onclick="resetFilter()">Reset</button>
      </div>
    </div>

    <!-- Products Section -->
    <div class="orders-container">
      <?php if(!empty($data['products'])): ?>
        <?php foreach($data['products'] as $product): ?>
          <div class="order-card product-container" 
               data-category="<?php echo htmlspecialchars($product->category); ?>" 
               data-province="<?php echo htmlspecialchars($product->province); ?>" 
               data-region="<?php echo htmlspecialchars($product->region); ?>" 
               data-status="<?php echo htmlspecialchars($product->status); ?>">

            <div class="order-main-content">
              <div class="order-image">
                <img src="<?php echo URLROOT . '/uploads/' . ($product->image_url ?? 'default.jpg');?>" 
                     alt="<?php echo htmlspecialchars($product->item_name); ?>">
              </div>
              
              <div class="order-content-wrapper">
                <div class="order-header">
                  <div>
                    <div class="order-id"><?= htmlspecialchars(ucfirst(strtolower($product->item_name))) ?></div>
                    <div class="order-id"><?php echo htmlspecialchars($product->item_id); ?></div>
                  </div>
                  <div class="order-status <?php echo strtolower($product->status); ?>">
                    <?php echo htmlspecialchars($product->status); ?>
                  </div>
                </div>

                <div class="order-content">
                  <div class="product-info">
                    <div class="product-details">
                      <p><strong>Description:</strong> <?php echo htmlspecialchars($product->description ?? 'N/A'); ?></p>
                      <p><strong>Category:</strong> <?php echo htmlspecialchars($product->category); ?></p>
                      <p><strong>Province:</strong> <?php echo htmlspecialchars($product->province); ?></p>
                      <p><strong>District:</strong> <?php echo htmlspecialchars($product->region); ?></p>
                      <p><strong>Available Quantity:</strong> <?php echo htmlspecialchars($product->available_quantity); ?> <?php echo htmlspecialchars($product->unit_type); ?></p>
                      <div class="price">LKR <?php echo number_format($product->price_per_unit, 2); ?></div>
                    </div>

                    <div class="divider-vertical"></div>

                    <div class="customer-details">
                      <h3>Seller Info</h3>
                      <p><strong>Seller ID:</strong> <?php echo htmlspecialchars($product->seller_id); ?></p>
                      <p><strong>Name:</strong> <?php echo htmlspecialchars($product->seller_name); ?></p>
                      <p><strong>Company:</strong> <?php echo htmlspecialchars($product->seller_company ?? 'N/A'); ?></p>
                      <p><strong>Address:</strong> <?php echo htmlspecialchars($product->seller_address); ?></p>
                      <p><strong>Contact:</strong> <?php echo htmlspecialchars($product->seller_telNo); ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No products found.</p>
      <?php endif; ?>
    </div>

  </div>
</main>

<script>
function applyFilter() {
  const search = document.getElementById("searchInput").value.toLowerCase().trim();
  const minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
  const maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;
  const category = document.getElementById("categoryFilter").value.toLowerCase();
  const province = document.getElementById("provinceFilter").value.toLowerCase();
  const region = document.getElementById("regionFilter").value.toLowerCase();
  const status = document.getElementById("statusFilter").value.toLowerCase();

  const products = document.querySelectorAll(".product-container");

  products.forEach(product => {
    // Get product name (first .order-id)
    const nameElem = product.querySelector(".order-id:first-child");
    const name = nameElem ? nameElem.textContent.toLowerCase() : "";

    // ✅ Get Seller ID
    const sellerIdElem = product.querySelector(".customer-details p strong");
    let sellerId = "";
    if (sellerIdElem && sellerIdElem.textContent.toLowerCase().includes("seller id")) {
      const nextNode = sellerIdElem.nextSibling;
      if (nextNode) sellerId = nextNode.textContent.trim().toLowerCase();
    }

    // Get price
    const priceElem = product.querySelector(".price");
    const price = priceElem ? parseFloat(priceElem.textContent.replace(/[^0-9.]/g, "")) : 0;

    // Get data attributes
    const prodCategory = product.getAttribute("data-category").toLowerCase();
    const prodProvince = product.getAttribute("data-province").toLowerCase();
    const prodRegion = product.getAttribute("data-region").toLowerCase();
    const prodStatus = product.getAttribute("data-status").toLowerCase();

    // Check all filters
    let match = true;

    // ✅ Search by product name OR seller ID
    if (search && !name.includes(search) && !sellerId.includes(search)) match = false;

    if (price < minPrice || price > maxPrice) match = false;
    if (category && category !== "" && prodCategory !== category) match = false;
    if (province && province !== "" && prodProvince !== province) match = false;
    if (region && region !== "" && prodRegion !== region) match = false;
    if (status && status !== "" && prodStatus !== status) match = false;

    product.style.display = match ? "flex" : "none";
  });
}

function resetFilter() {
  document.getElementById("searchInput").value = "";
  document.getElementById("minPrice").value = "";
  document.getElementById("maxPrice").value = "";
  document.getElementById("categoryFilter").value = "";
  document.getElementById("provinceFilter").value = "";
  document.getElementById("regionFilter").value = "";
  document.getElementById("statusFilter").value = "";

  document.querySelectorAll(".product-container").forEach(product => {
    product.style.display = "flex";
  });
}

function updateRegions() {
  const province = document.getElementById("provinceFilter").value;
  const regionOptions = document.querySelectorAll("#regionFilter option");

  regionOptions.forEach(option => {
    if (!option.value) {
      option.style.display = "block"; // "All Regions"
    } else if (province && option.dataset.province !== province) {
      option.style.display = "none";
    } else {
      option.style.display = "block";
    }
  });

  // Reset region if it's not valid anymore
  const regionFilter = document.getElementById("regionFilter");
  if (regionFilter.value && regionFilter.selectedOptions[0].style.display === "none") {
    regionFilter.value = "";
  }
}
</script>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>
