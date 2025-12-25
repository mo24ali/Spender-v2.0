<?php


class Database
{
    private static PDO $conn;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/connexion.php';
        
        try{

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

            $connection = new PDO(
                $dsn,
                $config['user'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
                );
            self::$conn = $connection;
        }catch(Exception $pe){
                die($pe->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return self::$conn; 
    }
}

