<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
    <link href="css/Main.css" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body>
<?php
include_once 'employee_db.php';
if($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] !='Super Admin')
{
include_once 'Top_nav.php';
echo '<br><br>';

$userName = $userType = $password = $userEmail = $userStatus = "";
$userName_Err = $userEmail_Err = $userType_Err = $password_Err = $userStatus_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['userName'])) {
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
// database-------

        $insert = "INSERT INTO murali(userName, userType, password, userEmail, userStatus) VALUES('$userName', '$userType', '$password', '$userEmail','$userStatus')";

        $conn->query($insert);
        header('Location: New_User.php');
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

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_user.php">Users</a></li>
                    <li class="breadcrumb-item active">Add Users</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">

                        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="class">
                                <div class="parent">
                                    <div>
                                        <label>User Name</label>
                                    </div>
                                    <div>
                                        <input type="text" class="user" name="userName" placeholder="User Name" value="<?php echo $userName; ?>">
                                        <span class="error">* <?php echo $userName_Err; ?></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>User Type</label>
                                    </div>
                                    <div>
                                        <select class="user" name="userType">
                                            <option value=""> Please Select User Type</option>
                                            <option <?php if ($userType == '1'){ echo 'selected'; }?>> Super Admin</option>
                                            <option <?php if ($userType == '2') {echo 'selected'; }?>>Admin</option>
                                            <option <?php if ($userType == '3') {echo 'selected';} ?>> Sub Admin</option>

                                        </select>
                                        <span class="error">* <?php echo $userType_Err; ?></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>Password</label>
                                    </div>
                                    <div>
                                        <input id="password" name="password" placeholder="Password"  type="password" value="">
                                        <span class="error">* <?php echo $password_Err; ?></span>
                                    </div>
                                </div>
                            </div><br>
                            <div class="parent">
                                <div>
                                    <label>User Email</label>
                                </div>
                                <div>
                                    <input type="email" class="user" name="userEmail" placeholder="User Email" value="<?php echo $userEmail; ?>">
                                    <span class="error">* <?php echo $userEmail_Err; ?></span>
                                </div>
                            </div>
                            <br>
                            <div>
                                <input type="checkbox" class="user" name="userStatus" <?php if ($userStatus == '1') {echo 'checked';} ?>>
                                <label>User Status</label>
                            </div>
                            <br>
                            <div>
                                <button id="bt1" type="submit" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
        </main>
        <?php include_once "footer.php" ?>
    </div>
    <?php
    }
    else {
        echo "<div style='text-align: center;'>";
        echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
        echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
        echo "</div>";
    }
    ?>
</body>
</html>