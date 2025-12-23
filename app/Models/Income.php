<?php
require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";
    class Income{
        private $conn;

        public function __construct($conn)
        {
            $this->conn = $conn;
        }


        public function ajouterIncome($incomeTitle, $incomeDescription, $price,$categorie, $getDate,$userId,$isRecurent){
            $request = "insert into income(incomeTitle , description , user_id , price ,categorie, getIncomeDate,isRecurent) 
                        values ('$incomeTitle','$incomeDescription','$userId','$price','$categorie','$getDate','$isRecurent')";
            $query = mysqli_query($this->conn,$request);
            if(isset($query)){
                header("Location: ../incomes.php");
            }
        }
        public function supprimerIncome($incomeId){
            $request = "delete from income where incomeId=$incomeId";
            $query = mysqli_query($this->conn,$request);
            if(isset($query)){
                header("Location: ../incomes.php");
            }
        }
        public function modifierIncome($incomeId, $incomeTitle, $newincomeDesc , $newincomePrice,$categorie, $incGetDate,$isRecurent){
            $request = "update income 
                        set incomeTitle='$incomeTitle', 
                            description='$newincomeDesc', 
                            price='$newincomePrice', 
                            categorie='$categorie',
                            getIncomeDate='$incGetDate' ,
                            isRecurent='$isRecurent'
                        where incomeId='$incomeId';";
            $query=mysqli_query($this->conn, $request);
            if(isset($query)){
                header("Location: ../incomes.php");
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