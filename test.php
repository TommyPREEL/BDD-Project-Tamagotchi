<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('');
$dotenv->load();

$database_host = $_ENV['DATABASE_HOST'];
$database_port = $_ENV['DATABASE_PORT'];
$database_name = $_ENV['DATABASE_NAME'];
$database_user = $_ENV['DATABASE_USER'];
$database_engine = $_ENV['DATABASE_ENGINE'];
$database_password = $_ENV['DATABASE_PASSWORD'];

$config = [
    "host" => $database_host,
    "port" => $database_port,
    "username" => $database_user,
    "password" => $database_password,
    "engine" => $database_engine,
    "database" => $database_name
];
// PDO instance creation
$pdo = new PDO(sprintf(
    "%s:host=%s:%s;dbname=%s",
    $config["engine"],
    $config["host"],
    $config["port"],
    $config["database"]
), $config["username"], $config["password"], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

$sql = "SELECT * FROM users";
$stmt = $pdo->prepare(sprintf($sql));
$stmt->execute();
print_r($stmt->fetchAll());
