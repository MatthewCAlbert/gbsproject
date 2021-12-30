<?php
require "../../include/structure.php";
require '../../include/server.php';
require '../../include/session.checker.php';
require '../../include/getuserdata.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    require 'search.php';
    ?>
    <title>Help Desk Search - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Help Desk')").addClass('active');
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
                            <div class="card-header card-chart card-header-info">
                                <h4 class="card-title">Message View</h4>
                                <p class="card-category">Help Desk</p>
                            </div>
                            <div class="card-body">
                                <?php
                                    if(isset($_GET['id'])){
                                        $id = $_GET['id'];
                                        $sql = "SELECT * FROM `help` WHERE `id`='$id'";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row = mysqli_fetch_array($result);
                                        }else{
                                            echo"No such help ID exist!";
                                        }
                                        $userid = $row['account_id'];
                                        $sql2 = "SELECT `name` FROM `student` WHERE `id`='$userid'
                                        UNION SELECT `name` FROM `teacher` WHERE `id`='$userid'
                                        UNION SELECT `name` FROM `vendor` WHERE `id`='$userid'
                                        ";
                                        $name = mysqli_fetch_array($conn->query($sql2));
                                ?>
                            </div>
                            <div class="container">
                                <label>Help ID : </label><span> <?php echo $row['id']  ?></span><br>
                                <label>Type : </label><span> <?php echo $row['type']  ?></span><br>
                                <label>User ID : </label><span> <?php echo $row['account_id'] ?></span><br>
                                <label>Name : </label><span> <?php echo $name['name'] ?></span><br>
                                <label>Email : </label><span> <?php echo $row['email'] ?></span><br>
                                <label>Title : </label><span> <?php echo $row['title'] ?></span><br>
                                <label>Description : </label>
                                <textarea class="form-control" cols="40" rows="6" readonly style="padding:10px;"><?php echo $row['description'] ?></textarea>
                                <br>
                                <label>Status : </label><?php 
                                    switch( $row['status'] ){
                                        case 'unread': echo '<span style="color:grey;"><b> ';break;
                                        case 'replied': echo '<span style="color:orange;"><b> ';break;
                                        case 'solved': echo '<span style="color:green;"><b> ';break;
                                        default : echo '<span style="color:black;"><b> ';break;
                                    }
                                    echo $row['status']."</b></span>"; 
                                ?><br>
                                <button class="btn btn-primary" onclick="window.history.back()" ><i class="material-icons">arrow_back_ios</i>Back</button>
                                <div class="hr hr-40"></div><br>
                                    <form method="post" action="view.php?id=<?php echo $row['id'];  ?>">
                                        <h5>Update Status</h5>
                                        <div class="row">
                                        <div class="col-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="unread">Unread</option>
                                            <option value="replied">Replied</option>
                                            <option value="solved">Solved</option>
                                        </select></div>
                                        <div class="col">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        </div></div>
                                    </form><br>
                                    <?php 
                                        if(isset($_POST["status"])){
                                            $newstatus=$_POST["status"];
                                            $sql = "UPDATE `help` SET `status`='$newstatus' WHERE `id`='$id'";
                                            if ($conn->query($sql) === TRUE) {
                                                echo '<span class="alert alert-success">Help Status Successfully Updated!</span><br><br>';
                                            } else {
                                                echo "Error: " . $x . "<br><br>" . $conn->error;
                                            }           
                                        }
                                        echo '<script>$("#status option[value='.$row['status'].']").prop("selected",true);</script>';
                                    ?>
                                    <div class="hr hr-40"></div><br>
                                    <form id="process" method="post" action="<?php $main_directory ?>/mailer/index.php">
                                        <input type="hidden" name="redirect" value="../../help/index.php" hidden>
                                        <h5>Email</h5>
                                        <input name="email" type="email" style="width:300px;" class="form-control" value="<?php echo $row['email']; ?>" readonly>
                                        <br><br><h5>Title</h5><input name="title" type="text" class="form-control" value="Re: <?php echo $row['title'] ?>" style="width:300px;"><br>
                                        <br><br>
                                        <h5>Reply Message</h5>
                                        <textarea class="form-control" name="reply-text" value="" style="width:100%;" cols="40" rows="5" placeholder="Your reply here.."></textarea>
                                        <br><button type="submit" class="btn btn-primary">Send</button>
                                    </form><br>
                            </div><br>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php require "../../include/structure/footer.php"; ?>
        </div>
    </div>
</body>
</html>
