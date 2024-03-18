<?php
//include "class_employee_db.php";

$server_Name = "localhost";
$user_Name = "root";
$password = "";
$database = "class_employee";

$conn = new mysqli($server_Name, $user_Name, $password, $database);

//$conn =mysqli_connect($server_Name, $user_Name,$password,$database);
if($conn)
{
    echo "Connected";
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
//    echo 'We don\'t have mysqli!!!';
//} else {
//    echo '<br>mysqli is installed';
//}
 public class EmployeeClass
{
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

   public function empInsert()
    {
        $Emp_Name = (string)readline("Enter Employee Name: ");
        $Emp_Email = (string)readline("Enter Email: ");
        $Emp_phonenumber = (string)readline("Enter Phone Number: ");
        $Emp_Designation = (string)readline("Enter Designation: ");
        $Emp_Status = readline("Enter Status: ");
        if (empty($Emp_Status))
        {
            $Emp_Status = '1';
        }
        if ($Emp_Name && $Emp_Email && $Emp_phonenumber && $Emp_Designation && $Emp_Status)
        {
            $string = "INSERT INTO employee_class(Emp_Name,Emp_Email,Emp_phonenumber,Emp_Designation,Emp_Status)
                   VALUES ('$Emp_Name','$Emp_Email','$Emp_phonenumber','$Emp_Designation','$Emp_Status')";

            $result = $this->conn->query($string);
            if ($result)
            {
                $empo_id = $this->conn->insert_id;
//                echo $empo_id . "<br>";
                $format_id = "EMP" . str_pad($empo_id, 3, "0", STR_PAD_LEFT);
//                echo $format_id . "<br>";
                $format_query = "UPDATE employee_class SET EmpId='$format_id' WHERE id='$empo_id'";
                $update_result = $this->conn->query($format_query);

                if ($update_result) {
                    echo "Employee row Inserted successfully" . $format_id;
                } else {
                    echo "Error: " . $this->conn->error;
                }
            }
        }
    }

  public function empUpdate()
    {
        $EmpId = (string)readline("Enter Employee Id for update: ");
        $sql_check = "SELECT * FROM employee_class WHERE EmpId = '$EmpId'";
        $result_check = $this->conn->query($sql_check);
        $row = mysqli_fetch_assoc($result_check);
        if ($row)
        {
            echo "Name: " . $row['Emp_Name'] . "\n";
            echo "Email: " . $row['Emp_Email'] . "\n";
            echo "Phone Number: " . $row['Emp_Phonenumber'] . "\n";
            echo "Designation: " . $row['Emp_Designation'] . "\n";
            echo "Status: " . $row['Emp_Status'] . "\n\n";

            $Emp_Name = (string)readline("Enter Employee Name: ");
            $Emp_Email = (string)readline("Enter Email: ");
            $Emp_Phonenumber = (string)readline("Enter Phone Number: ");
            $Emp_Designation = (string)readline("Enter designation: ");
            $Emp_Status = readline("Enter Status:");

            if ($Emp_Name == "")
            {
                $Emp_Name = $row['Emp_Name'];
            }
            if($Emp_Email == "")
            {
                $Emp_Email =$row['Emp_Email'];
            }
            if($Emp_Phonenumber =="")
            {
                $Emp_Phonenumber =$row['Emp_Phonenumber'];
            }
            if($Emp_Designation =="")
            {
                $Emp_Designation = $row['Emp_Designation'];
            }
            if($Emp_Status =="")
            {
                $Emp_Status = $row['Emp_Status'];
            }
                $sql = "UPDATE employee_class  SET Emp_Name='$Emp_Name', Emp_Email='$Emp_Email', Emp_Phonenumber='$Emp_Phonenumber', Emp_Designation='$Emp_Designation' ,Emp_Status='$Emp_Status'WHERE EmpId='$EmpId'";
                $result = $this->conn->query($sql);
                if ($result) {
                    echo "Employee row updated successfully";
                } else {
                    echo "Error: " . $this->conn->error;
                }
            } else {
                echo "Employee Id not found.";
            }
    }

   public function empDelete()
    {
        $EmpId = (string)readline("Enter Employee Id: ");

        $sql_check = "SELECT * FROM employee_class WHERE EmpId = '$EmpId'";
        $result_check = $this->conn->query($sql_check);

        $row = mysqli_fetch_assoc($result_check);
        if ($row) {
            $query = "DELETE FROM employee_class WHERE EmpId = '$EmpId'";
            $result = $this->conn->query($query);
            if ($result) {
                echo "Employee row deleted successfully";
            } else {
                echo "Error: " . $this->conn->error;
            }
        } else {
            echo "Employee Id not found.";
        }
    }

   public function empDownload()
    {
        $query = "select EmpId,Emp_Name,Emp_Email,Emp_Phonenumber,Emp_Designation,Emp_Status from employee_class";

        $result = $this->conn->query($query);
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $file = fopen('EmployeeClass.csv', 'w');
        fputcsv($file, array_keys($array[0]));
        foreach ($array as $line) {
            fputcsv($file, $line);
        }

        fclose($file);
        echo "Export successful";
        exit;
    }

   public function Display()
    {
        $query = "SELECT * FROM employee_class";
        $result = $this->conn->query($query);
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            print_r($data);
//            echo "<ul>";
//            foreach ($data as $row) {
//                echo "<li>" . $row['EmpId'] . "</li>";
//                echo "<li>" . $row['Emp_Name'] . "</li>";
//                echo "<li>" . $row['Emp_Email'] . "</li>";
//                echo "<li>" . $row['Emp_Phonenumber'] . "</li>";
//                echo "<li>" . $row['Emp_Designation'] . "</li>";
//                echo "<li>" . ($row['Emp_Status'] == 1 ? 'Active' : 'Inactive') . "</li>";
//            }
//            echo "</ul>";
        } else {
            echo mysqli_error($this->conn);
        }
      }
}
$crud = new EmployeeClass($conn);

//$crud->EmpDownload();

$int = (int)readline('Please Enter Option 1.Insert 2. Update 3.Delete 4.Download 5.Display Employees : ');
switch ($int)
{
    case 1:
        $crud->empInsert();
        Break;
    case 2:
        $crud->empUpdate();
        Break;
    case 3:
        $crud->empDelete();
        Break;
    case 4:
        $crud->empDownload();
        Break;
    case 5:
        $crud->Display();
        Break;
}
?>

