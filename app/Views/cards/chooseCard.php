<?php
session_start();
$expenseId = (int)$_GET['expenseId'] ?? 0;

if ($expenseId > 0) {
    header("Location: ../expenses.php?chooseCard=true&expenseId=$expenseId");
    exit;
} else {
    header("Location: ../expenses.php");
    exit;
}
