<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="Javascript/Main.js"></script>
    <style>
        span {
            color: red;
        }
    </style>
</head>
<body class="bg-primary">
<?php
include_once 'employee_db.php';

if(isset($_SESSION['user_Email']))
{
    header('Location:Dashboard.php');
}

$userEmail = $password = "";
$userEmailErr = $passwordErr ="";
$success = $invalid = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']))
{
    $userEmail = validate($_POST['userEmail']);
    $password = validate($_POST['password']);

    if (empty($userEmail)) {
        $userEmailErr = "Email is required";
    }
    elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $userEmailErr = "Invalid email format";
    }
    if (empty($password)) {
        $passwordErr = "Password is required";
    }

//    echo $userEmail. "regrfbf  ".$password."wergfd--->".$userType;

    if (empty($passwordErr) && empty($userEmailErr))
    {
        $get = "SELECT userEmail, password,userType FROM users WHERE userEmail = '$userEmail' AND password = '$password'";
        $result = $conn->query($get);

        if ($result->num_rows > 0)
        {
            $user_result = $result->fetch_assoc();
//                  echo "<br>Successs";

            $_SESSION['user_Email'] = $user_result['userEmail'];
            $_SESSION['user_Type'] = $user_result['userType'];
            $_SESSION['user_Name'] = $user_result['userName'];


//            echo "Session created";
            header('Location:Dashboard.php');
        } else {
            $invalid = "<h5 style='color: red'>Invalid Credentials!!...</h5>";
        }
    }
}

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content" style="">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                            <div class="card-body">
                                <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="userEmail" type="email" name="userEmail" placeholder="name@example.com" value="<?php echo $userEmail; ?>" />
                                        <span id="userEmailErr"><?php echo $userEmailErr; ?></span>
                                        <label for="inputEmail">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" type="password" name="password" placeholder="Password" value="<?php echo $password; ?>"/>
                                        <span id="passwordErr"><?php echo $passwordErr; ?></span>
                                        <label for="inputPassword">Password</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                        <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button class="btn btn-primary" id="bt1" type="submit" name="submit">Submit</button><br>
                                        <span><?php echo $success; echo $invalid; ?></span>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="Register.php">Need an account? Sign up!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php include_once 'footer.php'; ?>
</div>
</body>
</html>
