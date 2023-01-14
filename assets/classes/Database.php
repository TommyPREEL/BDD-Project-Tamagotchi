<?php
require_once(dirname (__FILE__) ."\..\..\\vendor\autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(dirname (__FILE__) ."\..\..\\");
$dotenv->load();

/**
 * Database class
 * $table : the table name in the database
 * $columns : the columns name in the table 
 */
abstract class Database
{
    /**
     * The table name
     */
    protected static string $table = "";
    /**
     * The primary key
     */
    protected static string $id = "";
    /**
     * The columns list
     */
    protected static array $columns = [];

    /**
     * Database connection singleton 
     */
    private static ?PDO $pdo = null;

    /**
     * Connection to the database
     */
    public static function getDatabase()
    {
        if(!self::$pdo) {
            // Update the .env for configure your connection
            $config = [
                "host" => $_ENV['DATABASE_HOST'],
                "port" => $_ENV['DATABASE_PORT'],
                "username" => $_ENV['DATABASE_USER'],
                "password" => $_ENV['DATABASE_PASSWORD'],
                "engine" => $_ENV['DATABASE_ENGINE'],
                "database" => $_ENV['DATABASE_NAME']
            ];
            // PDO instance creation
            self::$pdo = new PDO(sprintf(
                "%s:host=%s:%s;dbname=%s",
                $config["engine"],
                $config["host"],
                $config["port"],
                $config["database"]
            ), $config["username"], $config["password"], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]);
        }
        return self::$pdo;
    }

    /**
     * @see all() : Select all data in a table 
     * @return The results
     */
    public static function all() : array
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    /**
     * @see find() : Select data in a table depending of the id entered
     * @param $id : int : An ID
     * @return The results
     */
    public static function find(int $id) : ?static
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = :id", static::$table, static::$id));
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

    // To delete VSCode errors
    public function __set($k, $v) { $this->$k = $v; }
}