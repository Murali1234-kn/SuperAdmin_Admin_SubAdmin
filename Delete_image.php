<?php
    if (isset($_GET['delete_image']))
    {
        $image = $_GET['delete_image'];
       echo $image;echo "<br>";
         $path ='uploads/'.$image;
         echo $path;
            unlink($path);
            header('Location:New_Images.php');


    }
?>