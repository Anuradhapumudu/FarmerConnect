<?php require_once APPROOT . '/views/inc/components/header.php'; ?>
<main class="main-content" id="mainContent">
    <div class="container">
        <div class="content-card">
            <header class="content-header" style="text-align: left;">
                <h1>🐛 Disease Detector</h1>
                <p class="content-subtitle">Report plant diseases to help protect our agricultural community</p>
                
                <?php if (isset($data['errors']) && !empty($data['errors'])): ?>
                    <div class="alert alert-error">
                        <h4>Please correct the following errors:</h4>
                        <ul>
                            <?php foreach ($data['errors'] as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </header>

            <form action="<?php echo URLROOT; ?>/disease/submitReport" method="POST" id="diseaseReportForm" class="framework-form" enctype="multipart/form-data">
                <div class="report-id-display">
                    Report ID: <span id="reportIdDisplay"></span>
                </div>
                
                <div class="form-group">
                    <label for="farmerNIC" class="required">Farmer NIC Number</label>
                    <input type="text" id="farmerNIC" name="farmerNIC" 
                           value="<?php echo isset($data['data']['farmerNIC']) ? htmlspecialchars($data['data']['farmerNIC']) : ''; ?>"
                           placeholder="Enter your National Identity Card number" required>
                </div>
                
                <div class="form-group">
                    <label for="plrNumber" class="required">PLR Number</label>
                    <input type="text" id="plrNumber" name="plrNumber" 
                           value="<?php echo isset($data['data']['plrNumber']) ? htmlspecialchars($data['data']['plrNumber']) : ''; ?>"
                           placeholder="Enter your Planters Registration Number" required>
                </div>
                
                <div class="form-group">
                    <label for="date" class="required">Date of Observation</label>
                    <input type="date" id="date" name="date" 
                           value="<?php echo isset($data['data']['date']) ? htmlspecialchars($data['data']['date']) : ''; ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="title" class="required">Report Title</label>
                    <input type="text" id="title" name="title" 
                           value="<?php echo isset($data['data']['title']) ? htmlspecialchars($data['data']['title']) : ''; ?>"
                           placeholder="Brief description of the issue" required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="required">Detailed Description</label>
                    <textarea id="description" name="description" 
                              placeholder="Describe the symptoms, patterns, and any other relevant details" required><?php echo isset($data['data']['description']) ? htmlspecialchars($data['data']['description']) : ''; ?></textarea>
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
                            <input type="radio" name="severity" value="low" 
                                   <?php echo (isset($data['data']['severity']) && $data['data']['severity'] === 'low') ? 'checked' : ''; ?> required>
                            Low
                        </label>
                        <label class="radio-option severity-medium">
                            <input type="radio" name="severity" value="medium"
                                   <?php echo (isset($data['data']['severity']) && $data['data']['severity'] === 'medium') ? 'checked' : ''; ?>>
                            Medium
                        </label>
                        <label class="radio-option severity-high">
                            <input type="radio" name="severity" value="high"
                                   <?php echo (isset($data['data']['severity']) && $data['data']['severity'] === 'high') ? 'checked' : ''; ?>>
                            High
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="affectedArea" class="required">Affected Area (in acres)</label>
                    <input type="number" id="affectedArea" name="affectedArea" 
                           value="<?php echo isset($data['data']['affectedArea']) ? htmlspecialchars($data['data']['affectedArea']) : ''; ?>"
                           placeholder="Enter the size of the affected area" min="0" step="0.1" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>
        </div>
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
            /* box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3); */
        }
        
        .content-header {
            margin-bottom: 30px;
            text-align: left; /* Changed from center to left */
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
            size: 20%;
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
        }
        
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .alert-error {
            background-color: rgba(231, 76, 60, 0.1);
            border-left-color: #e74c3c;
            color: #c0392b;
        }
        
        .alert h4 {
            margin: 0 0 10px 0;
            font-size: 1rem;
        }
        
        .alert ul {
            margin: 0;
            padding-left: 20px;
        }
        
        @media (max-width: 768px) {
            .content-card {
                padding: 20px;
                margin: 15px auto 30px;
            }
            
            .content-header h1 {
                font-size: 1.8rem;
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

    <script>
        // Generate a random report ID (in a real application, this would come from the server)
        function generateReportId() {
            const uuid = crypto.randomUUID();
            return `DR-${uuid}`;
        }
        
        // Set the report ID on page load
        document.getElementById('reportIdDisplay').textContent = generateReportId();
        
        // Set today's date as default if no date is set
        const dateInput = document.getElementById('date');
        if (!dateInput.value) {
            dateInput.valueAsDate = new Date();
        }
        
        // File upload area functionality
        const fileUploadArea = document.getElementById('mediaUploadArea');
        const fileInput = document.getElementById('media');
        
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
                
            fileUploadArea.querySelector('p').textContent = fileText;
        }
        
        // Form submission - allow normal form submission to backend
        document.getElementById('diseaseReportForm').addEventListener('submit', function(e) {
            // Let the form submit normally to the backend
            // The backend will handle validation and redirect to success page
        });
    </script>
</main>
<?php require_once APPROOT . '/views/inc/components/footer.php'; ?>