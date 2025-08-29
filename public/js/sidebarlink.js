// Initialize sidebar functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing sidebar...');
  initSidebarNavigation();
  
  // Handle browser back/forward buttons
  window.addEventListener('hashchange', function() {
    const hash = window.location.hash.substring(1);
    const page = hash || 'home';
    console.log('Hash changed to:', hash, 'Loading page:', page);
    updateMainContent(page);
    updateActiveLink(page);
  });
  
  // Also handle initial page load with a slight delay to ensure everything is ready
  setTimeout(() => {
    const initialHash = window.location.hash.substring(1);
    const initialPage = initialHash || 'home';
    console.log('Final check - loading page:', initialPage);
    updateMainContent(initialPage);
    updateActiveLink(initialPage);
  }, 100);
});

// Function to update active link based on current page
function updateActiveLink(currentPage) {
  const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
  
  sidebarLinks.forEach(link => {
    link.classList.remove('active');
    
    const tooltip = link.getAttribute('data-tooltip') || '';
    const menuText = link.querySelector('.menu-text')?.textContent || '';
    const pageKey = getPageKey(tooltip, menuText);
    
    if (pageKey === currentPage) {
      link.classList.add('active');
    }
  });
}

// Helper function to get page key from tooltip and menu text
function getPageKey(tooltip, menuText) {
  let pageKey = 'home';
  
  switch(tooltip.toLowerCase()) {
    case 'home':
      pageKey = 'home';
      break;
    case 'cultivation timeline':
      pageKey = 'cultivation';
      break;
    case 'fertilizer calculator':
      pageKey = 'calculator';
      break;
    case 'disease detector':
      pageKey = 'detector';
      break;
    case 'knowledge center':
      pageKey = 'knowledge';
      break;
    case 'complain':
      pageKey = 'complain';
      break;
    default:
      // Try to match by menu text if tooltip doesn't match
      if (menuText.toLowerCase().includes('trending')) {
        pageKey = 'trending';
      } else if (menuText.toLowerCase().includes('cultivation')) {
        pageKey = 'cultivation';
      } else if (menuText.toLowerCase().includes('calculator')) {
        pageKey = 'calculator';
      } else if (menuText.toLowerCase().includes('disease')) {
        pageKey = 'detector';
      } else if (menuText.toLowerCase().includes('knowledge')) {
        pageKey = 'knowledge';
      } else if (menuText.toLowerCase().includes('complain')) {
        pageKey = 'complain';
      }
  }
  
  return pageKey;
}

function initSidebarNavigation() {
  const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
  
  // Remove all active classes first
  sidebarLinks.forEach(link => {
    link.classList.remove('active');
  });
  
  // Check if there's a hash in the URL to restore the previous page
  let currentPage = 'home';
  const hash = window.location.hash.substring(1); // Remove the # symbol
  if (hash && hash.trim() !== '') {
    currentPage = hash;
  } else {
    // Set default hash if none exists
    window.location.hash = 'home';
  }
  
  console.log('Current hash:', window.location.hash);
  console.log('Current page to load:', currentPage);
  
  // Set the appropriate link as active based on current page
  let activeIndex = 0;
  sidebarLinks.forEach((link, index) => {
    const tooltip = link.getAttribute('data-tooltip') || '';
    const menuText = link.querySelector('.menu-text')?.textContent || '';
    
    let pageKey = getPageKey(tooltip, menuText);
    
    if (pageKey === currentPage) {
      activeIndex = index;
    }
  });
  
  if (sidebarLinks.length > 0) {
    sidebarLinks[activeIndex].classList.add('active');
  }
  
  // Load the current page content (with a small delay to ensure DOM is ready)
  setTimeout(() => {
    updateMainContent(currentPage);
    console.log('Loading content for page:', currentPage);
  }, 50);
  
  // Add click event listeners to sidebar links
  sidebarLinks.forEach((link, index) => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Remove active class from all links
      sidebarLinks.forEach(l => l.classList.remove('active'));
      
      // Add active class to clicked link
      this.classList.add('active');
      
      // Get the page identifier based on the link's data-tooltip or text content
      const tooltip = this.getAttribute('data-tooltip') || '';
      const menuText = this.querySelector('.menu-text')?.textContent || '';
      
      let pageKey = getPageKey(tooltip, menuText);
      
      console.log('Clicked on:', tooltip, 'Page key:', pageKey);
      
      // Update URL hash to remember the current page
      window.location.hash = pageKey;
      
      // Update main content
      updateMainContent(pageKey);
    });
  });
}

