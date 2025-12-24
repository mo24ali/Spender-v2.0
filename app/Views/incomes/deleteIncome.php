<?php

    require "../config/connexion.php";
    require "../models/income.php";


    $id = $_GET['id'];
    $inc = new Income($conn);
    $inc -> supprimerIncome($id);
?>