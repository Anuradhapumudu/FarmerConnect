const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");

const orders = document.querySelectorAll(".order-card");
const paddies = document.querySelectorAll(".paddy-card");

searchInput.addEventListener("keyup", filterList);
statusFilter.addEventListener("change", filterList);

function filterList() {

    let searchValue = searchInput.value.toLowerCase().trim();

    // Filter Orders
    orders.forEach(function(order){
        let orderid = order.getAttribute("data-order")?.toLowerCase() || "";

        let match = orderid.includes(searchValue);

        order.style.display = match ? "" : "none";
    });

    //  Filter Paddy
    paddies.forEach(function(paddy){
        let plr = paddy.getAttribute("data-plr")?.toLowerCase() || "";

        let match = plr.includes(searchValue);

        paddy.style.display = match ? "" : "none";
    });
}