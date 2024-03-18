<?php
header("Content-Type:application/json");
include_once 'DATABASE_API.php';
const INVALID ='Invalid Request';
if (isset($_GET['id']) && $_GET['id']!="")
{

    $id = $_GET['id'];
    $query = "SELECT * FROM first WHERE id='$id'";
    $result = $conn->query($query);
    if(mysqli_num_rows($result)  > 0)
    {
        $row = mysqli_fetch_assoc($result);
        $amount = $row['Name'];
       $age  = $row['Age'];
       $gender  = $row['Gender'];

      echo json_encode($row);
    }
    else
    {echo "No record";}
}
else
{
    echo INVALID;
}
//function response($id,$amount,$age, $gender)
//{
//    $response['id'] = $id;
//    $response['Name'] = $amount;
//    $response['Age'] = $age;
//    $response['Gender'] = $gender;
//    $json_response = json_encode($response);
//    echo $json_response;
//}
if (isset($_GET['Name']) && $_GET['Age']!="")
{
    $name = $_GET['Name'];
    $age = $_GET['Age'];
    $gender = $_GET['Gender'];
    $query = "insert into first (Name,Age,Gender) values ('$name','$age','$gender')";
    $result = $conn->query($query);
     echo "Inserted Successfull";
}
else
{
    echo INVALID;
}

if (isset($_POST['id']) && $_POST['id']!="")
{

    $id = $_POST['id'];
    $query = "delete from first WHERE id='$id'";
    $result = $conn->query($query);
     if($result)
    {
        echo "Successfully Deleted";
    }
    else
    {echo "No record";}
}
else
{
    echo INVALID;
}
