<?php
     require_once "../../Core/database.php";
    require "../../Models/expense.php";
    $id = $_GET['id'];
    if(isset($id)){
        header("Location: ../expenses/expenses.php?id=$id");
    }

?>