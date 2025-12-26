<?php
session_start();

require "../../Core/database.php";
require "../../Models/User.php";

$db = Database::getInstance();
$conn = $db->getConnection();

if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['emailRegister']) || empty($_POST['passwordRegister'])){
    header("Location: ../index.php?error=missing_fields");
    exit();
}

$userData = [
    'firstname' => $_POST['firstname'],
    'lastname'  => $_POST['lastname'],
    'email'     => $_POST['emailRegister'],
    'password'  => $_POST['passwordRegister']
];

$user = new User($conn, $userData);

if($user->register()){
    header("Location: ../../../index.php?success=registered");
} else {
    header("Location: ../../../index.php?error=register_failed");
}
exit();
?>