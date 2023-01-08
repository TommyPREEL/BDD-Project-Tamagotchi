<?php
session_start();
require_once '../database/Database.php';
require_once '../database/Users.php';

if(Users::connect($_POST["username"]))
{
    $_SESSION["user_id"] = Users::getUserIdByUsername($_POST["username"])['id'];
    header('Location: ../views/tamagotchis_list.php');
    exit();
}else
{
    header('Location: ../index.php');
    exit();
}