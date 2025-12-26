<?php
session_start();
require_once "../../Core/database.php";
require_once "../../Models/Expense.php";


$conn = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'expenseId'    => $_GET['id'] ?? null, 
        'user_id'      => $_SESSION['user_id'],
        'expenseTitle' => $_POST['expense_title'],
        'description'  => $_POST['expense_description'],
        'price'        => $_POST['expense_price'],
        'categorie'    => $_POST['expense_categorie'],
        'dueDate'      => $_POST['expense_date'],
        'isRecurent'   => $_POST['expense_recurrency']
    ];

    $expense = new Expense($conn, $data);

    if ($expense->save()) {
        header("Location: ../expenses/expenses.php?msg=success");
    } else {
        header("Location: ../expenses/expenses.php?msg=error");
    }
    exit;
}