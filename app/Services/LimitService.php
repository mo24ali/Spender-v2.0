<?php
class LimitService
{
    public function canAddExpense($userId, $categoryId, $amount) {

    }
}
/**
 * <?php
require "../config/connexion.php";
session_start();

if (isset($_POST['setLimit'])) {
    $categoryName = $_POST['categoryNameLimit'];
    $monthly_limit = (float)$_POST['monthly_limit'];
    $user_id = (int)$_POST['user_id'];

    $check = mysqli_query($conn, "SELECT * FROM categories WHERE name = '$categoryName' AND user_id = $user_id");

    if (mysqli_num_rows($check) > 0) {
        $stmt = $conn->prepare("UPDATE categories SET monthly_limit = ? WHERE name = ? AND user_id = ?");
        $stmt->bind_param("dsi", $monthly_limit, $categoryName, $user_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name, monthly_limit, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $categoryName, $monthly_limit, $user_id);
        $stmt->execute();
    }

    header("Location: ../expenses.php");
    exit;
}

 */
