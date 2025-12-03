<?php

    require "../config/connexion.php";


    $id = $_GET['id'];
    $request = "delete from expense where expenseId=$id";
    $query = mysqli_query($conn,$request);
    if(isset($query)){
        header("Location: ../expenses.php");
    }
    

?>