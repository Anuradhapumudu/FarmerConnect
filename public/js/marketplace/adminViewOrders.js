
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


    document.addEventListener('DOMContentLoaded', function() {
      // Navigation between pages
      const navLinks = document.querySelectorAll('.nav-link');
      const adminContents = document.querySelectorAll('.admin-content');
      
      navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          
          // Remove active class from all links and contents
          navLinks.forEach(l => l.classList.remove('active'));
          adminContents.forEach(c => c.classList.remove('active'));
          
          // Add active class to clicked link
          this.classList.add('active');
          
          // Show the corresponding content
          const target = this.getAttribute('data-target');
          document.getElementById(target).classList.add('active');
        });
      });
      
      // Modal functionality
      const orderModal = document.getElementById('order-detail-modal');
      const viewButtons = document.querySelectorAll('.view-btn');
      const closeModalButtons = document.querySelectorAll('.close-modal');

      function openOrderModal(data) {
        document.getElementById('modal-order-id').textContent = data.order;
        document.getElementById('modal-order-id-2').textContent = '#' + data.order;
        document.getElementById('modal-order-date').textContent = data.date || '';
        document.getElementById('modal-order-status').textContent = data.status || '';
        document.getElementById('modal-order-quantity').textContent = data.quantity || '';
        document.getElementById('modal-order-category').textContent = data.category || '';
        document.getElementById('modal-order-amount').textContent = data.amount ? ('LKR ' + data.amount) : '';
        document.getElementById('modal-payment-method').textContent = data['paymentMethod'] || '';

        document.getElementById('modal-customer-name').textContent = data.customer || '';
        document.getElementById('modal-customer-phone').textContent = data.phone || '';
        document.getElementById('modal-customer-address').textContent = data.address || '';

        document.getElementById('modal-seller-name').textContent = data.seller || '';
        document.getElementById('modal-seller-phone').textContent = data.sellerPhone || '';
        document.getElementById('modal-seller-address').textContent = data.sellerAddress || '';

        // show modal
        orderModal.style.display = 'flex';
      }

      // Open modal when view button is clicked
      viewButtons.forEach(button => {
        button.addEventListener('click', function() {
          const ds = this.dataset;
          openOrderModal({
            order: ds.order,
            customer: ds.customer,
            product: ds.product,
            category: ds.category,
            seller: ds.seller,
            date: ds.date,
            quantity: ds.quantity,
            amount: ds.amount,
            status: ds.status,
            paymentMethod: ds.paymentMethod,
            phone: ds.phone,
            address: ds.address,
            sellerPhone: ds.sellerPhone,
            sellerAddress: ds.sellerAddress
          });
        });
      });

      // Close modal when close button is clicked
      closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
          orderModal.style.display = 'none';
        });
      });
      
      // Close modal when clicking outside
      window.addEventListener('click', function(e) {
        if (e.target === orderModal) {
          orderModal.style.display = 'none';
        }
      });
      

    });
  