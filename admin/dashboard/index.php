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
    ?>
    <title>Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; 
    if(isset($_GET['login'])){
        $notif_message = 'Welcome Back, '.$user_row['name'];
    ?>
    <script>
        $(document).ready(function(){
            <?php 
                echo 'showNotification("top","center","'.$notif_message.'");';
            }
            ?>
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
                                    <i class="fas fa-universal-access"></i>
                                </div>
                                <p class="card-category">Your Access Level</p>
                                <h3 class="card-title"><small>Level </small><?php echo $user_row['level']; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i> 
                                    <a href="../information/level">View Access Info...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        if($user_row['level'] >= 4){
                            echo '<div class="col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <p class="card-category">You Are</p>
                                    <h3 class="card-title">A Manager</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="fas fa-certificate" style="margin:5px 5px 0 0;"></i> 
                                        <a href="'.$main_directory.'/manager">Start Managing...</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }else{
                            switch($user_row['level']){
                                case '1':$you_are = 'Customer Service';$you_icon='<i class="fas fa-user-tie"></i>';break;
                                case '2':$you_are = 'Moderator';$you_icon='<i class="fas fa-user-ninja"></i>';break;
                                case '3':$you_are = 'Booth Administrator';$you_icon='<i class="fas fa-user-tag"></i>';break;
                            }
                            echo '<div class="col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-info card-header-icon">
                                    <div class="card-icon">
                                        '.$you_icon.'
                                    </div>
                                    <p class="card-category">You Are</p>
                                    <h3 class="card-title">A '.$you_are.'</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="fas fa-certificate" style="margin:5px 5px 0 0;"></i> 
                                        Level '.$user_row['level'].'
                                    </div>
                                </div>
                            </div>
                            </div>';
                        }
                    ?>
                </div>
                <div class="row">
                    <!-- Second Row here -->
                </div>
            </div>
            <?php require '../include/structure/footer.php'; ?>
            <script>
            $(".nav .nav-item:contains('Dashboard')").addClass('active');
            </script>
        </div>
    </div>
</body>
</html>
