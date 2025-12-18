<?php

    require "../config/connexion.php";

    $id = $_GET['cardId'];

    $query = "delete from carte where idCard=$id";
    $request = mysqli_query($conn,$query);
    if(isset($request)){
        header("Location: ../mycard.php");
    }
?>