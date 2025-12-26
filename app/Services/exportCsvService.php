<?php
    require "../Core/database.php";
    session_start();


    $db = Database::getInstance();
    $conn = $db->getConnection();
    $userId = $_SESSION['user_id'];
    $request = "SELECT * FROM income i , expense e where i.user_id='$userId' and e.user_id='$userId'";
    $query = $conn->query($request);
    $data = array();
    if($query->rowCount() > 0){
        while($rows = $query->fetch(PDO::FETCH_ASSOC)){
            $data[] = $rows;
        }
    }

    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachement; filename=Data_user_id=$userId.csv");

    $output = fopen('php://output','w');
    fputcsv($output,array('#','expenseId','expenseTitle','description','user_id','price','categorie','dueDate','state','incomeId','incomeTitle','description','user_id', 'price','categorie','getIncomeDate'));
    if(count($data) >0){
        foreach($data as $row){
            fputcsv($output,$row);
        }
    }
?>
