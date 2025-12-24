<?php

    require "../config/connexion.php";
    require "../models/expense.php";
    $id = $_GET['id'];
    $exp = new Expense($conn);
    $exp->supprimerExpense($id);
    

?>