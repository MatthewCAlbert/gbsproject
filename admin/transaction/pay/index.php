<?php 
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 2 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    ?>
    <title>Pay - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Transaction')").addClass('active');
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
                                <h4 class="card-title">Pay Form</h4>
                                <p class="card-category">Transaction</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                    <?php
                                        if(isset($_POST['submit'])){
                                            $by = mysqli_escape_string($conn,$_POST['by']);
                                            $sender = mysqli_escape_string($conn,$_POST['sender']);
                                            $receiver = mysqli_escape_string($conn,$_POST['receiver']);
                                            
                                            $value = '';
                                            $value_raw = mysqli_escape_string($conn,$_POST['value']);
                                            $values_raw = explode('.',$value_raw);
                                            foreach( $values_raw as $value_part ){
                                                $value .= "$value_part";
                                            } 
                                            $value = (int)$value;
                                            if( $value < 0 ){
                                                $value = -$value;
                                            }
                                            
                                            if( $value < 1000 ){
                                                header('Location: ../pay?warning=minimum-value-Rp-1.000');
                                                exit();
                                            }
                                            
                                            $status1 = false;
                                            $status2 = false;

                                            //check sender existence
                                            $sql = "SELECT * FROM `student` WHERE `$by`='$sender'";
                                            $res = $conn->query($sql);
                                            if( $res->num_rows > 0 ){
                                                $status1 = 'student';
                                                $row1 = mysqli_fetch_array($res);
                                            }
                                            $sql = "SELECT * FROM `teacher` WHERE `$by`='$sender'";
                                            $res = $conn->query($sql);
                                            if( $res->num_rows > 0 ){
                                                $status1 = 'teacher';
                                                $row1 = mysqli_fetch_array($res);
                                            }
                                            $sql = "SELECT * FROM `vendor` WHERE `$by`='$sender'";
                                            $res = $conn->query($sql);
                                            if( $res->num_rows > 0 ){
                                                $status1 = 'vendor';
                                                $row1 = mysqli_fetch_array($res);
                                            }

                                            //check receiver existence
                                            $sql = "SELECT * FROM `vendor` WHERE `$by`='$receiver'";
                                            $res = $conn->query($sql);
                                            if( $res->num_rows > 0 ){
                                                $status2 = 'vendor';
                                                $row2 = mysqli_fetch_array($res);
                                            }
                                            
                                            //Transfer Functions
                                            if($status1 != false && $status2 != false){
                                                if( $row1['status'] == 'banned' ){
                                                    header('Location: ../pay?warning=sender-user-is-banned');
                                                    exit();
                                                }
                                                if( $row2['status'] == 'banned' ){
                                                    header('Location: ../pay?warning=target-user-is-banned');
                                                    exit();
                                                }
                                                $current_balance_sender = $row1['balance'];
                                                $current_balance_receiver = $row2['balance'];
                                                if( $current_balance_sender >= $value ){
                                                    $new_balance_sender = $current_balance_sender - $value;
                                                    $new_balance_receiver = $current_balance_receiver + $value;

                                                    $sql = "UPDATE `$status1` SET `balance`='$new_balance_sender' WHERE `$by`='$sender'";
                                                    $res1 = $conn->query($sql);
                                                    $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('".$row1['id']."','$new_balance_sender')";
                                                    $res11 = $conn->query($sql);

                                                    $sql = "UPDATE `vendor` SET `balance`='$new_balance_receiver' WHERE `$by`='$receiver'";
                                                    $res2 = $conn->query($sql);
                                                    $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('".$row2['id']."','$new_balance_receiver')";
                                                    $res22 = $conn->query($sql);

                                                    if( $res1 && $res2 ){
                                                        echo '<p class="alert alert-success">Pay Success! (Rp '.number_format($value).')( '.$row1['name'].' to '.$row2['name'].' )</p>';
                                                        $desc = 'Pay Success!';
                                                        $request_res = 'success';
                                                        if( !$res11 || !$res22 ){
                                                            $desc.= ' (Balance History not Updated)';
                                                        }
                                                    }else{
                                                        $desc = 'Pay Failed';
                                                        echo '<p class="alert alert-danger">'.$desc.'</p>';
                                                        $request_res = 'failed';
                                                    }
                                                }else{
                                                    $desc = 'Balance not Enough!';
                                                    echo '<p class="alert alert-warning">'.$desc.'</p>';
                                                    $request_res = 'failed';
                                                }

                                                //make receipt(session)
                                                $sd = $row1['id'];
                                                $rc = $row2['id'];
                                                $where = 'admin-site';
                                                $admin_username = $user_row['username'];
                                                $sql = "INSERT INTO `transaction`(`type`,`sender`,`receiver`,`value`,`description`,`status`,`machine_id`) VALUES 
                                                ('Transfer','$sd','$rc','$value','$desc','$request_res','$admin_username') ";
                                                $res = $conn->query($sql);
                                                if( $res ){
                                                    echo '<p class="alert alert-success">Receipt Successfully Created!</p>';
                                                }else{
                                                    echo '<p class="alert alert-danger">Receipt Creation Failed!</p>';
                                                }
                                            }else{
                                                echo '<p class="alert alert-warning">Invalid ID or RFID!</p>';
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="container">
                                        <form method="post" action="index.php" id="form">
                                                <label>By</label>
                                                <select class="form-control" name="by" id="type-filter" onchange="switchFilterOption()" required>
                                                    <option value="card_id" selected>RFID Card ID</option>
                                                    <option value="id">ID</option>
                                                </select>
                                                <br>
                                                <label>ID / RFID Card ID (Sender)</label>
                                                <input class="form-control" type="text" name="sender" required><br>
                                                <label>ID / RFID Card ID (Vendor)</label>
                                                <input class="form-control" type="text" name="receiver" required><br>
                                                <label>Value</label>
                                                <div>
                                                <input class="form-control" type="text" value="1.000" id="amount" name="value" maxlength="9" required>
                                                </div><br>
                                                <button class="btn btn-danger not-auth" type="button" id="auth-enter" onclick="authorizeEnter()">Authorize</button>
                                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                            </form>
                                            <button onclick="<?php if(isset($_POST['submit'])){echo "window.location.href = 'index.php'";}else{echo 'window.history.back()';} ?>" class="btn btn-light" type="button"><i class="material-icons">arrow_back_ios</i>Back</button>
                                            <script>applyFilterOption();</script>
                                        </div><br>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require "../../include/structure/footer.php"; ?>
        </div>
    </div>
</body>
</html>
