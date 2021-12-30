<?php 
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 4 ){
        header("Location: $main_directory/error/403");
        exit();
    }
    $title = "Not Found";
    $verified = false;
    $row = "";
    if( isset($_GET['id']) ){
        $title = $_GET['id'];
        $sql = "SELECT * FROM `veritrans` WHERE `id`='$title'";
        $res = $conn->query($sql);
        if($res){
            if( $res->num_rows>0){
                $row=mysqli_fetch_assoc($res);
                $verified = true;
            }else{

            }
        }

    }else{
        header("Location: ../log");
        exit();
    }
    function checkStatus($who){
        global $conn;
        $status = "";
        $sql = "SELECT * FROM `student` WHERE `id`='$who'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            $status = "student";
        }
        $sql = "SELECT * FROM `teacher` WHERE `id`='$who'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            $status = "teacher";
        }
        $sql = "SELECT * FROM `vendor` WHERE `id`='$who'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            $status = "vendor";
        }
        return $status;
    }
    function checkWho($id,$status){
        global $conn;
        $who = "--";
        $sql = "SELECT * FROM `$status` WHERE `id`='$id'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            $row=mysqli_fetch_assoc($result);
            $who=$row['name'];
        }
        return $who;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    ?>
    <title>View Midtrans Transaction Order - GBS eMoney Admin</title>
    <?php require "../../include/structure/script.php"; ?>
    <script>
        var passreset = false;
        var deleteaccount = false;
        var banning = false;
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
            <?php require "../../include/structure/sidenav-bar.php"; ?>
        </div>
        <div class="main-panel">
            <?php require "../../include/structure/navbar.php"; ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-rose">
                                <h4 class="card-title">Transaction Order #<?php echo $title; ?></h4>
                                <p class="card-category">Midtrans Transaction</p>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                <?php
                                    if( $row != "" && $verified == true ){
                                        
                                ?>
                                    <label for="id">ID</label><h5><?php echo $row['id']; ?></h5>
                                    <label for="type">Type</label><h5><?php echo $row['type']; ?></h5>
                                    <label for="uid">User ID</label><h5><?php echo $row['user_id']." (".checkWho($row['user_id'],checkStatus($row['user_id'])).")"; ?></h5>
                                    <label for="value">Value</label><h5>Rp <?php echo number_format($row['value']); ?></h5>
                                    <label for="status">Status</label><h5><?php echo $row['status']; ?></h5>
                                <?php
                                    }
                                ?>
                                <br>
                                <h4><b>Respond</b></h4>
                                <p><i>Not Available Yet.</i></p>
                                </form>
                            </div>
                            <div class="card-footer">
                            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php require "../../include/structure/footer.php"; ?>
        </div>
    </div>
</body>
<script>
</script>
</html>
