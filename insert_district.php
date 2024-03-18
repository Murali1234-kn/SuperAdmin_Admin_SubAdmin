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
if($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Admin')
{
include_once 'Top_nav.php';
echo '<br><br>';
$district_name  = $status_id ="";
$district_status = "1";
$districtName_Err = $districtStatus_Err = $stateName_Err ="";
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['district_name'])) {
        $districtName_Err = "Enter District Name";
    }
    else {
        $district_name = validate($_POST['district_name']);
        if (!preg_match('/^[a-zA-Z ]{3,}$/', $district_name))
        {
            $districtName_Err ="Only Letters Allow";
        }
    }
    if (!empty($district_name)) {
        $name_query = "select * from district where district_name='$district_name'";
        $name_result = mysqli_query($conn, $name_query);
        if (mysqli_num_rows($name_result) > 0)
        {
            $districtName_Err = "District Already Exit";
        }
    }
    if (empty($_POST['state']))
    {
        $stateName_Err = "Please Select State";
    }
    else {
        $state = validate($_POST['state']);
    }

    $district_status = isset($_POST['district_status']) ? '1' : '0';

//    echo $district_status;
//    echo "designation name" . $district_name . "designation status " . $district_status . " ";

    if (empty($districtName_Err) && empty($districtStatus_Err)) {

////        $insert_query = "INSERT INTO designation (designation_name,designation_status) VALUES ($district_name, $district_status)";
//        $insert_query = "INSERT INTO district (district_name, district_status,state_id) VALUES (?, ?,?)";
//        $insert = $conn->prepare($insert_query);
//
//        if ($insert !== false) {
//            $insert->bind_param("ssi", $district_name, $district_status);
//
//            if ($insert->execute()) {
//                echo "Record inserted successfully";
//                header('Location: New_District.php');
//            } else {
//                echo "Error executing query: " . $insert->error;
//            }
       $insert_query = "INSERT INTO district (district_name,state_id,district_status) VALUES ('$district_name',$state,$district_status)";

                if(mysqli_query($conn, $insert_query))
                {
                   header("Location:New_District.php");
                } else {
                    echo "error";
                }
        }
}


?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">District</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_District.php">District</a></li>
                    <li class="breadcrumb-item active">Add District</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <div class="class">
                                <div class="parent">
                                    <div>
                                        <label>District Name</label>
                                    </div>
                                    <br>
                                    <div>
                                        <input type="text" class="district_name" name="district_name" placeholder="District Name" value="<?php echo $district_name; ?>">
                                        <span class="error">* <?php echo $districtName_Err; ?></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>State</label>
                                    </div>
                                    <div>
                                        <select class="input" name="state">
                                            <option value=""> Please Select Employee Designation</option>
                                            <?php
                                            $query = "SELECT * FROM state";
                                            $result = $conn->query($query);
                                            while ($row = $result->fetch_assoc())
                                            {
                                                $state_namee = $row['state_name'];
                                                $state_iid = $row['state_id'];
                                                echo "<option value='$state_iid'>$state_namee</option>";
                                            }
                                            ?>
                                        </select>
                                        <span class="error">* <?php echo $stateName_Err; ?></span>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div>
                                <input type="checkbox" class="district_status" name="district_status" <?php echo $district_status == 1 ? 'checked' : ''; ?>>
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