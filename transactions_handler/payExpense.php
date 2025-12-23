<?php
require "../config/connexion.php";

if (!isset($_GET['payed'], $_GET['card'])) {
    die("Invalid request");
}

$expenseId = (int) $_GET['payed'];
$cardId    = (int) $_GET['card'];

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("
        SELECT expenseTitle, description, user_id, price, categorie, state
        FROM expense
        WHERE expenseId = ? AND state = 'not paid'
        FOR UPDATE
    ");
    $stmt->bind_param("i", $expenseId);
    $stmt->execute();
    $expense = $stmt->get_result()->fetch_assoc();

    if (!$expense) {
        throw new Exception("Expense already paid or not found");
    }

    $stmt = $conn->prepare("
        SELECT categoryId, monthly_limit
        FROM categories
        WHERE name = ?
    ");
    $stmt->bind_param("s", $expense['categorie']);
    $stmt->execute();
    $category = $stmt->get_result()->fetch_assoc();

    if (!$category) {
        throw new Exception("Invalid category");
    }

    $categoryId = $category['categoryId'];
    $limit      = $category['monthly_limit'];

    if ($limit > 0) {
        $stmt = $conn->prepare("
            SELECT IFNULL(SUM(amount),0) AS total
            FROM transactions
            WHERE category_id = ?
            AND type = 'EXPENSE'
            AND state = 'paid'
            AND MONTH(transaction_date) = MONTH(CURDATE())
            AND YEAR(transaction_date) = YEAR(CURDATE())
        ");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $spent = $stmt->get_result()->fetch_assoc()['total'];

        if (($spent + $expense['price']) > $limit) {
            throw new Exception("Category limit exceeded");
        }
    }

    $stmt = $conn->prepare("
        SELECT currentSold
        FROM carte
        WHERE idCard = ?
        FOR UPDATE
    ");
    $stmt->bind_param("i", $cardId);
    $stmt->execute();
    $card = $stmt->get_result()->fetch_assoc();

    if (!$card || $card['currentSold'] < $expense['price']) {
        throw new Exception("Insufficient card balance");
    }

    $stmt = $conn->prepare("
        UPDATE carte
        SET currentSold = currentSold - ?
        WHERE idCard = ?
    ");
    $stmt->bind_param("di", $expense['price'], $cardId);
    $stmt->execute();

    $stmt = $conn->prepare("
        INSERT INTO transactions
        (title, description, user_id, category_id, type, amount, transaction_date, state)
        VALUES (?, ?, ?, ?, 'EXPENSE', ?, CURDATE(), 'paid')
    ");
    $stmt->bind_param(
        "ssiid",
        $expense['expenseTitle'],
        $expense['description'],
        $expense['user_id'],
        $categoryId,
        $expense['price']
    );
    $stmt->execute();


    $stmt = $conn->prepare("
        UPDATE expense SET state = 'paid'
        WHERE expenseId = ?
    ");
    $stmt->bind_param("i", $expenseId);
    $stmt->execute();

    $conn->commit();

    header("Location: ../transactions.php");
    exit;

} catch (Exception $e) {

    $conn->rollback();
    die("❌ Payment failed: " . $e->getMessage());
}
