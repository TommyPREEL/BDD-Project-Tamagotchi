<?php

require_once 'Database.php';

class Tamagotchis extends Database
{
    protected static string $table = "tamagotchis";
    protected static array $columns = ["id_users","id","name","hungry","drink","sleep","boredom","creation_date"];	

    public static function create(int $id_user, string $name)
    {
        $pdo = self::getDatabase();
        $sql = 'CALL create_tamagotchi('.$id_user.',"'.$name.'")';
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

    public static function getAllByTamagotchiId(int $id_user, int $id_tamagotchi)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user AND %s = :id_tamagotchi";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[1]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->bindValue("id_tamagotchi", $id_tamagotchi);
        $stmt->execute();
        return $stmt->fetch();
    }

}