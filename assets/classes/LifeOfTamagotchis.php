<?php 
require_once 'Database.php';

class LifeOfTamagotchis extends Database
{
    /**
     * The table name
     */
    protected static string $table = "life_of_tamagotchis";

    /**
     * The columns list
     */
    protected static array $columns = ["id","name","hungry","drink","boredom","sleep"];	

    /**
     * @see getJSONInfoTamagotchiById() : select data in the table depending of the tamagotchi id
     * @param $id_tamagotchi : int : Tamagotchi ID
     * @return The results
     */
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