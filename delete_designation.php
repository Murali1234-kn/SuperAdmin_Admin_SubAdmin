<?php
//
//include_once 'employee_db.php';
//
//if (isset($_GET['designation_id'])) {
//    $delete_id = $_GET['designation_id'];
//    $delete_query = "DELETE FROM designation WHERE designation_id = $delete_id";
//    $result=  $conn->query($delete_query);
//    if ($result) {
//        header('Location:New_Designation.php');
//    } else {
//        echo "Error deleting record: " . $conn->error;
//    }
//}


include_once 'employee_db.php';
if($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Admin') {
    if (isset($_GET['designation_id'])) {
        $delete_id = $_GET['designation_id'];
        try {

            $query = "select emp_designation from employee where emp_designation = $delete_id";
            $result1 = $conn->query($query);
            if ($result1->num_rows > 0) {
                echo '<script>';
                echo 'alert("Designation Used for Employees Cannot Delete Right Now!..");';
                echo 'window.location.href = "New_Designation.php";';
                echo '</script>';
            } else {
                $delete_query = "DELETE FROM designation WHERE designation_id = $delete_id";
                $result = $conn->query($delete_query);
                header('Location: New_Designation.php');
            }


        } catch (mysqli_sql_exception $e) {
//        echo '<script>';
//        echo 'alert("Designation Used for Employees Cannot Delete Right Now!..");';
//        echo 'window.location.href = "New_Designation.php";';
//        echo '</script>';
            echo " errors" . $e->message() . " ";
        }
    }
}
else {
    echo "<div style='text-align: center;'>";
    echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
    echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
    echo "</div>";
}

?>
