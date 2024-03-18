<?php
include_once 'employee_db.php';
if($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Super Admin')
{
    if (isset($_GET['id'])) {
        $delete_id = $_GET['id'];
        $delete_query = "DELETE FROM users WHERE id = $delete_id";

        $conn->query($delete_query);

        header("Location:New_User.php");
    }
}
else {
    echo "<div style='text-align: center;'>";
    echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
    echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
    echo "</div>";
}
