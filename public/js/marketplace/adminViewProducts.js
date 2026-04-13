const searchInput = document.getElementById("searchInput");
const minInput = document.getElementById("minPrice");
const maxInput = document.getElementById("maxPrice");
const categoryFilter = document.getElementById("categoryFilter");
const provinceFilter = document.getElementById("provinceFilter");
const regionFilter = document.getElementById("regionFilter");
const statusFilter = document.getElementById("statusFilter");

const products = document.querySelectorAll(".order-card.product-container");

// Event listeners
searchInput.addEventListener("keyup", filterProducts);
provinceFilter.addEventListener("change", filterProducts);
regionFilter.addEventListener("change", filterProducts);
minInput.addEventListener("input", filterProducts);
maxInput.addEventListener("input", filterProducts);
statusFilter.addEventListener("change", filterProducts);
categoryFilter.addEventListener("change", filterProducts);

function filterProducts() {

  let searchValue = searchInput.value.toLowerCase().trim();
  let minPrice = parseFloat(minInput.value) || 0;
  let maxPrice = parseFloat(maxInput.value) || Infinity;
  let province = provinceFilter.value.toLowerCase();
  let region = regionFilter.value.toLowerCase();
  let statusValue = statusFilter.value.toLowerCase();
  let categoryValue = categoryFilter.value.toLowerCase();

  products.forEach(function(product){

    let name = product.getAttribute("data-product-name") || "";
    let id = product.getAttribute("data-seller-id") || "";
    let price = parseFloat(product.getAttribute("data-price")) || 0;
    let productProvince = product.getAttribute("data-province") || "";
    let productRegion = product.getAttribute("data-region") || "";
    let status = product.getAttribute("data-status") || "";
    let category = product.getAttribute("data-category") || "";

    // Convert to lowercase safely
    name = name.toLowerCase();
    id = id.toLowerCase();
    productProvince = productProvince.toLowerCase();
    productRegion = productRegion.toLowerCase();
    status = status.toLowerCase();
    category = category.toLowerCase();

    // Conditions
    let matchSearch = name.includes(searchValue) || id.includes(searchValue);
    let matchProvince = province === "" || productProvince === province;
    let matchRegion = region === "" || productRegion === region;
    let matchPrice = price >= minPrice && price <= maxPrice;
    let matchStatus = statusValue === "" || status === statusValue;
    let matchCategory = categoryValue === "" || category === categoryValue;

    if (matchSearch && matchProvince && matchRegion && matchPrice && matchStatus && matchCategory) {
        product.style.display = "block"; // or "flex" if needed
    } else {
        product.style.display = "none";
    }

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
