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
    require '../../include/structure/header.php'; ?>
    <title>Edit Database - GBS eMoney Maintenance</title>
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
                            <div class="card-header card-chart card-header-warning">
                                <h4 class="card-title">Database Edit</h4>
                                <p class="card-category">Maintenance</p>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <form method="post" id="modify-database" action="select.php">
                                        <label>Action: </label>
                                        <select id="db-edit-select" onclick="changeAction()" class="form-control">
                                            <option value="select">Select</option>
                                            <option value="update">Update</option>
                                            <option value="delete">Delete</option>
                                        </select><br>
                                        <label>Arguements</label>
                                        <input type="text" name="req" class="form-control" placeholder="Arguements here.." required><br>
                                        <label>Additional</label>
                                        <input type="text" name="additional" class="form-control" placeholder="Optinal"><br>
                                        <label>Status</label><br>
                                        <select name="status" class="form-control">
                                            <option value="student">Student</option>
                                            <option value="teacher">Teacher/Staff</option>
                                            <option value="vendor">Vendor</option>
                                        </select><br><br>
                                        <label>Password</label>
                                        <input type="text" name="password" class="form-control" placeholder="Optional.."><br>
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    <button class="btn btn-light" onclick="window.history.back()"><i class="material-icons">arrow_back_ios</i>Back</button>
                                    <br><br>
                                    <div class="row container">
                                        <h5>Logs</h5>
                                        <div class="container" style="background-color:rgba(0,0,0,0.05);padding:20px;">
                                        <?php
                                            if(isset($_SESSION['report'])){
                                                if($_SESSION['report'] == 'Lefted Balance'){
                                                    $their_balance = $_SESSION['their_balance'];
                                                    $still_have_balance = $_SESSION['still_have_balance'];
                                                    $left_balance = $_SESSION['left_balance'];
                                                    echo 'Total Remaining Balance Haven\'t Withdrawed : '.$left_balance;
                                                    echo '<br>';
                                                    for($i = 0 ; $i < count($still_have_balance) ; $i++){
                                                        echo $still_have_balance[$i].': '.$their_balance[$i];
                                                    }
                                                    $_SESSION['report'] = null;
                                                    $_SESSION['their_balance'] = null;
                                                    $_SESSION['still_have_balance'] = null;
                                                    $_SESSION['left_balance'] = null;
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div><br>
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
