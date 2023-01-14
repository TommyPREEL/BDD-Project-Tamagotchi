<?php
session_start();

require_once(dirname (__FILE__) . '\..\assets\classes\Tamagotchis.php');
require_once(dirname (__FILE__) . '\..\assets\classes\AliveTamagotchis.php');

// Depending of the tamagotchi action
switch($_GET["action"])
{
    case 'eat':
    {
        // Call the function eat of the AliveTamagotchis class
        AliveTamagotchis::eat($_SESSION["tamagotchi_id"]);
        break;
    }

    case 'drink':
    {
        // Call the function drink of the AliveTamagotchis class
        AliveTamagotchis::drink($_SESSION["tamagotchi_id"]);
        break;
    }

    case 'sleep':
    {
        // Call the function sleep of the AliveTamagotchis class
        AliveTamagotchis::sleep($_SESSION["tamagotchi_id"]);
        break;
    }

    case 'play':
    {
        // Call the function play of the AliveTamagotchis class
        AliveTamagotchis::play($_SESSION["tamagotchi_id"]);
        break;
    }
}

// Redirect to the tamagotchi profil page
header('Location: ../views/tamagotchi_profil.php?tamagotchi_id='.$_SESSION["tamagotchi_id"]);
exit();