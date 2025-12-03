<?php

    require "../config/connexion.php";


    $id = $_GET['id'];
    $request = "delete from income where incomeId=$id";
    $query = mysqli_query($conn,$request);
    if(isset($query)){
        header("Location: ../incomes.php");
    }
    

?>