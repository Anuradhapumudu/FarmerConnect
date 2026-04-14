<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php'; // correct path

function sendApprovalEmail($toEmail, $sellerId) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'farmerconnect.lk@gmail.com';
        $mail->Password   = 'uhnc xtlk sgqh xufa';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('farmerconnect.lk@gmail.com', 'FarmerConnect Admin');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = ' Account Approved - FarmerConnect.lk';

        $mail->Body = "
        <div style='font-family: Arial; padding:20px;'>
            <h2 style='color:green;'> Congratulations!</h2>
            <p>Your seller account has been <strong>APPROVED</strong>.</p>

            <p><strong>Seller ID:</strong> $sellerId</p>

            <p>You can now log in and start selling your agricultural products on FarmerConnect.</p>

            <br>
            <p>Thank you for joining us </p>
            <p><strong>FarmerConnect Team</strong></p>
        </div>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}

function sendRejectEmail($toEmail, $sellerId, $missingFields = []) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'farmerconnect.lk@gmail.com';
        $mail->Password   = 'uhnc xtlk sgqh xufa';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('farmerconnect.lk@gmail.com', 'FarmerConnect Admin');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Seller Account Pending - FarmerConnect.lk';

        $missingList = "";
        if (!empty($missingFields)) {
            $missingList .= "<ul>";
            foreach ($missingFields as $field) {
                $missingList .= "<li>" . ucfirst($field) . "</li>";
            }
            $missingList .= "</ul>";
        }

        $mail->Body = "
        <div style='font-family: Arial; padding:20px;'>
            <h2 style='color:orange;'> Account Reject Review</h2>

            <p>Your seller account is currently <strong>NOT APPROVED</strong>.</p>

            <p><strong>Seller ID:</strong> $sellerId</p>

            <p>Missing or invalid information:</p>
            $missingList

            <p>Please contact admin for approval.</p>

            <br>
            <p><strong>FarmerConnect Team</strong></p>
        </div>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}

function sendWaitingApprovalEmail($toEmail) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'farmerconnect.lk@gmail.com';
        $mail->Password   = 'uhnc xtlk sgqh xufa';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('farmerconnect.lk@gmail.com', 'FarmerConnect Admin');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = ' Account Under Review - FarmerConnect.lk';

        $mail->Body = "
        <div style='font-family: Arial, sans-serif; padding:20px;'>
            
            <h2 style='color:#ff9800;'> Account is pending </h2>

            <p>Thank you for registering as a seller on <strong>FarmerConnect.lk</strong>.</p>

            <p>Your account is currently <strong>under review</strong> by our admin team.</p>

            <hr>

            <p><strong>What happens next?</strong></p>
            <ul>
                <li>Admin will review your submitted details</li>
                <li>Your information will be verified</li>
                <li>You will receive an approval email once verified</li>
            </ul>

            <hr>

            <p style='color:#555;'>
                Please wait while we complete the verification process.  
                This may take some time.
            </p>

            <br>

            <p>Thank you for your patience 🌱</p>
            <p><strong>FarmerConnect Team</strong></p>
        </div>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}