<?php require_once APPROOT . '/views/inc/adminheader.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/marketplace/adminviewproducts.css?v=<?= time(); ?>">

<main class="main-content" id="mainContent">
  <div class="containers">
    <div class="header text-center">
      <h1>Product Management</h1>
    </div>

    <!-- Filter -->
    <div class="filter-container center-content">
      <div class="filter-wrapper">
        <input type="text" id="searchInput" placeholder="Search product...">
        <input type="number" id="minPrice" placeholder="Min Price">
        <input type="number" id="maxPrice" placeholder="Max Price">
        <select id="categoryFilter">
          <option value="">All Items</option>
          <option value="Fertilizer">Fertilizer</option>
          <option value="Seeds">Paddy seeds</option>
          <option value="Tools">Tools</option>
          <option value="Others">Others</option>
        </select>
        <!-- Province Dropdown -->
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

    <!-- Region Dropdown (was district) -->
    <select id="regionFilter">
      <option value="">All Regions</option>
      <!-- Western -->
      <option value="Colombo" data-province="Western">Colombo</option>
      <option value="Gampaha" data-province="Western">Gampaha</option>
      <option value="Kalutara" data-province="Western">Kalutara</option>
      <!-- Central -->
      <option value="Kandy" data-province="Central">Kandy</option>
      <option value="Matale" data-province="Central">Matale</option>
      <option value="Nuwara Eliya" data-province="Central">Nuwara Eliya</option>
      <!-- Southern -->
      <option value="Galle" data-province="Southern">Galle</option>
      <option value="Matara" data-province="Southern">Matara</option>
      <option value="Hambantota" data-province="Southern">Hambantota</option>
      <!-- Northern -->
      <option value="Jaffna" data-province="Northern">Jaffna</option>
      <option value="Kilinochchi" data-province="Northern">Kilinochchi</option>
      <option value="Mannar" data-province="Northern">Mannar</option>
      <option value="Vavuniya" data-province="Northern">Vavuniya</option>
      <option value="Mullaitivu" data-province="Northern">Mullaitivu</option>
      <!-- Eastern -->
      <option value="Trincomalee" data-province="Eastern">Trincomalee</option>
      <option value="Batticaloa" data-province="Eastern">Batticaloa</option>
      <option value="Ampara" data-province="Eastern">Ampara</option>
      <!-- North Western -->
      <option value="Kurunegala" data-province="North Western">Kurunegala</option>
      <option value="Puttalam" data-province="North Western">Puttalam</option>
      <!-- North Central -->
      <option value="Anuradhapura" data-province="North Central">Anuradhapura</option>
      <option value="Polonnaruwa" data-province="North Central">Polonnaruwa</option>
      <!-- Uva -->
      <option value="Badulla" data-province="Uva">Badulla</option>
      <option value="Monaragala" data-province="Uva">Monaragala</option>
      <!-- Sabaragamuwa -->
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


  <!-- Products Section -->
    <div class="orders-container">

