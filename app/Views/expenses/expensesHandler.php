
<?php
session_start();
require "../config/connexion.php";
require "../models/expense.php";

$exp = new Expense($conn);

$title = $_POST['expense_title'];
$desc  = $_POST['expense_description'];
$price = $_POST['expense_price'];
$date  = $_POST['expense_date'];
$category = $_POST['expense_categorie'];
$isRecurrent = $_POST['expense_recurrency'];

$id = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];
if (!empty($id)) {
    $exp->modifierExpense($id, $title, $desc, $price,$category, $date,$isRecurrent);
    header("Location: ../expenses.php");
    exit;
} else {
    $exp->ajouterExpense($title, $desc, $price,$category, $date,$userId,$isRecurrent);
    header("Location: ../expenses.php");
    exit;
}



?>