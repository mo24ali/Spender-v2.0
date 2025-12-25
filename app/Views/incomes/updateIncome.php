<?php
     require_once "../../Core/database.php";
    require "../../Models/Income.php";
    $id = $_GET['id'];
    if(isset($id)){
        header("Location: ../incomes/incomes.php?id=$id");
    }

?>