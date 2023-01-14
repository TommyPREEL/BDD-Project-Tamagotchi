<?php

require_once 'Database.php';

class Tamagotchis extends Database
{
    /**
     * The table name
     */
    protected static string $table = "tamagotchis";

    /**
     * The columns list
     */
    protected static array $columns = ["id_users","id","name","creation_date"];	

    /**
     * @see create() : Call the procedure create() in SQL 
     * @param $id_user : int : User ID
     * @param $name : string : Tamagotchi ID
     * @return A boolean
     */
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