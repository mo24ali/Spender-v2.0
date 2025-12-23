<?php
require_once __DIR__ . '/../config/db.php';
date_default_timezone_set('Africa/Casablanca');

$stmt = $conn->prepare("
    SELECT * FROM expense
    WHERE isRecurent = 'YES'
    AND state = 'not paid'
    AND next_run <= NOW()
");
$stmt->execute();
$res = $stmt->get_result();

while ($e = $res->fetch_assoc()) {

    $conn->begin_transaction();

    try {
        $cardStmt = $conn->prepare("
            SELECT idCard, currentSold FROM carte
            WHERE user_id = ? AND statue = 'Primary'
            FOR UPDATE
        ");
        $cardStmt->bind_param("i", $e['user_id']);
        $cardStmt->execute();
        $card = $cardStmt->get_result()->fetch_assoc();

        if (!$card || $card['currentSold'] < $e['price']) {
            throw new Exception("Insufficient funds");
        }

        $catStmt = $conn->prepare("SELECT categoryId FROM categories WHERE name = ?");
        $catStmt->bind_param("s", $e['categorie']);
        $catStmt->execute();
        $categoryId = $catStmt->get_result()->fetch_assoc()['categoryId'];

        if (!categoryLimitOK($conn, $categoryId, $e['price'])) {
            throw new Exception("Category limit exceeded");
        }

        $upd = $conn->prepare("
            UPDATE carte SET currentSold = currentSold - ?
            WHERE idCard = ?
        ");
        $upd->bind_param("di", $e['price'], $card['idCard']);
        $upd->execute();

        $tx = $conn->prepare("
            INSERT INTO transactions
            (title, description, user_id, category_id, type, amount, transaction_date, state)
            VALUES (?, ?, ?, ?, 'EXPENSE', ?, CURDATE(), 'paid')
        ");
        $tx->bind_param(
            "ssiid",
            $e['expenseTitle'],
            $e['description'],
            $e['user_id'],
            $categoryId,
            $e['price']
        );
        $tx->execute();

        $next = match ($e['interval_type']) {
            'DAILY' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'WEEKLY' => date('Y-m-d H:i:s', strtotime('+1 week')),
            'MONTHLY' => date('Y-m-d H:i:s', strtotime('+1 month')),
        };

        $upd = $conn->prepare("
            UPDATE expense SET next_run = ?, state = 'paid'
            WHERE expenseId = ?
        ");
        $upd->bind_param("si", $next, $e['expenseId']);
        $upd->execute();

        $conn->commit();

    } catch (Exception $ex) {
        $conn->rollback();
    }
}
