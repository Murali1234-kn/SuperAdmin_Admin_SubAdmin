<?php
include_once 'employee_db.php';
if (!empty($_POST["state_id"]))
{
    $query = "SELECT * FROM district WHERE state_id = '" . $_POST["state_id"] . "'";
    $result = $conn->query($query);
    ?>
    <option>Please Select District</option>
    <?php
    while ($row = mysqli_fetch_array($result)) {
        ?>
        <option
            value='<?php echo $row["district_id"]; ?>'
            <?php
            if (isset($_POST["district_id"]))
            {
                echo $row["district_id"] == $_POST["district_id"] ? 'selected' : '';
            }
            ?>
        >
            <?php echo $row["district_name"]; ?>
        </option>
        <?php
    }
}
?>
