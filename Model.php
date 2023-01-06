<?php

abstract class Model
{
    /**
     * Le nom de la table
     */
    protected static string $table = "";
    /**
     * La colonne contenant la clef primaire
     * Attention : cela n'est pas compatible avec des clefs composites
     */
    protected static string $id = "";
    /**
     * La liste des colonnes de la table (incluant la clef primaire)
     */
    protected static array $columns = [];

    /**
     * Singleton de connexion à la base de données
     * Un singleton ne sera instancié qu'une fois dans toute l'application
     */
    private static ?PDO $pdo = null;

    /**
     * Méthode permettant de récupérer (et si nécessaire d'instancier) une connexion à la BDD
     */
    public static function getDatabase()
    {
        if(!self::$pdo) {
            // TODO Récupérer ces informations d'un fichier .env (ou plus généralement de configuration)
            $config = [
                "host" => "localhost",
                "port" => 3306,
                "username" => "root",
                "password" => "",
                "engine" => "mysql",
                "database" => "livecampus_project_bdd_tamagotchi"
            ];
            // Création d'une instance PDO
            // Utilisation de sprintf : https://php.net/sprintf
            self::$pdo = new PDO(sprintf(
                "%s:host=%s:%s;dbname=%s",
                $config["engine"],
                $config["host"],
                $config["port"],
                $config["database"]
            ), $config["username"], $config["password"], [
                // https://www.php.net/manual/fr/pdo.constants.php
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]);
        }
        return self::$pdo;
    }

    /**
     * Récupère l'ensemble des lignes d'une table
     */
    public static function all() : array
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    /**
     * Récupère une ligne d'une table en fonction d'un id numérique
     */
    public static function find(int $id) : ?static
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = :id", static::$table, static::$id));
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

    // Pour retirer les erreurs de VSCode
    public function __set($k, $v) { $this->$k = $v; }

    /**
     * Insérer une nouvelle ligne dans une table
     */
    public function save() : void
    {
        $pdo = self::getDatabase();
        // INSERT INTO actor
        $sql = "INSERT INTO " . static::$table;
        // (%s, %s, %s, %s)
        $sql .= "(" . implode(', ', array_fill(0, count(static::$columns), "%s")) . ")";
        // INSERT INTO actor(actor_id, first_name, last_name, last_update)
        $sql = sprintf($sql, ...static::$columns);
        
        // VALUES
        $sql .= " VALUES ";
        // (?,?,?,?)
        $sql .= "(" . implode(', ', array_fill(0, count(static::$columns), "?")) . ")";

        // INSERT INTO actor(actor_id, first_name, last_name, last_update) VALUES (?,?,?,?)
        $stmt = $pdo->prepare($sql);
        foreach(static::$columns as $idx => $column) {
            // bindValue(0 + 1, $this->actor_id ?? "")
            $stmt->bindValue($idx + 1, $this->{$column} ?? NULL);
        }
        $stmt->execute();
    }

