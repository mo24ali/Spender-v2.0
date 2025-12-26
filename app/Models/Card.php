<?php

class Card
{
    private  $conn;
    private $cardId;
    private $cardName;
    private $user_id;
    private $currentSold;
    private $limite;
    private $statue;
    private $expireDate;
    private $num;

    public function __construct($db, $data = [])
    {
        $this->conn = $db;

        $this->cardId      = $data['idCard'] ?? null;
        $this->user_id      = $data['user_id'] ?? null;
        $this->cardName     = $data['nom'] ?? null;
        $this->currentSold  = $data['currentSold'] ?? 0;
        $this->limite       = $data['limite'] ?? 0;
        $this->statue       = $data['statue'] ?? 'active';
        $this->expireDate   = $data['expireDate'] ?? null;
        $this->num          = $data['num'] ?? null;
    }


    public function save()
    {
        if ($this->cardId) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    private function create()
    {
        $query = "INSERT INTO carte (nom, user_id, currentSold, limite, statue, expireDate, num)
                  VALUES (:name, :user_id, :currentSold, :limite, :stat, :expireDate, :num)";

        $stmt = $this->conn->getConnection()->prepare($query);
        return $stmt->execute([
            ':name'         => $this->cardName,
            ':user_id'      => $this->user_id,
            ':currentSold'  => $this->currentSold,
            ':limite'       => $this->limite,
            ':stat'         => $this->statue,
            ':expireDate'   => $this->expireDate,
            ':num'          => $this->num
        ]);
    }

    private function update()
    {
        $query = "UPDATE carte SET 
                    nom = ?, 
                    currentSold = ?, 
                    limite = ?, 
                    statue = ?, 
                    expireDate = ?, 
                    num = ?
                  WHERE idCard = ? AND user_id = ?";

        $stmt = $this->conn->getConnection()->prepare($query);
        return $stmt->execute([
            $this->cardName,
            $this->currentSold,
            $this->limite,
            $this->statue,
            $this->expireDate,
            $this->num,
            $this->cardId,
            $this->user_id
        ]);
    }

    public function delete()
    {
        if (!$this->cardId) return false;
        $stmt = $this->conn->prepare("DELETE FROM carte WHERE idCard = ? AND user_id = ?");
        return $stmt->execute([
            $this->cardId,
            $this->user_id
        ]);
    }
}
