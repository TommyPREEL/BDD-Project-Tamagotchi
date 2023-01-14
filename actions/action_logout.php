<?php
session_start();

// Empty all session variables
$_SESSION = array();

// Destroy the actual session
session_destroy();

// Redirect to the index page
header('Location: ../index.php');
exit();