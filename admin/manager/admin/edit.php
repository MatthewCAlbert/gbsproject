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
    require '../../include/structure/header.php'; 
    require 'search.php';
    ?>
    <title>Edit Admin - GBS eMoney Admin</title>
    <?php require "../../include/structure/script.php"; ?>
    <script>
        var passreset = false;
        var deleteaccount = false;
        var banning = false;
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-rose">
                                <h4 class="card-title">Admin Edit</h4>
                                <p class="card-category">Manager</p>
                            </div>
                            <div class="card-body">
                            <?php 
                                if(isset($_POST['submit'])){
                                    $username = mysqli_escape_string($conn,$_POST['username']);
                                    $name = mysqli_escape_string($conn,$_POST['name']);
                                    $level = mysqli_escape_string($conn,$_POST['level']);
                                    
                                    if($username == $user_row['username']){ echo 'Cannot delete yourself!';}
                                    else{
                                        if($user_row['level'] >= $level){ //prevent lower user from changing upper level
                                            //reset password
                                            if(isset($_POST['reset-password'])){
                                                $password = mysqli_escape_string($conn,$_POST['password']);
                                                $re_password = mysqli_escape_string($conn,$_POST['re-password']);
                                                if( $password == $re_password ){
                                                    $hashedPw = password_hash("$password",PASSWORD_BCRYPT);
                                                    $sql = "UPDATE `admin` SET `password`='$hashedPw' WHERE `username`='$username' ";
                                                    $res = $conn->query($sql);
                                                    if( $res ){
                                                        echo 'Password Successfully Reset';
                                                    }else{
                                                        echo 'Reset Failed';
                                                    }
                                                }else{
                                                    echo 'Password Mismatch!';
                                                }
                                            }
    
                                            //change status ban unban
                                            if(isset($_POST['switch-status'])){
                                                $sql = "SELECT `status` FROM `admin` WHERE `username`='$username'";
                                                $res = $conn->query($sql);
                                                $row = mysqli_fetch_array($res);
                                                if( $row['status'] == 'banned' ){
                                                    $newstatus = 'active';
                                                }else{
                                                    $newstatus = 'banned';
                                                }
    
                                                $sql = "UPDATE `admin` SET `status`='$newstatus' WHERE `username`='$username'";
                                                $res = $conn->query($sql);
                                                if( $res ){
                                                    echo 'Status Switched';
                                                } else{
                                                    echo 'Failed';
                                                }
                                            }
    
                                            $sql = "UPDATE `admin` SET `name`='$name',`level`='$level' WHERE `username`='$username' ";
                                            $conn->query($sql);
    
                                            //delete account
                                            if(isset($_POST['delete-account'])){
                                                $sql = "DELETE FROM `admin` WHERE `username`='$username'";
                                                echo $sql;
                                                $res = $conn->query($sql);
                                                if( $res ){
                                                    echo 'Account Deleted';
                                                } else{
                                                    echo 'Failed';
                                                }
                                            }
                                        }
                                    }

                                }
                                if(isset($_GET['username'])){
                                    $username = mysqli_escape_string($conn,$_GET['username']);
                                    $sql = "SELECT * FROM `admin` WHERE `username`='$username'";
                                    $res = $conn->query($sql);
                                    if( !$res ){
                                        echo 'Account not found!';
                                    }
                                    $row = mysqli_fetch_array($res);
                                }
                            ?>
                            </div>
                            <div class="card-footer">
                            
                            </div>
                            <div class="container">
                            
                            <form action="edit.php?username=<?php if(isset($_GET['username'])){echo $row['username'];} ?>" method="post">

                                <label>Username</label>
                                <h6><?php if(isset($_GET['username'])){echo $row['username'];} ?></h6><br>
                                <label>Access Level</label>
                                <select name="level" class="form-control" required>
                                    <option value="1">1 (Help Desk)</option>
                                    <option value="2">2</option>
                                    <option value="3">3 (Booth)</option>
                                    <option value="4">4 (Supervisor)</option>
                                    <option value="5">5 (Master)</option>
                                </select>
                                <?php
                                if(isset($_GET['username'])){
                                    $level = $row['level'];
                                    $sy = '$("form select[name=level] > option[value='.$level.']").prop("selected",true);';
                                    echo '<script>'.$sy.'</script>';
                                }
                                ?><br>
                                <label>Status</label>
                                <?php 
                                    if ( isset($_GET['username']) ){
                                        $syntax_fixer = "'banning'";
                                        if ($row["status"] == "active"){
                                            ?><script><?php echo "var banning=false;var banned=false;"; ?></script>
                                            <?php
                                            echo '<h6 class="text-success">'.$row["status"].'</h6>';
                                            echo '<button type="button" id="ban-btn" class="btn btn-danger" onclick="toggleEditForm('.$syntax_fixer.')">Ban</button><br>';
                                        }else{
                                            ?><script><?php echo "var banning=true;var banned=true;"; ?></script>
                                            <?php
                                            echo '<h6 class="text-danger">'.$row["status"].'</h6>';
                                            echo '<button type="button" id="ban-btn" class="btn btn-success" onclick="toggleEditForm('.$syntax_fixer.')">Unban</button><br>';
                                        }   
                                    }else{
                                        echo "-";
                                    }
                                ?>
                                <br><h5>Edit Below To Change Name</h5><input type="text" name="name" value="<?php if(isset($_GET['username'])){echo $row["name"];} ?>" class="form-control">
                                <br><br><button type="button" class="btn btn-primary" onclick="toggleEditForm('reset')">Reset Password</button>
                                
                                <div id="pass-reset" class="hide col"><br>
                                    <h5>New Password</h5>
                                    <input type="password" name="password" class="form-control" value="">
                                    <h5>Retype Password</h5>
                                    <input type="password" name="re-password" class="form-control" value="">
                                </div><br>
                                
                                <button type="button" class="btn btn-danger" onclick="toggleEditForm('delete')">Delete Account</button>
                                <br><p id="del-stat" class="alert alert-warning hide">THIS ACCOUNT WILL BE DELETED!</p>

                                <!-- Hidden Checkboxes -->
                                <input type="text" name="username" value="<?php if(isset($_GET['username'])){echo $row['username'];} ?>" hidden>
                                <input type="checkbox" name="reset-password" val="" hidden>
                                <input type="checkbox" name="switch-status" val="" hidden>
                                <input type="checkbox" name="delete-account" val="" hidden>

                                <br>
                                <button onclick="<?php if(isset($_POST['username'])){echo "window.location.href = 'index.php'";}else{echo 'window.history.back()';} ?>" class="btn btn-light" type="button"><i class="material-icons">arrow_back_ios</i>Back</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">Update</button>
                                <!-- Modal -->
                                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are You Sure?</h4>
                                                <br>
                                                <p class="reset alert alert-warning hide">Password will be resetted!</p>
                                                <p class="delete alert alert-danger hide">Account will be deleted!</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Mmodal -->
                            </form>

                            </div><br>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php require "../../include/structure/footer.php"; ?>
        </div>
    </div>
</body>
</html>
