<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once APPROOT . '/vendor/autoload.php';

function sendApprovalEmail($toEmail, $sellerId) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'janeeshahasadara@gmail.com';
        $mail->Password   = 'nyne ltss fobt zwer';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('janeeshahasadara@gmail.com', 'FarmerConnect Admin');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Seller Approval - FarmerConnect';
        $mail->Body    = "
            <h2>Congratulations!</h2>
            <p>Your seller account has been approved 🎉</p>
            <p>Your Seller ID is: <strong>$sellerId</strong></p>
            <p>You can now log in and start selling!</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>