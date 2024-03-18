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
        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            width:100%;
        }
        .gallery-item {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
<?php
include_once 'employee_db.php';
if ($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Super Admin') {
    include_once 'Top_nav.php';
    ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include_once 'Side_nav.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Gallery</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="New_Images.php">Gallery</a></li>
                        <li class="breadcrumb-item active">Display Images</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header flex-between">
                            <div>
                                <i class="fas fa-image me-1"></i>
                                Images
                            </div>
                            <?php if ($_SESSION['user_Type'] != 'Sub Admin' && $_SESSION['user_Type'] != 'Super Admin') {
                                $date = $_GET['date'];
                                $dir = 'uploads/' . $date;
                                $file_name = scandir($dir);
                                ?>
                                <a href="Zip.php?date=<?php echo $date; ?>" class="btn btn-primary custom-btn">Download to Zip</a>
                                <?php
                            } ?>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="gallery-container">
                            <?php
                            foreach ($file_name as $image) {
                                if ($image != "." && $image != "..")
                                {
                                    ?>
                                    <div class="gallery-item">
                                        <a href="Full_image.php?image=<?php echo $date."/".$image; ?>">
                                        <img class="gallery_image" src="<?php echo $dir . '/' . $image; ?>" alt="images"/>
                                        </a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
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
