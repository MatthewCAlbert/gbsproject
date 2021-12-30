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
    <title>Search Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('View')").addClass('active');
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
                                    <i class="fas fa-users"></i>
                                </div>
                                <p class="card-category">View</p>
                                <h3 class="card-title">Users</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stat">
                                    <i class="fas fa-eye" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/search/user">View Users...</a>
                                </div>
                            </div>
                            <div class="container">
                                <h4>Total Registered Users: <?php echo $total_user ?></h4>
                                <p>Registered Student: <?php echo $student_count ?></p>
                                <p>Registered Teacher: <?php echo $teacher_count ?></p>
                                <p>Registered Vendor: <?php echo $vendor_count ?></p>
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
                                <h3 class="card-title">Transaction</h3>
                            </div>
                            <div class="card-footer"> 
                                <div class="stat">
                                    <i class="fas fa-eye" style="margin:5px 5px 0 0;"></i> 
                                    <a href="<?php echo $main_directory; ?>/search/session">View Transaction...</a>
                                </div>
                            </div>
                            <div class="container">
                                <h4>Total Transaction Count: <?php echo $total_transaction ?></h4>
                                <p>Top Up Count: <?php echo $top_up_count ?></p>
                                <p>Withdrawal Count: <?php echo $withdraw_count ?></p>
                                <p>Pay Count: <?php echo $pay_count ?></p>
                                <p>Transfer Count: <?php echo $transfer_count ?></p>
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
