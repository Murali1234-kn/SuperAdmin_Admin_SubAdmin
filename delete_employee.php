<?php
include_once 'employee_db.php';
if($_SESSION['user_Type'] != 'Sub Admin')
{
    $delete_id = $_GET['emp_id'];
//echo $delete_id;
    $delete_query = "DELETE FROM employee WHERE emp_id = $delete_id";
    $result = $conn->query($delete_query);

//echo $result; 1;
    if ($result == TRUE) {
        header('Location:New_Employee.php');
    } else {
        echo "Error:" . $delete_query . "<br>" . $conn->error;
    }

} else {
    echo "<div style='text-align: center;'>";
    echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
    echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
    echo "</div>";
}


?>
