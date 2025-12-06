<?php
session_start();
require "../config/connexion.php";
require "../models/user.php";

if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['emailRegister']) || empty($_POST['passwordRegister'])){
    header("Location: ../index.php?error=missing_fields");
    exit();
}

$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$email     = $_POST['emailRegister'];
$password  = $_POST['passwordRegister'];

$user = new User($conn);
if($user->register($firstname, $lastname, $email, $password)){
    header("Location: ../index.php?success=registered");
    exit();
} else {
    header("Location: ../index.php?error=register_failed");
    exit();
}
?>
