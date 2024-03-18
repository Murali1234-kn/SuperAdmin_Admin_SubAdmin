<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #main {
            display: grid;
        }
    </style>
</head>
<?php
include_once 'employee_db.php';
if ($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Super Admin') {
include_once 'Top_nav.php';
?>
<body>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include_once 'Side_nav.php'; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Gallery</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Gallery</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header flex-between">
                        <div>
                            <i class="fas fa-image me-1"></i>
                            Gallery
                        </div>
                        <?php if ($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != ' Super Admin') { ?>
                            <a href="insert_image.php" class="btn btn-primary custom-btn">Add Images</a>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <div id="main">
                            <?php
                            $path = "./uploads/";
                            $dir = new DirectoryIterator($path);

                            foreach ($dir as $fileinfo) {
                                if ($fileinfo->isDir() && !$fileinfo->isDot()) { ?>
                                    <div class="folder_container">
                                        <a href="Images_show.php?date=<?php echo $fileinfo->getFilename(); ?>">
                                            <?php echo $fileinfo->getFilename(); ?>
                                        </a>
                                        <div class="download">
                                            <a href="Unzip.php?unzip_date=<?php echo $fileinfo->getFilename(); ?>">
                                                <img alt="image" src="./image/zip.png" width="20px" value="<?php echo $fileinfo->getFilename(); ?>">
                                            </a>
                                            &nbsp &nbsp
                                            <a href="Zip.php?date=<?php echo $fileinfo->getFilename(); ?>" download>
                                                <img alt="image" src="./image/download3.png" width="20px" value="<?php echo $fileinfo->getFilename(); ?>">
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    //                                echo "<h4 style='color: red;text-align: center'>No Images...</h4>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once 'footer.php' ?>
    </div>
</div>
<?php
} else {
    echo "<div style='text-align: center;'>";
    echo "<h5 style='color: red'>Sorry!!... You Don't have Access</h5>";
    echo "<a type='button' class='btn btn-primary btn-bg' href='Dashboard.php'>Go Back!!</a>";
    echo "</div>";
}
?>
</body>

</html>
