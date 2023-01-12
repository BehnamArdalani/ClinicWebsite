<?php

class DBHandler {

    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        self::$initialized = true;
    }

    private static $conn = null;

    public static function ConnectToDb()
    {
        self::initialize();

        $dsn = "mysql:host=".$_SESSION["databaseURL"].";dbname=".$_SESSION["databaseDBName"];

        try{
            self::$conn = new PDO ($dsn,$_SESSION["databaseUsername"],$_SESSION["databasePassword"]);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $ex){
            echo $ex->getMessage();
            die('Database Error!');
        }

    }

    public static function DB(){
        
        self::initialize();

        if(!isset(self::$conn) or self::$conn == null){
            self::ConnectToDb();
            return self::$conn;
        }
        
        return self::$conn;
    }

    public function Disconnect(){

        self::initialize();

        self::$conn = null;
    }
}


// class DB_Query extends PDOStatement {
//     private $class;
//     protected function __construct ($class) {
//         $this->class = $class;
//         $this->setFetchMode(PDO::FETCH_CLASS, $this->class);
//     }
// }

// class DB_Row extends ArrayObject {
//     public function __set($name, $val) {
//         $this[$name] = $val;
//     }
//     public function __get($name) {
//         return $this[$name];
//     }
// }

?>