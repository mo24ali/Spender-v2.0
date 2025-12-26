<?php

    require_once "../../Core/database.php";
    require "../../Models/expense.php";
    session_start();
    $userId = $_SESSION['user_id'];
    $id = $_GET['id'];
    
    $conn = Database::getInstance();
    $deletedData = getExpenseById($id,$conn);
    
    $exp = new Expense($conn,$deletedData);
    if($exp->delete()){
        header("Location: expenses.php");
    }else{
        echo "not deleted";
    }

    function getExpenseById($id,$conn){
        $query = "select * from expense where expenseId=?";
        $stmt = $conn->getConnection()->prepare($query);
        $stmt->execute([$id]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

?>