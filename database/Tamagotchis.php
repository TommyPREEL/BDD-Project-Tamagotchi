<?php

require_once 'Database.php';

class Tamagotchis extends Database
{
    protected static string $table = "tamagotchis";
    protected static array $columns = ["id_1", "id", "name", "hungry", "thirsty", "sleep", "boredom", "level", "nb_action", "creation_date", "dead_date", "death_reason"];

    // public static function connect(string $username)
    // {
    //     $pdo = self::getDatabase();
    //     $sql = "SELECT * FROM %s WHERE %s = :login";

    //     $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[1]));
    //     $stmt->bindValue("login", $username);

    //     try
    //     {
    //         $stmt->execute();
    //         $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
    //         if(count($stmt->fetchAll()) != 0)
    //             return true;
    //         else
    //             return false;
    //     }catch(Exception $e)
    //     {
    //         return false;
    //     }
    // }

    // public static function create(int $id_user, $name)
    // {
    //     $pdo = self::getDatabase();
    //     $sql = "INSERT INTO %s (%s) VALUES('".$username."')";

    //     $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[1]));

    //     try
    //     {
    //         $stmt->execute();
    //         return true;
    //     }catch(Exception $e)
    //     {
    //         return false;
    //     }

    // }

    public static function getAllByUserId(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        //$stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetchAll();
    }
}