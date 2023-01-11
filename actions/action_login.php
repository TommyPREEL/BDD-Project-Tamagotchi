<?php
session_start();
require_once(dirname (__FILE__) . '\..\assets\classes\Users.php');

if(Users::connect($_POST["username"]))
{
    $_SESSION["user_id"] = Users::getUserIdByUsername($_POST["username"])['id'];
    header('Location: ../views/tamagotchis_list.php');
    exit();
}else
{
    $_SESSION["user_id"] = null;
    header('Location: ../index.php');
    exit();
}