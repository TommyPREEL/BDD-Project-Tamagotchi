<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$database_host = $_ENV['DATABASE_HOST'];
$database_port = $_ENV['DATABASE_PORT'];
$database_name = $_ENV['DATABASE_NAME'];
$database_user = $_ENV['DATABASE_USER'];
$database_engine = $_ENV['DATABASE_ENGINE'];
$database_password = $_ENV['DATABASE_PASSWORD'];

print_r($database_host);
print_r($database_port);
print_r($database_name);
print_r($database_user);
print_r($database_engine);
print_r($database_password);