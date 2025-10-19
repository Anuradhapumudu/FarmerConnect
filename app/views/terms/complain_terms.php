<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="content-card">
    <div class="content-header">
        <h1>Terms and Conditions - Complaint Report</h1>
        <p class="content-subtitle">Please read these terms carefully before submitting your complaint</p>
    </div>

    <div class="terms-content">
        <h2>1. Purpose of Complaint Reporting</h2>
        <p>The FarmerConnect Complaint Reporting System provides farmers with a platform to report issues, concerns, or grievances related to agricultural services, products, or support. This helps improve service quality and resolve problems efficiently.</p>

        <h2>2. Types of Complaints</h2>
        <p>You may report complaints regarding:</p>
        <ul>
            <li>Agricultural extension services</li>
            <li>Quality of farming inputs (seeds, fertilizers, pesticides)</li>
            <li>Market access and pricing issues</li>
            <li>Technical support and advisory services</li>
            <li>Platform functionality and user experience</li>
            <li>Other agricultural service-related concerns</li>
        </ul>

        <h2>3. Complaint Submission Guidelines</h2>
        <ul>
            <li>Provide clear and specific details about the issue</li>
            <li>Include relevant dates, locations, and parties involved</li>
            <li>Be respectful and professional in your communication</li>
            <li>Avoid making unsubstantiated accusations</li>
            <li>Provide supporting evidence when possible</li>
        </ul>

        <h2>4. Accuracy and Truthfulness</h2>
        <p>All information provided in the complaint must be accurate and truthful to the best of your knowledge. False or malicious complaints may result in account suspension and legal consequences under Sri Lankan law.</p>

        <h2>5. Data Privacy</h2>
        <p>Your personal information and complaint details are protected under Sri Lanka's data protection regulations. Information is shared only with authorized personnel necessary for investigation and resolution.</p>

        <h2>6. Investigation Process</h2>
        <p>Submitted complaints will be:</p>
        <ul>
            <li>Acknowledged within 48 hours</li>
            <li>Investigated by appropriate authorities</li>
            <li>Resolved within reasonable timeframes based on complexity</li>
            <li>Communicated back to you with findings and actions taken</li>
        </ul>

        <h2>7. Confidentiality</h2>
        <p>Complaint details are treated confidentially. However, in cases involving legal matters or serious violations, information may need to be shared with relevant authorities as required by law.</p>

        <h2>8. Resolution and Appeals</h2>
        <p>If you are not satisfied with the resolution, you may request a review or appeal through the system. Final decisions are made by designated agricultural authorities.</p>

        <h2>9. Prohibited Content</h2>
        <p>Complaints must not contain:</p>
        <ul>
            <li>Defamatory or libelous statements</li>
            <li>Threats or harassment</li>
            <li>Discriminatory language</li>
            <li>Confidential or sensitive information about others</li>
            <li>Spam or repetitive submissions</li>
        </ul>

        <h2>10. Liability and Disclaimers</h2>
        <p>FarmerConnect acts as a reporting platform and is not liable for the outcomes of complaint investigations. Users are responsible for the accuracy and appropriateness of their submissions.</p>

        <h2>11. Updates to Terms</h2>
        <p>These terms may be updated periodically. Continued use of the complaint system constitutes acceptance of updated terms.</p>

        <h2>12. Contact Information</h2>
        <p>For questions about these terms or assistance with complaints, contact the FarmerConnect support team or your local agricultural office.</p>

        <div class="terms-acceptance">
            <p><strong>By checking the agreement box on the complaint report form, you acknowledge that you have read, understood, and agree to abide by these terms and conditions.</strong></p>
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