<div class="order-card">
  <div class="order-main-content">
    <div class="order-image">
      <img src="<?php echo URLROOT; ?>/img/collage.jpg" alt="Premium Paddy Seeds">
    </div>
    
    <div class="order-content-wrapper">
      <div class="order-header">
        <div>
          <div class="order-id">Premium Paddy Seeds</div>
        </div>
        <div class="order-status status-outstock">Outstock</div>
      </div>
  
      <div class="order-content"> 
        <div class="product-info">
          <div class="product-details">
            <p>Description:</p>
            <p>Category: Paddy Seeds</p>
            <p>Province: Western</p>
            <p>District: Colombo</p>
            <p>Available quantity: 10 Kg</p>
            <p>Unit Type: Kg</p>
            <div class="price">LKR 5,000.00</div>
          </div>
        
          <div class="divider-vertical"></div>

          <div class="customer-details">
            <h3>Seller Info</h3>
            <p><strong>Name:</strong> <span class="customer-name">A.J.K Athukorala</span></p>
            <p><strong>Address:</strong> Kandy, Sri Lanka</p>
            <p><strong>Contact:</strong> +94 71 123 4567</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="order-card">
  <div class="order-main-content">
    <div class="order-image">
      <img src="<?php echo URLROOT; ?>/img/vegetables.jpg" alt="Organic Vegetables">
    </div>
    
    <div class="order-content-wrapper">
      <div class="order-header">
        <div>
          <div class="order-id">Organic Vegetables</div>
        </div>
        <div class="order-status status-confirmed">In Stock</div>
      </div>
  
      <div class="order-content"> 
        <div class="product-info">
          <div class="product-details">
            <p>Description:</p>
            <p>Category: Vegetables</p>
            <p>Province: Central</p>
            <p>District: Matale</p>
            <p>Available quantity: 20 Kg</p>
            <p>Unit Type: Kg</p>
            <div class="price">LKR 3,200.00</div>
          </div>
        
          <div class="divider-vertical"></div>

          <div class="customer-details">
            <h3>Seller Info</h3>
            <p><strong>Name:</strong> <span class="customer-name">S.M. Perera</span></p>
            <p><strong>Address:</strong> Dambulla, Sri Lanka</p>
            <p><strong>Contact:</strong> +94 71 987 6543</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="order-card">
  <div class="order-main-content">
    <div class="order-image">
      <img src="<?php echo URLROOT; ?>/img/fruits.jpg" alt="Fresh Fruits">
    </div>
    
    <div class="order-content-wrapper">
      <div class="order-header">
        <div>
          <div class="order-id">Fresh Fruits</div>
        </div>
        <div class="order-status status-delivered">In Stock</div>
      </div>
  
      <div class="order-content"> 
        <div class="product-info">
          <div class="product-details">
            <p>Description:</p>
            <p>Category: Fruits</p>
            <p>Province: Southern</p>
            <p>District: Galle</p>
            <p>Available quantity: 15 Kg</p>
            <p>Unit Type: Kg</p>
            <div class="price">LKR 4,500.00</div>
          </div>
        
          <div class="divider-vertical"></div>

          <div class="customer-details">
            <h3>Seller Info</h3>
            <p><strong>Name:</strong> <span class="customer-name">N.D. Fernando</span></p>
            <p><strong>Address:</strong> Hikkaduwa, Sri Lanka</p>
            <p><strong>Contact:</strong> +94 77 555 1122</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


    </div>


</div>


