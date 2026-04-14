


const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");

const rows = document.querySelectorAll(".userList");

searchInput.addEventListener("keyup", filterlist);
statusFilter.addEventListener("change", filterlist);

function filterlist(){

    let searchValue = searchInput.value.toLowerCase().trim();
    let statusValue = statusFilter.value.toLowerCase();

    rows.forEach(function(row){

        let firstName =  row.getAttribute("data-fname")?.toLowerCase() || "";
        let lastName =  row.getAttribute("data-lname")?.toLowerCase() || "";
        let Id = row.getAttribute("data-id")?.toLowerCase() || "";
        let status = row.getAttribute("data-status")?.toLowerCase() || "";

        let matchSearch =firstName.includes(searchValue) || lastName.includes(searchValue) || Id.includes(searchValue);

        let matchStatus = statusValue === "all" || status === statusValue;

        if (matchSearch && matchStatus) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });
}
