<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        span{
            color: red;
        }
    </style>

</head>
<body class="bg-primary">
<?php
include_once "employee_db.php";
echo '<br><br>';
$userName = $userType = $password = $userEmail = $userStatus = "";
$userName_Err = $userEmail_Err = $userType_Err = $password_Err = $userStatus_Err = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['userName']))
    {
        $userName_Err = "Name is required";
    } else {
        $userName = validate($_POST['userName']);
        if (!preg_match('/^[a-zA-Z]{3,}$/', $userName))
        {
            $userName_Err ="Only Letters Allow";
        }
    }
    if (empty($_POST['userType'])) {
        $userType_Err = "Please Select Type";
    } else {
        $userType = validate($_POST['userType']);
    }

    if (empty($_POST['password'])) {
        $password_Err = "Password is Required";
    } else {
        $password = validate($_POST['password']);
        if (!password($password)) {
            $password_Err = "Invalid password";
        }
    }
    if (empty($_POST['userEmail'])) {
        $userEmail_Err = "Email is Required";
    } else {
        $userEmail = validate($_POST['userEmail']);
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $userEmail_Err = "Invalid email format";
        }
    }
   if (!empty($userEmail))
   {
       $email_query = "SELECT * FROM users WHERE userEmail ='$userEmail'";
       $email_result = mysqli_query($conn, $email_query);
       if (mysqli_num_rows($email_result) > 0)
       {
           $userEmail_Err = "Email Already Register!..";
       }
    }
    $userStatus = isset($_POST['userStatus']) ? '1' : '0';

    if (empty($userName_Err) && empty($userType_Err) && empty($password_Err) && empty($userEmail_Err))
    {

        $insert = "INSERT INTO users(userName, userType, password, userEmail, userStatus) VALUES('$userName', '$userType', '$password', '$userEmail','$userStatus')";
        $conn->query($insert);
        header('Location: Login.php');
    }
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function password($password)
{
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s])\S{8,}$/', $password);
}
?>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                            <div class="card-body">
                                <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">

                                                <input class="form-control" id="inputFirstName" name="userName" type="text" placeholder="Enter your Name" value="<?php echo $userName; ?>">
                                                <span class="error">* <?php echo $userName_Err; ?></span>
                                                <label for="inputFirstName">User Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                    <select class="user" name="userType" style="padding: 5px">
                                                        <option value=""> Please Select User Type</option>
                                                        <option <?php if ($userType == '1'){echo 'selected';} ?>> Super Admin</option>
                                                        <option <?php if ($userType == '2') {echo 'selected'; }?>> Admin</option>
                                                        <option <?php if ($userType == '3') {echo 'selected'; }?>>Sub Admin</option>

                                                    </select>
                                                    <span class="error">* <?php echo $userType_Err; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">

                                        <input class="form-control" id="inputEmail" type="email" name="userEmail" placeholder="name@example.com" value="<?php echo $userEmail; ?>">
                                        <span class="error">* <?php echo $userEmail_Err; ?></span>
                                        <label for="inputEmail">Email address</label>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="password" type="password" name="password" placeholder="Create a password" value="<?php echo $password;?>">
                                                <span class="error">* <?php echo $password_Err; ?></span>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div >
                                                <input type="checkbox" class="user" name="userStatus" <?php if ($userStatus == '1') {echo 'checked';} ?>>
                                                <label>User Status</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mb-0">
                                        <div class="d-flex">
                                            <button class="bg-info" type="submit" name="submit">Create Account</button>
                                        </div>
                                    </div>
                                </>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="Login.php">Have an account? Go to login</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer"  style="height: 10vh">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