function updateMainContent(page = 'home') {
  const mainContent = document.querySelector('.main-content .container');
  
  if (!mainContent) {
    console.warn('Main content container not found');
    return;
  }
  
  const pageContent = {
    cultivation: {
      title: '📅 Cultivation Timeline',
      subtitle: 'Plan Your Farming Calendar',
      content: `
        <p>Optimize your crop planning with our comprehensive cultivation timeline tools.</p>
        <div style="margin-top: 20px; padding: 20px; background: rgba(63, 81, 181, 0.15); border-radius: 8px; border-left: 4px solid #3f51b5; backdrop-filter: blur(10px);">
          <h3 style="color: #3f51b5; margin-bottom: 10px;">📋 Timeline Features:</h3>
          <ul style="margin-left: 20px; color: var(--text-secondary);">
            <li>Seasonal planting schedules</li>
            <li>Harvest time predictions</li>
            <li>Weather-based recommendations</li>
            <li>Crop rotation planning</li>
          </ul>
        </div>
      `
    },
    calculator: {
      title: '🧮 Fertilizer Calculator',
      subtitle: 'Calculate Optimal Fertilizer Usage',
      content: `
        <p>Determine the right amount of fertilizer for your crops with our smart calculator.</p>
        <div style="margin-top: 20px; padding: 20px; background: rgba(156, 39, 176, 0.15); border-radius: 8px; border-left: 4px solid #9c27b0; backdrop-filter: blur(10px);">
          <h3 style="color: #9c27b0; margin-bottom: 10px;">⚗️ Calculator Features:</h3>
          <ul style="margin-left: 20px; color: var(--text-secondary);">
            <li>NPK ratio calculations</li>
            <li>Crop-specific recommendations</li>
            <li>Soil type considerations</li>
            <li>Cost optimization</li>
          </ul>
        </div>
      `
    },
    detector: {
      title: '🐛 Disease Detector',
      subtitle: 'Report plant diseases to help protect our agricultural community',
      content: `
        <div class="content-card">
            <form action="#" method="POST" id="diseaseReportForm" class="framework-form" enctype="multipart/form-data">
                <div class="report-id-display">
                    Report ID: <span id="reportIdDisplay"></span>
                </div>
                
                <div class="form-group">
                    <label for="farmerNIC" class="required">Farmer NIC Number</label>
                    <input type="text" id="farmerNIC" name="farmerNIC" 
                           placeholder="Enter your National Identity Card number" required>
                </div>
                
                <div class="form-group">
                    <label for="plrNumber" class="required">PLR Number</label>
                    <input type="text" id="plrNumber" name="plrNumber" 
                           placeholder="Enter your Planters Registration Number" required>
                </div>
                
                <div class="form-group">
                    <label for="date" class="required">Date of Observation</label>
                    <input type="date" id="date" name="date" required>
                </div>
                
                <div class="form-group">
                    <label for="title" class="required">Report Title</label>
                    <input type="text" id="title" name="title" 
                           placeholder="Brief description of the issue" required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="required">Detailed Description</label>
                    <textarea id="description" name="description" 
                              placeholder="Describe the symptoms, patterns, and any other relevant details" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="media">Upload Images / Video</label>
                    <div class="file-upload" id="mediaUploadArea">
                        <div>
                            <i class="upload-icon"><img style="width: 30px; height: 30px;" src="https://cdn-icons-png.flaticon.com/128/10024/10024248.png"></i>
                                <p>Click to upload or drag and drop</p>
                                <p class="upload-subtext">PNG, JPG, MP4 up to 10MB</p>
                            </div>
                        <input type="file" id="media" name="media" accept="image/*,video/*" hidden multiple>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="required">Severity Level</label>
                    <div class="radio-group">
                        <label class="radio-option severity-low">
                            <input type="radio" name="severity" value="low" required>
                            Low
                        </label>
                        <label class="radio-option severity-medium">
                            <input type="radio" name="severity" value="medium">
                            Medium
                        </label>
                        <label class="radio-option severity-high">
                            <input type="radio" name="severity" value="high">
                            High
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="affectedArea" class="required">Affected Area (in acres)</label>
                    <input type="number" id="affectedArea" name="affectedArea" 
                           placeholder="Enter the size of the affected area" min="0" step="0.1" required>
                </div>
                <div class="form-group">
                    <div class="checkbox-container">
                        <label for="terms" class="checkbox-label required">
                            <input type="checkbox" id="terms" name="terms" required>
                            I agree to the <a href="#" class="terms-link" style="color:red">terms and conditions</a>
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>
        </div>

        <style>
            /* Fix for scrolling issue - add top padding to main content */
            .main-content {
                padding-top: 30px;
            }
            
            .content-card {
                background: var(--glass-bg);
                backdrop-filter: var(--glass-blur);
                border-radius: 15px;
                padding: 30px;
                margin: 20px auto 40px;
            }
            
            .content-header {
                margin-bottom: 30px;
                text-align: left;
            }
            
            .content-header h1 {
                color: var(--text-primary);
                font-size: 2.2rem;
                margin-bottom: 10px;
                font-weight: 800;
            }
            
            .content-subtitle {
                color: var(--text-secondary);
                font-size: 1.1rem;
            }
            
            .framework-form {
                max-width: 800px;
                margin: 0 auto;
            }
            
            .form-group {
                margin-bottom: 25px;
            }
            
            .form-group label {
                display: block;
                margin-bottom: 10px;
                font-weight: 600;
                color: var(--text-primary);
            }
            
            .form-group .required::after {
                content: " *";
                color: #e74c3c;
            }
            
            input, select, textarea {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid var(--card-border);
                border-radius: 8px;
                font-size: 1rem;
                background: rgba(255, 255, 255, 0.8);
                transition: var(--transition);
                color: var(--dark);
                box-sizing: border-box;
            }
            
            input:focus, select:focus, textarea:focus {
                border-color: var(--primary);
                outline: none;
                box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
            }
            
            textarea {
                min-height: 120px;
                resize: vertical;
            }
            
            .radio-group {
                display: flex;
                gap: 20px;
                flex-wrap: wrap;
            }
            
            .radio-option {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 15px;
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.7);
                transition: var(--transition);
                cursor: pointer;
            }
            
            .radio-option:hover {
                background: rgba(255, 255, 255, 0.9);
            }
            
            .radio-option input {
                width: auto;
            }
            
            .severity-low { color: var(--primary-light); }
            .severity-medium { color: var(--secondary); }
            .severity-high { color: #e74c3c; }
            
            .file-upload {
                border: 2px dashed var(--card-border);
                padding: 25px;
                text-align: center;
                border-radius: 8px;
                cursor: pointer;
                transition: var(--transition);
                background: rgba(255, 255, 255, 0.7);
            }
            
            .file-upload:hover {
                border-color: var(--primary);
                background: rgba(255, 255, 255, 0.9);
            }
            
            .upload-icon {
                font-size: 2rem;
                margin-bottom: 10px;
                display: block;
            }
            
            .upload-subtext {
                font-size: 0.9rem;
                color: var(--text-secondary);
                margin-top: 5px;
            }
            
            .report-id-display {
                background: var(--bg-secondary);
                padding: 15px;
                border-radius: 8px;
                text-align: center;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 25px;
                border-left: 4px solid var(--primary);
            }
            
            .btn-primary {
                width: 100%;
                padding: 15px;
                font-size: 1.1rem;
                margin-top: 10px;
                background: var(--primary);
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: var(--transition);
            }
            
            .btn-primary:hover {
                background: var(--primary-dark);
            }
            
            /* Custom checkbox styling */
            .checkbox-container {
                position: relative;
                margin-top: 10px;
            }
            
            .checkbox-label {
                display: flex;
                align-items: center;
                cursor: pointer;
                font-size: 0.95rem;
                line-height: 1.4;
                background: rgba(255, 255, 255, 0.7);
                transition: var(--transition);
                margin-bottom: 0;
            }
            
            .checkbox-label:hover {
                background: rgba(255, 255, 255, 0.9);
                border-color: var(--primary);
            }
            
            #terms {
                width: 18px;
                height: 18px;
                margin: 0;
                cursor: pointer;
                accent-color: var(--primary);
            }
            
            .terms-link {
                color: var(--primary);
                text-decoration: none;
                font-weight: 600;
                border-bottom: 1px solid transparent;
                transition: var(--transition);
            }
            
            .terms-link:hover {
                color: var(--primary-dark);
                border-bottom-color: var(--primary-dark);
            }
            
            .checkbox-label.required::after {
                content: " *";
                color: #e74c3c;
                font-weight: bold;
            }
            
            @media (max-width: 768px) {
                .content-card {
                    padding: 20px;
                    margin: 15px auto 30px;
                }
                
                .radio-group {
                    flex-direction: column;
                    gap: 10px;
                }
                
                .file-upload {
                    padding: 15px;
                }
            }
        </style>
      `
    },
    knowledge: {
      title: '📚 Knowledge Center',
      subtitle: 'Learn & Grow Your Farming Skills',
      content: `
        <p>Access comprehensive resources, guides, and educational materials for modern farming.</p>
        <div style="margin-top: 20px; padding: 20px; background: rgba(0, 150, 136, 0.15); border-radius: 8px; border-left: 4px solid #009688; backdrop-filter: blur(10px);">
          <h3 style="color: #009688; margin-bottom: 10px;">📖 Learning Resources:</h3>
          <ul style="margin-left: 20px; color: var(--text-secondary);">
            <li>Farming best practices</li>
            <li>Video tutorials</li>
            <li>Expert articles</li>
            <li>Community discussions</li>
          </ul>
        </div>
      `
    },
    complain: {
      title: '⚠️ Submit Complaint',
      subtitle: 'Report Issues & Get Support',
      content: `
        <p>Have an issue or concern? Submit your complaint and our team will assist you.</p>
        <div style="margin-top: 20px; padding: 20px; background: rgba(255, 152, 0, 0.15); border-radius: 8px; border-left: 4px solid #ff9800; backdrop-filter: blur(10px);">
          <h3 style="color: #ff9800; margin-bottom: 10px;">📝 Support Options:</h3>
          <ul style="margin-left: 20px; color: var(--text-secondary);">
            <li>Technical issues</li>
            <li>Account problems</li>
            <li>Feature requests</li>
            <li>General feedback</li>
          </ul>
        </div>
      `
    }
  };
  
  const content = pageContent[page] || pageContent.home;
  
  // Special handling for home page - load PHP content
  if (page === 'home') {
    // Show loading state
    mainContent.innerHTML = '<div style="text-align: center; padding: 50px;"><h2>Loading...</h2></div>';
    
    // Fetch the home page content from PHP
    fetch(window.location.origin + window.location.pathname.replace('/public/index.php', '') + '/farmer/home')
      .then(response => response.text())
      .then(html => {
        // Extract just the main content from the response
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const mainContentFromPHP = doc.querySelector('.main-content .container');
        
        if (mainContentFromPHP) {
          mainContent.innerHTML = mainContentFromPHP.innerHTML;
        }
      })
      .catch(error => {
        console.error('Error loading home page:', error);
        // Fallback content on error
        mainContent.innerHTML = `
          <h1>Welcome to FarmerConnect.lk</h1>
          <p>Error loading content. Please try again later.</p>
        `;
      });
    return;
  }
  
  // Check if it's the detector page (which has its own content structure)
  if (page === 'detector') {
    mainContent.innerHTML = `
      <div class="content-header" style="text-align: left; margin-bottom: 30px;">
        <h1>${content.title}</h1>
        <p class="content-subtitle" style="color: var(--text-secondary); font-size: 1.1rem; margin: 10px 0;">${content.subtitle}</p>
      </div>
      ${content.content}
    `;
    
    // Execute the JavaScript for the detector page after DOM is updated
    setTimeout(() => {
        // Generate a random report ID
        function generateReportId() {
            // Using crypto.randomUUID() - available in modern browsers
            if (typeof crypto !== 'undefined' && crypto.randomUUID) {
                const uuid = crypto.randomUUID();
                return 'DR-' + uuid;
            }
            
            // Alternative for older environments
            return 'DR-' + ([1e7]+-1e3+-4e3+-8e3+-1e11).toString().replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
        }
        
        // Set the report ID
        const reportIdElement = document.getElementById('reportIdDisplay');
        if (reportIdElement) {
            reportIdElement.textContent = generateReportId();
        }
        
        // Set today's date as default
        const dateInput = document.getElementById('date');
        if (dateInput && !dateInput.value) {
            dateInput.valueAsDate = new Date();
        }
        
        // File upload area functionality
        const fileUploadArea = document.getElementById('mediaUploadArea');
        const fileInput = document.getElementById('media');
        
        if (fileUploadArea && fileInput) {
            fileUploadArea.addEventListener('click', () => {
                fileInput.click();
            });
            
            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.style.borderColor = 'var(--primary)';
                fileUploadArea.style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
            });
            
            fileUploadArea.addEventListener('dragleave', () => {
                fileUploadArea.style.borderColor = 'var(--card-border)';
                fileUploadArea.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
            });
            
            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.style.borderColor = 'var(--card-border)';
                fileUploadArea.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    updateFileUploadText(e.dataTransfer.files);
                }
            });
            
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length) {
                    updateFileUploadText(fileInput.files);
                }
            });
            
            function updateFileUploadText(files) {
                const fileText = files.length === 1 ? 
                    `1 file selected: ${files[0].name}` : 
                    `${files.length} files selected`;
                    
                const textElement = fileUploadArea.querySelector('p');
                if (textElement) {
                    textElement.textContent = fileText;
                }
            }
        }
        
        // Form submission handler
        const form = document.getElementById('diseaseReportForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Disease report submitted successfully! This is a demo - in a real application, this would be sent to the server.');
            });
        }
    }, 100);
  } else {
    mainContent.innerHTML = `
      <h1>${content.title}</h1>
      ${content.content}
      <div style="margin-top: 30px;">
        <h2>${content.subtitle}</h2>
        <p>Content will be displayed here. The sidebar shows the active page with highlighting, and you can see how different pages would look.</p>
      </div>
    `;
  }
}