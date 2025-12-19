<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($firstname, $lastname, $email, $password)
    {

        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            return false; // stop registration
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; // invalid email
        }
        $hashedpass = password_hash($password, PASSWORD_DEFAULT);
        // $hashedpass = sha1($password);
        $stmt = $this->conn->prepare(
            "INSERT INTO users (firstname, lastname, email, password) 
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashedpass);
        return $stmt->execute();
    }


    public function getUserIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    public function sendOtpViaMail($email, $emailPassword, $otp) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $email; 
            $mail->Password   = $emailPassword; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;


            /**
             * 
             * 
             * need to generate a sender email and a password from the google app then put it in the .env file to use it later 
             */
            $mail->setFrom($email, 'Your App Name');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Hello!<br>Your OTP code is: <strong>$otp</strong><br>This code is valid for 5 minutes.";

            $mail->send();
            echo "OTP sent successfully!";
        } catch (Exception $e) {
            echo "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
        }
    }

    public function login($email, $password) {
        $ip = $this->getUserIp();

        $stmt = $this->conn->prepare("SELECT userId, password, email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $userId = $user['userId'];
            $userEmail = $user['email'];

            if (password_verify($password, $user['password'])) {

                $ipStmt = $this->conn->prepare("SELECT * FROM user_ips WHERE user_id = ? AND ip_address = ?");
                $ipStmt->bind_param("is", $userId, $ip);
                $ipStmt->execute();
                $ipResult = $ipStmt->get_result();

                if ($ipResult->num_rows > 0) {
                    $_SESSION['user_id'] = $userId;
                    header("Location: ../dashboard.php");
                    exit();
                } else {
                    $otp = rand(100000, 999999);
                    $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                    $otpStmt = $this->conn->prepare(
                        "INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)"
                    );
                    $otpStmt->bind_param("iis", $userId, $otp, $expires);
                    $otpStmt->execute();
/////////////////////////////////////////////////////////////////
                    $this->sendOtpViaMail($userEmail, 'rtyuio', $otp);
/////////////////////////////////////////////////////////////////////////////////////
                    // Store temporary session
                    $_SESSION['temp_user_id'] = $userId;
                    $_SESSION['temp_ip'] = $ip;

                    header("Location: ../index.php?verify_otp=true");
                    exit();
                }

            } else {
                echo "Wrong email or password";
            }
        } else {
            echo "Wrong email or password";
        }
    }
}
