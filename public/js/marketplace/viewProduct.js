const searchInput = document.getElementById("searchInput");
const minInput = document.getElementById("minPrice");
const maxInput = document.getElementById("maxPrice");
const provinceFilter = document.getElementById("provinceFilter");
const regionFilter = document.getElementById("regionFilter");

const products = document.querySelectorAll(".order-card.product-card");


searchInput.addEventListener("keyup", filterProducts);
provinceFilter.addEventListener("change", filterProducts);
regionFilter.addEventListener("change", filterProducts);
minInput.addEventListener("input", filterProducts);
maxInput.addEventListener("input", filterProducts);

function filterProducts() {

  let searchValue = searchInput.value.toLowerCase().trim();
  let minPrice = parseFloat(minInput.value) || 0;
  let maxPrice = parseFloat(maxInput.value) || Infinity;
  let province = provinceFilter.value.toLowerCase();
  let region = regionFilter.value.toLowerCase();

  products.forEach(function(product){

    let name = product.getAttribute("data-name").toLowerCase();
    let price = parseFloat(product.getAttribute("data-price"));
    let productProvince = product.getAttribute("data-province").toLowerCase();
    let productRegion = product.getAttribute("data-region").toLowerCase();

    let matchSearch = name.includes(searchValue);
    let matchProvince = province === "" || productProvince === province;
    let matchRegion = region === "" || productRegion === region;
    let matchPrice = price >= minPrice && price <= maxPrice;

    if (matchSearch && matchProvince && matchRegion && matchPrice) {
        product.style.display = "block"; 
    } else {
        product.style.display = "none";
    }

  });
}



function updateRegions() {
  const province = document.getElementById("provinceFilter").value;
  const regionSelect = document.getElementById("regionFilter");
  const options = regionSelect.querySelectorAll("option");

  options.forEach(opt => {
    if (!opt.value) return; //keep all regions
    opt.style.display = (!province || opt.dataset.province === province) ? "block" : "none";
  });

  regionSelect.value = "";
}

function checkStock(btn) {
    let qty = btn.getAttribute("data-qty");
    let status = btn.getAttribute("data-status");

    if (qty <= 0 || status === "Outstock") {
        alert("This product is out of stock");
        return false;
    }
    return true;
}

