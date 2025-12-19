<?php

    require "../config/connexion.php";
    session_start();
    $receiverMail = $_POST['receiverMail'];
    $amount = $_POST['amount'];
    $sender = $_SESSION['user_id'];


    $query = " select userId from users where email='$receiverMail' limit 1";
    $request = mysqli_query($conn,$query);
    

    if(mysqli_num_rows($request) > 0){
        $result = mysqli_fetch_assoc($request);
        $receiverId = $result['userId']; 
        
        //transferId 	idSender 	idReceiver 	amount 	daySent 	
        $insertQuery = "INSERT INTO transfert(idSender, idReceiver, amount)
                                    values (?,?,?)
                        ";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param(
            "iii",
            $sender,
            $receiverId,
            $amount
        );
        $stmt->execute();
        header("Location: ../transactions.php");
    }




?>