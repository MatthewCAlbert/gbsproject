<?php
    require "../include/structure.php";
    require '../include/server.php';
    require '../include/session.checker.php';
    require '../include/getuserdata.php';
    if( $user_row['level'] < 5 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; ?>
    <title>Maintenance Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
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
                                    <i class="fas fa-database"></i>
                                </div>
                                <p class="card-category">Edit</p>
                                <h3 class="card-title">Database</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/maintenance/database">Go to Database Page...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <p class="card-category">User</p>
                                <h3 class="card-title">Import</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/maintenance/import">Go to Import Page...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-file-archive"></i>
                                </div>
                                <p class="card-category">Database</p>
                                <h3 class="card-title">Back Up</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/maintenance/back-up">Go to Back Up Page...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="fab fa-google-drive"></i>
                                </div>
                                <p class="card-category">Back Up</p>
                                <h3 class="card-title">Google Drive</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="http://localhost:8080/gbs-admin/maintenance/gdrive">Go to Drive Page...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="fab fa-pied-piper-hat"></i>
                                </div>
                                <p class="card-category">Import</p>
                                <h3 class="card-title">Demo</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/maintenance/demo">Go to Demo Page...</a>
                                </div>
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
