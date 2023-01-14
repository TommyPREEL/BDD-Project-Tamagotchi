<?php
require_once(dirname (__FILE__) . '\..\assets\classes\Users.php');

// If the creation of the user account works
if(Users::createAccount($_POST["username"]))
{
    // Redirect to the index page
    header('Location: ../index.php');
    exit();
}else
{
    // Redirect to the register page
    header('Location: ../views/register.php');
    exit();
}