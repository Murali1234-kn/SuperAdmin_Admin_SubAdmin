<?php
$server_Name = "localhost";
$user_Name = "root";
$password = "";
$database = "class_employee";
$conn = new mysqli($server_Name, $user_Name, $password, $database);

//$conn =mysqli_connect($server_Name, $user_Name,$password,$database);
if($conn)
{
    echo "Connected";
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

