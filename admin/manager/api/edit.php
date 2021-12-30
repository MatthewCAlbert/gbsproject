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
    <title>Edit API - GBS eMoney Admin</title>
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
                                <h4 class="card-title">API Access Edit</h4>
                                <p class="card-category">Manager</p>
                            </div>
                            <div class="card-body">
                            <?php 
                                if(isset($_POST['submit'])){
                                    $username = mysqli_escape_string($conn,$_POST['username']);
                                    $api_key = mysqli_escape_string($conn,$_POST['api-key']);
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
                                    $allow = true;
                                    if(!$allow){ echo 'Cannot delete yourself!';}
                                    else{
                                        if($user_row['level'] >=4 ){ //prevent lower user from changing upper level
    
                                            //change status ban unban
                                            if(isset($_POST['switch-status'])){
                                                $sql = "SELECT `status` FROM `api` WHERE `username`='$username'";
                                                $res = $conn->query($sql);
                                                $row = mysqli_fetch_array($res);
                                                if( $row['status'] == 'banned' ){
                                                    $newstatus = 'active';
                                                }else{
                                                    $newstatus = 'banned';
                                                }
    
                                                $sql = "UPDATE `api` SET `status`='$newstatus' WHERE `username`='$username'";
                                                $res = $conn->query($sql);
                                                if( $res ){
                                                    echo 'Status Switched';
                                                } else{
                                                    echo 'Failed';
                                                }
                                            }
    
                                            $sql = "UPDATE `api` SET `access`='$access',`api_key`='$api_key' WHERE `username`='$username' ";
                                            $conn->query($sql);
    
                                            //delete account
                                            if(isset($_POST['delete-account'])){
                                                $sql = "DELETE FROM `api` WHERE `username`='$username'";
                                                $res = $conn->query($sql);
                                                if( $res ){
                                                    echo 'Access Deleted';
                                                } else{
                                                    echo 'Failed';
                                                }
                                            }
                                        }
                                    }

                                }
                                if(isset($_GET['username'])){
                                    $username = mysqli_escape_string($conn,$_GET['username']);
                                    $sql = "SELECT * FROM `api` WHERE `username`='$username'";
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
                            
                            <form action="edit.php?username=<?php if(isset($_GET['username'])){echo $_GET['username'];} ?>" method="post">

                                <label>Username</label>
                                <p style="font-size:1.2em;"><?php if(isset($_GET['username'])){echo $row['username'];} ?></p><br>
                                <h6>Allowed Access</h6>
                                        <input type="checkbox" name="access-1" id="a" />
                                        <label for="a">Retrieve User Data</label><br>
                                        <input type="checkbox" name="access-2" id="b" />
                                        <label for="b">Retrieve Admin Data</label><br>
                                        <input type="checkbox" name="access-3" id="c" />
                                        <label for="c">Top Up</label><br>
                                        <input type="checkbox" name="access-4" id="d" />
                                        <label for="d">Transaction</label>
                                    <br>
                                    <br>
                                <label>Type</label>
                                        <select name="type" class="form-control" required>
                                            <option value="1">App</option>
                                            <option value="2">Device</option>
                                            <option value="3">Web</option>
                                        </select>
                                <br>
                                <?php
                                if(isset($_GET['username'])){
                                    $access = $row['access'];
                                    $access = explode(",",$access);
                                    $script = "";
                                    foreach($access as $i){
                                        $script .= '$("input[name=access-'.$i.']").prop("checked",true);';
                                    }
                                    //$sy = '$("form select[name=level] > option[value='.$level.']").prop("selected",true);';
                                    echo '<script>'.$script.'</script>';
                                    $type = $row['type'];
                                    switch($type){
                                        case 'device': $script = '$("select[name=type] > option[value=2]").prop("selected",true);';break;
                                        case 'app': $script = '$("select[name=type] > option[value=1]").prop("selected",true);';break;
                                    }
                                    echo '<script>'.$script.'</script>';
                                }
                                ?>
                                <label>API Key</label>
                                <button type="button" id="keyview" style="font-size:.8em;border-radius:5px;padding:2px 3px;cursor:pointer;" onclick="toggleKey()">Show Key</button>
                                <input type="password" name="api-key" value="<?php if(isset($_GET['username'])){echo $row['api_key'];} ?>" class="form-control" required/>
                                <br>
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
                                <button type="button" class="btn btn-danger" onclick="toggleEditForm('delete')">Delete API</button>
                                <br><p id="del-stat" class="alert alert-warning hide">THIS API ACCESS WILL BE DELETED!</p>

                                <!-- Hidden Checkboxes -->
                                <input type="text" name="username" value="<?php if(isset($_GET['username'])){echo $row['username'];} ?>" hidden>
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
                                                <p class="delete alert alert-danger hide">API Access will be deleted!</p>
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
<script>
    function toggleKey(){
        if($('input[name=api-key]').prop("type")=="text"){
            $('#keyview').html("Show Key");
            $('input[name=api-key]').prop("type","password");
        }else{
            $('#keyview').html("Hide Key");
            $('input[name=api-key]').prop("type","text");
        }
    }
</script>
</html>
