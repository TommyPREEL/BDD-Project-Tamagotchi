<?php
require_once 'Database.php';
require_once 'Users.php';


if(Users::createAccount($_POST["username"]))
{
    header('Location: tamagotchis_list.php');
    exit();
}
var_dump($test);

echo "create ok";