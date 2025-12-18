<?php
    require "../config/connexion.php";

    $id = $_GET['payed'];

    $query = "UPDATE expense SET state='paid' WHERE expenseId=$id";
    $request = mysqli_query($conn, $query);
    if (isset($request)) {
        header("Location: ../transactions.php");
    }