</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize all components
      initMobileMenu();
      initSidebar();
    });

    // ---------------- SIDEBAR ----------------
    function initSidebar() {
      const sidebar = document.getElementById('sidebar');
      const sidebarToggleNav = document.getElementById('sidebarToggleNav');
      const mainContent = document.getElementById('mainContent');
      const footer = document.getElementById('footer');
      const overlay = document.getElementById('overlay');
      
      if (!sidebar || !sidebarToggleNav) return;
      
      function toggleSidebar() {
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
          // Mobile behavior - slide in/out from left
          sidebar.classList.toggle('expanded');
          if (overlay) {
            overlay.classList.toggle('active');
          }
          // Prevent body scrolling when sidebar is open on mobile
          if (sidebar.classList.contains('expanded')) {
            document.body.style.overflow = 'hidden';
          } else {
            document.body.style.overflow = 'auto';
          }
        } else {
          // Desktop behavior - expand/collapse in place
          sidebar.classList.toggle('expanded');
          mainContent.classList.toggle('expanded');
          if (footer) {
            footer.classList.toggle('expanded');
          }
        }
      }

      function closeSidebar() {
        sidebar.classList.remove('expanded');
        mainContent.classList.remove('expanded');
        if (footer) {
          footer.classList.remove('expanded');
        }
        if (overlay) {
          overlay.classList.remove('active');
        }
        document.body.style.overflow = 'auto';
      }
      
      sidebarToggleNav.addEventListener('click', toggleSidebar);

      // Close sidebar when clicking on overlay (mobile)
      if (overlay) {
        overlay.addEventListener('click', closeSidebar);
      }

      // Close sidebar when clicking on sidebar links (mobile)
      const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
      sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
          if (window.innerWidth <= 768 && sidebar.classList.contains('expanded')) {
            closeSidebar();
          }
        });
      });

      // Handle window resize
      window.addEventListener('resize', () => {
        const isMobile = window.innerWidth <= 768;
        
        if (!isMobile) {
          // Reset mobile states when switching to desktop
          if (overlay) {
            overlay.classList.remove('active');
          }
          document.body.style.overflow = 'auto';
        } else {
          // Reset desktop states when switching to mobile
          mainContent.classList.remove('expanded');
          if (footer) {
            footer.classList.remove('expanded');
          }
        }
      });

      // Close sidebar on escape key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('expanded') && window.innerWidth <= 768) {
          closeSidebar();
        }
      });
    }

    // ---------------- MOBILE MENU ----------------
    function initMobileMenu() {
      const mobileMenuBtn = document.getElementById('mobileMenuBtn');
      const navLinks = document.getElementById('navLinks');
      const overlay = document.getElementById('overlay');
      
      if (!mobileMenuBtn || !navLinks) return;
      
      // Initialize aria-expanded attribute
      mobileMenuBtn.setAttribute('aria-expanded', 'false');
      
      function openMobileMenu() {
        navLinks.classList.add('active');
        mobileMenuBtn.setAttribute('aria-expanded', 'true');
        mobileMenuBtn.innerHTML = '<i class="fas fa-times" aria-hidden="true"></i>';
        document.body.style.overflow = 'hidden';
        if (overlay) {
          overlay.classList.add('active');
        }
      }
      
      function closeMobileMenu() {
        navLinks.classList.remove('active');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenuBtn.innerHTML = '<i class="fas fa-bars" aria-hidden="true"></i>';
        document.body.style.overflow = 'auto';
        if (overlay) {
          overlay.classList.remove('active');
        }
      }
      
      function toggleMobileMenu() {
        const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
        if (isExpanded) {
          closeMobileMenu();
        } else {
          openMobileMenu();
        }
      }
      
      mobileMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileMenu();
      });
      
      // Close menu when clicking on links
      const navLinksItems = document.querySelectorAll('.nav-links a');
      navLinksItems.forEach(link => {
        link.addEventListener('click', () => {
          if (navLinks.classList.contains('active')) {
            closeMobileMenu();
          }
        });
      });
      
      // Close menu on escape key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navLinks.classList.contains('active')) {
          closeMobileMenu();
        }
      });
      
      // Close mobile menu when clicking on overlay
      if (overlay) {
        overlay.addEventListener('click', () => {
          if (navLinks.classList.contains('active')) {
            closeMobileMenu();
          }
        });
      }
      
      // Close mobile menu when clicking outside
      document.addEventListener('click', (e) => {
        if (!e.target.closest('.navbar') && !e.target.closest('.nav-links') && navLinks.classList.contains('active')) {
          closeMobileMenu();
        }
      });

      // Handle window resize - close mobile menu when switching to desktop
      window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
          closeMobileMenu();
        }
      });
    }




  // Apply filters
  function applyFilter() {
    let search = document.getElementById("searchInput").value.toLowerCase().trim();
    let minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
    let maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;
    let category = document.getElementById("categoryFilter").value;
    let region = document.getElementById("regionFilter").value;
    let status = document.getElementById("statusFilter").value;

    let products = document.querySelectorAll(".product-container");

    products.forEach(product => {
      let name = product.querySelector("h2")?.textContent.toLowerCase() || "";
      let price = parseFloat(product.querySelector(".price")?.textContent.replace(/\D/g, "")) || 0;
      let location = product.getAttribute("data-region") || "";
      let prodCategory = product.getAttribute("data-category") || "";
      let prodStatus = product.getAttribute("data-status") || "";

      let match = true;

      if (search && !name.includes(search)) match = false;
      if (price < minPrice || price > maxPrice) match = false;
      if (category && prodCategory !== category) match = false;
      if (region && location !== region) match = false;
      if (status && prodStatus !== status) match = false;

      product.style.display = match ? "flex" : "none";
    });
  }

  // Reset filters
  function resetFilter() {
    document.getElementById("searchInput").value = "";
    document.getElementById("minPrice").value = "";
    document.getElementById("maxPrice").value = "";
    document.getElementById("categoryFilter").value = "";
    document.getElementById("regionFilter").value = "";
    document.getElementById("statusFilter").value = "";

    document.querySelectorAll(".product-container").forEach(product => {
      product.style.display = "flex";
    });
  }



  </script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
