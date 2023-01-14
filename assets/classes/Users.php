<?php

require_once(dirname (__FILE__) ."\Database.php");

class Users extends Database
{
    /**
     * The table name
     */
    protected static string $table = "users";

    /**
     * The columns list
     */
    protected static array $columns = ["id", "username"];

    /**
     * @see connect() : Check if the user exists
     * @param $username : string : Username
     * @return A boolean
     */
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

    /**
     * @see createAccount() : Call the procedure create_account() in SQL 
     * @param $username : string : Username
     * @return A boolean
     */
    public static function createAccount(string $username)
    {
        $pdo = self::getDatabase();
        $sql = "CALL create_account('".$username."')";
        $stmt = $pdo->prepare($sql);

        try
        {
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
            return false;
        }
    }

    /**
     * @see getUserIdByUsername() : Select the user id depending of the username
     * @param $username : string : Username
     * @return The user ID
     */
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