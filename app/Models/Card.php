<?php

require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";


class Card
{
    private PDO $conn;
    private $cardName;
    private $owner;
    private $nom;
    private $user_id;
    private $currentSold;
    private $limite;
    private $statue;
    private $expireDate;
    private $num;
    private $primary_statue_user;

  public function __construct(
    string $cardName,
    string $owner,
    string $nom,
    int $user_id,
    float $currentSold,
    float $limite,
    string $statue,
    string $expireDate,
    string $num,
    bool $primary_statue_user
) {
    $this->cardName             = $cardName;
    $this->owner                = $owner;
    $this->nom                  = $nom;
    $this->user_id              = $user_id;
    $this->currentSold          = $currentSold;
    $this->limite               = $limite;
    $this->statue               = $statue;
    $this->expireDate           = $expireDate;
    $this->num                  = $num;
    $this->primary_statue_user  = $primary_statue_user;
}

    public function establishConnection($conn){
        $this->conn = $conn;
    }
    public function addCard(
        Card $crd
    ) {
        $query = "
            INSERT INTO carte (nom, user_id, currentSold, limite, statue, expireDate, num)
            VALUES (:name, :user_id, :currentSold, :limite, :stat, :expireDate, :num)
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':name' => $crd->cardName,
            ':user_id' => $crd->user_id,
            ':currentSold' => $crd->currentSold,
            ':limite' => $crd->limite,
            ':stat' => $crd->statue,
            ':expireDate' => $crd->expireDate,
            ':num' => $crd->num
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

    public function editCard($cardId) {}
}
