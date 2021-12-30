<?php
    require "../include/structure.php";
    require '../include/server.php';
    if(isset($_SESSION['useradmin_id'])){
        require '../include/getuserdata.php';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; 
    ?>
    <title>Information Centre - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Main Menu')").addClass('active');
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
            <?php require '../include/structure/sidenav-bar-help.php'; ?>
        </div>
        <div class="main-panel">
            <?php 
                $nav_title= "Information Centre";
                if(isset($_SESSION['useradmin_id'])){
                    require '../include/structure/navbar-help.php'; 
                }else{
                    require '../include/structure/navbar-help.php'; 
                }
            ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-list-ol"></i>
                                </div>
                                <p class="card-category">Help</p>
                                <h3 class="card-title">Access Level</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i> 
                                    <a href="../information/level">View Access Info...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="far fa-question-circle"></i>
                                </div>
                                <p class="card-category">Help</p>
                                <h3 class="card-title">FAQ</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i> 
                                    <a href="../information/faq">View FAQ...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <p class="card-category">Help</p>
                                <h3 class="card-title">About Us</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i> 
                                    <a href="../information/about-us">View Info...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <p class="card-category">About</p>
                                <h3 class="card-title">Privacy and Policy</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i> 
                                    <a href="../information/privacy">View More...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                                <p class="card-category">About</p>
                                <h3 class="card-title">Disclaimer</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i> 
                                    <a href="../information/disclaimer">View More...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-default card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <p class="card-category">About</p>
                                <h3 class="card-title">Licenses</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i> 
                                    <a href="../information/licenses">View More...</a>
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
