<?php
require "../config/connexion.php";

$id = $_GET['payed'];

$query = "UPDATE expense SET state='paid' WHERE expenseId=$id";
$request = mysqli_query($conn, $query);


$querySelect = "select * from expense where state='paid'";
$selectRequest = mysqli_query($conn, $querySelect);

//transactionId 	title 	description 	user_id 	category_id 	type 	amount 	transaction_date 	state 	
// expenseId 	expenseTitle 	description 	user_id 	price 	categorie 	dueDate 	isRecurent 	state 	
while ($rows = mysqli_fetch_assoc($selectRequest)) {
    $title = $rows['expenseTitle'];
    $description = $rows['description'];
    $user_id = $rows['user_id'];
    $amount = $rows['price'];
    $cateogry_id = $rows['categorie'];
    $state = $rows['state'];
    $type = 'expense';
    $currentDate = date("l jS \of F Y h:i:s A");

    $statement = "
                    INSERT INTO transactions
                    (title, description, user_id, category_id, type, amount, transaction_date, state)
                    VALUES (?,?,?,?,?,?,?,?)
                ";

    $stmt = $conn->prepare($statement);

    $stmt->bind_param(
        "ssiisdss",
        $title,
        $description,
        $user_id,
        $category_id,
        $type,
        $amount,
        $currentDate,
        $state
    );

    $result = $stmt->execute();
}
if (isset($result)) {
    header("Location: ../transactions.php");
}
