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
            try {
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
            } catch (Exception $e){
                
                $config["database"] = "";

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

    public static function isExist()
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

    public static function createDatabaseIfNotExists(string $database)
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("CREATE DATABASE IF NOT EXISTS %s", $database));
        $stmt->execute();
        
        self::use($database);
    }

    public static function dropDatabase(string $database)
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("DROP DATABASE %s", $database));
        $stmt->execute();
    }

    public static function doesDatabaseExist(string $database) : bool
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare("SHOW DATABASES");
        $stmt->execute();
        $databases = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($databases as $row)
        {
            if($row["Database"] == $database)
            {
                return true;
            }
        }
        return false;
    }

    public static function use(string $database)
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("USE %s", $database));
        $stmt->execute();
    }

    public static function createTable(Table $table)
    {
        $pdo = self::getDatabase();
        // CREATE TABLE table (colonne type extras, colonne type extras, ... PRIMARY KEY(colonne));
        $sql = sprintf("CREATE TABLE %s (", $table->name);
        foreach ($table->columns as $column) {
            $sql .= sprintf("%s %s %s, ", $column->name, $column->type, $column->extras);
        }
        $sql .= sprintf(" PRIMARY KEY(%s)", $table->primaryKey);

        if ($table->uniqueKeys){
            foreach ($table->uniqueKeys as $uniqueKey){
                $sql .= sprintf(", UNIQUE KEY `%s` (`%s`)",$uniqueKey,$uniqueKey);
                $sql .= ",";
            }
            $sql = rtrim($sql, ", ");
        }

        if ($table->primaryKeyplus){
            foreach ($table->primaryKeyplus as $primaryKey){
                $sql .= sprintf(", KEY `%s` (`%s`)", $primaryKey[0], $primaryKey[1]);
                $sql .= ",";
            }
            $sql = rtrim($sql, ", ");
        }

        if ($table->foreignKeys) {
            foreach ($table->foreignKeys as $foreignKey){
                $sql .= sprintf(", CONSTRAINT `%s` FOREIGN KEY (`%s`) REFERENCES `%s` (`%s`)",$foreignKey[0],$foreignKey[1],$foreignKey[2],$foreignKey[3]);
                $sql .= ",";
            }
            $sql = rtrim($sql, ", ");
        }

        $sql .= ")";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function createTables(array $tables)
    {
        foreach ($tables as $table) {
            self::createTable($table);
        }
    }

    public static function DropTable(string $database,string $table)
    {
        $pdo = self::getDatabase();
        $sql = sprintf("DROP TABLE `%s`.`%s`", $database, $table);

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function dropTables(string $database,array $tables)
    {
        foreach ($tables as $table) {
            self::DropTable($database, $table);
        }
   
    }

    public static function migrate(string $database, array $tables)
    {
        self::createDatabaseIfNotExists($database);
        self::createTables($tables);
    }

}