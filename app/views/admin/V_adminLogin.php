<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Login | FarmerConnect</title>
</head>
<body>
    <main>
        <div class="container">
            <!-- Left Side (Image Section) -->
            <div class="image-section">
                <img src="<?php echo URLROOT; ?>/img/login_img_desktop.jpg" class="desktop-img" alt="Farmer Connect">
                <img src="<?php echo URLROOT; ?>/img/login_img_mobile.jpg" class="mobile-img" alt="Farmer Connect">
            </div>
            <!-- Right Side (Form Section) -->
            <div class="form-section">
                <div class="signin">
                    <h1>Admin Login</h1>
                </div>
                <div class="form-box active" id="adminForm">
                    <form method="POST" action="<?php echo URLROOT; ?>/admin/AdminLogin">
                        <div class="input-group">
                            <div class="input-field">
                                <label for="username">Username<span class="required">*</span></label>
                                <input type="text" name="admin_id" id="admin_id" placeholder="Admin ID" value="<?php echo $data['admin_id']; ?>">
                                <span class="form-invalid"><?php echo $data['admin_id_error']; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="password">Password<span class="required">*</span></label>
                                <input type="password" name="password" id="admin_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                                <span class="form-invalid"><?php echo $data['password_error']; ?></span>
                            </div>
                        </div>
                        <div class="login">
                            <button type="submit">Login<i class="fa-solid fa-angle-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
