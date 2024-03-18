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
    <script src="Javascript/Main.js"></script>
</head>
<body>
<?php
include_once "employee_db.php";
include_once 'Top_nav.php';

$emp_name = $emp_designation = $emp_picture = $emp_status =$email_id =$phone_number = $state= $district="";
$empName_Err = $empdesignation_Err = $empimage_Err  =$emailid_Err =$phonenumber_Err = $state_Err =$district_Err ="";

$update_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : 0;

echo "Emp ID: $update_id";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    if (empty($_POST['emp_name']))
    {
        $empName_Err = "Name is required";
    } else {
        $emp_name = validate($_POST['emp_name']);
        if (!preg_match('/^[a-zA-Z ]{3,}$/', $emp_name))
        {
            $empName_Err ="Enter Alphabets";
        }
    }
    if (empty($_POST['emp_designation'])) {
        $empdesignation_Err = "Please Select Designation";
    } else {
        $emp_designation = validate($_POST['emp_designation']);
    }
    if (empty($_POST['phone_number'])) {
        $phone_Err = "Phone number is required";
    } else
    {
        $phone_number= validate($_POST['phone_number']);
        if(!preg_match('/^[0-9]{10,}$/',$phone_number))
        {
            $phonenumber_Err = "Invalid phone Number";
        }
    }
    if (empty($_POST["email_id"])) {
        $emailid_ErrErr = "Email is required";
    } else {
        $email_id = validate($_POST["email_id"]);
        if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
            $emailid_Err = "Invalid email format";
        }
    }
///-------------------------- UNIQUE
    if (!empty($email_id) || !empty($phone_number))
    {
        $email_query = "select * from employee where email_id='$email_id'";
        $email_result = mysqli_query($conn, $email_query);

        $phone_query = "select * from employee where phone_number='$phone_number'";
        $phone_result = mysqli_query($conn, $phone_query);

        if (mysqli_num_rows($email_result) > 0) {
            $emailid_Err = "Email ID Already Exit";
        }
        if (mysqli_num_rows($phone_result) > 0) {
            $phonenumber_Err = "Already Exit";
        }
    }

    if (isset($_FILES['emp_picture']) && $_FILES['emp_picture']['error'] == 0 && $_FILES['emp_picture']['size'] > 0)
    {
        $upload_dir = "image/";
        $image_query = "select number from employee where emp_id='$update_id'";
            $image_result = $conn->query($image_query);
        $row = mysqli_fetch_assoc($image_result);
           $img_name = $row['number'];


        $filename = pathinfo($_FILES['emp_picture']['name'], PATHINFO_EXTENSION);

        $new_filename = $img_name . '.' . $filename;

        $uploaded_file = $upload_dir . $new_filename;
        if (move_uploaded_file($_FILES['emp_picture']['tmp_name'], $uploaded_file))
        {
            $emp_picture = $uploaded_file;
        } else {
            $empimage_Err = "Error uploading file: ";
        }
    } else {
        $empimage_Err = "Please Select Employee Photo";
    }
    if (empty($_POST['state_name']))
    {
        $state_Err = " Please Select State";
    } else {
        $state = validate($_POST['state_name']);
    }

    if (empty($_POST['district_name']))
    {
        $district_Err = "Please Select District";
    }
    else {
        $district = validate($_POST['district_name']);
    }

    $emp_status = isset($_POST['emp_status']) ? '1' : '0';

       echo "<br>";
//    echo "emp_name: $emp_name, emp_designation: $emp_designation, emp_picture: $emp_picture, emp_status: $emp_status";
//    echo "phone number $phone_number, email id $email_id, state $state, district $district";
//echo"start";
    if (empty($empName_Err) && empty($empdesignation_Err) && empty($empimage_Err) && empty($emailid_Err) &&
        empty($phonenumber_Err) && empty($state_Err) && empty($district_Err))
    {
        $update_query = "UPDATE employee SET emp_name='$emp_name', emp_designation='$emp_designation', emp_picture='$emp_picture',
                    emp_status='$emp_status', email_id='$email_id', phone_number='$phone_number',state='$state',district='$district' WHERE emp_id = $update_id";

        $conn->query($update_query);
//           echo "successfull update";
        header("Location: New_Employee.php");
        exit();
    }
