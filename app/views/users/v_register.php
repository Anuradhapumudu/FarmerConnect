<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

            <!-- Left Side (Image Section) -->
            <div class="image-section">
                <img src="<?php echo URLROOT; ?>/img/register_img_desktop.jpeg" class="desktop-img" alt="Farmer Connect">
                <img src="<?php echo URLROOT; ?>/img/register_img_mobile.png" class="mobile-img" alt="Farmer Connect">
            </div>
            <!-- Right Side (Form Section) -->
            <div class="form-section">
    
                <div class="have-account">
                    <p>Already have an account ? <a href="<?php echo URLROOT; ?>/users/login">Login Here<i class="fa-solid fa-arrow-right"></i></a></p>
                </div> 

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
                                <label for="first_name">First Name<span class="required">*</span></label>
                                <input type="text" name="first_name" id="farmer_first_name" placeholder="First Name" value="<?php echo $data['first_name']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['first_name_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="last_name">Last Name<span class="required">*</span></label>
                                <input type="text" name="last_name" id="farmer_last_name" placeholder="Last Name" value="<?php echo $data['last_name']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['last_name_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="nic">NIC<span class="required">*</span></label>
                                <input type="text" name="nic" id="farmer_nic" placeholder="NIC" value="<?php echo $data['nic']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['nic_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">

                                <label for="phone_no">Phone No<span class="required">*</span></label>

                                <input type="text" name="phone_no" id="farmer_phone_no" placeholder="Phone Number" value="<?php echo $data['phone_no']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['phone_no_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="password">Password<span class="required">*</span></label>
                                <input type="password" name="password" id="farmer_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['password_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="confirm_password">Confirm Password<span class="required">*</span></label>
                                <input type="password" name="confirm_password" id="farmer_confirm_password" placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'farmer') ? $data['confirm_password_error'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="create-account">
                            <button type="submit" value="Register">Create Account<i class="fa-solid fa-angle-right"></i></button>
                        </div>
                        
                    </form>
                </div>

                <!-- Officer Registration Form -->
                <div class="form-box <?php echo $officerActive; ?>" id="officerForm">
                    <form method="POST" action="<?php echo URLROOT; ?>/users/register">
                        <div class="input-group">
                            <div class="input-field">
                                <label for="first_name">First Name<span class="required">*</span></label>
                                <input type="text" name="first_name" id="officer_first_name" placeholder="First Name" value="<?php echo $data['first_name']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['first_name_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="last_name">Last Name<span class="required">*</span></label>
                                <input type="text" name="last_name" id="officer_last_name" placeholder="Last Name" value="<?php echo $data['last_name']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['last_name_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="nic">NIC<span class="required">*</span></label>
                                <input type="text" name="nic" id="officer_nic" placeholder="NIC" value="<?php echo $data['nic']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['nic_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="email">Email<span class="required">*</span></label>
                                <input type="text" name="email" id="officer_email" placeholder="Email" value="<?php echo $data['email']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['email_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="officer_id">Officer ID<span class="required">*</span></label>
                                <input type="text" name="officer_id" id="officer_id" placeholder="Officer ID" value="<?php echo $data['officer_id']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['officer_id_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="password">Password<span class="required">*</span></label>
                                <input type="password" name="password" id="officer_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['password_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="confirm_password">Confirm Password<span class="required">*</span></label>
                                <input type="password" name="confirm_password" id="officer_confirm_password" placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'officer') ? $data['confirm_password_error'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="create-account">
                            <button type="submit" value="Register">Create Account<i class="fa-solid fa-angle-right"></i></button>
                        </div>
                    </form>
                </div>

                <!-- Seller Agent Registration Form -->
                <div class="form-box <?php echo $sellerActive; ?>" id="sellerForm">
                    <form method="POST" action="<?php echo URLROOT; ?>/users/register">
                        <div class="input-group">
                            <div class="input-field">
                                <label for="first_name">First Name<span class="required">*</span></label>
                                <input type="text" name="first_name" id="seller_first_name" placeholder="First Name" value="<?php echo $data['first_name']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['first_name_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="last_name">Last Name<span class="required">*</span></label>
                                <input type="text" name="last_name" id="seller_last_name" placeholder="Last Name" value="<?php echo $data['last_name']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['last_name_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="company_name">Company Name (Optional)</label>
                                <input type="text" name="company_name" id="seller_company_name" placeholder="Company Name" value="<?php echo $data['company_name']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['company_name_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="nic">NIC<span class="required">*</span></label>
                                <input type="text" name="nic" id="seller_nic" placeholder="NIC" value="<?php echo $data['nic']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['nic_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="email">Email<span class="required">*</span></label>
                                <input type="text" name="email" id="seller_email" placeholder="Email" value="<?php echo $data['email']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['email_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="brn">Business Registration Number ( BRN )<span class="required">*</span></label>
                                <input type="text" name="brn" id="seller_brn" placeholder="Business Registration Number ( BRN )" value="<?php echo $data['brn']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['brn_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="phone_no">Phone Number<span class="required">*</span></label>
                                <input type="text" name="phone_no" id="seller_phone_no" placeholder="Phone Number" value="<?php echo $data['phone_no']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['phone_no_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="address">Address<span class="required">*</span></label>
                                <input type="text" name="address" id="seller_address" placeholder="Address" value="<?php echo $data['address']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['address_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="password">Password<span class="required">*</span></label>
                                <input type="password" name="password" id="seller_password" placeholder="Password" value="<?php echo $data['password']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['password_error'] : ''; ?></span>
                            </div>
                            <div class="input-field">
                                <label for="confirm_password">Confirm Password<span class="required">*</span></label>
                                <input type="password" name="confirm_password" id="seller_confirm_password" placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                                <span class = "form-invalid"><?php echo ($data['form_type'] == 'seller') ? $data['confirm_password_error'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="create-account">
                            <button type="submit" value="Request">Request to Register<i class="fa-solid fa-angle-right"></i></button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </main>
</body>
</html>