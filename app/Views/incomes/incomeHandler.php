<?php
require "../config/connexion.php";
require "../models/income.php";


session_start();
$income = new Income($conn);


$title = $_POST['income_title'];
$description = $_POST['income_description'];
$price = $_POST['income_price'];
$date = $_POST['income_date'];
$category = $_POST['income_categorie'];
$id = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];
$isRecurent = $_POST['income_recurrency'];
if (!empty($id)) {

    $income->modifierIncome($id, $title, $description, $price,$category, $date, $isRecurent);
    header("Location: ../incomes.php");
    exit;
} else {

    $income->ajouterIncome($title, $description, $price,$category, $date,$userId, $isRecurent);

    header("Location: ../incomes.php");
    exit;
}
?>