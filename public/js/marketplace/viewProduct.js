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