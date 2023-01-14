<?php
session_start();
require_once(dirname (__FILE__) . '\..\assets\classes\Users.php');

// If the user connection works
if(Users::connect($_POST["username"]))
{
    // Create a variable session with the user_id
    $_SESSION["user_id"] = Users::getUserIdByUsername($_POST["username"])['id'];

    // Redirect to the tamagotchi list page
    header('Location: ../views/tamagotchis_list.php');
    exit();
}else
{
    // Empty the user_id variable session
    unset($_SESSION["user_id"]);

    // Create an error
    $_SESSION["error"] = "Unknown user";

    // Redirect to the index page
    header('Location: ../index.php');
    exit();
}