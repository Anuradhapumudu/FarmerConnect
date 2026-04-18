
const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");
const rows = document.querySelectorAll("tbody tr");

// Event listeners
searchInput.addEventListener("keyup", filterOrders);
statusFilter.addEventListener("change", filterOrders);

function filterOrders() {

    let searchValue = searchInput.value.toLowerCase().trim();
    let statusValue = statusFilter.value.toLowerCase();

    rows.forEach(function(row){

        let orderId = row.getAttribute("data-order")?.toLowerCase() || "";
        let sellerId = row.getAttribute("data-seller")?.toLowerCase() || "";
        let customerId = row.getAttribute("data-customer")?.toLowerCase() || "";
        let status = row.getAttribute("data-status")?.toLowerCase() || "";

       
        let matchSearch = 
            orderId.includes(searchValue) ||
            sellerId.includes(searchValue) ||
            customerId.includes(searchValue);

        
        let matchStatus = statusValue === "all" || status === statusValue;

        
        if (matchSearch && matchStatus) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });
}



  