<?php
session_start();
require_once __DIR__ . "/../../Core/database.php"; 
require_once __DIR__ . "/../../models/card.php";

$conn = Database::getInstance();

$id = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

$data = [
    'idCard'      => $id,
    'user_id'     => $userId,
    'nom'         => $_POST['provider'],
    'currentSold' => $_POST['balance'],
    'num'         => $_POST['cardNum'],
    'statue'      => $_POST['status'],
    'limite'      => $_POST['cardLimit'],
    'expireDate'  => $_POST['expiredate']
];

$card = new Card($conn, $data);


if ($card->save()) {
    header("Location: mycard.php?success=1");
} else {
    header("Location: mycard.php?error=failed_to_save");
}
exit();