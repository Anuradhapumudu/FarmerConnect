

  const searchInput = document.getElementById("searchInput");
  const statusFilter = document.getElementById("statusFilter");
  const rows = document.querySelectorAll(".userList");

  searchInput.addEventListener("keyup", filterlist);
  statusFilter.addEventListener("change", filterlist);

  function filterlist(){

      let searchValue = searchInput.value.toLowerCase().trim();
      let statusValue = statusFilter.value.toLowerCase();

      rows.forEach(function(row){

          let name = row.getAttribute("data-name")?.toLowerCase() || "";
          let id = row.getAttribute("data-id")?.toLowerCase() || "";
          let status = row.getAttribute("data-status")?.toLowerCase() || "";

          let matchSearch =
              name.includes(searchValue) ||
              id.includes(searchValue);

          let matchStatus =
              statusValue === "all" || status === statusValue;

          row.style.display = (matchSearch && matchStatus) ? "" : "none";
      });
  }

