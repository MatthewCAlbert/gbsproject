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
    require '../include/structure/header.php'; ?>
    <title>Account Settings - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Account Settings')").addClass('active');
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
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-warning">
                                <h4 class="card-title">Settings</h4>
                                <p class="card-category">Account</p>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <label>Username (cannot be changed!)</label><p><?php echo $user_row['username'] ?></p>
                                    <label>Name</label><p><?php echo $user_row['name'] ?></p>
                                    <label>Access Level</label><p><?php echo $user_row['level'] ?></p>
                                    <label>Status</label><p class="<?php if($user_row['status']=='active'){echo 'text-success';}else{echo 'text-danger';} ?>">
                                    <?php echo $user_row['status']; ?></p>
                                    <form action="edit.php" method="post">
                                    <button class="btn btn-primary" type="submit" name="submit" >Edit Or Change Password</button>
                                    </form>
                                </div>
                                <br>
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
