<?php
require_once 'Database.php';
require_once 'Users.php';

if(Users::connect($_POST["username"]))
{
    header('Location: tamagotchis_list.php');
    exit();
}