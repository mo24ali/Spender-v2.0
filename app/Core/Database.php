<?php


//Singleton 

class Database
{
    private static PDO $conn;


    // private static function init(){
    //     if(is_null(self::$conn)){
    //         self::$conn = new self();

    //     }
    //     return self::$conn;
    // }
    public function __construct()
    {
        $config = require __DIR__ . '/../config/connexion.php';

        try{

            echo "new connection created";
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
        }catch(\Exception $pe){
                die($pe->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return self::$conn; 
    }
}

