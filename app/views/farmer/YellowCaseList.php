<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/farmer/YellowCaseList.css?v=<?= time(); ?>">

<div class="yellow-header">
    <h2>Report a Problem</h2>
        <p>
        Are you experiencing any issues in your cultivation? <br>
        Select the appropriate category below to proceed.
    </p>
</div>

<div class="yellow-options">

    <!--  COMPLAINT -->
    <div class="yellow-card complaint">
        <h3>General Complaint</h3>

        <p>If you are facing general issues related to your farming process:</p>

        <ul>
            <li>Water supply problems</li>
            <li>Fertilizer distribution issues</li>
            <li>Labor or equipment issues</li>
            <li>Any delay in cultivation</li>
        </ul>

        <a href="<?php echo URLROOT; ?>/Complaint"
           class="yellow-btn complaint-btn">
            Go to Complaint Form
        </a>
    </div>

    <!--  DISEASE -->
    <div class="yellow-card disease">
        <h3>Disease Report</h3>

        <p>If your crops show unusual conditions:</p>

        <ul>
            <li>Leaf discoloration or yellowing</li>
            <li>Spots, fungus, or infections</li>
            <li>Wilting or dying plants</li>
            <li>Unknown damage to crops</li>
        </ul>

        <a href="<?php echo URLROOT; ?>/disease"
           class="yellow-btn disease-btn">
            Go to Disease Report
        </a>
    </div>

</div>
    


<?php require_once APPROOT . '/views/inc/footer.php'; ?>

