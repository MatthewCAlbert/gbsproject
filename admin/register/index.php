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
    <title>Register - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Register')").addClass('active');
            var randomPwd = Math.random().toString(36).substring(2, 10);
            console.log(randomPwd);
            $("#password").val(randomPwd);
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
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
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-success">
                                <h4 class="card-title">User Registration Form</h4>
                                <p class="card-category">Register</p>
                            </div>
                            <div class="card-body">
                                    <?php
                                        $success = false;
                                        if(isset($_POST['submit'])){
                                            $password = $_POST['password'];
                                            $id = $_POST['id'];
                                            $target = $_POST['target'];
                                            $name = $_POST['name'];
                                            $card_id = $_POST['card_id'];
                                            $hashedPw = password_hash("$password",PASSWORD_BCRYPT);
                                            $sql = "INSERT INTO `$target` (id, card_id, `status`, `name`, balance, `password`) VALUES ('$id', '$card_id', 'active', '$name',0,'$hashedPw')";
                                            $getdata = "SELECT id, card_id FROM vendor WHERE id = $id OR card_id = '$card_id' 
                                                UNION SELECT id, card_id FROM student WHERE id = $id OR card_id = '$card_id' 
                                                UNION SELECT id, card_id FROM teacher WHERE id = $id OR card_id = '$card_id' 
                                            ";
                                            $res1 = $conn->query($getdata);
                                            if( $res1->num_rows < 1 ){
                                                //allow input
                                                $res = $conn->query($sql);
                                                if( $res ){
                                                    echo "Successfully Registered!";
                                                    $success = true;
                                                }else{
                                                    echo "Failed!";
                                                }
                                            }else{
                                                echo "Cannot register existing RFID or ID!";
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
            <?php require '../include/structure/footer.php'; ?>
        </div>
    </div>
</body>
</html>
