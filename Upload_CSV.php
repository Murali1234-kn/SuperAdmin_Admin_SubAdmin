<!DOCTYPE html>
<html lang="en">
<head>
    <title>CSV File Upload</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #table {
            padding: 5px;
            margin: 10px auto;
            border-radius: 5px;
            border-collapse: collapse;
            width: 55%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            border-radius: 5px;
        }
        tr:hover {
            background-color:antiquewhite;
        }
        #search-bar{
            /*float:left;*/
            margin: 15px 10px ;
            width: 20%;
        }
        #search{
            padding: 7px;


    </style>
</head>
<body>

<?php
include_once "Database_conn.php";
if(isset($_POST["import"]))
{
    $filename = $_FILES["file"]["tmp_name"];                 // temporary name file name to access the uploaded file on server
    if($_FILES["file"]["size"] > 0)                          // 0-bytes
    {
        $files = fopen($filename,"r");                //fopen is a function to open and read the file mode is "r"
        while(($column = fgetcsv($files,10000,",")) !== FALSE)
                                                             //10000-->max. length of the line to read file
//                                                             // " ," -->delemeter mainly to seperate the csv file by commas,
        {
            $sql ="INSERT INTO age (`Period`,`Mothers_Age`, `Count`) 
             values ('".$column[0]."','".$column[1]."', '".$column[2]."')";

            $result = mysqli_query($conn, $sql);

            if($result !== FALSE)
            {
                $success= "CSV uploaded Successfully";
            } else {
                echo "Problem while uploading: " . mysqli_error($conn);
            }
        }
    }
}
if(isset($success)){
    echo $success;
    }
?>

<form class="importfile" name="uploadcsv" method="post" enctype="multipart/form-data">
    <div>
        <label>Choose CSV FILE</label><br><br>
        <input type="file" name="file" accept=".csv"><br><br>
        <button type="submit" name="import">Import</button>
    </div>
</form>

<?php
$select ="SELECT * FROM age";

$result1 =mysqli_query($conn,$select);

if(mysqli_num_rows($result1) > 0)
{?>
<div>

    <div id="main">
        <div id="search-bar">
            <input type="text" id="search" placeholder="Search...">
        </div>
    <div>
<table id="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Period</th>
        <th>Mother_Age</th>
        <th>Count</th>

    </tr>
    </thead>
    <?php
    while($rows=mysqli_fetch_assoc($result1))
    {
        ?>
    <tbody id="tbdy">
    <tr id="rows">
        <td><?php echo $rows['id'] ;?></td>
        <td><?php echo $rows['Period'] ;?></td>
        <td><?php echo $rows['Mothers_Age'] ;?></td>
        <td><?php echo $rows['Count'] ;?></td>
    </tr>
    </tbody>

   <?php }?>

</table>

  <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#search").on("keyup", function()
        {
            let value = $(this).val().toLowerCase();
            $("#tbdy tr").filter(function()
            {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

</script>
</body>
</html>
