<?php

require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";
// namespace Models
class Categorie
{
    private $conn;
    private $limite;
    private $name;
    private $userId;


    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function __construct($lim, $nm, $user)
    {
        $this->limite = $lim;
        $this->name = $nm;
        $this->userId = $user;
    }

    public function establishConnection($conn)
    {
        $this->conn = $conn;
    }
    public function setLimit($categoryId, $limit) {}

    public function addNewCategory(Categorie $newCat)
    {
        $query = "insert into categories values (?,?,?)";
        $request = $this->conn->prepare($query);
        return $request->execute([$newCat->name, $newCat->userId, $newCat->limite]);
    }

    public function getCategoryName()
    {
        return $this->name;
    }
    public function getCategoryLimit()
    {
        return $this->limite;
    }
    public function setCategoryName($name)
    {
        $this->name = $name;
    }
    public function setCategoryLimit($lim)
    {
        $this->limite = $lim;
    }

    public function getCategoryById($id) {}
}
