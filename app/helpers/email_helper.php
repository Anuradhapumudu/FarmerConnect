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
        $mail->Username   = 'janeeshahasadara@gmail.com';
        $mail->Password   = 'nyne ltss fobt zwer'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('janeeshahasadara@gmail.com', 'FarmerConnect Admin');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Seller Approval - FarmerConnect';
        $mail->Body    = "
            <h2>🎉 Congratulations!</h2>
            <p>Your seller account has been <strong>approved</strong>.</p>
            <p>Your Seller ID: <strong>$sellerId</strong></p>
            <p>You can now log in to FarmerConnect and start selling.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}
