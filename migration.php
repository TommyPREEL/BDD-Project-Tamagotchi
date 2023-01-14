<?php 

require_once("./assets/classes/Database.php");
require_once("./assets/classes/Column.php");
require_once("./assets/classes/Table.php");

/**
 * Migration
 */
class Migration extends Database
{
    protected static string $table = "migration";
    protected static array $columns = ["id_etape","type_etape","name_table"];
        
    /**
     * @see TableNotExist : if table not exist we create the table
     *
     * @param $database : mixed 
     * @param $tables : mixed 
     * @return void
     */
    public static function TableNotExist(string $database, array $tables)
    {
        Database::createDatabaseIfNotExists($database);
        try {
            Database::isExist();
        } catch (Exception $e) {
            Database::migrate($database, $tables);
        }
    }
    
    /**
     * @see getLast : return last row 
     *
     * @return void
     */
    public static function getLast(){
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * @see save
     *
     * @return void
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
}


/**
 * @see arguments() : Function that allows you to go to the next or previous table, 
 * it also allows you to reset the base or import everything at once 
 *
 * @param $args : mixed 
 * @param $tables : mixed 
 * @return void
 */
function arguments($args, $tables){

    // Table Migration
    $migration = [
        new Table("migration", "id", [
        new Column("id", "tinyint unsigned", "not null auto_increment"),
        new Column("id_etape", "tinyint unsigned", "not null"),
        new Column("type_etape", "varchar(50)", "not null"),
        new Column("name_table", "varchar(50)", "not null"),
        new Column("execution_date", "datetime", "NOT NULL DEFAULT CURRENT_TIMESTAMP")]),
    ];

    // Create Table "migration" if not exist
    try {
        Migration::TableNotExist("livecampus_project_bdd_tamagotchi", $migration);
    } catch (Exception $e) {}
    
    try {

        // Return the last row of table migration
        $tableMigration = Migration::getLast();

        // If table "migration" is empty we create the first row
        if (empty($tableMigration)){

            $mode = array(current($tables));
            $migration = new Migration();
            $migration->id_etape = 1;
            $migration->type_etape = "add";
            $migration->name_table = $mode[0]->name;
            $migration->save();
            Database::migrate("livecampus_project_bdd_tamagotchi",$mode);

        } else {

            if ($args == "next") {

                $tableaux = [];

                for ($i=$tableMigration['id_etape'];$i<=count($tables);$i++){
                    $tableaux[] = $tables[$i];
                }
            
                $mode = array(current($tableaux));
                $migration = new Migration();
                $migration->id_etape = intval($tableMigration['id_etape'])+1;
                $migration->type_etape = "add";
                $migration->name_table = $mode[0]->name;
                $migration->save();
                Database::migrate("livecampus_project_bdd_tamagotchi",$mode);

            } else if ($args == "previous") {

                $tableaux = [];

                for ($i=$tableMigration['id_etape']-1;$i<=count($tables);$i++){
                    $tableaux[] = $tables[$i];
                }
            
                $mode = array(current($tableaux));
                $migration = new Migration();
                $migration->id_etape = intval($tableMigration['id_etape'])-1;
                $migration->type_etape = "remove";
                $migration->name_table = $mode[0]->name;
                $migration->save();
                Database::DropTable("livecampus_project_bdd_tamagotchi",$mode[0]->name);
            }
            else if ($args == "reset") {

                $tableaux = [];

                foreach ($tables as $table){
                    $tableaux[] = $table->name;
                    
                }

                $migration = new Migration();
                $migration->id_etape = 0;
                $migration->type_etape = "Reset";
                $migration->name_table = "";
                $migration->save();
                Database::dropTables("livecampus_project_bdd_tamagotchi",$tableaux);
            }
            else if ($args == "migrate") {
                $migration = new Migration();
                $migration->id_etape = count($tables);
                $migration->type_etape = "migrate";
                $migration->name_table = "";
                $migration->save();
                Database::migrate("livecampus_project_bdd_tamagotchi",$tables);
            } else {
                return "Error command";
            }
        }
    } catch (Exception $e) {}
}

// Array contains Tables of livecampus_project_bdd_tamagotchi
$tables = [
    new Table("actions", "id", [
        new Column("id", "tinyint unsigned", "not null auto_increment"),
        new Column("id_tamagotchis", "tinyint unsigned", "not null"),
        new Column("type", "enum('eat','drink','sleep','play')", "not null"),
        new Column("creation_date", "datetime", "NOT NULL DEFAULT CURRENT_TIMESTAMP")],
        [['id_tamagotchis','id_tamagotchis']],
        [["actions_ibfk_1","id_tamagotchis","tamagotchis","id"]]
    ),

    new Table("deaths", "id", [
        new Column("id", "tinyint unsigned", "not null auto_increment"),
        new Column("id_tamagotchis", "tinyint unsigned", "not null"),
        new Column("reason", "varchar(50)", "not null"),
        new Column("creation_date", "datetime", "NOT NULL DEFAULT CURRENT_TIMESTAMP")],
        [['id_tamagotchis','id_tamagotchis']],
        [["deaths_ibfk_1","id_tamagotchis","tamagotchis","id"]]
    ),

    new Table("historical_actions", "id", [
        new Column("id", "tinyint unsigned", "not null auto_increment"),
        new Column("id_tamagotchis", "tinyint unsigned", "not null"),
        new Column("hungry", "tinyint", "not null"),
        new Column("drink", "tinyint", "not null"),
        new Column("sleep", "tinyint", "not null"),
        new Column("boredom", "tinyint", "not null"),
        new Column("action_type", "enum('eat','drink','sleep','play','created')", "not null"),
        new Column("creation_date", "datetime", "NOT NULL DEFAULT CURRENT_TIMESTAMP")],
        [['id_tamagotchis','id_tamagotchis']],
        [["historical_actions_ibfk_1","id_tamagotchis","tamagotchis","id"]]
    ),

    new Table("tamagotchis", "id", [
        new Column("id", "tinyint unsigned", "not null auto_increment"),
        new Column("id_users", "tinyint unsigned", "not null"),
        new Column("name", "varchar(50)", "not null"),
        new Column("creation_date", "datetime", "NOT NULL DEFAULT CURRENT_TIMESTAMP")],
        [['id_users','id_users']],
        [["tamagotchis_ibfk_1","id_users","users","id"]]
    ),

    new Table("users", "id", [
        new Column("id", "tinyint unsigned", "not null auto_increment"),
        new Column("username", "varchar(50)", "not null")],
        [],
        [],
        ['username']
    ),
];

// Execute function arguments()
print_r(arguments($argv[1],$tables));