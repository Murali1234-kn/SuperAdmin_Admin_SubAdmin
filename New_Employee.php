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
    <style>
        tr,td,th{
            border: 1px solid black !important;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
    <script src="Javascript/Main.js"></script>

</head>
<body>

<?php
include_once 'Top_nav.php';
  include_once "employee_db.php";

$query  = "SELECT * FROM employee";
$result = mysqli_query($conn,$query);
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
                    <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header flex-between">
                        <div>
                            <i class="fas fa-table me-1"></i>
                            Employees
                        </div>
                        <?php if($_SESSION['user_Type'] !='Sub Admin')
                            {?>
                     <a href="insert_employee.php" class="btn btn-primary custom-btn">Add Employee</a>
                   <?php
                        }?>
                    </div>
                    <div class="card-body">
                        <div id="search-bar">
                             <input type="text" id="search" placeholder="Search...">
                        </div>
                    <?php
                    $get_data = "SELECT emp.*, des.designation_name,st.state_name,dist.district_name
                               FROM ((employee emp LEFT JOIN designation des ON emp.emp_designation = des.designation_id)
                            LEFT JOIN state st ON emp.state = st.state_id
                            LEFT JOIN district dist ON emp.district =dist.district_id)";

                    $Get_emp = $conn->query($get_data);
        if (mysqli_num_rows($Get_emp) > 0) {
            ?>

                    <div class="card-body" id="tt">
                        <table id="table" style="width: 100%;border-radius: 5px">
                            <thead>
                            <tr>
                                <th scope="col">EMPID</th>
                                <th scope="col">Emp Name</th>
                                <th scope="col">Emp Email</th>
                                <th scope="col">Emp Mobile No.</th>
                                <th scope="col">Emp Desigantion</th>
                                <th scope="col">Emp State</th>
                                <th scope="col">Emp District</th>
                                <th scope="col">Emp Picture</th>
                                <th scope="col">Emp Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($Get_emp)) {
                            ?>
                            <tr  id='<?php echo $row['emp_id'];?>'>
                                <td><?php echo $row['number'];?></td>
                                <td><?php echo $row['emp_name'];?></td>
                                <td><?php echo $row['email_id'];?></td>
                                <td><?php echo $row['phone_number'];?></td>
                                <td><?php echo $row['designation_name'];?></td>
                                <td><?php echo $row['state_name'];?></td>
                                <td><?php echo $row['district_name'];?></td>
                                <td><img src='<?php echo $row['emp_picture']; ?>' alt='Employee Image' width='95'></td>
                                <td><?php echo $row['emp_status'] == 1 ? 'Active' : 'Inactive'; ?></td>

                                <td id="btt">
                                     <div>
                                         <?php if($_SESSION['user_Type'] !='Sub Admin')
                                         {?>
                                         <a type='button' style="m: 10px" class='btn btn-danger btn-sm' href='delete_employee.php?emp_id=<?php echo $row['emp_id'];?>' onclick='delete_record(event)'>Delete</a>
                                          <?php
                                          }?>
                                      </div><br>
                                    <div>
                                        <a type='button' style="margin-right: 10px" class='btn btn-info btn-sm' href='update_employee.php?emp_id=<?php echo $row['emp_id'];?>'>Update</a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php }
        else{
            echo "<h5 style='text-align: center;color: red'>No Employees found</h5>";
        }?>
                </div>
            </div>
        </main>
       <?php include_once 'footer.php'?>
    </div>
</body>
</html>




