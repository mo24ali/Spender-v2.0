<?php
session_start();

require "../../Core/database.php";
require "../../Models/User.php";

$db = new Database();
$conn = $db->getConnection();

// Basic validation before creating the object
if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['emailRegister']) || empty($_POST['passwordRegister'])){
    header("Location: ../index.php?error=missing_fields");
    exit();
}

// 1. Prepare data for the model
$userData = [
    'firstname' => $_POST['firstname'],
    'lastname'  => $_POST['lastname'],
    'email'     => $_POST['emailRegister'],
    'password'  => $_POST['passwordRegister']
];

// 2. Instantiate with connection and data
$user = new User($conn, $userData);

// 3. Call register (no arguments needed, uses internal state)
if($user->register()){
    header("Location: ../../../index.php?success=registered");
} else {
    header("Location: ../index.php?error=register_failed");
}
exit();
?>