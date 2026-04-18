const search = document.getElementById("search");
const statusFilter = document.getElementById("statusFilter");
const orders = document.querySelectorAll('.farmer-order-card');

search.addEventListener("keyup", filterOrders);
statusFilter.addEventListener("change", filterOrders);

function filterOrders(){

    let searchValue = search.value.toLowerCase().trim();
    let statusValue = statusFilter.value.toLowerCase();

    orders.forEach(function(order){

        let orderId = order.getAttribute("data-order-id").toLowerCase().trim();
        let productName = order.getAttribute("data-product-name")?.toLowerCase().trim() || "";
        let status = order.getAttribute("data-status").toLowerCase();

        let matchSearch = orderId.includes(searchValue) || productName.includes(searchValue);
        let matchStatus = statusValue === "all" || status === statusValue;

        if(matchSearch && matchStatus){
            order.style.display = "block"; // or "flex"
        }else{
            order.style.display = "none";
        }
    });
}



