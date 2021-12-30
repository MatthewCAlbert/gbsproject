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
    require 'count.php'; ?>
    <title>Manager Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Manager')").addClass('active');
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
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="fab fa-connectdevelop"></i>
                                </div>
                                <p class="card-category">Account</p>
                                <h3 class="card-title">Admin Manager</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/manager/admin">Go to Admin Manager Page...</a>
                                </div>
                            </div>
                            <div class="container">
                                <h4>Total Registered Administrator: <?php echo $total_admin ?></h4>
                                <p>Level 1: <?php echo $level_count[1] ?></p>
                                <p>Level 2: <?php echo $level_count[2] ?></p>
                                <p>Level 3: <?php echo $level_count[3] ?></p>
                                <p>Level 4: <?php echo $level_count[4] ?></p>
                                <p>Level 5: <?php echo $level_count[5] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="fab fa-connectdevelop"></i>
                                </div>
                                <p class="card-category">API</p>
                                <h3 class="card-title">API Manager</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/manager/api">Go to API Manager Page...</a>
                                </div>
                            </div>
                            <div class="container">
                                <h4>Total Registered API: <?php echo $api_count ?></h4>
                                <p>App: <?php echo $type_count['app'] ?></p>
                                <p>Device: <?php echo $type_count['device'] ?></p>
                                <p>Web: <?php echo $type_count['web'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                                <p class="card-category">Account</p>
                                <h3 class="card-title">Register</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/manager/register">Go to Register Admin Page...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                                <p class="card-category">API</p>
                                <h3 class="card-title">Request</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/manager/api-request">Go to API Request Page...</a>
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
