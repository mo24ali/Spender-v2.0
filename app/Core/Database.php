<?php


//Singleton 
class Database
{


    private static $conn = null;

    private static function init()
    {
        if (is_null(self::$conn)) {
            self::$conn = new self();
        }
        return self::$conn;
    }

    public function __construct()
    {
        try{
            $config = require __DIR__ . '/../config/connexion.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
            $this->conn = new PDO(
                $dsn, 
                $config['user'],
                $config['password']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $pe){
            die("Connection failed: ".$pe->getMessage());
        }
    }

    public static function getValue($key)
    {
        self::init();
        return self::$values[$key] ?? ' ';
    }

    public function setConnection() {}
}
