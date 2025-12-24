<?php
session_start();
require_once __DIR__ .  "/../../Core/Database.php";

$con = new Database();
$conn = $con->getConnection();
require "../../Models/User.php";

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
