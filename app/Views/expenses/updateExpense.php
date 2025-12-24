<?php
    require "../config/connexion.php";
    require "../models/expense.php";
    $id = $_GET['id'];
    if(isset($id)){
        header("Location: ../expenses.php?id=$id");
    }

?>