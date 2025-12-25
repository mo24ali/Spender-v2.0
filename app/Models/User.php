<?php
require_once __DIR__ . '/../Services/OtpService.php';

class User
{
    private $conn;
    private $userId;
    private $firstname;
    private $lastname;
    private $email;
    private $password;

    public function __construct($db, $data = [])
    {
        $this->conn = $db;
        $this->firstname = $data['firstname'] ?? null;
        $this->lastname  = $data['lastname'] ?? null;
        $this->email     = $data['email'] ?? null;
        $this->password  = $data['password'] ?? null;
    }


    public function register()
    {
        if (empty($this->firstname) || empty($this->lastname) || empty($this->email) || empty($this->password)) {
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $hashedPass = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $this->firstname, 
            $this->lastname, 
            $this->email, 
            $hashedPass
        ]);
    }

    public function login()
    {
        $ip = $this->getUserIp();
        $otpService = new OtpService();

        $stmt = $this->conn->prepare("SELECT userId, password, email FROM users WHERE email = ?");
        $stmt->execute([$this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            $this->userId = $user['userId'];
            $userEmail = $user['email'];

            $ipStmt = $this->conn->prepare("SELECT * FROM user_ips WHERE user_id = ? AND ip_address = ?");
            $ipStmt->execute([$this->userId, $ip]);
            
            if ($ipStmt->fetch()) {
                $_SESSION['user_id'] = $this->userId;
                return ["status" => "success", "redirect" => "../dashboard/dashboard.php"];
            } else {
                $otp = rand(100000, 999999);
                $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                $otpStmt = $this->conn->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
                $otpStmt->execute([$this->userId, $otp, $expires]);

                $otpService->sendOtpViaMail($userEmail, $otp);

                $_SESSION['temp_user_id'] = $this->userId;
                $_SESSION['temp_ip'] = $ip;

                return ["status" => "otp_required", "redirect" => "../../../index.php?verify_otp=true"];
            }
        }

        return ["status" => "error", "message" => "Wrong email or password"];
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: ../../../index.php");
        exit();
    }

    private function getUserIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
        return $_SERVER['REMOTE_ADDR'];
    }
}