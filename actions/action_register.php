<?php
require_once '../database/Database.php';
require_once '../database/Users.php';


if(Users::createAccount($_POST["username"]))
{
    header('Location: ../index.php');
    exit();
}else
{
    header('Location: ../views/register.php');
    exit();
}