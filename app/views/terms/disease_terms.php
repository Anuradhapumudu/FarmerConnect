<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="content-card">
    <div class="content-header">
        <h1>Terms and Conditions - Disease Report</h1>
        <p class="content-subtitle">Please read these terms carefully before submitting your disease report</p>
    </div>

    <div class="terms-content">
        <h2>1. Purpose of Disease Reporting</h2>
        <p>The FarmerConnect Disease Reporting System is designed to help protect Sri Lanka's agricultural community by enabling farmers to report plant diseases promptly. This allows agricultural authorities to take timely action to prevent the spread of diseases and protect crops.</p>

        <h2>2. Accuracy of Information</h2>
        <p>By submitting a disease report, you agree to provide accurate and truthful information to the best of your knowledge. False or misleading reports may result in penalties under agricultural regulations and could harm the community's response efforts.</p>

        <h2>3. Data Privacy and Protection</h2>
        <p>Your personal information (NIC Number, PLR Number) and farm details will be handled in accordance with Sri Lanka's data protection laws. This information is used solely for agricultural monitoring and disease control purposes.</p>

        <h2>4. Media Upload Guidelines</h2>
        <ul>
            <li>Only upload images and videos related to the reported disease</li>
            <li>Ensure media files are clear and show the symptoms adequately</li>
            <li>Respect copyright and privacy - do not upload images of other people's property without permission</li>
            <li>Maximum file size: 10MB per file</li>
            <li>Supported formats: Images (JPG, PNG, GIF) and Videos (MP4)</li>
        </ul>

        <h2>5. Severity Assessment</h2>
        <p>Please assess the severity level accurately:</p>
        <ul>
            <li><strong>Low:</strong> Minor symptoms affecting less than 10% of the crop</li>
            <li><strong>Medium:</strong> Moderate symptoms affecting 10-50% of the crop</li>
            <li><strong>High:</strong> Severe symptoms affecting more than 50% of the crop or threatening total loss</li>
        </ul>

        <h2>6. Response and Follow-up</h2>
        <p>Submitted reports will be reviewed by agricultural officers. You may be contacted for additional information or site visits. Response times may vary based on severity and location.</p>

        <h2>7. Confidentiality</h2>
        <p>Report details are treated as confidential and shared only with authorized agricultural personnel. However, anonymized data may be used for research and policy-making purposes.</p>

        <h2>8. Liability</h2>
        <p>FarmerConnect and its operators are not liable for any damages arising from the use of this reporting system. Users are responsible for the accuracy of their submissions.</p>

        <h2>9. Updates to Terms</h2>
        <p>These terms may be updated periodically. Continued use of the system constitutes acceptance of updated terms.</p>

        <h2>10. Contact Information</h2>
        <p>For questions about these terms or the reporting system, contact your local agricultural extension officer or the FarmerConnect support team.</p>

        <div class="terms-acceptance">
            <p><strong>By checking the agreement box on the disease report form, you acknowledge that you have read, understood, and agree to abide by these terms and conditions.</strong></p>
        </div>
    </div>
</div>

<style>
    .terms-content {
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .terms-content h2 {
        color: var(--primary);
        margin-top: 30px;
        margin-bottom: 15px;
        font-size: 1.4rem;
        border-bottom: 2px solid rgba(46, 125, 50, 0.2);
        padding-bottom: 5px;
    }

    .terms-content p {
        margin-bottom: 15px;
        color: var(--text-primary);
    }

    .terms-content ul {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .terms-content li {
        margin-bottom: 8px;
        color: var(--text-primary);
    }

    .terms-acceptance {
        background: rgba(46, 125, 50, 0.1);
        border: 1px solid rgba(46, 125, 50, 0.3);
        border-radius: 8px;
        padding: 20px;
        margin: 30px 0;
    }

    .terms-acceptance p {
        font-weight: 600;
        text-align: center;
        margin: 0;
    }

    .terms-actions {
        text-align: center;
        margin-top: 40px;
    }

    .btn-secondary {
        background: var(--text-secondary);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: var(--transition);
    }

    .btn-secondary:hover {
        background: var(--text-primary);
    }

    @media (max-width: 768px) {
        .terms-content {
            padding: 0 10px;
        }

        .terms-content h2 {
            font-size: 1.2rem;
        }
    }
</style>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>