<?php

require "../config/connexion.php";

class Card
{

    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function addCard($userId, $limite, $name, $currentSold, $number, $expireDate,$stat)
    {
        $query = "
        INSERT INTO carte (nom, user_id, currentSold, limite, statue, expireDate, num)
        VALUES (?, ?, ?, ?, ?, ?,?)
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            "siiissi",
            $name,
            $userId,
            $currentSold,
            $limite,
            $stat,
            $expireDate,
            $number
        );

        return $stmt->execute();
    }

    public function removeCard($carId) {
        $query = '
                DELETE FROM carte WHERE idCard = ? 
            ' ;

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            "i",
            $carId
        );
        $stmt->execute();
    }
    /////////////////////////////// edit card //////////////////////////////////////
    public function editCard($carId){
        
    }
}
