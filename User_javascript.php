<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tasks</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #bt1 {
            background-color: blue;
            color: aliceblue;
            padding: 5px;
            font-size: large;
            border-radius: 20%;
        }
        .main {
            border: 1px solid black;
            padding: 5px;
            width: 75%;
            border-radius: 5px;
        }
        .class {
            display: flex;
            flex-direction: row;
            padding: 7px;
            justify-content: space-between;
        }
        span {
            color: red;
        }
        input{
            border: 1px solid;
            border-radius: 4px;
            padding: 10px;
        }
        #userType{
            border-radius: 4px;
            padding:10px;
        }

    </style>
<!--    JQuery -------------------->
    <script>
        $(document).ready(function()
        {
            $("#form").submit(function()
            {
                let userName = $("#userName").val();
                let userType = $("#userType").val();
                let password = $("#password").val();
                let userEmail = $("#userEmail").val();

                if (userName === "")
                {
                    $("#NameError").html("Name is required");
                    return false;
                }

                if (userType === "")
                {
                    $("#TypeError").html("Please Select Type");
                    return false;
                }

                if (password === "")
                {
                    $("#passwordError").html("Password is Required");
                    return false;
                }

                if (userEmail === "")
                {
                    $("#EmailError").html("Email is Required");
                    return false;
                }
            });
        });
    </script
<script src="Users.js"></script>

</head>
<body>

<?php
include_once "Database_conn.php";

$userName = $userType = $password = $userEmail = $userStatus = "";
$userName_Err = $userEmail_Err = $userType_Err = $password_Err = $userStatus_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = validate($_POST['userName']);
    $userType = validate($_POST['userType']);
    $password = validate($_POST['password']);
    $userEmail = validate($_POST['userEmail']);

    $userStatus = isset($_POST['userStatus']) ? 'Active' : 'Inactive';

    if (empty($userName_Err) && empty($userType_Err) && empty($password_Err) && empty($userEmail_Err)) {
        // Insert data into the database
        $insert = "INSERT INTO murali(userName, userType, password, userEmail, userStatus) VALUES('$userName', '$userType', '$password', '$userEmail','$userStatus')";

        $conn->query($insert);
        header('Location: Get_user.php');
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

<h2>Users</h2>
<div class="main">
    <form  id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<!--        <form  onsubmit="validateForm()" id="form" method="post" action="--><?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?><!--">-->

        <div class="class">
            <div class="parent">
                <div>
                    <label>User Name</label>
                </div>
                <div>
                    <input type="text" name="userName" id="userName" placeholder="User Name" value="">
                    <span id="NameError"></span>
                </div>
            </div>
            <div class="parent">
                <div>
                    <label>User Type</label>
                </div>
                <div>
                    <select name="userType" id="userType">
                        <option value=""> Please Select User Type</option>
                        <option>Admin</option>
                        <option>Super Admin</option>
                    </select>
                    <span id="TypeError"></span>
                </div>
            </div>
            <div class="parent">
                <div>
                    <label>Password</label>
                </div>
                <div>
                    <input id="password" name="password" placeholder="Password" value="">
                    <span  id="passwordError"></span>
                </div>
            </div>
        </div>
        <br>
        <div class="parent">
            <div>
                <label>User Email</label>
            </div>
            <div>
                <input type="email"  name="userEmail" id="userEmail" placeholder="User Email" value="">
                <span id="EmailError"></span>
            </div>
        </div>
        <br>
        <div>
            <input type="checkbox"  name="userStatus" id="userStatus">
            <label>User Status</label>
        </div>
        <br>
        <div>
            <button id="bt1" type="submit" name="submit" onclick="validateForm()">Submit</button>
        </div>
    </form>
</div
</body>
</html>
