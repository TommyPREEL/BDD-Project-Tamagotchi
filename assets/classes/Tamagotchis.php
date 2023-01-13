<?php

require_once 'Database.php';

class Tamagotchis extends Database
{
    protected static string $table = "tamagotchis";
    protected static array $columns = ["id_users","id","name","creation_date"];	

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

}