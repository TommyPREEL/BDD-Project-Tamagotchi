<?php 
require_once 'Database.php';

class AliveTamagotchis extends Database
{
    protected static string $table = "alive_tamagotchis";
    protected static array $columns = ["user_id","name","hungry","drink","sleep","boredom","level"];	

    public static function getAllByUserId(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user AND %s IS NULL";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[6]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        return $stmt->fetchAll();
    }

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

    public static function sleep(int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "CALL sleep($id_tamagotchi)";
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