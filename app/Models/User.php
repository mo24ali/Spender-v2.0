<?php

// require __DIR__ . "../config/connexion.php";
// require __DIR__ . "../Core/Database.php";
require __DIR__ . '/../Services/OtpService.php';

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
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $hashedpass = password_hash($password, PASSWORD_DEFAULT);
        $request = "INSERT INTO users (firstname, lastname, email, password) 
             VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($request);

        return $stmt->execute([$firstname, $lastname, $email, $hashedpass]);
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


    public function login($email, $password)
    {
        $ip = $this->getUserIp();

        $otpService = new OtpService();

        $stmt = $this->conn->prepare("SELECT userId, password, email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<pre>";
        var_dump($user);
        echo "</pre>";
        if ($user) {
            $userId = $user['userId'];
            $userEmail = $user['email'];

            if (password_verify($password, $user['password'])) {

                $ipStmt = $this->conn->prepare("SELECT * 
                                                FROM user_ips 
                                                WHERE user_id = ? 
                                                AND ip_address = ?");
                $ipStmt->execute([$userId, $ip]);
                $ipResult = $ipStmt->fetchAll(PDO::FETCH_ASSOC);

                if ($ipResult) {
                    $_SESSION['user_id'] = $userId;
                    header("Location: ../dashboard/dashboard.php");
                    exit();
                } else {
                    $otp = rand(100000, 999999);
                    $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                    $otpStmt = $this->conn->prepare(
                        "INSERT 
                        INTO otp_codes (user_id, otp_code, expires_at) 
                        VALUES (?, ?, ?)"
                    );
                    $otpStmt->execute([$userId, $otp, $expires]);

                    $otpService->sendOtpViaMail($userEmail, $otp);

                    $_SESSION['temp_user_id'] = $userId;
                    $_SESSION['temp_ip'] = $ip;

                    header("Location: ../../../index.php?verify_otp=true");
                    exit();
                }
            } else {
                echo "Wrong email or password";
            }
        } else {
            echo "Wrong email or password";
        }
    }
    public function logout()
    {

        session_start();
        session_unset();
        session_destroy();
        header("Location: ../../../index.php");
        exit();
    }

    
}
