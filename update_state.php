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
include_once "employee_db.php";
include_once "Top_nav.php";

$update_id = $_GET['state_id'];

$state_name = "";
$state_status = "1";
$stateName_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['state_name']))
    {
        $stateName_Err = "Enter State name";
    } else {
        $state_name = validate($_POST['state_name']);
        if (!preg_match('/^[a-zA-Z ]{3,}$/', $state_name))
        {
            $stateName_Err ="Only Letters Allow";
        }
    }

    if (!empty($state_name))
    {
        $name_query = "SELECT * FROM state WHERE state_name='$state_name'";
        $name_result = mysqli_query($conn, $name_query);
        if (mysqli_num_rows($name_result) > 0) {
            $stateName_Err = "State Already Exit";
        }
    }

    $state_status = isset($_POST['state_status']) ? '1' : '0';

    if (empty($stateName_Err)) {
        $update_query = "UPDATE state SET state_name='$state_name',state_status='$state_status' WHERE state_id = $update_id";

        $result = $conn->query($update_query);

        if ($result === TRUE) {
            header("Location: New_State.php");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
else{
    $dist_id = "SELECT * FROM state WHERE state_id = '$update_id'";
    $all = $conn->query($dist_id);
    if ($all->num_rows > 0)
    {
        $row = $all->fetch_assoc();
        $state_name = $row['state_name'];
        $state_status = $row['state_status'];
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
                <h1 class="mt-4">States</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_State.php">State</a></li>
                    <li class="breadcrumb-item active">Update State</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?state_id=" . $update_id); ?>">
                            <div class="class">
                                <div class="parent">
                                    <div>
                                        <label>State Name</label>
                                    </div>
                                    <br>
                                    <div>
                                        <input type="text" id="state_name" name="state_name" placeholder="State Name" value="<?php echo $state_name; ?>">
                                        <span class ="errors" id="stateName_Err" name="stateName_Err"> <?php echo $stateName_Err ?>  </span>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <input type="checkbox" id="state_status" name="state_status" <?php if ($state_status == '1'){echo 'checked';} ?>>
                                <label>State Status</label>
                            </div>
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
</body>
</html>

