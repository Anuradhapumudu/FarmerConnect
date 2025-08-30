<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - <?php echo SITENAME; ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo URLROOT; ?>/img/logo.png">
    <!-- <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/logreg.css"> -->

    <style>
        .error {
            color: red;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box Register">
            <h2 class="animation" style="--S:1">Sign Up</h2>
            <form action="<?php echo URLROOT; ?>/login/register" method="post" class="animation" style="--S:2">
                <div class="input-box">
                    <input type="text" id="name" name="name"  value="<?php echo $data['name']; ?>">
                    <label for="name">Full Name</label>
                    <span class="error"><?php echo $data['name_error']; ?></span>
                </div>
                <div class="input-box">
                    <input type="email" id="email" name="email"  value="<?php echo $data['email']; ?>">
                    <label for="email">Email</label>
                    <span class="error"><?php echo $data['email_error']; ?></span>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password"  value="<?php echo $data['password']; ?>">
                    <label for="password">Password</label>
                    <span class="error"><?php echo $data['password_error']; ?></span>
                </div>
                <div class="input-box">
                    <input type="password" id="confirm_password" name="confirm_password"  value="<?php echo $data['confirm_password']; ?>">
                    <label for="confirm_password">Confirm Password</label>
                    <span class="error"><?php echo $data['confirm_password_error']; ?></span>
                </div>
                <button type="submit" class="btn">Sign Up</button>
            </form>
            <div class="regi-link">
                <p class="animation" style="--S:3">Already have an account? <a href="<?php echo URLROOT; ?>/login">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
