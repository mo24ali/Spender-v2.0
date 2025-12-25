<?php

class Income
{
    private $conn;
    private $incomeId;
    private $incomeTitle;
    private $description;
    private $user_id;
    private $price;
    private $getIncomeDate;
    private $isRecurent;
    private $categorie;

    public function __construct($db, $data = [])
    {
        $this->conn = $db;
        $this->incomeId      = $data['incomeId'] ?? null;
        $this->user_id       = $data['user_id'] ?? null;
        $this->incomeTitle   = $data['incomeTitle'] ?? null;
        $this->price         = $data['price'] ?? 0;
        $this->getIncomeDate = $data['getIncomeDate'] ?? null;
        $this->isRecurent    = $data['isRecurent'] ?? 'NO';
        $this->description   = $data['description'] ?? null;
        $this->categorie     = $data['categorie'] ?? null;
    }

    public function save()
    {
        if ($this->incomeId) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    private function create()
    {
        $sql = "INSERT INTO income (incomeTitle, description, user_id, price, categorie, getIncomeDate, isRecurent) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $this->incomeTitle, 
            $this->description, 
            $this->user_id, 
            $this->price, 
            $this->categorie, 
            $this->getIncomeDate, 
            $this->isRecurent
        ]);
    }

    private function update()
    {
        $sql = "UPDATE income SET incomeTitle=?, description=?, price=?, categorie=?, getIncomeDate=?, isRecurent=? 
                WHERE incomeId = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $this->incomeTitle, 
            $this->description, 
            $this->price, 
            $this->categorie, 
            $this->getIncomeDate, 
            $this->isRecurent, 
            $this->incomeId, 
            $this->user_id
        ]);
    }

    // Setters allow you to change state after instantiation
    public function setIncomeId($id) { $this->incomeId = $id; }


    public function delete(){
        if(!$this->incomeId) return false;
        $query = "DELETE FROM income WHERE incomeId=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->incomeId]);
    }
}