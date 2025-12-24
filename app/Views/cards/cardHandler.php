
<?php
session_start();
require "../config/connexion.php";
require "../models/card.php";

$card = new Card($conn);


$cardProvide = $_POST['provider'];
$cardBalance = $_POST['balance'];
$cardNumber = $_POST['cardNum'];
$cardStatus = $_POST['status'];
$cardLimite = $_POST['cardLimit'];
$cardExpireDate = $_POST['expiredate'];
// carte(#idCard, nom, user_id, currentSold,limite, statue, expireDate, num, user_id# )


$id = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];
if (empty($id)) {
    $card->addCard($userId,$cardLimite,$cardProvide,$cardBalance,$cardNumber,$cardExpireDate,$cardStatus);
    header("Location: ../mycard.php");
    exit;
} else {
    $card->editCard($id);
    header("Location: ../mycard.php");
    exit;
}



?>