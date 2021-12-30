<?php
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 5 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    ?>
    <title>Back Up Database - GBS eMoney Maintenance</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Maintenance')").addClass('active');
        });
    </script>
</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <?php require "../../include/structure/sidenav-bar.php"; ?>
        </div>
        <div class="main-panel">
            <?php require "../../include/structure/navbar.php"; ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-success">
                                <h4 class="card-title">Database Back Up</h4>
                                <p class="card-category">Maintenance</p>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <form action="getdb.php" method="post">
                                        <div class="row">
                                            <div class="col">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" value="gbsemoney-backup" required><br>
                                            </div>
                                            <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="date" value="" checked> Use Date
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Back Up Now</button>
                                    </form>
                                    <button class="btn btn-light" onclick="window.history.back()"><i class="material-icons">arrow_back_ios</i>Back</button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <?php require '../../include/structure/footer.php'; ?>
        </div>
    </div>
</body>
</html>
