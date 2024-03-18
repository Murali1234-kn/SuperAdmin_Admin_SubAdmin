
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
    <!--    <link href="css/styles.css" rel="stylesheet" />-->
    <link href="css/Main.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php
include_once 'employee_db.php';
if($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Super Admin')
{
include_once 'Top_nav.php';
    echo "hello";

if (isset($_FILES['images']) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) &&
    count($_FILES['images']['name']) > 0)
{
//    echo "True";
    $dir = "uploads/" . date("d-m-Y") . "/";
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $files = $_FILES['images'];

    foreach ($files['name'] as $key => $img_name)
    {
        $tmp_name = $files['tmp_name'][$key];
        $images = $dir . $img_name;
        if (move_uploaded_file($tmp_name, $images))
        {
            echo "Successs";
            header('Location:New_Images.php');
        } else {
            echo "Failed to move file.";
        }
    }
}
echo '<br><br>';
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h3 class="mt-4">Upload Images</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="New_Images.php">Gallery</a></li>
                    <li class="breadcrumb-item active">Add Images</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                            <input type="file" multiple="multiple" accept=".jpg, .png, .jpeg, .jfif" name="images[]"><br><br>
                            <input type="submit" name="submit" value="Upload Images">
                        </form>
                    </div>
                </div>
        </main>
        <?php include_once "footer.php" ?>
    </div>
    <?php
    }
    else {
        echo "<div style='text-align: center;'>";
        echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
        echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
        echo "</div>";
    }
    ?>
</body>
</html>
