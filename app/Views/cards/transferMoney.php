<?php

    require "../../Core/database.php";
    session_start();
    $receiverMail = $_POST['receiverMail'];
    $amount = $_POST['amount'];
    $sender = $_SESSION['user_id'];


    $db = Database::getInstance();
    $conn = $db->getConnection();
    $query = " select userId from users where email='$receiverMail' limit 1";
    $request = $conn->query($query);
    

    if($request->rowCount() > 0){
        $result = $request->fetch();
        $receiverId = $result['userId']; 
        
        //transferId 	idSender 	idReceiver 	amount 	daySent 	
        $insertQuery = "INSERT INTO transfert(idSender, idReceiver, amount)
                                    values (?,?,?)
                        ";
        $stmt = $conn->prepare($insertQuery);
       
        $stmt->execute([ $sender,
            $receiverId,
            $amount]);
        header("Location: ../transactions/transactions.php");
    }




?>