<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/officer/YellowcaseReplyForm.css?v=<?= time(); ?>">

<div class="yellowcase-card">
    <div class="yellowcase-header">
        <h1> Yellow Case - Officer Reply</h1>
        <p class="yellowcase-subtitle">Review the farmer’s report and submit your response or recommendations.</p>
    </div>

    <!-- Case Information Section (Read-only) -->
    <div class="case-info">
        <h2>Farmer Report Details</h2>
        <div class="form-group readonly-view">
            <label>Case ID:</label>
            <div class="readonly-field">YC-003</div>
        </div>

        <div class="form-row">
            <div class="form-col readonly-view">
                <label>Farmer NIC:</label>
                <div class="readonly-field">197940306V</div>
            </div>
            <div class="form-col readonly-view">
                <label>PLR Number:</label>
                <div class="readonly-field">02/25/00083/002/P/0006</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col readonly-view">
                <label>Observation Date:</label>
                <div class="readonly-field">2025-10-14</div>
            </div>
            <div class="form-col readonly-view">
                <label>Submitted On:</label>
                <div class="readonly-field">2025-10-15</div>
            </div>
        </div>

        <div class="form-group readonly-view">
            <label>Case Title:</label>
            <div class="readonly-field">Unusual Yellowing in Paddy Leaves</div>
        </div>

        <div class="form-group readonly-view">
            <label>Case Description:</label>
            <div class="readonly-field">
                The farmer observed rapid yellowing of paddy leaves over the past week. The area affected covers around 50% of the paddy field.
            </div>
        </div>

        <div class="form-group readonly-view">
            <label>Attached Media:</label>
            <div class="uploaded-files has-files">
                <div class="uploaded-file">yellowing1.jpg</div>
                <div class="uploaded-file">field_video.mp4</div>
            </div>
        </div>
    </div>

    <!-- Officer Reply Section -->
    <form action="<?php echo URLROOT; ?>/yellowcase/reply" method="POST" enctype="multipart/form-data" class="yellowcase-form">
        <h2>Officer Response</h2>

        <div class="form-group">
            <label for="officerReply" class="required">Your Reply / Recommendation</label>
            <textarea id="officerReply" name="officerReply" placeholder="Enter your reply or observations..."></textarea>
        </div>

        <div class="form-group">
            <label for="replyFiles">Attach Additional Files (Optional)</label>
            <div class="file-upload" id="replyUploadArea">
                <div>
                    <i class="upload-icon">
                        <img style="width: 30px; height: 30px;" src="https://cdn-icons-png.flaticon.com/128/10024/10024248.png" alt="Upload Icon">
                    </i>
                    <p>Click to upload or drag and drop</p>
                    <p class="upload-subtext">PDF, JPG, DOCX up to 10MB</p>
                </div>
                <input type="file" id="replyFiles" name="replyFiles[]" hidden multiple>
            </div>
            <div class="uploaded-files" id="uploadedReplyFiles"></div>
        </div>

        <button type="submit" class="btn-reply">Send Reply</button>
    </form>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
