<?php 
require_once 'Database.php';

/**
 * Database class
 * $table : the table name in the database
 * $columns : the columns name in the table 
 */
class DeadTamagotchis extends Database
{
    /**
     * The table name
     */
    protected static string $table = "dead_tamagotchis";

    /**
     * The columns list
     */
    protected static array $columns = ["user_id","id","name","level","reason","creation_date","death_date"];	

    /**
     * @see getAllDead() : Select data in the table depending of the user id
     * @param $id_user : int : User ID
     * @return The results
     */
    public static function getAllDead(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user";
        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @see getTamagotchiDead() : Select data in the table depending of the user id and tamagotchi id
     * @param $id_user : int : User ID
     * @param $id_tamagotchi : int : Tamagotchi ID
     * @return The results
     */
    public static function getTamagotchiDead(int $id_user, int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user AND %s = :id_tamagotchi";
        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[1]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->bindValue("id_tamagotchi", $id_tamagotchi);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}