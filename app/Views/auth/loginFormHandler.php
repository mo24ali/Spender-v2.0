<?php
session_start();
require "../config/connexion.php";
require "../models/user.php";

$user = new User($conn);
if (isset($_POST['connexion'])) {
    $mail = $_POST['emailLog'];
    $password = $_POST['passwordLog'];

    if ($mail != "" && $password != "") {
       $user->login($mail,$password);
    } else {
        echo "Mail et password sont obligatoires.";
    }
}
?>
