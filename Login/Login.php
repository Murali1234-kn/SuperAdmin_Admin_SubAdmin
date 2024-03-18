<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        h1{
            text-align: center;
            color: #0a53be;
        }
        span{
            color: red;
        }
        #main{
            border: 1px solid;
            width:25%;
            border-radius: 10px;
            margin: auto auto auto auto;
            background: white;
            padding: 10px;
        }
        #bt1{
            color: #fff;
            background: #337ab7;
            padding: 10px;
            margin-left: 70%;
            border-radius: 5px;
        }
        input{
            padding: 5px;

        }
        #register{
            display: unset;
            text-decoration: underline;
            font-size: 20px;
            text-align: center;
        }
        #reg{
            border: 1px  ;

        }
    </style>
    <script>
        $(document).ready(function()
        {
            $("#form").submit(function ()
            {
                let userEmail = $("#userEmail").val();
                let password = $("#password").val();

                if(userEmail === "")
                {
                    $("#userEmailErr").html("Email is Required")
                    return false;
                }
                if (password === "")
                {

                    $("#passwordErr").html("Password is Required");
                    return false;
                }
                else
                if (!Password(password))
                {
                    $password_Err = "Invalid password";
                    return false;
                }
            });
        });
        function Password(password) {
            return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s])\S{8,}$/.test(password);
        }
    </script>
</head>
<body>
<?php

require_once 'vendor/autoload.php';
   use Firebase\JWT\JWT;

//include_once 'employee_db.php';

$userEmail = $password="";
$userEmailErr = $passwordErr="";
$success = $invalid="";
 if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']))
 {
     $server_Name = "localhost";
     $user_Name = "root";
     $database = "employee_db";
     $password = "";
     $conn = new mysqli($server_Name, $user_Name, $password, $database);
session_start(); // session created
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }

     $userEmail = validate($_POST['userEmail']);

         $password = validate($_POST['password']);

    if (empty($passwordErr) && empty($userEmailErr))
     {
         $get = "SELECT * FROM users WHERE userEmail = '$userEmail' AND password = '$password'";

         $result = mysqli_query($conn,$get);

         if (mysqli_num_rows($result) > 0)
{
            $user_result = mysqli_fetch_assoc($result);
            $user_id = $user_result['id'];
            $user_Name = $user_result['userName'];
        $user_Email =  $user_result['userEmail'];
        $user_Type =$user_result['userType'];
        echo "Email:-".$user_Email;echo "<br><br>";
            if($user_result['password'] === $_POST['password'])
            {
                $key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';

                $token= JWT::encode(array(
                                     'iat' =>time(),
                                     'nbf' =>time(),
                                     'exp' =>time() +3600,
                                     'data' =>array('user_id' =>$user_id,'user_Type'=>$user_Type,'user_Name' =>$user_Name, 'user_Email'=>$user_Email)),
                       $key,
                           'HS256'
                   );
                   setcookie("token", $token, time() + 3600, "/", "", true, true);
                   echo $token;echo"<br>";echo "<br>.$key";
                   echo "cookies set";
                   $_SESSION['user_Email'] = $user_Email;
                   $_SESSION['user_Name'] = $user_Name;
                   $_SESSION['user_Type'] = $user_Type;

//                header('Location:http://localhost/Tasks/Dashboard.php');

                header('Location:Welcome.php');
            }

        } else {
            $invalid = "<h5 style='color: red'>Invalid Credentials!!...</h5>";
        }
    }
 }
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div id="main">
    <h1>Login</h1>
    <div id="sub-main">
        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <div>
                    <label>User Email</label>
                </div>
                <div>
                    <input  id="userEmail" name="userEmail" placeholder="user Email" value="">
                    <span id="userEmailErr"></span>
                </div>
            </div>
            <br>
            <div>
                <div>
                    <label>User password</label>
                </div>
                <div>
                    <input id="password" name="password" placeholder="Password" value="">
                    <span id="passwordErr"></span>
                </div>
            </div>
            <br>

            <div>
                <!--             <input id="bt1" type="submit" name="submit" value="Login">-->
                <button id="bt1" type="submit" name="submit">Submit</button><br>
                <span<?php echo $success; echo $invalid;?></span>
                <div id="reg">
                    <a id="register" href="register.html">Need a account? Sign up!</a>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>


