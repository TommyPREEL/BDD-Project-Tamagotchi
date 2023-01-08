<?php

require_once 'Database.php';

class Tamagotchis extends Database
{
    protected static string $table = "tamagotchis";
    protected static array $columns = ["id_users", "id", "name", "hungry", "thirsty", "sleep", "boredom", "level", "nb_action", "creation_date", "dead_date", "death_reason"];

    public static function create(int $id_user, string $name)
    {
        $pdo = self::getDatabase();
        $sql = "INSERT INTO %s (%s, %s, %s, %s, %s, %s, %s, %s, %s) VALUES(
            :id_user,
            :name,
            :hungry,
            :thirsty,
            :sleep,
            :boredom,
            :level,
            :nb_action,
            :creation_date);";

        $stmt = $pdo->prepare(sprintf($sql,
            static::$table,
            static::$columns[0], // id_users
            static::$columns[2], // name
            static::$columns[3], // hungry
            static::$columns[4], // thirsty
            static::$columns[5], // sleep
            static::$columns[6], // boredom
            static::$columns[7], // level
            static::$columns[8], // nb_action
            static::$columns[9] // creation_date
        ));

        $stmt->bindValue("id_user", $id_user, PDO::PARAM_INT);
        $stmt->bindValue("name", $name, PDO::PARAM_STR);
        $stmt->bindValue("hungry", 70, PDO::PARAM_INT);
        $stmt->bindValue("thirsty", 70, PDO::PARAM_INT);
        $stmt->bindValue("sleep", 70, PDO::PARAM_INT);
        $stmt->bindValue("boredom", 70, PDO::PARAM_INT);
        $stmt->bindValue("level", 1, PDO::PARAM_INT);
        $stmt->bindValue("nb_action", 0, PDO::PARAM_INT);
        $stmt->bindValue("creation_date", date("Y-m-d H:i:s"), PDO::PARAM_STR);

