<?php 
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 4 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; ?>
    <title>Register Admin - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Manager')").addClass('active');
            var randomPwd = Math.random().toString(36).substring(2, 10);
            console.log(randomPwd);
            $(".password").val(randomPwd);
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
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-success">
                                <h4 class="card-title">Administrator Registration Form</h4>
                                <p class="card-category">Manager</p>
                            </div>
                            <div class="card-body">
                                    <?php
                                        $success = false;
                                        if(isset($_POST['submit'])){
                                            $password = mysqli_escape_string($conn,$_POST['password']);
                                            $re_password = mysqli_escape_string($conn,$_POST['re-password']);
                                            $username = mysqli_escape_string($conn,$_POST['username']);
                                            $level = mysqli_escape_string($conn,$_POST['level']);
                                            $name = mysqli_escape_string($conn,$_POST['name']);
                                            if( $password == $re_password ){
                                                $hashedPw = password_hash("$password",PASSWORD_BCRYPT);
                                                $sql = "INSERT INTO `admin` (`username`,`name`,`level`,`status`,`password`) VALUES ('$username', '$name', '$level', 'active','$hashedPw')";
                                                $getdata = "SELECT `username` FROM `admin` WHERE `username` = '$username'";
                                                $res1 = $conn->query($getdata);
                                                if( $res1 ){
                                                    if( $res1->num_rows == 0 ){
                                                        //allow input
                                                        $res = $conn->query($sql);
                                                        if( $res ){
                                                            echo "Successfully Registered!";
                                                            $success = true;
                                                        }else{
                                                            echo "Failed!";
                                                        }
                                                    } else{
                                                        echo "Cannot register existing users!";
                                                    }
                                                }else{
                                                    echo "Error!";
                                                }
                                            }
                                        }
                                    ?>
                            </div>
                            <?php 
                                if(!isset($_POST['submit'])){
                                    include 'register.php';
                                }else if( $success = true ){
                                    include 'result.php';
                                }
                            ?>
                        </div>
                    </div>    
                </div>
            </div>
            <?php require '../../include/structure/footer.php'; ?>
        </div>
    </div>
</body>
</html>
