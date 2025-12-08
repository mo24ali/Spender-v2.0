<?php
    require "../config/connexion.php";
    session_start();
    $userId = $_SESSION['user_id'];
    $request = "SELECT * FROM income i , expense e where i.user_id='$userId' and e.user_id='$userId'";
    $query = mysqli_query($conn,$request);
    $data = array();
    if(mysqli_num_rows($query) > 0){
        while($rows = mysqli_fetch_assoc($query)){
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
