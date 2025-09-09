<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/register.css">
    <script src="<?php echo URLROOT; ?>/js/register.js" defer></script>
    <title>Register | FarmerConnect</title>
</head>
<body>
    <?php
        $farmerActive = '';
        $officerActive = '';
        $sellerActive = '';
        if (isset($data['form_type']) && $data['form_type'] == 'officer') {
            $officerActive = 'active';
        } elseif (isset($data['form_type']) && $data['form_type'] == 'seller') {
            $sellerActive = 'active';
        } else {
            $farmerActive = 'active';
        }
    ?>
    <main>
        <div class="container">
            <div class="signup">
                <h1>Register</h1>
            </div>
            
            <div class="btn-group">
                <button class="<?php echo $farmerActive; ?>" onclick="showForm('farmerForm', this)">Farmer</button>
                <button class="<?php echo $officerActive; ?>" onclick="showForm('officerForm', this)">Agri Officer</button>
                <button class="<?php echo $sellerActive; ?>" onclick="showForm('sellerForm', this)">Seller Agent</button>
            </div>
            

                <!-- Farmer Registration Form -->
            <div class="form-box <?php echo $farmerActive; ?>" id="farmerForm">
                <form method="POST" action="<?php echo URLROOT; ?>/users/register">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" name="first_name" id="farmer_first_name" placeholder="First Name" value="<?php echo $data['first_name']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['first_name_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="last_name" id="farmer_last_name" placeholder="Last Name" value="<?php echo $data['last_name']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['last_name_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="nic" id="farmer_nic" placeholder="NIC" value="<?php echo $data['nic']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['nic_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="email" id="farmer_email" placeholder="Email" value="<?php echo $data['email']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['email_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="farmer_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['password_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="confirm_password" id="farmer_confirm_password" placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['confirm_password_error'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="create-account">
                        <button type="submit" value="Register">Create Account</button>
                    </div>
                    
                </form>
            </div>

            <!-- Officer Registration Form -->
            <div class="form-box <?php echo $officerActive; ?>" id="officerForm">
                <form method="POST" action="<?php echo URLROOT; ?>/users/register">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" name="first_name" id="officer_first_name" placeholder="First Name" value="<?php echo $data['first_name']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['first_name_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="last_name" id="officer_last_name" placeholder="Last Name" value="<?php echo $data['last_name']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['last_name_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="nic" id="officer_nic" placeholder="NIC" value="<?php echo $data['nic']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['nic_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="email" id="officer_email" placeholder="Email" value="<?php echo $data['email']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['email_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="officerID" id="officerID" placeholder="Officer ID" value="<?php echo $data['officerID']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['officerID_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="officer_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['password_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="confirm_password" id="officer_confirm_password" placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['confirm_password_error'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="create-account">
                        <button type="submit" value="Register">Create Account</button>
                    </div>
                </form>
            </div>

            <!-- Seller Agent Registration Form -->
            <div class="form-box <?php echo $sellerActive; ?>" id="sellerForm">
                <form method="POST" action="<?php echo URLROOT; ?>/users/register">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" name="first_name" id="seller_first_name" placeholder="First Name" value="<?php echo $data['first_name']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['first_name_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="last_name" id="seller_last_name" placeholder="Last Name" value="<?php echo $data['last_name']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['last_name_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="nic" id="seller_nic" placeholder="NIC" value="<?php echo $data['nic']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['nic_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="email" id="seller_email" placeholder="Email" value="<?php echo $data['email']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['email_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="text" name="brn" id="seller_brn" placeholder="Business Registration Number ( BRN )" value="<?php echo $data['brn']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['brn_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="seller_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['password_error'] : ''; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="password" name="confirm_password" id="seller_confirm_password" placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                            <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['confirm_password_error'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="create-account">
                        <button type="submit" value="Request">Request to Register</button>
                    </div>
                </form>
            </div>
            <hr class="horizontal-line">
                <div class="have-account" >
                <p>Already have an account ? <a href="#">Login Here</a></p>
            </div> 
        </div>
    </main>
</body>
</html>