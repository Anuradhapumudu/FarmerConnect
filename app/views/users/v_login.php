<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/login.css">
    <script src="<?php echo URLROOT; ?>/js/register.js" defer></script>
    <title>Login | FarmerConnect</title>
</head>
<body>
    <?php
        $farmerActive = '';
        $officerActive = '';
        $sellerActive = '';
        $adminActive = '';
        if (isset($data['form_type']) && $data['form_type'] == 'officer') {
            $officerActive = 'active';
        } elseif (isset($data['form_type']) && $data['form_type'] == 'seller') {
            $sellerActive = 'active';
        } elseif (isset($data['form_type']) && $data['form_type'] == 'admin') {
            $adminActive = 'active';
        } else {
            $farmerActive = 'active';
        }
    ?>
    <main>
        <div class="container">
            <div class="signin">
                <h1>Login</h1>
            </div>
            
            <div class="btn-group">
                <button class="<?php echo $farmerActive; ?>" onclick="showForm('farmerForm', this)">Farmer</button>
                <button class="<?php echo $officerActive; ?>" onclick="showForm('officerForm', this)">Agri Officer</button>
                <button class="<?php echo $sellerActive; ?>" onclick="showForm('sellerForm', this)">Seller Agent</button>
                <button class="<?php echo $adminActive; ?>" onclick="showForm('adminForm', this)">Admin</button>
            </div>
            

            <!-- Farmer Login Form -->
            <div class="form-box <?php echo $farmerActive; ?>" id="farmerForm">
                <form method="POST" action="<?php echo URLROOT; ?>/users/login">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" name="nic" id="farmer_nic" placeholder="NIC" value="<?php echo $data['nic']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'farmer') ? $data['farmer_nic_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="farmer_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'farmer') ? $data['password_error'] : ''; ?></span>
                        </div>
                    </div>
                    <p  class="lostpassword">Lost Password ? <a href="#">Click Here</a></p>
                    <div class="login">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
            <!-- Officer Login Form -->
            <div class="form-box <?php echo $officerActive; ?>" id="officerForm">
                <form method="POST" action="<?php echo URLROOT; ?>/users/login">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" name="officer_id" id="officer_id" placeholder="Officer ID" value="<?php echo $data['officer_id']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'officer') ? $data['officer_id_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="officer_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'officer') ? $data['password_error'] : ''; ?></span>
                        </div>
                    </div>
                    <p  class="lostpassword">Lost Password ? <a href="#">Click Here</a></p>
                    <div class="login">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>

            <!-- Seller Agent Login Form -->
            <div class="form-box <?php echo $sellerActive; ?>" id="sellerForm">
                <form method="POST" action="<?php echo URLROOT; ?>/users/login">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" name="seller_id" id="seller_id" placeholder="Seller ID" value="<?php echo $data['seller_id']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'seller') ? $data['seller_id_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="seller_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'seller') ? $data['password_error'] : ''; ?></span>
                        </div>
                    </div>
                    <p  class="lostpassword">Lost Password ? <a href="#">Click Here</a></p>
                    <div class="login">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
            <!-- Admin Login Form -->
            <div class="form-box <?php echo $adminActive; ?>" id="adminForm">
                <form method="POST" action="<?php echo URLROOT; ?>/users/login">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" name="admin_id" id="admin_id" placeholder="Admin ID" value="<?php echo $data['admin_id']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'admin') ? $data['admin_id_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="admin_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                            <span class="form-invalid"><?php echo ($data['form_type'] === 'admin') ? $data['password_error'] : ''; ?></span>
                        </div>
                    </div>
                    <p  class="lostpassword">Lost Password ? <a href="#">Click Here</a></p>
                    <div class="login">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
            <hr class="horizontal-line">
                <div class="new-account">
                <p>Don't have an account ? <a href="<?php echo URLROOT; ?>/users/register">Register Here</a></p>
            </div> 
        </div>
    </main>
</body>
