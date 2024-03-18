<?php
include_once 'employee_db.php';
if ($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Admin') {
    if (isset($_GET['state_id'])) {
        $delete_id = $_GET['state_id'];

        $delete_query = "DELETE FROM state WHERE state_id = $delete_id";
        $result = $conn->query($delete_query);
        if ($result) {
            header('Location:New_State.php');
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
} else {
    echo "<div style='text-align: center;'>";
    echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
    echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
    echo "</div>";
}
