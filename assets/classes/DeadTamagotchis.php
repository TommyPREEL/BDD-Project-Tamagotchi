<?php 
require_once 'Database.php';

class DeadTamagotchis extends Database
{
    protected static string $table = "dead_tamagotchis";
    protected static array $columns = ["name","reason","creation_date","death_date","level"];	

    public static function getAllDead(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user AND %s IS NOT NULL";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[10]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}