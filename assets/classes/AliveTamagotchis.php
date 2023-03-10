<?php 
require_once 'Database.php';

/**
 * AliveTamagotchis class
 * $table : The table name in the database
 * $columns : The columns in the table
 */
class AliveTamagotchis extends Database
{
    /**
     * The table name
     */
    protected static string $table = "alive_tamagotchis";

    /**
     * The columns list
     */
    protected static array $columns = ["user_id","id","name","hungry","drink","sleep","boredom","level"];	

    /**
     * @see getAllByUserId() : Select the data depending of the user_id
     * @param $id_user : int : User ID
     * @return The results
     */
    public static function getAllByUserId(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user";
        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @see getInfoTamagotchiById() : Select the data depending of the user_id and tamagotchi_id
     * @param $id_user : int : User ID
     * @param $id_tamagotchi : int : Tamagotchi ID
     * @return The results
     */
    public static function getInfoTamagotchiById(int $id_user, int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user AND %s = :id";
        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[1]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->bindValue("id", $id_tamagotchi);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @see eat() : Call the procedure eat() in SQL 
     * @param $id_tamagotchi : int : the tamagotchi ID
     * @return A boolean
     */
    public static function eat(int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "CALL eat($id_tamagotchi)";
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
     * @see drink() : call the procedure drink() in SQL 
     * @param $id_tamagotchi : int : the tamagotchi ID
     * @return A boolean
     */
    public static function drink(int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "CALL drink($id_tamagotchi)";
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
     * @see sleep() : call the procedure bedtime() in SQL 
     * @param $id_tamagotchi : int : the tamagotchi ID
     * @return A boolean
     */
    public static function sleep(int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "CALL bedtime($id_tamagotchi)";
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
     * @see play() : call the procedure enjoy() in SQL 
     * @param $id_tamagotchi : int : the tamagotchi ID
     * @return A boolean
     */
    public static function play(int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "CALL enjoy($id_tamagotchi)";
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
}
?>