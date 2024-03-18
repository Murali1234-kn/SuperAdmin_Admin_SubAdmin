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
</head>
<body>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
<!--            <i style="color: red">--><?php //echo $_SESSION['user_Email'];?><!--</i>-->
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="Dashboard.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
<!--            <div class="sb-sidenav-menu-heading">Interface</div>-->
<!--            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">-->
<!--                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>-->
<!--                Layouts-->
<!--                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>-->
<!--            </a>-->
<!--            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">-->
<!--                <nav class="sb-sidenav-menu-nested nav">-->
<!--                    <a class="nav-link" href="#">Static Navigation</a>-->
<!--                    <a class="nav-link" href="#">Light Sidenav</a>-->
<!--                </nav>-->
<!--            </div>-->
<!--            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">-->
<!--                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>-->
<!--                Pages-->
<!--                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>-->
<!--            </a>-->
<!--            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">-->
<!--                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">-->
<!--                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">-->
<!--                        Authentication-->
<!--                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>-->
<!--                    </a>-->
<!--                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">-->
<!--                        <nav class="sb-sidenav-menu-nested nav">-->
<!--                            <a class="nav-link" href="Login.php">Login</a>-->
<!--                        </nav>-->
<!--                    </div>-->
<!--                </nav>-->
<!--            </div>-->
            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="New_Employee.php" id="employeeLink">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Employees
            </a>
            <a class="nav-link" href="New_Designation.php" id="designationLink">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Designations
            </a>
            <a class="nav-link" href="New_District.php" id="usersLink">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-house-chimney-user"></i></div>
                Districts
            </a>

            <a class="nav-link" href="New_State.php" id="usersLink">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-home"></i></div>
                States
            </a>
            <?php
        if($_SESSION['user_Type'] !='Super Admin' && $_SESSION['user_Type'] != 'Sub Admin')
            {?>
            <a class="nav-link" href="New_User.php" id="usersLink">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                Users
            </a>
            <?php }?>
            <?php
            if($_SESSION['user_Type'] !='Super Admin' && $_SESSION['user_Type'] != 'Sub Admin')
            {?>
                <a class="nav-link" href="New_Images.php" id="usersLink">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-image"></i></div>
                    Gallery
                </a>
            <?php }?>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        <?php  echo $_SESSION['user_Type']; ?>
    </div>
</nav>