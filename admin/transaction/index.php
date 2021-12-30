<?php 
    require "../include/structure.php";
    require '../include/server.php';
    require '../include/session.checker.php';
    require '../include/getuserdata.php';
    if( $user_row['level'] < 2 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; ?>
    <title>Transaction Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Transaction')").addClass('active');
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
                                    <i class="far fa-credit-card"></i>
                                </div>
                                <p class="card-category">Type</p>
                                <h3 class="card-title">Top Up</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/transaction/top-up">Go to Top Up Page...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <p class="card-category">Type</p>
                                <h3 class="card-title">Withdraw</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/transaction/withdraw">Go to Withdraw Page...</a>
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
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <p class="card-category">Type</p>
                                <h3 class="card-title">Pay</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/transaction/pay">Go to Pay Page...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <p class="card-category">Type</p>
                                <h3 class="card-title">Transfer</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-link" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/transaction/transfer">Go to Transfer Page...</a>
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
