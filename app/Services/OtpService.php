<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;



$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();
class OtpService
{
    public function sendOtpViaMail($toEmail,  $otp)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'];
            $mail->Password   = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'];


            $mail->setFrom($_ENV['MAIL_USERNAME'], 'spenderOTP');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "
            <p>Hello,</p>
            <p>Your OTP code is:</p>
            <h2>{$otp}</h2>
            <p>This code is valid for <strong>5 minutes</strong>.</p>
        ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
    public function verify($userId, $code) {}
}
