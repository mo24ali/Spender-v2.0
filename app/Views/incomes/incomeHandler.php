<?php
session_start();
require_once "../../Core/database.php";
require_once "../../Models/Income.php";

$db = Database::getInstance();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'user_id'       => $_SESSION['user_id'],
        'incomeTitle'   => $_POST['income_title'],
        'description'   => $_POST['income_description'],
        'price'         => $_POST['income_price'],
        'getIncomeDate' => $_POST['income_date'],
        'isRecurent'    => $_POST['income_recurrency'],
        'categorie'     => $_POST['income_categorie']
    ];

    $income = new Income($conn, $data);

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $income->setIncomeId($_GET['id']);
    }

    if ($income->save()) {
        header("Location: incomes.php?success=1");
    } else {
        echo "Something went wrong.";
    }
    exit;
}