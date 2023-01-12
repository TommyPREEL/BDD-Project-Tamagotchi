<?php 
require_once 'Database.php';

class DeadTamagotchis extends Database
{
    protected static string $table = "dead_tamagotchis";
    protected static array $columns = ["user_id","id","name","level","reason","creation_date","death_date"];	

    public static function getAllDead(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function getTamagotchiDead(int $id_user,int $id_tamagotchi,)
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