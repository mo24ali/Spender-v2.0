<?php
    require "../config/connexion.php";
    require "../models/income.php";


    //validate the update 
    $id = $_GET['id'];
    if(isset($_GET['id'])){
        header("Location: ../incomes.php?id=$id");
    }

?>