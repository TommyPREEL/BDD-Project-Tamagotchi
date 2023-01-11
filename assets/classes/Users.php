<?php

require_once(dirname (__FILE__) ."\Database.php");

class Users extends Database
{
    protected static string $table = "users";
    protected static array $columns = ["id", "username"];

    // Permet de trouver si l'utilisateur existe.
    public static function connect(string $username)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :username";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[1]));
        $stmt->bindValue("username", $username);

        try
        {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
            if(count($stmt->fetchAll()) != 0)
                return true;
            else
                return false;
        }catch(Exception $e)
        {
            return false;
        }
    }

    // Permete de créer un compte.
    public static function createAccount(string $username)
    {
        $pdo = self::getDatabase();
        $sql = "INSERT INTO %s (%s) VALUES('".$username."')";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[1]));

        try
        {
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            return false;
        }

    }

    // Permet de rechercher ID utilisateur par son "username".
    public static function getUserIdByUsername(string $username)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT %s FROM %s WHERE %s = :username";

        $stmt = $pdo->prepare(sprintf($sql, static::$columns[0], static::$table, static::$columns[1]));
        $stmt->bindValue("username", $username);
        $stmt->execute();
        return $stmt->fetch();
    }
}