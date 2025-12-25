<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../Core/database.php';
require_once __DIR__ . '/../Models/Income.php';

// Security: user must be logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$db   = new Database();
$conn = $db->getConnection();

$income = new Income($conn);

/* ============================
   INPUT SANITIZATION
============================ */

$title       = trim($_POST['income_title'] ?? '');
$description = trim($_POST['income_description'] ?? '');
$price        = (float) ($_POST['income_price'] ?? 0);
$date         = $_POST['income_date'] ?? '';
$category     = $_POST['income_categorie'] ?? '';
$isRecurrent  = $_POST['income_recurrency'] ?? 'NO';
$userId       = (int) $_SESSION['user_id'];
$incomeId     = isset($_GET['id']) ? (int) $_GET['id'] : null;

/* ============================
   VALIDATION
============================ */

$errors = [];

if ($title === '') {
    $errors[] = 'Income title is required';
}

if ($price <= 0) {
    $errors[] = 'Price must be greater than zero';
}

if ($date === '') {
    $errors[] = 'Income date is required';
}

if (!in_array($isRecurrent, ['YES', 'NO'], true)) {
    $errors[] = 'Invalid recurrence value';
}

if (!empty($errors)) {
    $_SESSION['income_errors'] = $errors;
    header('Location: ../Views/incomes/incomes.php');
    exit;
}

/* ============================
   SET MODEL DATA
============================ */

$income->setData(
    userId: $userId,
    title: $title,
    description: $description,
    price: $price,
    category: $category,
    incomeDate: $date,
    isRecurrent: $isRecurrent
);

/* ============================
   CREATE OR UPDATE
============================ */

try {

    if ($incomeId !== null) {
        // UPDATE
        $income->update($incomeId);
    } else {
        // CREATE
        $income->create();
    }

    header('Location: ../Views/incomes/incomes.php');
    exit;

} catch (PDOException $e) {

    // Log error in real apps
    $_SESSION['income_errors'] = ['Database error occurred'];
    header('Location: ../Views/incomes/incomes.php');
    exit;
}
