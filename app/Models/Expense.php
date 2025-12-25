<?php
require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";
class Expense
{
    private $conn;
    private Categorie $categorie;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function ajouterExpense($expenseTitle, $expenseDescription, $price, $categorie, $dueDate, $userId, $isRecurrent)
    {
        $request = "insert into expense(expenseTitle,description,user_id,price,categorie,dueDate,isRecurent) 
            values ('$expenseTitle','$expenseDescription','$userId',$price,'$categorie','$dueDate','$isRecurrent')";
        $query = mysqli_query($this->conn, $request);
        if (isset($query)) {
            header("Location: ../expenses.php");
        }
    }
    public function supprimerExpense($expenseId)
    {
        $request = "delete from expense where expenseId=$expenseId";
        $query = mysqli_query($this->conn, $request);
        if (isset($query)) {
            header("Location: ../expenses.php");
        }
    }
    public function modifierExpense($expenseId, $expenseTitle, $newExpenseDesc, $newExpensePrice, $categorie, $expDueDate, $isRecurrent)
    {
        $request = "update expense 
                        set expenseTitle='$expenseTitle', 
                            description='$newExpenseDesc', 
                            price='$newExpensePrice',
                            categorie='$categorie', 
                            dueDate='$expDueDate',
                            isRecurent='$isRecurrent' 
                        where expenseId='$expenseId'";
        $query = mysqli_query($this->conn, $request); /////////////////////
        if (isset($query)) {
            header("Location: ../expenses.php");
        }
    }


    public function getAll($userID)
    {
        $stmt = $this->conn->prepare("Select * from expense where user_id=?");
        $stmt->bind_param($userID);
        $stmt->execute();
    }
    public function getById($userID, $expenseId)
    {
        $stmt = $this->conn->prepare("Select * from expense where user_id=? and expenseId=?");
        $stmt->bind_param($userID,$expenseId);
        $stmt->execute();
    }
    public function getByCategory($categoryId) {
        $stmt = $this->conn->prepare("Select * from expense where categorie=?");
        $stmt->bind_param($categoryId);
        $stmt->execute();
    }
    public function setCategorie(Categorie $cat){
        $this->categorie = $cat->getCategoryName();

    }
    public function getCategorie(): Categorie{
        return $this->categorie;
    }
}
