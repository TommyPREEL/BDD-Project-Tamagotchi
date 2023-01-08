<?php
session_start();

require_once '../database/Tamagotchis.php';

switch($_GET["action"])
{
    case 'eat':
    {
        echo "coucou je eat";
        Tamagotchis::eat($_SESSION["user_id"], $_SESSION["tamagotchi_id"]);
        break;
    }

    case 'drink':
    {
        echo "coucou je drink";
        Tamagotchis::drink($_SESSION["user_id"], $_SESSION["tamagotchi_id"]);
        break;
    }

    case 'sleep':
    {
        echo "coucou je sleep";
        Tamagotchis::sleep($_SESSION["user_id"], $_SESSION["tamagotchi_id"]);
        break;
    }

    case 'play':
    {
        echo "coucou je play";
        Tamagotchis::play($_SESSION["user_id"], $_SESSION["tamagotchi_id"]);
        break;
    }
}
Tamagotchis::checkLevel($_SESSION["user_id"], $_SESSION["tamagotchi_id"]);
header('Location: ../views/tamagotchi_profil.php?tamagotchi_id='.$_SESSION["tamagotchi_id"]);
exit();