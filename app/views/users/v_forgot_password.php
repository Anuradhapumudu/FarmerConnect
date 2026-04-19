<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forgot_password.css">
    <title>Forgot Password | FarmerConnect</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FarmerConnect.lk</h1>
        </div>
        <h2>Forgot Password</h2>

        <div class="step-indicator">
            <div class="step-box <?php echo ($data['step'] == 1) ? 'active' : ''; ?>">
                <div class="step">1</div>
                <small>Username</small>
            </div>

            <div class="step-box <?php echo ($data['step'] == 2) ? 'active' : ''; ?>">
                <div class="step">2</div>
                <small>Request OTP</small>
            </div>

            <div class="step-box <?php echo ($data['step'] == 3) ? 'active' : ''; ?>">
                <div class="step">3</div>
                <small>Verify OTP</small>
            </div>

            <div class="step-box <?php echo ($data['step'] == 4) ? 'active' : ''; ?>">
                <div class="step">4</div>
                <small>Change Password</small>
            </div>
        </div>

        <?php if($data['step'] == 1): ?>
            <form method="POST" action="<?php echo URLROOT; ?>/users/findEmailByUsername">
                <label for="username" class="form-label">Username :</label>
                <input type="text" name="username" id="username" placeholder="NIC / Officer ID / Seller ID" required>
                <p class="error">
                    <?php echo $data['error']; ?>
                </p>
                <div class="btn-group">
                    <button type="submit">Next</button>
                    <a href="<?php echo URLROOT; ?>/users/login" class="cancel-btn">Cancel</a>
                </div>
            </form>

        <?php elseif($data['step'] == 2): ?>
            <p>Your registered email:</p>
            <h3><?php echo $data['maskedemail']; ?></h3>

            <form method="POST" action="<?php echo URLROOT; ?>/users/sendOTP">
                <input type="hidden" name="email" value="<?php echo $data['email']; ?>">
                <input type="hidden" name="username" value="<?php echo $data['username']; ?>">
                <input type="hidden" name="user_type" value="<?php echo $data['user_type']; ?>">
                <div class="btn-group">
                    <button type="submit">Send OTP</button>
                    <a href="<?php echo URLROOT; ?>/users/login" class="cancel-btn">Cancel</a>
                </div>
            </form>

        <?php elseif($data['step'] == 3): ?>
            <form method="POST" action="<?php echo URLROOT; ?>/users/verifyOTP">
                <input type="text" name="otp" placeholder="Enter OTP">
                <p class="error">
                    <?php echo $data['error']; ?>
                </p>
                <div class="btn-group">
                    <button type="submit">Verify</button>
                    <a href="<?php echo URLROOT; ?>/users/login" class="cancel-btn">Cancel</a>
                </div>
            </form>

            <?php if ($data['error'] == 'OTP expired. Please request a new one.'): ?>
                <form method="POST" action="<?php echo URLROOT; ?>/users/sendOTP">
                    <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                    <input type="hidden" name="user_type" value="<?php echo $_SESSION['user_type']; ?>">

                    <button type="submit" class="resend-btn"> Resend OTP </button>
                </form>
            <?php endif; ?>

        <?php elseif($data['step'] == 4): ?>
            <form method="POST" action="<?php echo URLROOT; ?>/users/resetPassword">
                <input type="password" name="password" placeholder="New Password" title="At least 6 characters, letters and numbers required">
                <input type="password" name="confirm_password" placeholder="Confirm New Password">
                <p class="error">
                    <?php echo $data['error']; ?>
                </p>
                <div class="btn-group">
                    <button type="submit">Reset Password</button>
                    <a href="<?php echo URLROOT; ?>/users/login" class="cancel-btn">Cancel</a>
                </div>
            </form>
        <?php endif; ?>

    </div>
</body>