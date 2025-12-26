<?php
require_once "../../Core/database.php"; 

if (!isset($_GET['payed'], $_GET['card'])) {
    die("Invalid request");
}

$expenseId = (int) $_GET['payed'];
$cardId    = (int) $_GET['card'];

$db =Database::getInstance(); 
$conn = $db->getConnection();

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("
        SELECT expenseTitle, description, user_id, price, categorie, state 
        FROM expense 
        WHERE expenseId = ? AND state = 'not paid' 
        FOR UPDATE
    ");
    $stmt->execute([$expenseId]);
    $expense = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$expense) {
        throw new Exception("Expense already paid or not found");
    }

    $stmt = $conn->prepare("SELECT categoryId, monthly_limit 
                            FROM categories 
                            WHERE name = ?");
    $stmt->execute([$expense['categorie']]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        throw new Exception("Invalid category => You should set the category limit first");
    }

    $categoryId = $category['categoryId'];
    $limit      = $category['monthly_limit'];

    if ($limit > 0) {
        $stmt = $conn->prepare("
            SELECT IFNULL(SUM(amount), 0) AS total 
            FROM transactions 
            WHERE category_id = ? 
            AND type = 'EXPENSE' 
            AND state = 'paid' 
            AND MONTH(transaction_date) = MONTH(CURDATE()) 
            AND YEAR(transaction_date) = YEAR(CURDATE())
        ");
        $stmt->execute([$categoryId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $spent = $row['total'];

        if (($spent + $expense['price']) > $limit) {
            throw new Exception("Category limit exceeded for this month");
        }
    }

    $stmt = $conn->prepare("SELECT currentSold 
                                                FROM carte 
                                                WHERE idCard = ? FOR UPDATE");
    $stmt->execute([$cardId]);
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$card || $card['currentSold'] < $expense['price']) {
        throw new Exception("Insufficient card balance");
    }

    $stmt = $conn->prepare("UPDATE carte 
                            SET currentSold = currentSold - ? 
                            WHERE idCard = ?");
    $stmt->execute([$expense['price'], $cardId]);

    $stmt = $conn->prepare("
        INSERT INTO transactions (title, description, user_id, category_id, type, amount, transaction_date, state) 
        VALUES (?, ?, ?, ?, 'EXPENSE', ?, CURDATE(), 'paid')
    ");
    $stmt->execute([
        $expense['expenseTitle'],
        $expense['description'],
        $expense['user_id'],
        $categoryId,
        $expense['price']
    ]);

    $stmt = $conn->prepare("UPDATE expense 
                            SET state = 'paid' 
                            WHERE expenseId = ?");
    $stmt->execute([$expenseId]);

    $conn->commit();

    header("Location: ../transactions/transactions.php?success=payment_complete");
    exit;

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    die("Payment failed: " . $e->getMessage());
}