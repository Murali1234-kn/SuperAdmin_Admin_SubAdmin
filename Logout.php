<?php
include_once 'employee_db.php';
if (isset($_SESSION['user_Email']) && isset($_SESSION['user_Type']))
{
session_unset();  // used to delete session variables

session_destroy();   // destroy the session
}
header('Location: Login.php');
exit();

