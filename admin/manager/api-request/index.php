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
    <title>Request API - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; ?>
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
            <?php require "../../include/structure/sidenav-bar.php"; ?>
        </div>
        <div class="main-panel">
            <?php require "../../include/structure/navbar.php"; ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-success">
                                <h4 class="card-title">API Request Form</h4>
                                <p class="card-category">Manager</p>
                            </div>
                            <div class="card-body">
                                    <?php
                                        function generateRandomString($length = 10) {
                                            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                            $charactersLength = strlen($characters);
                                            $randomString = '';
                                            for ($i = 0; $i < $length; $i++) {
                                                $randomString .= $characters[rand(0, $charactersLength - 1)];
                                            }
                                            return $randomString;
                                        }
                                        $success = false;
                                        if(isset($_POST['submit'])){
                                            $username = mysqli_escape_string($conn,$_POST['username']);
                                            $type = mysqli_escape_string($conn,$_POST['type']);
                                            switch($type){
                                                case '1': $type = "app";break;
                                                case '2': $type = "device";break;
                                                case '3': $type = "web";break;
                                                default: $type = "unidentified";break;
                                            }
                                            $access = array();
                                            for( $i = 1 ; $i <= 4 ; $i++ ){
                                                if( isset($_POST['access-'.$i]) ){
                                                    array_push($access,$i);
                                                }
                                            }
                                            $access = implode(",",$access);
                                            $api_key = generateRandomString(16);
                                                $sql = "INSERT INTO `api` (`username`,`api_key`,`access`,`status`,`type`) VALUES ('$username', '$api_key', '$access', 'active','$type')";
                                                $getdata = "SELECT `username` FROM `api` WHERE `username` = '$username'";
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
