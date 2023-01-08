<?php
require_once(dirname (__FILE__) . '\..\assets\classes\Users.php');

if(Users::createAccount($_POST["username"]))
{
    header('Location: ../index.php');
    exit();
}else
{
    header('Location: ../views/register.php');
    exit();
}