<?php

    require "../../Core/database.php";

    $id = $_GET['cardId'];

    $conn = Database::getInstance();

    $query = "delete from carte where idCard=$id";
    $request = $conn->getConnection()->query($query);
    if(isset($request)){
        header("Location: mycard.php");
    }
?>