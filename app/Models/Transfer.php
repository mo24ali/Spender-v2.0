<?php
require __DIR__ . "../config/connexion.php";
require __DIR__ . "../config/database.php";
class Transfer
{
    private $senderId;
    private $receiverId;
    private $conn;

    public function __construct($senderId, $receiverId)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
    }
    public function establishConnection($conn)
    {
        $this->conn = $conn;
    }
}
