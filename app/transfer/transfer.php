<?php
    require '../include/config.php'; 
    require '../include/server.php';  
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 
    if( $user_row['pin'] == "" ){
        header('Location: ../edit/create-pin.php');
        exit();
    }

    if(isset($_POST['submit'])){
        $captcha_verify = true;
        if( $captcha_verify == true ){
            $id = $user_row['card_id'];
            $get_desc = '';
            if(isset($_POST['id']) && isset($_POST['real-amount']) && isset($_SESSION['verified_transfer_pin']) ){
                //escape all input
                if( !$_SESSION['verified_transfer_pin'] ){
                    header('Location: ../transfer?warning=wrong-pin');
                    exit();
                }
                $by = 1;
                switch($by){
                    case '1': $by = 'id';break;
                    case '2': $by = 'card_id';break;
                }
                $sender = $user_row['id'];
                $reciever = mysqli_escape_string($conn,$_POST['id']);
                $value = '';
                $value_raw = mysqli_escape_string($conn,$_POST['real-amount']);
                $values_raw = explode('.',$value_raw);
                foreach( $values_raw as $value_part ){
                    $value .= "$value_part";
                } 
                $value = (int)$value;
    
                if( $value < 0 ){ //escape negative value
                    $value = -$value;
                }
                if( $value < 2000 ){
                    header('Location: ../transfer?warning=minimum-transfer-Rp-1.000');
                    exit();
                }
                if( $value > 1000000 ){
                    header('Location: ../transfer?warning=maximum-transfer-Rp-1.000.000');
                    exit();
                }
    
                $status2 = false;
                //check reciever existence
                $sql = "SELECT * FROM `student` WHERE `$by`='$reciever'";
                $res = $conn->query($sql);
                if( $res->num_rows > 0 ){
                    $status2 = 'student';
                    $row2 = mysqli_fetch_array($res);
                }
                $sql = "SELECT * FROM `teacher` WHERE `$by`='$reciever'";
                $res = $conn->query($sql);
                if( $res->num_rows > 0 ){
                    $status2 = 'teacher';
                    $row2 = mysqli_fetch_array($res);
                }
                $sql = "SELECT * FROM `vendor` WHERE `$by`='$reciever'";
                $res = $conn->query($sql);
                if( $res->num_rows > 0 ){
                    $status2 = 'vendor';
                    $row2 = mysqli_fetch_array($res);
                }
    
                //Transfer Functions
                if($status2 != false){
                    if( $row2['id'] == $user_row['id'] || $row2['card_id'] == $user_row['card_id'] ){
                        header('Location: ../transfer?warning=cannot-transfer-to-yourself');
                        exit();
                    }
                    if( $row2['status'] == 'banned' ){
                        header('Location: ../transfer?warning=target-user-is-banned');
                        exit();
                    }
                    $status1 = $status;
                    $current_balance_sender = $user_row['balance'];
                    $current_balance_reciever = $row2['balance'];
                    if( $current_balance_sender >= $value ){
                        $new_balance_sender = $current_balance_sender - $value;
                        $new_balance_reciever = $current_balance_reciever + $value;
                        
                        $sql = "UPDATE `$status1` SET `balance`='$new_balance_sender' WHERE `id`='$sender'";
                        $res1 = $conn->query($sql);
                        
                        $sql = "UPDATE `$status2` SET `balance`='$new_balance_reciever' WHERE `$by`='$reciever'";
                        $res2 = $conn->query($sql);
                        
                        $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('$sender','$new_balance_sender')";
                        $res11 = $conn->query($sql);
                        $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('".$row2['id']."','$new_balance_reciever')";
                        $res22 = $conn->query($sql);
    
                        if( $res1 && $res2 ){
                            $desc = 'Transfer Success! ('.$user_row['name'].' to '.$row2['name'].')';
                            $request_res = 'success';
                            $get_desc .= 'result=success';
                            
                            if( !$res11 || !$res22 ){
                                $desc.= ' (Balance History not Updated)';
                            }
                        }else if( !$res1 || !$res2 ){
                            $desc = 'Transfer Failed (Partially)';
                            $request_res = 'failed';
                            $get_desc .= 'result=failed-please-contact-administrator-as-soon-as-possible';
                        }else{
                            $desc = 'Transfer Failed';
                            $request_res = 'failed';
                            $get_desc .= 'result=failed';
                        }
                    }else{
                        $desc = 'Balance not Enough!';
                        $request_res = 'failed';
                        $get_desc .= 'warning=balance-not-enough';
                    }
    
                    //make receipt(session)
                    $sd = $user_row['id'];
                    $rc = $row2['id'];
                    $where = 'admin-site';
                    $admin_username = 'webapp-'.$user_row['id'];
                    $sql = "INSERT INTO `transaction`(`type`,`sender`,`receiver`,`value`,`description`,`status`,`machine_id`) VALUES 
                    ('Transfer','$sd','$rc','$value','$desc','$request_res','$admin_username') ";
                    $res = $conn->query($sql);
                    if( $res ){
                        $get_desc .= '&receipt=success';
                    }else{
                        $get_desc .= '&receipt=failed';
                    }

                    $sql = "SELECT `id` FROM `transaction` WHERE `sender`='$sd' AND `receiver`='$rc' AND `value`='$value' AND `description`='$desc' AND `status`='$request_res' AND `type`='Transfer' AND `machine_id`='$admin_username' ORDER BY `id` DESC LIMIT 1";
                    $res3 = $conn->query($sql);
                    $t_id = "";
                    if( $res3 ){
                        if( $res3->num_rows > 0 ){
                            $row3 = mysqli_fetch_assoc($res3);
                            $t_id = $row3['id'];
                        }
                    }
                    http_response_code(200);
                    header('Location: ../transaction?id='.$t_id);
                    exit();
                }else{
                    http_response_code(404);
                    header('Location: ../transfer?warning=target-user-not-exist');
                    exit();
                }
            }else{
                http_response_code(500);
                header('Location: ../transfer?warning=empty');
                exit();
            }
            
        }else if($captcha_verify == false){
            header('Location: ../transfer?warning=wrong-captcha');
            exit();
        }
    }else{
        http_response_code(403);
        header('Location: ../transfer');
        exit();
    }