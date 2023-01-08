<?php
session_start();

require_once '../database/Database.php';
require_once '../database/Tamagotchis.php';


if(Tamagotchis::create($_SESSION['user_id'], $_POST["name"]))
{
    header('Location: ../views/tamagotchis_list.php');
    exit();
}
