<?php
require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";
    class Expense{
        private $conn;

        public function __construct($conn)
        {
            $this->conn = $conn;
        }


        public function ajouterExpense($expenseTitle, $expenseDescription, $price,$categorie, $dueDate,$userId,$isRecurrent){
            $request = "insert into expense(expenseTitle,description,user_id,price,categorie,dueDate,isRecurent) 
            values ('$expenseTitle','$expenseDescription','$userId',$price,'$categorie','$dueDate','$isRecurrent')";
            $query = mysqli_query($this->conn,$request);
            if(isset($query)){
                header("Location: ../expenses.php");
            }
        }
        public function supprimerExpense($expenseId){
            $request = "delete from expense where expenseId=$expenseId";
            $query = mysqli_query($this->conn,$request);
            if(isset($query)){
                header("Location: ../expenses.php");
            }
        }
        public function modifierExpense($expenseId, $expenseTitle, $newExpenseDesc , $newExpensePrice, $categorie, $expDueDate,$isRecurrent){
            $request = "update expense 
                        set expenseTitle='$expenseTitle', 
                            description='$newExpenseDesc', 
                            price='$newExpensePrice',
                            categorie='$categorie', 
                            dueDate='$expDueDate',
                            isRecurent='$isRecurrent' 
                        where expenseId='$expenseId'";
            $query=mysqli_query($this->conn, $request); /////////////////////
            if(isset($query)){
                header("Location: ../expenses.php");
            }
        }

        
        public function getAll(){
            

        }
        public function getById(){

        }
        public function getByCategory(){

        }
    }

?>