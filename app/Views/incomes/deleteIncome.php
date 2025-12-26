<?php

    require_once "../../Core/database.php";
    require "../../Models/Income.php";
    session_start();
    $userId = $_SESSION['user_id'];
    $id = $_GET['id'];
    
    // $db = new Database();
    $conn = Database::getInstance();
    $deletedData = getIncomeById($id,$conn);
    
    $inc = new Income($conn,$deletedData);
    if($inc->delete()){
        header("Location: incomes.php");
    }else{
        echo "not deleted";
    }

    function getIncomeById($id,$conn){
        $query = "select * from income where incomeId=?";
        $stmt = $conn->getConnection()->prepare($query);
        $stmt->execute([$id]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

?>