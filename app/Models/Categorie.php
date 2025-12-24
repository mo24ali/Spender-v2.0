<?php

require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";
    class Categorie{
        private $conn;
        private $limite;
        private $name;
        
        public function __construct($lim, $nm)
        {   
                $conn = new Database();
                $this->conn = $conn->getConnection();
                $this->limite = $lim;
                $this->name = $nm;
                
           
        }


        public function setLimit($categoryId, $limit){
            
        }

        

    }
?>