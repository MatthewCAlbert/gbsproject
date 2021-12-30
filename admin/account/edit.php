<?php
require "../include/structure.php";
require '../include/server.php';
require '../include/session.checker.php';
require '../include/getuserdata.php';
if(!isset($_POST['submit'])){
    header('Location: ../account');
    exit();
}
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
                                <h4 class="card-title">Edit Settings</h4>
                                <p class="card-category">Account</p>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <form action="edit.php" method="post">
                                    <label>Username (cannot be changed!)</label><p><?php echo $user_row['username']; ?></p>
                                    <label>Access Level</label><p><?php echo $user_row['level'] ?></p>
                                    <label>Status</label><p class="<?php if($user_row['status']=='active'){echo 'text-success';}else{echo 'text-danger';} ?>">
                                    <?php echo $user_row['status']; ?></p>
                                    <label>Name</label><input type="text" name="name" class="form-control" value="<?php echo $user_row['name']; ?>"><br>
                                    <button class="btn btn-primary" type="submit" name="submit" >Edit</button>
                                    </form><br>
                                    <button class="btn btn-warning"data-toggle="modal" data-target="#passwordModal">Change Password</button>
                                    <?php
                                        if(isset($_POST['submit'])){
                                            $username = $user_row['username'];
                                            if(isset($_POST['current_password'])){
                                                $old_pass = $_POST['current_password'];
                                                $new_pass = $_POST['new_password'];
                                                $re_pass = $_POST['re_password'];
                                                if( password_verify("$old_pass",$user_row['password']) ){
                                                    if( $new_pass == $re_pass ){
                                                        $hashedPw = password_hash("$new_pass",PASSWORD_BCRYPT);
                                                        $sql = "UPDATE `admin` SET `password`='$hashedPw' WHERE `username`='$username'";
                                                        if($conn->query($sql)){
                                                            echo "Password Successfully Changed!";
                                                        }else{
                                                            echo "Failed!";
                                                        }
                                                    }else{
                                                        echo "Password mismatch!";
                                                    }
                                                }else{
                                                    echo "Wrong password!";
                                                }
                                            }
                                            if(isset($_POST['name'])){
                                                $name = $_POST['name'];
                                                $sql = "UPDATE `admin` SET `name`='$name' WHERE `username`='$username'";
                                                if($conn->query($sql)){
                                                    echo "Name Successfully Changed!";
                                                }else{
                                                    echo "Failed!";
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="edit.php" method="post">
                                            <label>Current Password</label>
                                            <input type="password" name="current_password" maxlength="32" class="form-control">
                                            <label>New Password</label>
                                            <input type="password" name="new_password" minlength="8" maxlength="32" class="form-control"  title="Please enter between 8-32 characters. Excluding < > (non UTF-8 unicode)" oninvalid="this.setCustomValidity('Please enter between 8-32 characters.  Excluding < > (non UTF-8 unicode)')" oninput="this.setCustomValidity('')" required />
                                            <label>Retype Password</label>
                                            <input type="password" name="re_password" minlength="8" maxlength="32" class="form-control" title="Please repeat the password." oninvalid="this.setCustomValidity('Please repeat the password above.')" oninput="this.setCustomValidity('')" required />
                                            <br>
                                            <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
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
