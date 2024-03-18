<?php
require_once 'vendor/autoload.php';
session_start();
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';

if(isset($_COOKIE['token']))
{
    $decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
} else {
    header('location:Login.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
</head>
<body>
     <h2>JWT Token </h2>
    <div>
            <h1>Welcome <b><?php echo $decoded->data->user_Name; ?></b></h1>
             <h3>Email:<i><?php echo $decoded->data->user_Email; ?></i></h3>
            <h2></h2>UserType:<strong><?php echo $decoded->data->user_Type; ?></strong></h2><br>

    </div>
     <h2>Session</h2>
    <div>
        <h1>Welcome <b><?php print $_SESSION['user_Name']; ?></b></h1>
        <h3>Email:<i><?php echo $_SESSION['user_Email']; ?></i></h3>
        <h2></h2>UserType:<strong><?php echo $_SESSION['user_Type']; ?></strong></h2><br>

       <h1><a href="logout.php">Logout</a></h1>

    </div>
</body>
</html>