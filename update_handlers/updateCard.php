<?php
    require "../config/connexion.php";
    require "../models/card.php";


    $id = $_GET['id'];
    if(isset($id)){
        header("Location: ../mycard.php?id=$id");
        exit;
    }
?>