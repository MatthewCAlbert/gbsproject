<?php 
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 3 ){
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
    <title>Edit User - GBS eMoney Admin</title>
    <?php require "../../include/structure/script.php"; ?>
    <script>
        var passreset = false;
        var deleteaccount = false;
        var banning = false;
        var rfid_change = false;
        var pinreset = false;
        $(document).ready(function(){
            $(".nav .nav-item:contains('View')").addClass('active');
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
            <?php require "../../include/structure/sidenav-bar.php"; ?>
        </div>
        <div class="main-panel">
            <?php require "../../include/structure/navbar.php"; ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-success">
                                <h4 class="card-title">User</h4>
                                <p class="card-category">Edit</p>
                            </div>
                            <div class="card-body">
                            <?php
                                $profile = 0;
                                $get_data =  0;
                                $verified = 'false';
                                // after post
                                if(isset($_POST["id"])){
                                    if( $_POST["process"] == 'true' ){
                                        $id = mysqli_escape_string($conn,$_POST["id"]);
                                        $profile = mysqli_escape_string($conn,$_POST["profile"]);
                                        $status = mysqli_escape_string($conn,$_POST["status"]);
                                        if(isset($_POST["reset-password"])){$resetstatus = 1;}else{$resetstatus = 0; }
                                        if(isset($_POST["reset-pin"])){$resetpin = 1;}else{$resetpin = 0; }
                                        $password = mysqli_escape_string($conn,$_POST["password"]);
                                        $re_password = mysqli_escape_string($conn,$_POST["re-password"]);
                                        if( isset($_POST["reset-pin"]) ){
                                            $pin = mysqli_escape_string($conn,$_POST["pin"]);
                                            $re_pin = mysqli_escape_string($conn,$_POST["re-pin"]);
                                        }
                                        $name = mysqli_escape_string($conn,$_POST["name"]);
                                        $new_rfid = mysqli_escape_string($conn,$_POST["new-rfid"]);
                                        if(isset($_POST["delete-account"])){$delete = 1;}else{$delete = 0; }
                                        if(isset($_POST["rfid-change"])){$change_rfid = 1;}else{$change_rfid = 0; }

                                        
                                        $sql = "UPDATE `$profile` SET `name`='$name' WHERE `id`='$id'";
                                        $res = $conn->query($sql);
                                        if( $res ){
                                            echo 'Name updated!';
                                        } else{
                                            echo 'Failed';
                                        }
                                        
                                        //change status ban unban
                                        if(isset($_POST['switch-status'])){
                                            $sql = "SELECT `status` FROM `$profile` WHERE `id`='$id'";
                                            $res = $conn->query($sql);
                                            $row = mysqli_fetch_array($res);
                                            if( $row['status'] == 'banned' ){
                                                $newstatus = 'active';
                                            }else{
                                                $newstatus = 'banned';
                                            }

                                            $sql = "UPDATE `$profile` SET `status`='$newstatus' WHERE `id`='$id'";
                                            $res = $conn->query($sql);
                                            if( $res ){
                                                echo 'Status Switched';
                                            } else{
                                                echo 'Failed';
                                            }
                                        }
                                        
                                        if( $resetstatus == '1' ){
                                            if( $password == $re_password ){
                                            $hashed_password = password_hash("$password",PASSWORD_BCRYPT);
                                            $update = "UPDATE `$profile` SET `name`='$name',`password`='$hashed_password' WHERE `id`='$id'";
                                            queryOrNot($conn,$update);
                                            }else{
                                                echo "Password Mismatch!";
                                            }
                                        }
                                        if( $resetpin == '1' ){
                                            if( $pin == $re_pin ){
                                                if( $pin == "" ){
                                                    $hashed_pin = $pin;
                                                }else{
                                                    $hashed_pin = password_hash("$pin",PASSWORD_BCRYPT);
                                                }
                                            $update = "UPDATE `$profile` SET `name`='$name',`pin`='$hashed_pin' WHERE `id`='$id'";
                                            queryOrNot($conn,$update);
                                            }else{
                                                echo "PIN Mismatch!";
                                            }
                                        }
                                        if( $delete == '1' ){
                                            if( $user_row['level'] >= 4 ){
                                            $update = "DELETE FROM `$profile` WHERE `id`='$id'";
                                            queryOrNot($conn,$update);
                                            }else{
                                                echo "\nIneligible to delete user!";
                                            }
                                        }


                                        //CHANGE RFID
                                        if( $change_rfid == '1'){
                                            if( $user_row['level'] >= 4 ){
                                                if( !empty($new_rfid) ){
                                                    $getdata = "SELECT id, card_id FROM vendor WHERE card_id = '$new_rfid' 
                                                        UNION SELECT id, card_id FROM student WHERE card_id = '$new_rfid' 
                                                        UNION SELECT id, card_id FROM teacher WHERE card_id = '$new_rfid' 
                                                    ";
                                                    $res1 = $conn->query($getdata);
                                                    if( $res1->num_rows < 1 ){
                                                        //allow input
                                                        $sql = "UPDATE `$profile` SET `card_id`='$new_rfid' WHERE `id`='$id'";
                                                        $res = $conn->query($sql);
                                                        if( $res ){
                                                            echo "\nRFID Successfully Changed!";
                                                        }else{
                                                            echo "\nFailed!";
                                                        }
                                                    }else{
                                                        echo "\nCannot add existing RFID or ID!";
                                                    }
                                                }else{
                                                    echo "\nCannot leave RFID blank!";
                                                }
                                            }else{
                                                echo "\nIneligible to change RFID!";
                                            }
                                        }

                                    }else{
                                        echo "Data Incorrect. Unable to Query!";
                                    }
                                }
                                //before post
                                if(isset($_GET["id"])){
                                    $id = mysqli_escape_string($conn,$_GET["id"]);
                                    $student = "SELECT  `id`,`card_id`,`name`,`status`,`email`,`pin` FROM `student` WHERE `id`='$id'";
                                    $result = $conn->query($student);
                                    if ($result) {
                                        if($result->num_rows >0 ){
                                            $profile = 'student';
                                            $get_data = mysqli_fetch_array($result);
                                            $verified = 'true';
                                        }
                                    }
                                    $student = "SELECT  `id`,`card_id`,`name`,`status`,`email`,`pin` FROM `teacher` WHERE `id`='$id'";
                                    $result = $conn->query($student);
                                    if ($result) {
                                        if($result->num_rows >0 ){
                                            $profile = 'teacher';
                                            $get_data = mysqli_fetch_array($result);
                                            $verified = 'true';
                                        }
                                    }
                                    $student = "SELECT  `id`,`card_id`,`name`,`status`,`email`,`pin` FROM `vendor` WHERE `id`='$id'";
                                    $result = $conn->query($student);
                                    if ($result) {
                                        if($result->num_rows >0 ){
                                            $profile = 'vendor';
                                            $get_data = mysqli_fetch_array($result);
                                            $verified = 'true';
                                        }
                                    }

                                }

                                //functions
                                function queryOrNot($conn,$x){
                                    if ($conn->query($x) === TRUE) {
                                        echo "";
                                    } else {
                                        echo "Error: " . $x . "<br>" . $conn->error;
                                    }
                                }
                            ?>
                            </div>
                            <div class="card-footer">
                            
                            </div>
                            <div class="container">
                            <?php if(isset($_POST["id"])){echo '<div class="alert alert-success">Data Updated!</div> ';} ?>
                            <form method="post" action="edit.php?id=<?php if(isset($_GET["id"])){echo $_GET["id"]; } ?>" >
                            <label>Name : </label>
                            <?php echo $get_data["name"]; ?><br>
                            <label>ID/NIS : </label>
                            <?php 
                                if ($verified == 'true'){switch($profile){
                                    case 'student' : echo $get_data["id"];break;
                                    case 'teacher' : echo $get_data["id"];break;
                                    case 'vendor' : echo $get_data["id"];break;
                                    default: echo "No Data";break;
                                }}else{
                                    echo "-";
                                } 
                                ?><br>
                            <label>RFID Card ID : </label>
                            <?php echo $get_data["card_id"]; ?><br>
                            <label>Profile : </label>
                            <?php echo $profile; ?><br>
                            <label>Email : </label>
                            <?php echo $get_data["email"]; ?><br>
                            <label>PIN Set : </label>
                            <?php if( $get_data['pin'] == "" ){ echo "FALSE"; }else{ echo "TRUE"; } ?><br><br>
                            <label>Status</label>
                            <?php 
                                if ($verified == 'true'){
                                    $syntax_fixer = "'banning'";
                                    if ($get_data["status"] == "active"){
                                        ?><script><?php echo "var banning=false;var banned=false;"; ?></script>
                                        <?php
                                        echo '<h6 class="text-success">'.$get_data["status"].'</h6>';
                                        echo '<button type="button" id="ban-btn" class="btn btn-danger" onclick="toggleEditForm('.$syntax_fixer.')">Ban</button><br>';
                                    }else{
                                        ?><script><?php echo "var banning=true;var banned=true;"; ?></script>
                                        <?php
                                        echo '<h6 class="text-danger">'.$get_data["status"].'</h6>';
                                        echo '<button type="button" id="ban-btn" class="btn btn-success" onclick="toggleEditForm('.$syntax_fixer.')">Unban</button><br>';
                                    }   
                                }else{
                                    echo "-";
                                }
                            ?><br>
                            <br><h5>Edit Below To Change Name</h5><input type="text" name="name" value="<?php echo $get_data["name"]; ?>" class="form-control">
                            <br><br><button type="button" class="btn btn-primary" onclick="toggleEditForm('reset')">Reset Password</button>
                            
                            <div id="pass-reset" class="hide col"><br>
                                <h5>New Password</h5>
                                <input type="password" name="password" class="form-control" pattern=".{8,32}" maxlength="32" value="">
                                <h5>Retype Password</h5>
                                <input type="password" name="re-password" class="form-control" pattern=".{8,32}" maxlength="32" value="">
                            </div><br><br>

                            
                            <?php
                                if( $get_data['pin'] != "" ){
                                    echo '
                            <button type="button" class="btn btn-primary" onclick="toggleEditForm('."'pinreset'".')">Reset PIN</button>
                            <div id="pin-reset" class="hide col"><br>
                                <h5>New PIN</h5>
                                <input type="password" name="pin" class="form-control" pattern=".{6}" maxlength="6" value="">
                                <h5>Retype PIN</h5>
                                <input type="password" name="re-pin" class="form-control" pattern=".{6}" maxlength="6" value="">
                            </div><br><br>';
                                }
                            ?>
                            
                            <?php
                                if( $user_row['level'] >= 4 ){
                                    echo '<button type="button" class="btn btn-primary" onclick="toggleEditForm('."'rfid'".')">Change RFID</button>';
                                }
                            ?>

                            <div id="new-rfid" class="hide col"><br>
                                <h5>New RFID</h5>
                                <input type="text" name="new-rfid" class="form-control" value="">
                            </div><br><br>

                            <?php
                                if( $user_row['level'] >= 4 ){
                                    echo '<button type="button" class="btn btn-danger" onclick="toggleEditForm('."'delete'".')">Delete Account</button>';
                                }
                            ?>
                            
                            <br>
                                <!-- Hidden Checkboxes -->
                                <input type="checkbox" name="reset-password" val="" hidden>
                                <input type="checkbox" name="switch-status" val="" hidden>
                                <input type="checkbox" name="delete-account" val="" hidden>
                                <input type="checkbox" name="reset-pin" val="" hidden>
                                <input type="checkbox" name="rfid-change" val="" hidden>

                            <br><p id="del-stat" class="alert alert-warning hide">THIS ACCOUNT WILL BE DELETED!</p>
                            <input type="hidden" value="<?php if($verified == 'true'){echo $verified;} ?>" name="process">
                            <input type="hidden" value="<?php if($verified == 'true'){echo $get_data["status"];} ?>" name="status">
                            <input type="hidden" value="<?php if($verified == 'true'){echo $profile;} ?>" name="profile">
                            <input type="hidden" value="<?php if($verified == 'true'){if(isset($_GET['card_id'])){echo mysqli_escape_string($conn,$_GET["card_id"]);}} ?>" name="card_id">
                            <input type="hidden" value="<?php if($verified == 'true'){if(isset($_GET['id'])){echo mysqli_escape_string($conn,$_GET["id"]);}} ?>" name="id">
                            <br>
                            <button onclick="<?php if(isset($_POST['id'])){echo "window.location.href = 'index.php'";}else{echo 'window.history.back()';} ?>" class="btn btn-light" type="button"><i class="material-icons">arrow_back_ios</i></button>
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
                                    <p class="rfid alert alert-warning hide">RFID will be changed!</p>
                                    <p class="pin alert alert-warning hide">PIN will be resetted!</p>
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
