<?php

require "../config/connexion.php";

class Card
{

    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function addCard($userId, $limite, $name, $currentSold, $number, $expireDate)
    {
        $query = "
        INSERT INTO carte (nom, user_id, currentSold, limite, expireDate, num)
        VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            "siiisi",
            $name,
            $userId,
            $currentSold,
            $limite,
            $expireDate,
            $number
        );

        return $stmt->execute();
    }

    public function removeCard() {}
}
