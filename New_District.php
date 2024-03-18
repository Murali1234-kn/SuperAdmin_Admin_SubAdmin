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
$query ="SELECT district.district_id,district.district_name,state.state_name,district.district_status FROM district INNER JOIN state on district.state_id = state.state_id";
$result = mysqli_query($conn,$query);
$district_data=[];
if(mysqli_num_rows($result) > 0)
{
    $district_data= mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Districts</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Districts</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header flex-between">
                        <div>
                            <i class="fas fa-table me-1"></i>
                            Districts
                        </div>
                        <?php if($_SESSION['user_Type'] !='Sub Admin' && $_SESSION['user_Type'] !='Admin')
                        {?>
                        <a href="insert_district.php" class="btn btn-primary custom-btn">Add District</a>
                        <?php
                        }?>
                    </div>
                    <div class="card-body">
                        <div id="search-bar">
                            <input type="text" id="search" placeholder="Search...">
                        </div>

                        <div class="card-body" id="tt">
                            <table id="table" style="width: 100%;border-radius: 5px">
                                <thead>
                                <tr>
                                    <th scope="col">District Id</th>
                                    <th scope="col">District Name</th>
                                    <th scope="col">State Name</th>
                                    <th scope="col">District Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($district_data)
                                {
                                foreach ($district_data as $row) {
                                    ?>
                                    <tr id="rows">
                                        <td><?php echo $row['district_id']; ?></td>
                                        <td><?php echo $row['district_name']; ?></td>
                                        <td><?php echo $row['state_name'];?></td>
                                        <td> <?php echo $row['district_status'] == 1 ? 'Active' : 'Inactive';?></td>
                                        <td id="btt">
                                            <?php if($_SESSION['user_Type'] !='Sub Admin' && $_SESSION['user_Type'] !='Admin')
                                            {?>
                                            <a type='button' class='btn btn-danger' href='delete_district.php?district_id=<?php echo $row['district_id'];?>' onclick='delete_record(event)'>Delete</a>
                                    <?php }?>
                                            <a type='button' class='btn btn-info' href='update_district.php?district_id=<?php echo $row['district_id'];?>'>Update</a>
                                        </td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </main>
        <?php include_once 'footer.php'?>
    </div>
</body>
</html>

