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
        $stmt = $this->conn->prepare($sql);
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
        $stmt = $this->conn->prepare($sql);
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
        $stmt = $this->conn->prepare("DELETE FROM expense WHERE expenseId = ? AND user_id = ?");
        return $stmt->execute([$this->expenseId, $this->user_id]);
    }

    public function setExpenseId($id) { $this->expenseId = $id; }
    public function getExpenseId() { return $this->expenseId; }
}