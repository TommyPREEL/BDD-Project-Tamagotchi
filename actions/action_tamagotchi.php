<?php
session_start();

require_once(dirname (__FILE__) . '\..\assets\classes\Tamagotchis.php');
require_once(dirname (__FILE__) . '\..\assets\classes\AliveTamagotchis.php');

switch($_GET["action"])
{
    case 'eat':
    {
        AliveTamagotchis::eat($_SESSION["tamagotchi_id"]);
        break;
    }

    case 'drink':
    {
        AliveTamagotchis::drink($_SESSION["tamagotchi_id"]);
        break;
    }

    case 'sleep':
    {
        AliveTamagotchis::sleep($_SESSION["tamagotchi_id"]);
        break;
    }

    case 'play':
    {
        AliveTamagotchis::play($_SESSION["tamagotchi_id"]);
        break;
    }
}

header('Location: ../views/tamagotchi_profil.php?tamagotchi_id='.$_SESSION["tamagotchi_id"]);
exit();