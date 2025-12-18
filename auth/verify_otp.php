<?php

session_start();
require "../config/connexion.php";

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
    $stmt->bind_param("is", $userId, $enteredOtp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $otpRow = $result->fetch_assoc();
        $updateStmt = $conn->prepare("UPDATE otp_codes SET used = 1 WHERE id = ?");
        $updateStmt->bind_param("i", $otpRow['id']);
        $updateStmt->execute();

        $ipStmt = $conn->prepare("INSERT INTO user_ips (user_id, ip_address) VALUES (?, ?)");
        $ipStmt->bind_param("is", $userId, $ip);
        $ipStmt->execute();

        $_SESSION['user_id'] = $userId;

        unset($_SESSION['temp_user_id'], $_SESSION['temp_ip']);

        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Invalid or expired OTP. Please try again.";
    }
}
?>

