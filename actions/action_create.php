<?php
session_start();

require_once(dirname (__FILE__) . '\..\assets\classes\Tamagotchis.php');

if($_POST["name"] == "")
{
    header('Location: ../views/tamagotchi_create.php');
    exit();
}else
{
    if(Tamagotchis::create($_SESSION['user_id'], $_POST["name"]))
    {
        header('Location: ../views/tamagotchis_list.php');
        exit();
    }
}

