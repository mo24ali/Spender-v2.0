<?php

session_start();
require "../../Core/database.php";

$db = new Database();
$conn = $db->getConnection();
if (!isset($_SESSION['temp_user_id'], $_SESSION['temp_ip'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['temp_user_id'];
$ip = $_SESSION['temp_ip'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];

    $stmt = $conn->prepare("
        SELECT * FROM otp_codes 
        WHERE user_id = ? AND otp_code = ? AND used = 0 AND expires_at > NOW()
    ");
    $stmt->execute([$userId, $enteredOtp]);
    $otpRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($otpRow) {
        $updateStmt = $conn->prepare("UPDATE otp_codes SET used = 1 WHERE id = ?");
        $updateStmt->execute([$otpRow['id']]);

        $ipStmt = $conn->prepare("INSERT INTO user_ips (user_id, ip_address) VALUES (?, ?)");
        $ipStmt->execute([$userId, $ip]);

        $_SESSION['user_id'] = $userId;

        unset($_SESSION['temp_user_id'], $_SESSION['temp_ip']);

        header("Location: ../dashboard/dashboard.php");
        exit();
    } else {
        $error = "Invalid or expired OTP. Please try again.";
    }
}
?>

