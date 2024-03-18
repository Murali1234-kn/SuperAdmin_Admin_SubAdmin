<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
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
include_once "Top_nav.php";

$update_id = $_GET['id'];

$userName = $userType = $userEmail = $userStatus = "";
$userName_Err = $userEmail_Err = $userType_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{

    $userName = validate($_POST['userName']);
    if (!preg_match('/^[a-zA-Z]{5,}$/', $userName))
    {
        $userName_Err ="Only Letters allow";
    }
    $userType = validate($_POST['userType']);
    $userEmail = validate($_POST['userEmail']);

    $userStatus = isset($_POST['userStatus']) ? '1' : '0';


    if (empty($userName_Err) && empty($userType_Err) && empty($userEmail_Err))
    {
        $update_query = "UPDATE murali SET userName='$userName', userType='$userType', userEmail='$userEmail', userStatus='$userStatus' WHERE id = $update_id";
        $conn->query($update_query);
        header("Location:New_User.php");

    }
}
else {
    $get_user_query = "SELECT * FROM users WHERE id = $update_id";
    $all = $conn->query($get_user_query);


    if ($all->num_rows > 0)
    {
        $row = $all->fetch_assoc();
        $userName = $row['userName'];
        $userType = $row['userType'];
        $userEmail = $row['userEmail'];
        $userStatus = $row['userStatus'];
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

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_User.php">User</a></li>
                    <li class="breadcrumb-item active">Update User</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $update_id); ?>">
                            <div class="class">
                                <div class="parent">
                                    <div>
                                        <label>User Name</label>
                                    </div>
                                    <div>
                                        <input type="text" id="userName" name="userName" placeholder="User Name" value="<?php echo $userName; ?>">
                                        <span id="NameError"></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>User Type</label>
                                    </div>
                                    <div>
                                        <select id="userType" name="userType">
                                            <option value="Admin" <?php if ($userType == 'Admin'){ echo 'selected'; }?>>Admin</option>
                                            <option value="Super Admin" <?php if ($userType == 'Super Admin') {echo 'selected'; }?>>Super Admin</option>
                                            <!--                        <option value="--><?php //echo $userType ?><!--"></option>-->
                                            <option value="Sub Admin" <?php if ($userType == 'Sub Admin') {echo 'selected'; }?>>Sub Admin</option>

                                        </select>
                                        <span id="TypeError"></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>User Email</label>
                                    </div>
                                    <div>
                                        <input type="email" id="userEmail" name="userEmail" placeholder="User Email" value="<?php echo $userEmail; ?>">
                                        <span id="EmailError"> </span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <input type="checkbox" id="userStatus" name="userStatus" <?php if ($userStatus == '1') {echo 'checked'; }?>>
                                <label>User Status</label>
                            </div>
                            <br>
                            <br>
                            <div>
                                <button id="bt1" type="submit" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once 'footer.php'?>
    </div>
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

