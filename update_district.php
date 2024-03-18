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

$update_id = $_GET['district_id'];

echo "$update_id";
$district_name = $state="";
$district_status = "1";
$districtName_Err = $stateName_Err= "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['district_name']))
    {
        $districtName_Err = "Enter District Name";
    } else {
        $district_name = validate($_POST['district_name']);
        if (!preg_match('/^[a-zA-Z ]{3,}$/', $district_name))
        {
            $districtName_Err ="Only Letters Allow";
        }
    }

    if (!empty($district_name))
    {
        $name_query = "SELECT * FROM district WHERE district_name='$district_name'";
        $name_result = mysqli_query($conn, $name_query);
        if (mysqli_num_rows($name_result) > 0) {
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
echo "hello";


    if (empty($districtName_Err)) {
        $update_query = "UPDATE district SET district_name='$district_name', district_status='$district_status',state_id ='$state' WHERE district_id = $update_id";

        $result = $conn->query($update_query);

        if ($result === TRUE) {
            header("Location: New_District.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

else{
    $dist_id = "SELECT * FROM district WHERE district_id = '$update_id'";
    echo "hello";
    echo "$dist_id";
    $all = $conn->query($dist_id);
    if ($all->num_rows > 0)
    {
        $row = $all->fetch_assoc();
        $district_id = $row['district_id'];
        $district_name = $row['district_name'];
        $district_status = $row['district_status'];
        $state =$row['state_id'];
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
                <h1 class="mt-4">District</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_District.php">District</a></li>
                    <li class="breadcrumb-item active">Update District</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?district_id=" . $update_id); ?>">
                            <div class="class">
                                <div class="parent">
                                    <div>
                                        <label>District Name</label>
                                    </div>
                                    <br>
                                    <div>
                                        <input type="text" id="district_name" name="district_name" placeholder="District Name" value="<?php echo $district_name; ?>">
                                        <span class ="errors" id="districtName_Err" name="districtName_Err"> <?php echo $districtName_Err ?>  </span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>State Name</label>
                                    </div>
                                    <div>
                                        <select class="form-select"  id="state" name="state" aria-label="Default select example">
                                            <?php
                                            $query ="SELECT * FROM state";
                                            $result = mysqli_query($conn,$query);

                                            if($result->num_rows> 0){
                                                $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            }
                                            foreach ($options as $option) {
                                                ?>
                                                <option value='<?php echo $option['state_id']; ?>' <?php if($state==$option['state_id']){echo 'selected="selected"';}?>><?php echo $option['state_name']; ?> </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="error"><?php echo $stateName_Err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <input type="checkbox" id="district_status" name="district_status" <?php if ($district_status == '1') {echo 'checked';} ?>>
                                <label>District Status</label>
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

