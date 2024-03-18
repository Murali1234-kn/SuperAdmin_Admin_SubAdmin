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

</head>
<body>
<?php
include_once 'employee_db.php';
if($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Super Admin')
{
include_once 'Top_nav.php';
$query  = "SELECT * FROM users";
$result = mysqli_query($conn,$query);
?>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header flex-between">
                        <div>
                            <i class="fas fa-user me-1"></i>
                            Users
                        </div>
                        <a href="insert_user.php" class="btn btn-primary custom-btn">Add Users</a>
                    </div>
                    <div class="card-body">
                        <div id="search-bar">
                            <input type="text" id="search" placeholder="Search...">
                        </div>
                        <div class="card-body" id="tt">
                            <table id="table" style="width: 100%;border-radius: 5px">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>User Name</th>
                                    <th>User Type</th>
                                    <th>User Email</th>
                                    <th>User Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                <tr id="rows">
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['userName']; ?></td>
                                    <td><?php echo $row['userType']; ?></td>
                                    <td><?php echo $row['userEmail']; ?></td>
                                    <td> <?php echo $row['userStatus'] == 1 ? 'Active' : 'Inactive';?></td>
                                    <td id="btt">
                                        <div>
                                            <a type='button' style="m: 10px" class='btn btn-danger btn-sm' href='delete_user.php?id=<?php echo $row['id'];?>' onclick='delete_emp(event)'>Delete</a>

                                        </div><br>
                                        <div>
                                            <a type='button' style="margin-right: 10px" class='btn btn-info btn-sm' href='update_user.php?id=<?php echo $row['id'];?>'>Update</a>
                                        </div>
                                    </td>
                                </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once 'footer.php'?>
    </div>
</div>
<script>
    function delete_emp(event) {
        event.preventDefault();

        let a = confirm("Are you sure you want to delete");
        if (a)
        {
            window.location.href = event.target.href;
        }
        else
        {
            console.log("sucesfull");
        }
    }
</script>
<script>
    $(document).ready(function(){
        $("#search").on("keyup", function() {
            let value = $(this).val().toLowerCase();
            $("#tt tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
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

