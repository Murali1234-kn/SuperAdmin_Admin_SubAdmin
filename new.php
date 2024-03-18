<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
</head>
<body>
<?php
if (isset($_FILES['images']) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) &&
    count($_FILES['images']['name']) > 0)
{
    echo "True";
    $dir = "uploads/" . date("d-m-Y") . "/";
    $files = $_FILES['images'];
    echo $dir;
    foreach ($files['name'] as $key => $img_name)
    {
        echo "m0ve";
        $tmp_name = $files['tmp_name'][$key];
        $images = $dir . $img_name;
        echo $images;
        if(move_uploaded_file($tmp_name, $images)) {
            echo "Successs";
//                header('Location:Multiple_Images.php');
        } else {
            echo "Failed to move file.";
        }

    }
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <input type="file" multiple="multiple" accept=".jpg, .png, .jpeg, .jfif" name="images[]"><br><br>
    <input type="submit" name="submit" value="Upload Images">
</form>
</body>
</html>
