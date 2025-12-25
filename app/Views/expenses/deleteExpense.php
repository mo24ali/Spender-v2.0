<?php

    require_once "../../Core/database.php";
    require "../../Models/expense.php";
    session_start();
    $userId = $_SESSION['user_id'];
    $id = $_GET['id'];
    
    $db = new Database();
    $conn = $db->getConnection();
    $deletedData = getExpenseById($id,$conn);
    
    $exp = new Expense($conn,$deletedData);
    if($exp->delete()){
        header("Location: expenses.php");
    }else{
        echo "not deleted";
    }

    function getExpenseById($id,$conn){
        $query = "select * from expense where expenseId=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

?>