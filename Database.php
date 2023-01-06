<?php

abstract class Database
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
}