    /**
     * Mettre à jour une ligne en passant en paramètre la liste des éléments à changer
     */
    public function update(array $props) : void
    {
        $pdo = self::getDatabase();
        // UPDATE actor SET 
        $sql = "UPDATE %s SET ";
        if(empty($props)) {
            return; // Rien à modifier, on s'arrête là
        }
        // Pour chacune des clefs du tableau $props ["first_name" => "Billy", "last_name" => "Piper"]
        foreach(array_keys($props) as $columnName) {
            // Si la colonne n'existe pas, on s'en va
            if(array_search($columnName, static::$columns) === false) {
                throw new BadMethodCallException("Column " . $columnName . " does not exist in " . static::class);
            }
            // Sinon, first_name = ?, 
            $sql .= $columnName . " = ?, ";
        }
        // On retire la virgule de trop
        $sql = rtrim($sql, ", ");
        // WHERE actor_id = ?
        $sql .= " WHERE %s = ?";

        $sql = sprintf($sql, static::$table, static::$id);
        $stmt = $pdo->prepare($sql);

        foreach(array_values($props) as $idx => $val) {
            // bindValue(0 + 1, "Billy")
            $stmt->bindValue($idx + 1, $val);
        }
        // Mise à niveau de la variable $idx par rapport au nombre de points d'interrogation
        $idx += 2;
        // Définition de l'identifiant (dans le WHERE actor_id = ?)
        $stmt->bindValue($idx, $this->{static::$id}, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Supprime une ligne de la table
     */
    public function delete() : void
    {
        if(!$this->{static::$id}) {
            throw new BadMethodCallException("Cannot remove entity when id is empty");
        }
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("DELETE FROM %s WHERE %s = :id", static::$table, static::$id));
        $stmt->bindValue("id", $this->{static::$id}, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Selectionner des lignes en passant en paramètre la liste des éléments de sélection
     */
    public static function where(array $props)
    {
        $pdo = self::getDatabase();
        // SELECT * FROM la_table_en_question
        $sql = "SELECT * FROM ". static::$table. " WHERE ";
        if(empty($props)) {
            return []; // Rien à modifier, on s'arrête là
        }
        // Pour chacune des clefs du tableau $props ["first_name" => "Billy", "last_name" => "Piper"]
        foreach(array_keys($props) as $columnName) {
            // Si la colonne n'existe pas, on s'en va
            if(array_search($columnName, static::$columns) === false) {
                throw new BadMethodCallException("Column " . $columnName . " does not exist in " . static::class);
            }
            // Sinon, first_name = ?, 
            $sql .= $columnName . " = ? AND ";
        }
        // On retire la virgule de trop
        $sql = rtrim($sql, " AND ");
        // // WHERE actor_id = ?
        // $sql .= " WHERE %s = ?";

        $sql = sprintf($sql, static::$id);

        $stmt = $pdo->prepare($sql);

        foreach(array_values($props) as $idx => $val) {
            // bindValue(0 + 1, "Billy")
            $stmt->bindValue($idx + 1, $val);
        }
        // Mise à niveau de la variable $idx par rapport au nombre de points d'interrogation
        $idx += 2;
        // Définition de l'identifiant (dans le WHERE actor_id = ?)
        $stmt->bindValue($idx, static::$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
        // return $sql;
        }

    /**
     * Selectionner des lignes en passant en paramètre la liste des éléments de sélection
     */
    public static function in(array $props)
    {
        $pdo = self::getDatabase();
        // SELECT * FROM la_table_en_question
        $sql = "SELECT * FROM ". static::$table." WHERE %s IN(";
        if(empty($props)) {
            throw new BadMethodCallException("You need to enter a list in !");
        }
        foreach($props as $id)
        {
            $sql .= "?, ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= ")";
        $sql = sprintf($sql, static::$id);
        $stmt = $pdo->prepare($sql);


        foreach(array_values($props) as $idx => $val) {
            // bindValue(0 + 1, "Billy")
            $stmt->bindValue($idx + 1, $val);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }










    public static function createDatabase(string $dbname)
    {
        $pdo = self::getDatabase();
        $sql = "CREATE DATABASE %s";
        $sql = sprintf($sql, $dbname);
        $stmt = $pdo->prepare($sql);
        try{
            $stmt->execute();
            echo "Création de la bdd ".$dbname." avec succès ! ";
        } catch(Exception $err){
            echo "Erreur ! ".$err->getMessage();
        }
    }





    public static function createTable(array $props)
    {
        $pdo = self::getDatabase('mabdddetest');
        $sql = "CREATE TABLE ";
        $sql .= $props['table_name']." (";
        foreach($props['columns'] as $col)
        {
            $sql .= $col['name']." ".$col['type']."(".$col['length'].") ";
            foreach($col['keywords'] as $keyword)
            {
                $sql .= $keyword." ";
            }
            $sql = rtrim($sql, " ");
            $sql .= ',';
        }
        $sql = rtrim($sql, ",");
        $sql .= ")";
        $stmt = $pdo->prepare($sql);
        try{
            $stmt->execute();
            echo "Création de la table ".$props['table_name']." avec succès ! ";
        } catch(Exception $err){
            echo "Erreur ! ".$err->getMessage();
        }
        
    }
}













/**
 * Classe représentant la table actor
 */
class Actor extends Model {
    protected static string $table = "actor";
    protected static string $id = "actor_id";
    protected static array $columns = [
        "actor_id", "first_name", "last_name", "last_update"
    ];
}

/**
 * Classe représentant la table category
 */
class Category extends Model {
    protected static string $table = "category";
    protected static string $id = "category_id";
    protected static array $columns = [
        "category_id", "name", "last_update"
    ];
}

function actorList()
{
    $actors = Actor::all();
    var_dump($actors);
}

function actorFind()
{
    $actor = Actor::find(150);
    var_dump($actor);
}

function actorUpdate() 
{
    $actor = Actor::find(150);
    $actor->update([
        "first_name" => "Billy",
        "last_name" => "Piper"
    ]);
}

function actorInsert() 
{
    $actor = new Actor();
    $actor->first_name = "John";
    $actor->last_name = "Doe";
    $actor->last_update = "2022-01-03 14:29:00";
    $actor->save();
}

function actorDelete()
{
    $actor = Actor::find(150);
    $actor->delete();
}

function categoryFind()
{
    $category = Category::find(2);
    var_dump($category);
}

function actorWhere()
{
    // $actor = Actor::where();
    $actor = Actor::where([
        "first_name" => "Billy",
        "last_name" => "Piper"
    ]);
    var_dump($actor);
}
function actorIn()
{
    // $actor = Actor::where();
    $actor = Actor::in([2,5,10,15]);
    var_dump($actor);
}