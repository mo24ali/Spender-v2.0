<?php

class Expense
{
    private $conn;
    private $expenseId;
    private $expenseTitle;
    private $description;
    private $user_id;
    private $price;
    private $categorie;
    private $dueDate;
    private $isRecurent;
    private $state;

    public function __construct($db, $data = [])
    {
        $this->conn = $db;
        
        $this->expenseId    = $data['expenseId'] ?? null;
        $this->expenseTitle = $data['expenseTitle'] ?? null;
        $this->description  = $data['description'] ?? null;
        $this->user_id      = $data['user_id'] ?? null;
        $this->price        = $data['price'] ?? 0;
        $this->categorie    = $data['categorie'] ?? null;
        $this->dueDate      = $data['dueDate'] ?? null;
        $this->isRecurent   = $data['isRecurent'] ?? 'NO';
        $this->state   = $data['state'] ?? 'NOT PAID';
    }

    
    public function save()
    {
        if ($this->expenseId) {
            return $this->update();
            
        } else {
            return $this->create();
            
        }
    }

    private function create()
    {
        $sql = "INSERT INTO expense (expenseTitle, description, user_id, price, categorie, dueDate, isRecurent) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->getConnection()->prepare($sql);
        return $stmt->execute([
            $this->expenseTitle,
            $this->description,
            $this->user_id,
            $this->price,
            $this->categorie,
            $this->dueDate,
            $this->isRecurent
        ]);
    }

    private function update()
    {
        $sql = "UPDATE expense SET 
                expenseTitle = ?, description = ?, price = ?, categorie = ?, dueDate = ?, isRecurent = ? 
                WHERE expenseId = ? AND user_id = ?";
        $stmt = $this->conn->getConnection()->prepare($sql);
        return $stmt->execute([
            $this->expenseTitle,
            $this->description,
            $this->price,
            $this->categorie,
            $this->dueDate,
            $this->isRecurent,
            $this->expenseId,
            $this->user_id
        ]);
    }

    public function delete()
    {
        if (!$this->expenseId) return false;
        $stmt = $this->conn->getConnection()->prepare("DELETE FROM expense WHERE expenseId = ?");
        return $stmt->execute([$this->expenseId]);
    }

    public function setExpenseId($id) { $this->expenseId = $id; }
    public function getExpenseId() { return $this->expenseId; }

    
}