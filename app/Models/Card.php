<?php

require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";


class Card
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function addCard(
        int $userId,
        float $limite,
        string $name,
        float $currentSold,
        string $number,
        string $expireDate,
        string $stat
    ) {
        $query = "
            INSERT INTO carte (nom, user_id, currentSold, limite, statue, expireDate, num)
            VALUES (:name, :user_id, :currentSold, :limite, :stat, :expireDate, :num)
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':name' => $name,
            ':user_id' => $userId,
            ':currentSold' => $currentSold,
            ':limite' => $limite,
            ':stat' => $stat,
            ':expireDate' => $expireDate,
            ':num' => $number
        ]);
    }

    public function removeCard(int $cardId): bool
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM carte WHERE idCard = :id"
        );

        return $stmt->execute([
            ':id' => $cardId
        ]);
    }
}
