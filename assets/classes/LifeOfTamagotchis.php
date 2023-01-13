<?php 
require_once 'Database.php';

class LifeOfTamagotchis extends Database
{
    protected static string $table = "life_of_tamagotchis";
    protected static array $columns = ["id","name","hungry","drink","boredom","sleep"];	

    public static function getJSONInfoTamagotchiById(int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0]));
        $stmt->bindValue("id", $id_tamagotchi);
        $stmt->execute();
        return $stmt->fetch();
    }
}