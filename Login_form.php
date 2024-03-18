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
include_once "Database_conn.php";

$userEmail = $password="";
$userEmailErr = $passwordErr="";
$success = $invalid="";
 if($_SERVER['REQUEST_METHOD'] == "POST")
 {

         $userEmail = validate($_POST['userEmail']);

         $password = validate($_POST['password']);

    if (empty($passwordErr) && empty($userEmailErr))
     {
         $get = "SELECT userEmail, password FROM murali WHERE userEmail = '$userEmail' AND password = '$password'";

         $result = $conn->query($get);

         $count = mysqli_num_rows($result);

         if($count == 1)
         {
             $success = "Login Successfull!!!!   ";
             header('Location:Home.html');

         }
         else
         {
             $invalid = "<h5 style='color: red'>Invalid username or password.</h5> ";
//             echo "<h2 style='color: red'>Invalid username or password.</h2>";

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


