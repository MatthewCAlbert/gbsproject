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
    <title>Withdraw - GBS eMoney Admin</title>
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
                            <div class="card-header card-chart card-header-warning">
                                <h4 class="card-title">Withdrawal Form</h4>
                                <p class="card-category">Transaction</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                    <?php
                                        if(isset($_POST['submit'])){
                                            $by = mysqli_escape_string($conn,$_POST['by']);
                                            $id = mysqli_escape_string($conn,$_POST['id']);
                                            
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
                                                header('Location: ../withdraw?warning=minimum-value-Rp-1.000');
                                                exit();
                                            }
                                            
                                            $status = false;

                                            //check user existence
                                            $sql = "SELECT * FROM `student` WHERE `$by`='$id'";
                                            $res = $conn->query($sql);
                                            if( $res->num_rows > 0 ){
                                                $status = 'student';
                                                $row = mysqli_fetch_array($res);
                                            }
                                            $sql = "SELECT * FROM `teacher` WHERE `$by`='$id'";
                                            $res = $conn->query($sql);
                                            if( $res->num_rows > 0 ){
                                                $status = 'teacher';
                                                $row = mysqli_fetch_array($res);
                                            }
                                            $sql = "SELECT * FROM `vendor` WHERE `$by`='$id'";
                                            $res = $conn->query($sql);
                                            if( $res->num_rows > 0 ){
                                                $status = 'vendor';
                                                $row = mysqli_fetch_array($res);
                                            }

                                            //Withdraw Functions
                                            if($status != false){
                                                if( $row['status'] == 'banned' ){
                                                    header('Location: ../withdraw?warning=target-user-is-banned');
                                                    exit();
                                                }
                                                $current_balance = $row['balance'];
                                                if( $current_balance >= $value ){
                                                    $new_balance = $current_balance - $value;

                                                    $sql = "UPDATE `$status` SET `balance`='$new_balance' WHERE `$by`='$id'";
                                                    $res = $conn->query($sql);
                                                    $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('".$row['id']."','$new_balance')";
                                                    $res11 = $conn->query($sql);
                                                    
                                                    if( $res ){
                                                        echo '<p class="alert alert-success">Withdrawal Success! (Rp '.number_format($value).') ( Lefted : Rp '.number_format($new_balance).' ) ( '.$row['name'].' )</p>';
                                                        $desc = 'Withdrawal Success!';
                                                        $request_res = 'success';
                                                        if( !$res11 ){
                                                            $desc.= ' (Balance History not Updated)';
                                                        }
                                                    }else{
                                                        $desc = 'Withdraw Failed';
                                                        echo '<p class="alert alert-danger">'.$desc.'</p>';
                                                        $request_res = 'failed';
                                                    }
                                                }else{
                                                    $desc = 'Balance not Enough!';
                                                    echo '<p class="alert alert-warning">'.$desc.'</p>';
                                                    $request_res = 'failed';
                                                }

                                                //make receipt(session)
                                                $id = $row['id'];
                                                $where = 'admin-site';
                                                $admin_username = $user_row['username'];
                                                $sql = "INSERT INTO `transaction`(`type`,`sender`,`receiver`,`value`,`description`,`status`,`machine_id`) VALUES 
                                                ('Withdraw','$where','$id','$value','$desc','$request_res','$admin_username') ";
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
                                            <label>ID / RFID Card ID</label>
                                            <input class="form-control" type="text" name="id" required><br>
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
