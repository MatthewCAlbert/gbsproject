<?php
require "../include/structure.php";
require '../include/server.php';
require '../include/session.checker.php';
require '../include/getuserdata.php';

//revenue counter
$sql = "SELECT `balance` FROM `student` UNION
 SELECT `balance` FROM `teacher` UNION 
 SELECT `balance` FROM `vendor`";
$res = $conn->query($sql);
$balance_counter = 0;
if($res){
    if( $res->num_rows > 0 ){
        while( $row = mysqli_fetch_array($res) ){
            $balance_counter += (int)$row['balance'];
        }
    }
}

$sql = "SELECT `value` FROM `transaction` WHERE `type`='Top Up' AND `status`='success'";
$res = $conn->query($sql);
$topup_counter = 0;
if($res){
    if( $res->num_rows > 0 ){
        while( $row = mysqli_fetch_array($res) ){
            $topup_counter += (int)$row['value'];
        }
    }
}
$sql = "SELECT `value` FROM `transaction` WHERE `type`='Withdraw' AND `status`='success'";
$res = $conn->query($sql);
$withdrawal_count = 0;
if($res){
    if( $res->num_rows > 0 ){
        while( $row = mysqli_fetch_array($res) ){
            $withdrawal_count += (int)$row['value'];
        }
    }
}
$sql = "SELECT `value` FROM `transaction` WHERE `type`='Pay' AND `status`='success'";
$res = $conn->query($sql);
$pay_count = 0;
if($res){
    if( $res->num_rows > 0 ){
        while( $row = mysqli_fetch_array($res) ){
            $pay_count += (int)$row['value'];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; ?>
    <title>Analytics Dashboard - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Analytics')").addClass('active');
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
                                    <i class="fas fa-universal-access"></i>
                                </div>
                                <p class="card-category">In Revenue</p>
                                <h3 class="card-title">Rp <?php echo number_format($balance_counter,0,",",".").",-"; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i>
                                    <span>Total money stored on the system.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-universal-access"></i>
                                </div>
                                <p class="card-category">Total Payment</p>
                                <h3 class="card-title" id="payment">Rp <?php echo number_format($pay_count,0,",",".").",-"; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i>
                                    <span>Total money users spent on the system.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-universal-access"></i>
                                </div>
                                <p class="card-category">Total Withdrawal</p>
                                <h3 class="card-title" id="withdraw">Rp <?php echo number_format($withdrawal_count,0,",",".").",-"; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i>
                                    <span>Total money that have been retrieved from the system.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="fas fa-universal-access"></i>
                                </div>
                                <p class="card-category">Total Topup</p>
                                <h3 class="card-title" id="topup">Rp <?php echo number_format($topup_counter,0,",",".").",-"; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="fas fa-info-circle" style="margin:5px 5px 0 0;"></i>
                                    <span>Total money that have been topped to the system.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                        <div class="card-header card-chart card-header-info">
                            <div class="ct-chart" id="dailySalesChart"></div>
                        </div>  
                        <div class="card-body">
                            <h4 class="card-title">Daily Contributon</h4>
                            <p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 55%  </span> increase in today sales.</p>
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
                        }
                    ?>
                </div>
            </div>
            <?php require '../include/structure/footer.php'; ?>
        </div>
    </div>
    <script>
            function getData(a_type,a_range,a_month=0,a_year=0){
                //$('#loading').show();
                let res = "";
                let api_name = "analytics";
                let api_pwd = "597YnJrZCMX7nIqP";
                $.ajax({
                    url: '<?php echo $api_directory."/web/analytics/index.php"; ?>',
                    method: 'POST',
                    dataType: 'application/json',
                    data: {
                        username:api_name,
                        key:api_pwd,
                        type:a_type,
                        range:a_range,
                        month:a_month,
                        year:a_year,
                    },
                    error: function(data){
                        res = JSON.parse(data["responseText"]);
                        $("#"+a_type).html("Rp "+res["message"]+",-");
                    }
                });
            }
    </script>
</body>
</html>
