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
<!--    <script>-->
<!--        $(document).ready(function () {-->
<!--            $("#form").submit(function (event) {-->
<!--                if (!$('.designation_status').prop('checked')) {-->
<!--                    alert('Please check the Designation Status checkbox before submitting.');-->
<!--                    event.preventDefault();-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    </script>-->

</head>
<body>

<?php
include_once 'employee_db.php';
if($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Admin')
{
include_once 'Top_nav.php';

echo '<br><br>';

$designation_name  = "";
$designation_status = "1";
$designationName_Err = $designationStatus_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['designation_name'])) {
        $designationName_Err = "Enter Designation";
    }
    else {
        $designation_name = validate($_POST['designation_name']);
        if (!preg_match('/^[a-zA-Z ]{3,}$/', $designation_name))
        {
            $designationName_Err ="Only Letters Allow";
        }
    }
    if (!empty($designation_name)) {
        $name_query = "select * from designation where designation_name='$designation_name'";
        $name_result = mysqli_query($conn, $name_query);
        if (mysqli_num_rows($name_result) > 0)
        {
            $designationName_Err = "Designation Already Present";
        }
    }
    $designation_status = isset($_POST['designation_status']) ? '1' : '0';

//    echo $designation_status;
//    echo "designation name" . $designation_name . "designation status " . $designation_status . " ";

    if (empty($designationName_Err) && empty($designationStatus_Err)) {

//        $insert_query = "INSERT INTO designation (designation_name,designation_status) VALUES ($designation_name, $designation_status)";
        $insert_query = "INSERT INTO designation (designation_name, designation_status) VALUES (?, ?)";
        $insert = $conn->prepare($insert_query);

        if ($insert !== false) {
            $insert->bind_param("ss", $designation_name, $designation_status);

            if ($insert->execute()) {
                echo "Record inserted successfully";
                header('Location: New_Designation.php');
            } else {
                echo "Error executing query: " . $insert->error;
            }
//                $insert = $conn->prepare($insert_query);

//                if ($insert !== false) {
//                    $insert->bind_param("ssss", $designation_name, $designation_status);
//           $conn->query($insert_query);
//            header('Location:Designation.php');
        }}
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
                <h1 class="mt-4">Designation</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_Designation.php">Designation</a></li>
                    <li class="breadcrumb-item active">Add Designation</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
<form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <div class="class">
        <div class="parent">
            <div>
                <label>Designation Name</label>
            </div>
            <br>
            <div>
                <input type="text" class="designation_name" name="designation_name" placeholder="Designation Name" value="<?php echo $designation_name; ?>">
                <span class="error">* <?php echo $designationName_Err; ?></span>
            </div>
        </div>
    </div>
    <br><br>

    <div>
        <input type="checkbox" class="designation_status" name="designation_status" <?php echo $designation_status == 1 ? 'checked' : ''; ?>>
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