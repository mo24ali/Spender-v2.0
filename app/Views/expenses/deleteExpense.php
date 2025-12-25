<?php

    // require "../config/connexion.php";
    require_once "../../Core/database.php";
    require "../../Models/expense.php";
    session_start();
    $userId = $_SESSION['user_id'];
    $id = $_GET['id'];
    
    $deletedData = [$id,"","",$userId,"","",""];
    $db = new Database();
    $conn = $db->getConnection();

    $exp = new Expense($conn,$deletedData);
    $exp->delete();
    

?>