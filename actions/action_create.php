<?php
session_start();

require_once(dirname (__FILE__) . '\..\assets\classes\Tamagotchis.php');

// If the Tamagotchi name is empty
if($_POST["name"] == "")
{
    // Redirect to the tamagotchi creation page
    header('Location: ../views/tamagotchi_create.php');
    exit();
}else
{
    // If the Tamagotchi creation works
    if(Tamagotchis::create($_SESSION['user_id'], $_POST["name"]))
    {
        // Redirect to the tamagotchi list page
        header('Location: ../views/tamagotchis_list.php');
        exit();
    }
}

