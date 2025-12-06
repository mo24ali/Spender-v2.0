<?php
session_start();
require "../config/connexion.php";

if (isset($_POST['connexion'])) {
    $mail = $_POST['emailLog'];
    $password = $_POST['passwordLog'];

    if ($mail != "" && $password != "") {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$mail' AND password='$password'");
        if (mysqli_num_rows($query) > 0) {
            $_SESSION['user'] = mysqli_fetch_assoc($query);
            echo "Login successful!";
            header("Location: ../dashboard.php");
        } else {
            echo "Email ou mot de passe incorrect.";
        }
    } else {
        echo "Mail et password sont obligatoires.";
    }
}
?>
