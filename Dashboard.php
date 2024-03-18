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
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body>
<?php
include_once 'employee_db.php';
//if($_SESSION['user_Type'] == 'Sub Admin' || $_SESSION['user_Type'] == 'Admin' || $_SESSION['user_Type'] =='Super Admin')
//{
include_once 'Top_nav.php';
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Employees <?php
                                $query1 = "SELECT * FROM employee";
                                $emp_result = mysqli_query($conn, $query1);
                                echo $emp_result->num_rows;
                                ?></div>

                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="New_Employee.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">

                            <div class="card-body">Designations <?php
                                $query1 = "SELECT * FROM designation";
                                $emp_result = mysqli_query($conn, $query1);
                                echo $emp_result->num_rows;
                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="New_Designation.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-info text-white mb-4">

                            <div class="card-body">Districts <?php
                                $query1 = "SELECT * FROM district";
                                $emp_result = mysqli_query($conn, $query1);
                                echo $emp_result->num_rows;
                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="New_District.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">

                            <div class="card-body">States <?php
                                $query1 = "SELECT * FROM state";
                                $emp_result = mysqli_query($conn, $query1);
                                echo $emp_result->num_rows;
                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="New_State.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($_SESSION['user_Type'] !='Super Admin' && $_SESSION['user_Type'] != 'Sub Admin')
                    {?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Users <?php
                                $query1 = "SELECT * FROM users";
                                $emp_result = mysqli_query($conn, $query1);
                                echo $emp_result->num_rows;
                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="New_User.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                </div>
            </div>
        </footer>
    </div>
</div>
    <?php
//}
//else {
//    echo "<div style='text-align: center;'>";
//    echo "<h5 style='color: red'>Please Login!.....</h5>";
//    echo "<a type='button' class='btn btn-primary btn-bg' href='Login.php'>Login</a>";
//    echo "</div>";
//}
?>

</body>
</html>

