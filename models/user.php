<?php
class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($firstname, $lastname, $email, $password)
    {
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

    public function login($email, $password)
    {
        $ip = $this->getUserIp(); 

        $stmt = $this->conn->prepare("SELECT userId, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $userId = $user['userId'];

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
                    $expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));

                    $otpStmt = $this->conn->prepare(
                        "INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)"
                    );
                    $otpStmt->bind_param("iss", $userId, $otp, $expires);
                    $otpStmt->execute();


                    $_SESSION['temp_user_id'] = $userId;
                    $_SESSION['temp_ip'] = $ip;

                    header("Location: ../auth/verify_otp.php"); 
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