        try
        {
            $stmt->execute();
            return true;
        }catch(Exception $e)
        {
           return false;
        }

    }

    public static function getAllByUserId(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user AND %s IS NULL";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[10]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        //$stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetchAll();
    }

    public static function checkLevel(int $id_user, int $id_tamagotchi)
    {
        $tamagotchi = self::getAllByTamagotchiId($id_user, $id_tamagotchi);
        if($tamagotchi[self::$columns[7]] <= floor($tamagotchi[self::$columns[8]]/10))
        {
            $pdo = self::getDatabase();
            $sql = "UPDATE %s set %s = :level WHERE %s = :id_user AND %s = :id_tamagotchi";
            $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[7], static::$columns[0], static::$columns[1]));
            $stmt->bindValue(":level", $tamagotchi['level']+1, PDO::PARAM_INT);
            $stmt->bindValue("id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue("id_tamagotchi", $id_tamagotchi, PDO::PARAM_INT);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
            return true;
        }else
        {
            return false;
        }
    }

    public static function checkDeath(int $id_user, int $id_tamagotchi) 
    {
        $tamagotchi = self::getAllByTamagotchiId($id_user, $id_tamagotchi);
        if($tamagotchi[self::$columns[3]] == 0 || $tamagotchi[self::$columns[4]] == 0 || $tamagotchi[self::$columns[5]] == 0 || $tamagotchi[self::$columns[6]] == 0)
        {
            $death_reason = null;
            if($tamagotchi[self::$columns[3]] == 0)
            {
                $death_reason = self::$columns[3];
            }else if($tamagotchi[self::$columns[4]] == 0)
            {
                $death_reason = self::$columns[4];
            }else if($tamagotchi[self::$columns[5]] == 0)
            {
                $death_reason = self::$columns[5];
            }else if($tamagotchi[self::$columns[6]] == 0)
            {
                $death_reason = self::$columns[6];
            }
            $pdo = self::getDatabase();
            $sql = "UPDATE %s set %s = :dead_date, %s = :death_reason WHERE %s = :id_user AND %s = :id_tamagotchi";
            $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[10], static::$columns[11], static::$columns[0], static::$columns[1]));
            $stmt->bindValue(":dead_date", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $stmt->bindValue(":death_reason", $death_reason, PDO::PARAM_STR);
            $stmt->bindValue("id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue("id_tamagotchi", $id_tamagotchi, PDO::PARAM_INT);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
            return true;
        }else
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
        //$stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

    public static function getAllDead(int $id_user)
    {
        $pdo = self::getDatabase();
        $sql = "SELECT * FROM %s WHERE %s = :id_user AND %s IS NOT NULL";

        $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[10]));
        $stmt->bindValue("id_user", $id_user);
        $stmt->execute();
        //$stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetchAll();
    }

    public static function eat(int $id_user, int $id_tamagotchi)
    {
        $tamagotchi = self::getAllByTamagotchiId($id_user, $id_tamagotchi);
        if($tamagotchi['hungry'] >= 80)
        {
            return false;
        }
        else
        {
            $pdo = self::getDatabase();
            $base_stats_impact= [
                "hungry" => 30,
                "thirsty" => 10,
                "sleep" => 5,
                "boredom" => 5
            ];
    
            $real_stats_impact = [];
            $new_stats = [];
    
            foreach($base_stats_impact as $stat => $value)
            {
                $value += $tamagotchi['level']-1;
                $real_stats_impact[$stat] = $value;
            }
    
            $sql = "UPDATE %s set ";
    
            foreach($real_stats_impact as $stat => $value)
            {
                if($stat == static::$columns[3])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] + $real_stats_impact[$stat];
                    if($new_stats[$stat] > 100)
                    {
                        $new_stats[$stat] = 100;
                    }
                }
                    
                else if($stat == static::$columns[4] || $stat == static::$columns[5] || $stat == static::$columns[6])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] - $real_stats_impact[$stat];
                    if($new_stats[$stat] < 0)
                    {
                        $new_stats[$stat] = 0;
                    }
                }
            }
    
            foreach($new_stats as $stat => $value)
            {
                $sql .= $stat." = ".$value.', ';
            }
    
            $sql .= " nb_action = :nb_action";
            $sql .= " WHERE %s = :id_user AND %s = :id_tamagotchi";
    
            $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[1]));
            $stmt->bindValue("id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue("id_tamagotchi", $id_tamagotchi, PDO::PARAM_INT);
            $stmt->bindValue("nb_action", $tamagotchi["nb_action"]+1, PDO::PARAM_INT);
    
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

    public static function drink(int $id_user, int $id_tamagotchi)
    {
        $tamagotchi = self::getAllByTamagotchiId($id_user, $id_tamagotchi);
        if($tamagotchi['thirsty'] >= 80)
        {
            return false;
        }
        else
        {
            $pdo = self::getDatabase();
            $base_stats_impact= [
                "hungry" => 10,
                "thirsty" => 30,
                "sleep" => 5,
                "boredom" => 5
            ];
    
            $real_stats_impact = [];
            $new_stats = [];
    
            foreach($base_stats_impact as $stat => $value)
            {
                $value += $tamagotchi['level']-1;
                $real_stats_impact[$stat] = $value;
            }
    
            $sql = "UPDATE %s set ";
    
            foreach($real_stats_impact as $stat => $value)
            {
                if($stat == static::$columns[4])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] + $real_stats_impact[$stat];
                    if($new_stats[$stat] > 100)
                    {
                        $new_stats[$stat] = 100;
                    }
                }
                    
                else if($stat == static::$columns[3] || $stat == static::$columns[5] || $stat == static::$columns[6])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] - $real_stats_impact[$stat];
                    if($new_stats[$stat] < 0)
                    {
                        $new_stats[$stat] = 0;
                    }
                }
            }
    
            foreach($new_stats as $stat => $value)
            {
                $sql .= $stat." = ".$value.', ';
            }
    
            $sql .= " nb_action = :nb_action";
            $sql .= " WHERE %s = :id_user AND %s = :id_tamagotchi";
    
            $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[1]));
            $stmt->bindValue("id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue("id_tamagotchi", $id_tamagotchi, PDO::PARAM_INT);
            $stmt->bindValue("nb_action", $tamagotchi["nb_action"]+1, PDO::PARAM_INT);
    
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

    public static function sleep(int $id_user, int $id_tamagotchi)
    {
        $tamagotchi = self::getAllByTamagotchiId($id_user, $id_tamagotchi);
        if($tamagotchi['sleep'] >= 80)
        {
            return false;
        }
        else
        {
            $pdo = self::getDatabase();
            $base_stats_impact= [
                "hungry" => 10,
                "thirsty" => 15,
                "sleep" => 30,
                "boredom" => 15
            ];
    
            $real_stats_impact = [];
            $new_stats = [];
    
            foreach($base_stats_impact as $stat => $value)
            {
                $value += $tamagotchi['level']-1;
                $real_stats_impact[$stat] = $value;
            }
    
            $sql = "UPDATE %s set ";
    
            foreach($real_stats_impact as $stat => $value)
            {
                if($stat == static::$columns[5])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] + $real_stats_impact[$stat];
                    if($new_stats[$stat] > 100)
                    {
                        $new_stats[$stat] = 100;
                    }
                }
                    
                else if($stat == static::$columns[4] || $stat == static::$columns[3] || $stat == static::$columns[6])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] - $real_stats_impact[$stat];
                    if($new_stats[$stat] < 0)
                    {
                        $new_stats[$stat] = 0;
                    }
                }
            }
    
            foreach($new_stats as $stat => $value)
            {
                $sql .= $stat." = ".$value.', ';
            }
    
            $sql .= " nb_action = :nb_action";
            $sql .= " WHERE %s = :id_user AND %s = :id_tamagotchi";
    
            $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[1]));
            $stmt->bindValue("id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue("id_tamagotchi", $id_tamagotchi, PDO::PARAM_INT);
            $stmt->bindValue("nb_action", $tamagotchi["nb_action"]+1, PDO::PARAM_INT);
    
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

    public static function play(int $id_user, int $id_tamagotchi)
    {
        $tamagotchi = self::getAllByTamagotchiId($id_user, $id_tamagotchi);
        if($tamagotchi['boredom'] >= 80)
        {
            return false;
        }
        else
        {
            $pdo = self::getDatabase();
            $base_stats_impact= [
                "hungry" => 5,
                "thirsty" => 5,
                "sleep" => 5,
                "boredom" => 15
            ];
    
            $real_stats_impact = [];
            $new_stats = [];
    
            foreach($base_stats_impact as $stat => $value)
            {
                $value += $tamagotchi['level']-1;
                $real_stats_impact[$stat] = $value;
            }
    
            $sql = "UPDATE %s set ";
    
            foreach($real_stats_impact as $stat => $value)
            {
                if($stat == static::$columns[6])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] + $real_stats_impact[$stat];
                    if($new_stats[$stat] > 100)
                    {
                        $new_stats[$stat] = 100;
                    }
                }
                    
                else if($stat == static::$columns[4] || $stat == static::$columns[3] || $stat == static::$columns[5])
                {
                    $new_stats[$stat] = $tamagotchi[$stat] - $real_stats_impact[$stat];
                    if($new_stats[$stat] < 0)
                    {
                        $new_stats[$stat] = 0;
                    }
                }
            }
    
            foreach($new_stats as $stat => $value)
            {
                $sql .= $stat." = ".$value.', ';
            }
    
            $sql .= " nb_action = :nb_action";
            $sql .= " WHERE %s = :id_user AND %s = :id_tamagotchi";
    
            $stmt = $pdo->prepare(sprintf($sql, static::$table, static::$columns[0], static::$columns[1]));
            $stmt->bindValue("id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue("id_tamagotchi", $id_tamagotchi, PDO::PARAM_INT);
            $stmt->bindValue("nb_action", $tamagotchi["nb_action"]+1, PDO::PARAM_INT);
    
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
}