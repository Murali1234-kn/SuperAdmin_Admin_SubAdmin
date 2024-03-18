<?php
$server_Name = "localhost";
$user_Name = "root";
$database = "employee_db";
$password = "";
$conn = new mysqli($server_Name, $user_Name, $password, $database);

//$conn =mysqli_connect($server_Name, $user_Name,$password,$database);

//-------------------2
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
