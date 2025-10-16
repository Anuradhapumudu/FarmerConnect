<?php
    // PHP code here
?>
<script>
    // Helper function to get the correct base URL
    function getBaseURL() {
        // Get the base URL from the current location
        const currentPath = window.location.pathname;
        if (currentPath.includes('/public/')) {
            return window.location.origin + currentPath.substring(0, currentPath.indexOf('/public/'));
        }
        return 'http://localhost/FarmerConnect';
    }

    // Initialize sidebar functionality when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM loaded, initializing sidebar...');
      
      try {
        debugSidebar();
        preventSidebarExpansion();
        initSidebarNavigation();
        initCustomTooltips();
        initOutsideClickHandler();
        console.log('Sidebar navigation initialized successfully');
      } catch (error) {
        console.error('Error initializing sidebar navigation:', error);
      }
    });

    // Debug function to check sidebar and tooltip elements
    function debugSidebar() {
      const sidebar = document.getElementById('sidebar');
      const links = document.querySelectorAll('.sidebar-menu a');
      
      console.log('=== Sidebar Debug Info ===');
      console.log('Sidebar element:', sidebar);
      console.log('Sidebar classList:', sidebar ? sidebar.classList : 'N/A');
      console.log('Sidebar computed style overflow-x:', sidebar ? window.getComputedStyle(sidebar).overflowX : 'N/A');
      console.log('Number of sidebar links:', links.length);
      
      if (links.length > 0) {
        const firstLink = links[0];
        console.log('First link:', firstLink);
        console.log('First link position:', window.getComputedStyle(firstLink).position);
        console.log('First link data-tooltip:', firstLink.getAttribute('data-tooltip'));
        console.log('First link computed z-index:', window.getComputedStyle(firstLink).zIndex);
      }
    }

    // Create and manage custom tooltips that render outside sidebar
    function initCustomTooltips() {
      const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
      
      sidebarLinks.forEach(link => {
        link.addEventListener('mouseenter', function(e) {
          const sidebar = document.getElementById('sidebar');
          const tooltipText = this.getAttribute('data-tooltip');
          
          // Show tooltips only when sidebar is COLLAPSED, not expanded
          if (!tooltipText || sidebar.classList.contains('expanded')) return;
          
          // Create tooltip element
          const tooltip = document.createElement('div');
          tooltip.className = 'custom-sidebar-tooltip';
          tooltip.textContent = tooltipText;
          tooltip.style.cssText = `
            position: fixed;
            background-color: rgba(0, 0, 0, 0.95);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            white-space: nowrap;
            z-index: 10001;
            pointer-events: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            font-weight: 500;
          `;
          
          document.body.appendChild(tooltip);
          
          // Position tooltip to the right of the link with better calculation
          const rect = this.getBoundingClientRect();
          const tooltipWidth = tooltip.offsetWidth;
          const viewportWidth = window.innerWidth;
          
          // Position tooltip to the right of the sidebar
          let leftPosition = rect.right + 10;
          
          // Ensure tooltip doesn't go off-screen on small devices
          if (leftPosition + tooltipWidth > viewportWidth - 10) {
            leftPosition = viewportWidth - tooltipWidth - 10;
          }
          
          tooltip.style.left = leftPosition + 'px';
          tooltip.style.top = (rect.top + (rect.height / 2) - (tooltip.offsetHeight / 2)) + 'px';
          
          // Add arrow to tooltip
          const arrow = document.createElement('div');
          arrow.style.cssText = `
            position: fixed;
            left: ${rect.right + 5}px;
            top: ${rect.top + (rect.height / 2) - 5}px;
            width: 0;
            height: 0;
            border: 5px solid transparent;
            border-right-color: rgba(0, 0, 0, 0.95);
            z-index: 10002;
            pointer-events: none;
          `;
          document.body.appendChild(arrow);
          
          // Store tooltip references
          this._customTooltip = tooltip;
          this._customTooltipArrow = arrow;
        });
        
        link.addEventListener('mouseleave', function() {
          if (this._customTooltip) {
            this._customTooltip.remove();
            this._customTooltip = null;
          }
          if (this._customTooltipArrow) {
            this._customTooltipArrow.remove();
            this._customTooltipArrow = null;
          }
        });

        // Also remove tooltips when sidebar is expanded
        const sidebar = document.getElementById('sidebar');
        const observer = new MutationObserver(function(mutations) {
          mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class' && sidebar.classList.contains('expanded')) {
              if (link._customTooltip) {
                link._customTooltip.remove();
                link._customTooltip = null;
              }
              if (link._customTooltipArrow) {
                link._customTooltipArrow.remove();
                link._customTooltipArrow = null;
              }
            }
          });
        });
        
        observer.observe(sidebar, { attributes: true });
      });
    }

    // Initialize sidebar toggle functionality
    function preventSidebarExpansion() {
      const sidebarToggleBtn = document.getElementById('sidebarToggleNav');
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const mainContent = document.getElementById('mainContent');
      
      if (!sidebarToggleBtn || !sidebar) {
        console.warn('Sidebar toggle elements not found');
        return;
      }
      
      // Ensure sidebar starts collapsed
      sidebar.classList.remove('expanded');
      
      // Toggle sidebar visibility when hamburger is clicked
      sidebarToggleBtn.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent event from bubbling to document
        sidebar.classList.toggle('expanded');
        
        if (overlay) {
          overlay.classList.toggle('active');
        }
        
        if (mainContent) {
          mainContent.classList.toggle('sidebar-open');
        }
        
        // Add/remove dark background from body when sidebar is open
        if (sidebar.classList.contains('expanded')) {
          document.body.classList.add('sidebar-open-overlay');
        } else {
          document.body.classList.remove('sidebar-open-overlay');
        }
        
        // Update button aria-expanded attribute for accessibility
        const isExpanded = sidebar.classList.contains('expanded');
        sidebarToggleBtn.setAttribute('aria-expanded', isExpanded);
        console.log('Sidebar toggled, expanded:', isExpanded);
      });
      
      // Close sidebar when clicking on overlay
      if (overlay) {
        overlay.addEventListener('click', function() {
          closeSidebar();
        });
      }
      
      // Close sidebar on escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('expanded')) {
          closeSidebar();
        }
      });
    }

    // Function to close sidebar and remove overlay
    function closeSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const mainContent = document.getElementById('mainContent');
      const sidebarToggleBtn = document.getElementById('sidebarToggleNav');
      
      sidebar.classList.remove('expanded');
      if (overlay) {
        overlay.classList.remove('active');
      }
      if (mainContent) {
        mainContent.classList.remove('sidebar-open');
      }
      if (sidebarToggleBtn) {
        sidebarToggleBtn.setAttribute('aria-expanded', 'false');
      }
      
      // Remove dark background from body
      document.body.classList.remove('sidebar-open-overlay');
    }

    // Handle clicks outside sidebar to close it
    function initOutsideClickHandler() {
      document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebarToggleNav');
        
        // Check if sidebar is expanded and click is outside sidebar and toggle button
        if (sidebar && sidebar.classList.contains('expanded')) {
          const isClickInsideSidebar = sidebar.contains(e.target);
          const isClickOnToggleBtn = sidebarToggleBtn && sidebarToggleBtn.contains(e.target);
          
          if (!isClickInsideSidebar && !isClickOnToggleBtn) {
            closeSidebar();
          }
        }
      });
      
      // Prevent sidebar from closing when clicking inside it
      const sidebar = document.getElementById('sidebar');
      if (sidebar) {
        sidebar.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
    }

    // Map tooltips to their navigation URLs
    function getNavigationTarget(tooltip) {
      const baseURL = getBaseURL();
      
      switch(tooltip.toLowerCase()) {
        case 'home':
          return baseURL + '/farmer';
        case 'cultivation timeline':
          return baseURL + '/farmer#cultivation';
        case 'fertilizer calculator':
          return baseURL + '/farmer#calculator';
        case 'disease detector':
          return baseURL + '/disease';
        case 'knowledge center':
          return baseURL + '/farmer#knowledge';
        case 'marketplace':
          return baseURL + '/marketplace/marketpl';
        case 'complain':
          return baseURL + '/farmer#complain';
        default:
          return baseURL + '/farmer';
      }
    }

    // Function to update active link styling
    function updateActiveLink(link) {
      const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
      sidebarLinks.forEach(l => l.classList.remove('active'));
      link.classList.add('active');
    }

    // Initialize sidebar navigation with click handlers
    function initSidebarNavigation() {
      const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
      
      console.log('Found sidebar links:', sidebarLinks.length);
      
      if (sidebarLinks.length === 0) {
        console.warn('No sidebar links found! Check if .sidebar-menu exists in the DOM');
        return;
      }
      
      // Add click event listeners to sidebar links for navigation
      sidebarLinks.forEach((link) => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          
          // Get the tooltip to determine where to navigate
          const tooltip = this.getAttribute('data-tooltip') || '';
          
          console.log('Clicked on:', tooltip);
          
          // Update active link styling
          updateActiveLink(this);
          
          // Navigate to the target page
          const navigationTarget = getNavigationTarget(tooltip);
          console.log('Navigating to:', navigationTarget);
          window.location.href = navigationTarget;
        });
      });
    }
</script>