<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/YellowCaseForm.css?v=<?= time(); ?>">

<div class="yellowcase-card">
    <div class="yellowcase-header">
        <h1> Yellow Case Report</h1>
        <p class="yellowcase-subtitle">Submit a Yellow Case to notify officers of any urgent or special agricultural situation.</p>
    </div>
    
    <div class="case-id-display">
        <label>Case ID:</label>
        <span id="caseIdDisplay">Will be generated upon submission</span>
    </div>

    <form action="<?php echo URLROOT; ?>/yellowcase/submit" method="POST" id="yellowCaseForm" class="yellowcase-form" enctype="multipart/form-data">
        <input type="hidden" name="submission_timestamp" value="">

        <div class="form-group">
            <label for="farmerNIC" class="required">Farmer NIC Number</label>
            <input type="text" id="farmerNIC" name="farmerNIC" placeholder="Enter your NIC number" value="197940306V">
        </div>
        
        <div class="form-group">
            <label for="plrNumber" class="required">PLR Number</label>
            <input type="text" id="plrNumber" name="plrNumber" placeholder="Enter your PLR number" value="02/25/00083/002/P/0006">
        </div>
        
        <div class="form-row">
            <div class="form-col">
                <label for="observationDate" class="required">Observation Date</label>
                <input type="date" id="observationDate" name="observationDate" value="">
            </div>
            <div class="form-col">
                <label for="todayDate">Today's Date</label>
                <input type="date" id="todayDate" name="todayDate" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label for="caseTitle" class="required">Case Title</label>
            <input type="text" id="caseTitle" name="caseTitle" placeholder="Briefly describe the issue" value="">
        </div>
        
        <div class="form-group">
            <label for="caseDescription" class="required">Detailed Description</label>
            <textarea id="caseDescription" name="caseDescription" placeholder="Detailed Description"></textarea>
        </div>
        
        <div class="form-group">
            <label for="mediaUpload">Upload Images / Videos (Optional)</label>
            <div class="file-upload" id="mediaUploadArea">
                <div>
                    <i class="upload-icon">
                        <img style="width: 30px; height: 30px;" src="https://cdn-icons-png.flaticon.com/128/10024/10024248.png" alt="Upload Icon">
                    </i>
                    <p>Click to upload or drag and drop</p>
                    <p class="upload-subtext">PNG, JPG, MP4 up to 10MB</p>
                </div>
                <input type="file" id="mediaUpload" name="media[]" accept="image/*,video/*" hidden multiple>
            </div>
            <div class="uploaded-files" id="uploadedFiles"></div>
        </div>
        
        <button type="submit" class="btn-yellow">Submit Yellow Case</button>
    </form>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
