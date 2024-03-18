<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
<!--    <link href="css/styles.css" rel="stylesheet" />-->
    <link href="css/Main.css" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php

//echo $update_id;
//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    echo "heloooooooooooooooooo";
//    if (empty($_POST['designation_name']))
//    {
//        $designationName_Err = "Enter Designation";
//    } else {
//        $designation_name = validate($_POST['designation_name']);
//    }

include_once "employee_db.php";
include_once "Top_nav.php";

$update_id = $_GET['designation_id'];

$designation_name = "";
$designation_status = "1";
$designationName_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['designation_name'])) {
        $designationName_Err = "Enter Designation";
    } else {
        $designation_name = validate($_POST['designation_name']);
        if (!preg_match('/^[a-zA-Z ]{3,}$/', $designation_name))
        {
            $designationName_Err ="Only Letters Allow";
        }
    }

    if (!empty($designation_name))
    {
        $name_query = "SELECT * FROM designation WHERE designation_name='$designation_name'";
        $name_result = mysqli_query($conn, $name_query);
        if (mysqli_num_rows($name_result) > 0) {
            $designationName_Err = "Designation Already Present";
        }
    }

    $designation_status = isset($_POST['designation_status']) ? '1' : '0';

    if (empty($designationName_Err)) {
        $update_query = "UPDATE designation SET designation_name='$designation_name', designation_status='$designation_status' WHERE designation_id = $update_id";

        $result = $conn->query($update_query);

        if ($result === TRUE) {
            header("Location: New_Designation.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

else{
//    echo "byeeeee";
    $desig = "SELECT * FROM designation WHERE designation_id = $update_id";
    $all = $conn->query($desig);

    if ($all->num_rows > 0)
    {
        $row = $all->fetch_assoc();
        $designation_name = $row['designation_name'];
        $designation_status = $row['designation_status'];
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
        <?php include_once 'Side_nav.php' ;?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Designations</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_Designation.php">Designations</a></li>
                    <li class="breadcrumb-item active">update Designation</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?designation_id=" . $update_id); ?>">
                            <div class="class">
                                <div class="parent">
                                    <div>
                                        <label>Designation Name</label>
                                    </div>
                                    <br>
                                    <div>
                                        <input type="text" id="designation_name" name="designation_name" placeholder="Designation Name" value="<?php echo $designation_name; ?>">
                                        <span class ="errors" id="designationName_Err" name="designationName_Err"> <?php echo $designationName_Err ?>  </span>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <input type="checkbox" id="designation_status" name="designation_status" <?php if ($designation_status == '1') {echo 'checked'; }?>>
                                <label>Designation Status</label>
                            </div>
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