//    echo "out";
}
else {
    echo "Emp ID: $update_id";

    $get_emp_query = "SELECT * FROM employee WHERE emp_id = $update_id";
    $result = $conn-> query($get_emp_query);

    if ($result-> num_rows > 0) {

        $row = $result-> fetch_assoc();
        $emp_name = $row['emp_name'];
        $email_id = $row['email_id'];
        $phone_number = $row['phone_number'];
        $emp_designation = $row['emp_designation'];
        $state= $row['state'];
        $district=$row['district'];
        $emp_picture = $row['emp_picture'];
        $emp_status = $row['emp_status'];
    }
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
const SELECTED = "selected";
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Employees</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_Employee.php">Employees</a></li>
                    <li class="breadcrumb-item active">Update Employee</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?emp_id=" . $update_id); ?>" enctype="multipart/form-data">
                            <div class="class">
                                <div class="parent">
                                    <div>
                                        <label>Empployee Name</label>
                                    </div>
                                    <div>
                                        <input type="text" class="input" name="emp_name" placeholder="Employee Name" value="<?php echo $emp_name; ?>">
                                        <span class="error">* <?php echo $empName_Err; ?></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>Mobile Number</label>
                                    </div>
                                    <div>
                                        <input type="text" class="input" name="phone_number" placeholder="Mobile Number" value="<?php echo $phone_number; ?>">
                                        <span class="error">* <?php echo $phonenumber_Err; ?></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label>Email ID</label>
                                    </div>
                                    <div>
                                        <input type="email" class="input" name="email_id" placeholder="Email ID" value="<?php echo $email_id; ?>">
                                        <span class="error">* <?php echo $emailid_Err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="class-2">
                                <div class="parent">
                                    <div>
                                        <label>Employee Designation</label>
                                    </div>
                                    <div>
                                        <select class="form-select"  id="emp_designation" name="emp_designation" aria-label="Default select example">
                                            <?php
                                            $query ="SELECT * FROM designation";
                                            $result = mysqli_query($conn,$query);

                                            if($result->num_rows> 0){
                                                $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            }
                                            foreach ($options as $option) {
                                                ?>
                                                <option value='<?php echo $option['designation_id']; ?>' <?php if($emp_designation==$option['designation_id']){echo SELECTED;} ?>><?php echo $option['designation_name']; ?> </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="error">* <?php echo $empdesignation_Err; ?></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label> State</label>
                                    </div>
                                    <div>
                                        <select class="form-select" id="state_name" name="state_name" aria-label="Default select example" onchange="get_districts(this.value)">
                                            <?php
                                            $query = "SELECT * FROM state";
                                            $result = mysqli_query($conn, $query);

                                            if ($result->num_rows > 0) {
                                                $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            }
                                            foreach ($options as $option) {
                                                ?>
                                                <option value='<?php echo $option['state_id']; ?>' <?php if ($state == $option['state_id']) {echo SELECTED; }?>>
                                                    <?php echo $option['state_name']; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="error">* <?php echo $state_Err; ?></span>
                                    </div>
                                </div>
                                <div class="parent">
                                    <div>
                                        <label> District </label>
                                    </div>
                                    <div>
                                        <select class="input" name="district_name" id="districts">
                                            <?php
                                            $query = "SELECT * FROM district where state_id='$state'";
                                            $result = mysqli_query($conn, $query);

                                            if ($result->num_rows > 0) {
                                                $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            }
                                            foreach ($options as $option) {
                                                ?>
                                                <option value='<?php echo $option['district_id']; ?>' <?php if ($district == $option['district_id']){ echo SELECTED;} ?>>
                                                    <?php echo $option['district_name']; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                            git remote add origin https://github.com/Murali1234-kn/Web_Development_by_PHP.git           </select>
                                        <span class="error">* <?php echo $district_Err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <div class="parent">
                                    <div>
                                        <label>Employee Picture </label>
                                    </div><br>
                                    <div>
                                        <?php
                                        if (!empty($emp_picture)) {
                                            echo "<img src='$emp_picture' alt='Employee Picture' width='100' height='85'>";
                                        }
                                        ?><br><br>
                                        <input type="file" class="input" name="emp_picture" accept=".jpg, .png, .jpeg, .jfif" placeholder="Employee Picture" value="<?php echo $emp_picture; ?>"><br>
                                        <span class="error">* <?php echo $empimage_Err; ?></span>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <input type="checkbox" class="input" name="emp_status" <?php echo $emp_status == 1 ? 'checked' : ''; ?>>
                                    <label>Employee Status</label>
                                </div>
                                <br>
                                <div>
                                    <button id="bt1" type="submit" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
    </main>
   <?php include_once 'footer.php'?>
</div>
    <script>
        function get_districts(val) {
            $.ajax({
                type: "POST",
                url: "Districts_All.php",
                data:'state_id='+val,
                success: function(data){
                    $("#districts").html(data);
                }
            });
        }

    </script>

</body>
</html>