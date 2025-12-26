<?php
require "../../Core/database.php";
session_start();


$db = Database::getInstance();
$conn = $db->getConnection();
if (isset($_POST['setLimit'])) {
    $categoryName = $_POST['categoryNameLimit'];
    $monthly_limit = (float)$_POST['monthly_limit'];
    $user_id = (int)$_POST['user_id'];


    $query = "SELECT * FROM categories WHERE name = '$categoryName' AND user_id = $user_id";
    $check = $conn->query($query);


    if ($check->rowCount() > 0) {
        $stmt = $conn->prepare("UPDATE categories SET monthly_limit = ? WHERE name = ? AND user_id = ?");
        // $stmt->bind_param("dsi", );
        $stmt->execute([$monthly_limit, $categoryName, $user_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name, monthly_limit, user_id) VALUES (?, ?, ?)");
        // $stmt->bind_param("sdi", );
        $stmt->execute([$categoryName, $monthly_limit, $user_id]);
    }

    header("Location: ../expenses/expenses.php");
    exit;
}