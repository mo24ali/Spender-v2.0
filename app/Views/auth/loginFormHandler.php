<?php
session_start();
require_once __DIR__ . "/../../Core/database.php";
require "../../Models/User.php";

$db = Database::getInstance();
$conn = $db->getConnection();

if (isset($_POST['connexion'])) {
    $mail = $_POST['emailLog'] ?? '';
    $password = $_POST['passwordLog'] ?? '';

    if ($mail !== "" && $password !== "") {
        $user = new User($conn, [
            'email'    => $mail,
            'password' => $password
        ]);

        $result = $user->login();

        if ($result['status'] === 'error') {
            echo $result['message'];
        } else {
            header("Location: " . $result['redirect']);
            exit();
        }
    } else {
        echo "Mail et password sont obligatoires.";
    }
}
?>