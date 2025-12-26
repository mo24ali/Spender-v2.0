<?php
session_start();
require_once "../../Core/database.php";
require_once "Transaction.php";

$db = Database::getInstance();
$conn = $db->getConnection();

$transaction = new Transaction($conn);

$data = [
    'title'       => $_POST['title'],
    'amount'      => (float)$_POST['amount'],
    'description' => $_POST['description'],
    'date'        => $_POST['date'] ?? null,
    'card_id'     => (int)$_POST['card_id'],
    'category_id' => $_POST['category_id'] ?? null,
    'user_id'     => $_SESSION['user_id'],
    'is_recurring'=> isset($_POST['recurring'])
];

$result = $transaction->create('expenses', $data);

if ($result['success']) {
    header("Location: ../dashboard/dashboard.php?msg=success");
} else {
    echo "Error: " . $result['error'];
}