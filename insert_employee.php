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
    if ($_SESSION['user_Type'] != 'Sub Admin') {
        include_once 'Top_nav.php';

        $emp_name = $emp_designation = $emp_picture  = $phone_number = $email_id = $state = $district = "";
        $emp_status = "1";
        $empName_Err = $empdesignation_Err = $empimage_Err = $empStatus_Err = $phonenumber_Err =
            $emailid_Err = $state_Err = $district_Err = "";

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST['emp_name'])) {
                $empName_Err = "Name is required";
            } else {
                $emp_name = validate($_POST['emp_name']);

                if (!preg_match('/^[a-zA-Z ]{3,}$/', $emp_name)) {
                    $empName_Err = "Enter Alphabets";
                }
            }
            if (empty($_POST['phone_number'])) {
                $phonenumber_Err = "Phone number is required";
            } else {
                $phone_number = validate($_POST['phone_number']);
                if (!preg_match('/^[0-9]{10}$/', $phone_number)) {
                    $phonenumber_Err = "Invalid phone Number";
                }
            }
            if (empty($_POST["email_id"])) {
                $emailid_Err = "Email is required";
            } else {
                $email_id = validate($_POST["email_id"]);
                if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
                    $emailid_Err = "Invalid email format";
                }
            }
            if (!empty($email_id) || !empty($phone_number)) {
                $email_query = "SELECT * FROM employee WHERE email_id='$email_id' OR phone_number='$phone_number'";
                $email_result = mysqli_query($conn, $email_query);

                $phone_query = "SELECT * FROM employee WHERE phone_number='$phone_number'";
                $phone_result = mysqli_query($conn, $phone_query);


                if (mysqli_num_rows($email_result) > 0) {
                    $emailid_Err = "Email ID Already Present";
                }
                if (mysqli_num_rows($phone_result) > 0) {
                    $phonenumber_Err = "Mobile Number Already Present";
                }
                //        mysqli_free_result($email_result);
                //        mysqli_free_result($phone_result);
            }

            if (empty($_POST['emp_designation'])) {
                $empdesignation_Err = "Please Select Designation";
            } else {
                $emp_designation = validate($_POST['emp_designation']);
            }

            if (empty($_POST['state_name'])) {
                $state_Err = " Please Select State";
            } else {
                $state = validate($_POST['state_name']);
            }

            if (empty($_POST['district_name'])) {
                $district_Err = "Please Select District";
            } else {
                $district = validate($_POST['district_name']);
            }

            $emp_status = isset($_POST['emp_status']) ? '1' : '0';

            if (
                empty($empName_Err) && empty($empdesignation_Err) && empty($phonenumber_Err) && empty($emailid_Err)
                && empty($state_Err) && empty($district_Err)
            ) {

                $query = "SELECT designation_id FROM designation WHERE designation_name = ?";
                $stmt = $conn->prepare($query);

                if ($stmt !== false) {
                    $stmt->bind_param("s", $emp_designation);
                    $stmt->execute();
                    $stmt->bind_result($designation_id);

                    if ($stmt->fetch()) {
                        $stmt->close();
                        echo $emp_picture;
                        echo "imageeee <br>";
                        $insert_query = "INSERT INTO employee (emp_name, emp_designation, emp_picture, emp_status, phone_number, email_id,state,district) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $insert = $conn->prepare($insert_query);
                        if ($insert !== false) {
                            $insert->bind_param("ssssssss", $emp_name, $designation_id, $emp_picture, $emp_status, $phone_number, $email_id, $state, $district);

                            if ($insert->execute()) {
                                $empo_id = $conn->insert_id;  // getting AI here

                                echo $empo_id;
                                $format_id = "EMP" . str_pad($empo_id, 3, "0", STR_PAD_LEFT);

                                $format_query = "UPDATE employee SET number=? WHERE emp_id=?";

                                $format_stmt = $conn->prepare($format_query);
                                $format_stmt->bind_param("si", $format_id, $empo_id);
                                $format_stmt->execute();

                                if (isset($_FILES['emp_picture']) && $_FILES['emp_picture']['error'] == 0 && $_FILES['emp_picture']['size'] > 0) {
                                    $upload_dir = "image/";
                                    $filename = pathinfo($_FILES['emp_picture']['name'], PATHINFO_EXTENSION);

                                    $new_filename = $format_id . '.' . $filename;
                                    //                                echo $new_filename;
                                    $uploaded_file = $upload_dir . $new_filename;
                                    if (move_uploaded_file($_FILES['emp_picture']['tmp_name'], $uploaded_file)) {
                                        $emp_picture = $uploaded_file;
                                        $update_image = "UPDATE employee SET emp_picture ='$emp_picture' WHERE emp_id='$empo_id'";
                                        $excute_query = $conn->query($update_image);
                                        echo "<br>";
                                        //                                  echo "success";
                                    } else {
                                        $empimage_Err = "Error uploading file: " . $_FILES['emp_picture']['error'];
                                    }
                                } else {
                                    $empimage_Err = "Please Select Employee Photo";
                                }
                                //                        echo "Record inserted successfully";
                                header('Location: New_Employee.php');
                            } else {
                                echo "Error executing query: " . $insert->error;
                            }
                        }
                    }
                }
            }
        }
        echo "<br>";
        //    echo "emp_name: $emp_name, emp_designation: $emp_designation, emp_picture: $emp_picture, emp_status: $emp_status";
        //    echo "phone number $phone_number, email id $email_id";

    ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php include_once'Side_nav.php'; ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Employees</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="New_Employee.php">Employees</a></li>
                            <li class="breadcrumb-item active">Add Employee</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">

                                <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
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
                                                <select class="input" name="emp_designation">
                                                    <option value=""> Please Select Employee Designation</option>
                                                    <?php
                                                    $query = "SELECT * FROM designation";
                                                    $result = $conn->query($query);

                                                    while ($row = $result->fetch_assoc()) {
                                                        $designation_name = $row['designation_name'];
                                                        echo "<option value='$designation_name'>$designation_name</option>";
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
                                                <select class="input" name="state_name" onChange="get_districts(this.value)">
                                                    <option value=""> Please Select State</option>
                                                    <?php
                                                    $query = "SELECT * FROM state";
                                                    $result = $conn->query($query);

                                                    while ($row = $result->fetch_assoc()) {
                                                        $state_name = $row['state_name'];
                                                        $state_id = $row['state_id'];
                                                        echo "<option value='" . $row['state_id'] . "'>" . $row['state_name'] . "</option>";
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

                                                    <option>Please Select District</option>
                                                </select>
                                                <span class="error">* <?php echo $district_Err; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <div class="parent">
                                            <div>
                                                <label>Employee Picture </label>
                                            </div>
                                            <div>
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
                </main>
                <?php include_once "footer.php" ?>
            </div>
            <script>
                function get_districts(val) {
                    $.ajax({
                        type: "POST",
                        url: "Districts_All.php",
                        data: 'state_id=' + val,
                        success: function(data) {
                            $("#districts").html(data);
                        }
                    });
                }
            </script>
        <?php
    } else {
        echo "<div style='text-align: center;'>";
        echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
        echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
        echo "</div>";
    }
        ?>
</body>
</html>