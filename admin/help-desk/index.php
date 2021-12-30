<?php
require "../include/structure.php";
require '../include/server.php';
require '../include/session.checker.php';
require '../include/getuserdata.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; 
    require 'count.php';
    ?>
    <title>Help Desk Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Help Desk')").addClass('active');
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
            <?php require '../include/structure/sidenav-bar.php'; ?>
        </div>
        <div class="main-panel">
            <?php require '../include/structure/navbar.php'; ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="far fa-chart-bar"></i>
                                </div>
                                <p class="card-category">Total</p>
                                <h3 class="card-title">Statistic</h3>
                            </div>
                            <div class="card-footer">
                            </div>
                            <div class="container">
                                <h4>Total Support: <?php echo $total_support ?></h4>
                                <p>Message Replied: <?php echo $replied_count ?></p>
                                <p>Message Unread: <?php echo $unread_count ?></p>
                                <p>Message Solved: <?php echo $solved_count ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <p class="card-category">Help</p>
                                <h3 class="card-title">Support</h3>
                            </div>
                            <div class="card-footer"> 
                                <div class="stat">
                                    <i class="fas fa-search" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/help-desk/search">Go to Help Search...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require '../include/structure/footer.php'; ?>
        </div>
    </div>
</body>
</html>
