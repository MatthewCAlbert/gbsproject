<?php 
    require "../include/structure.php";
    require '../include/server.php';
    require '../include/session.checker.php';
    require '../include/getuserdata.php';
    if( $user_row['level'] < 4 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; 
    require 'count.php';
    ?>
    <title>Midtrans API Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Midtrans')").addClass('active');
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
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-list-ul"></i>
                                </div>
                                <p class="card-category">View</p>
                                <h3 class="card-title">Midtrans Transaction</h3>
                            </div>
                            <div class="card-footer"> 
                                <div class="stat">
                                    <i class="fas fa-eye" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/midtrans/view">View Transaction...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-list-ul"></i>
                                </div>
                                <p class="card-category">View</p>
                                <h3 class="card-title">API Transaction Bot Logs</h3>
                            </div>
                            <div class="card-footer"> 
                                <div class="stat">
                                    <i class="fas fa-eye" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/midtrans/logs">View Logs...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <p class="card-category">Overview</p>
                                <h3 class="card-title">API Information</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stat">
                                    <i class="fas fa-info" style="margin:5px 5px 0 0;"></i> 
                                    <span>Veritrans Data Below</span>
                                </div>
                            </div>
                            <div class="container">
                                <p>Total API Hit : <?php echo number_format($total_api_hit) ?></p>
                                <p>Total API Amount : Rp <?php echo number_format($total_api_value) ?></p>
                                <p>Total Pending Transaction : <?php echo number_format($unpaid_transaction) ?></p>
                                <p>Total Verified Transaction : <?php echo number_format($paid_transaction) ?></p>
                                <p>Total Failed Transaction : <?php echo number_format($failed_transaction) ?></p>
                                <p>Total Success Transaction : <?php echo number_format($success_transaction) ?></p>
                                <p>Total Error Transaction : <?php echo number_format($error_transaction) ?></p>
                                <p>Total Unknown Transaction : <?php echo number_format($unknown_transaction) ?></p>
                                <p>Total Marked Transaction : <?php echo number_format($marked_transaction) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-list-ul"></i>
                                </div>
                                <p class="card-category">Scheduler</p>
                                <h3 class="card-title">API Cron Job</h3>
                            </div>
                            <div class="card-footer"> 
                                <div class="stat">
                                    <i class="fas fa-eye" style="margin:5px 5px 0 0;"></i> 
                                    <a href="javascript:void(0)" onclick="forceSchedule()">Force Process...</a>
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
<script>
function forceSchedule(){
    $.ajax({
            url: 'http://192.168.100.14:8080/gbs-api/sc/index.php',//'http://api.gbsproject.ga/sc/index.php',
            method: 'POST',
            crossDomain: true,
            dataType: 'text',
            data: {
                send: 1,
            },
            success: function(response){
                let res = JSON.parse(response);
                let data = res['message'];
                let success = res['success'];
                alert("Response: "+success);
            }
        });
}
</script>
</html>
