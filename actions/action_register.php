<?php
session_start();

require_once(dirname (__FILE__) . '\..\assets\classes\Users.php');

// If the creation of the user account works
if(Users::createAccount($_POST["username"]))
{
    // Redirect to the index page
    header('Location: ../index.php');
    exit();
}else
{
    // Create an error
    $_SESSION["error"] = "This user already exists";

    // Redirect to the register page
    header('Location: ../views/register.php');
    exit();
}