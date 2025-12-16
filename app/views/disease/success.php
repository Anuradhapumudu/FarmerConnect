<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<div class="content-card">
    <div class="success-container">
        <div class="success-icon">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" fill="#4CAF50"/>
                <path d="M9 12l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
        <h1>Report Submitted Successfully!</h1>
        <p class="success-message">Your disease report has been submitted and will be reviewed by our agricultural experts.</p>
        
        <div class="report-details">
            <div class="detail-item">
                <label>Report ID:</label>
                <span class="report-id"><?php echo htmlspecialchars($data['report_id']); ?></span>
            </div>
            
            <div class="detail-item">
                <label>Submission Date:</label>
                <span><?php echo date('F j, Y \a\t g:i A'); ?></span>
            </div>
            
            <div class="detail-item">
                <label>Status:</label>
                <span class="status-pending">Under Review</span>
            </div>
        </div>
        
        <div class="success-actions">
            <a href="<?php echo URLROOT; ?>/disease/viewReport/<?php echo htmlspecialchars($data['report_id']); ?>" class="btn btn-primary">
                View Report Details
            </a>
            
            <a href="<?php echo URLROOT; ?>/disease" class="btn btn-secondary">
                Submit Another Report
            </a>
            
            <a href="<?php echo URLROOT; ?>/disease/viewReports" class="btn btn-secondary">
                View All Reports
            </a>
        </div>
        
        <div class="next-steps">
            <h3>What happens next?</h3>
            <ul>
                <li>Our agricultural experts will review your report within 24-48 hours</li>
                <li>You will receive updates via the system</li>
                <li>If additional information is needed, we will contact you</li>
                <li>Expert recommendations will be provided based on your report</li>
            </ul>
        </div>
    </div>
</div>

<style>
.content-card {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    border-radius: 15px;
    padding: 40px;
    margin: 20px auto;
    max-width: 800px;
    width: 90%;
    text-align: center;
}

.success-container {
    max-width: 600px;
    margin: 0 auto;
}

.success-icon {
    margin-bottom: 30px;
    animation: scaleIn 0.5s ease-out;
}

@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.success-container h1 {
    color: #4CAF50;
    font-size: 2.5rem;
    margin-bottom: 20px;
    font-weight: 700;
}

.success-message {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 30px;
    line-height: 1.6;
}

.report-details {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 30px;
    text-align: left;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item label {
    font-weight: 600;
    color: var(--text-primary);
}

.report-id {
    font-family: 'Courier New', monospace;
    background: #e8f5e8;
    padding: 5px 10px;
    border-radius: 5px;
    color: #2e7d32;
    font-weight: bold;
}

.status-pending {
    background: #fff3e0;
    color: #ef6c00;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.9rem;
    font-weight: 500;
}

.success-actions {
    margin-bottom: 40px;
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background: #4CAF50;
    color: white;
}

.btn-primary:hover {
    background: #45a049;
    transform: translateY(-2px);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-primary);
    border: 2px solid var(--card-border);
}

.btn-secondary:hover {
    background: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

.next-steps {
    text-align: left;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 10px;
    padding: 25px;
    border-left: 4px solid #4CAF50;
}

.next-steps h3 {
    color: var(--text-primary);
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.next-steps ul {
    color: var(--text-secondary);
    line-height: 1.6;
}

.next-steps li {
    margin-bottom: 8px;
}

@media (max-width: 768px) {
    .content-card {
        padding: 25px;
        margin: 15px auto;
        width: 95%;
    }
    
    .success-container h1 {
        font-size: 2rem;
    }
    
    .success-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 280px;
    }
    
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}
</style>

<script>
    // Auto-redirect after 3 seconds
    let seconds = 3;
    const redirectUrl = "<?php echo URLROOT; ?>/disease/viewReport/<?php echo $data['report_id']; ?>";
    
    // Create and append countdown element
    const container = document.querySelector('.success-container');
    const countdownDiv = document.createElement('div');
    countdownDiv.style.textAlign = 'center';
    countdownDiv.style.marginTop = '20px';
    countdownDiv.style.color = 'var(--text-secondary)';
    countdownDiv.style.fontWeight = '500';
    countdownDiv.innerHTML = `Redirecting to report details in <span id="countdown">${seconds}</span> seconds...`;
    container.appendChild(countdownDiv);

    const timer = setInterval(() => {
        seconds--;
        document.getElementById('countdown').textContent = seconds;
        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = redirectUrl;
        }
    }, 1000);
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>