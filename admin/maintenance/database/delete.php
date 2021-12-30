<?php
session_start();
require '../../include/server.php';
    if(isset($_POST['submit'])){
        $status = mysqli_real_escape_string($conn,$_POST['status']);
        $req = mysqli_real_escape_string($conn,$_POST['req']);
        $additional = mysqli_real_escape_string($conn,$_POST['additional']);
        $action_taken = 'none';
        if($req == 'all'){
            $sql = "DELETE * FROM `$status`";
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            $action_taken = "deleted ".$count." from ".$status;
        }
        if($req == 'nopassword'){
            $sql = "DELETE * FROM `$status` WHERE `password`=''";
        }
        if($req == 'previousgeneration' && !empty($additional)){
            $sql = "SELECT * FROM `student` WHERE `id` LIKE '$additional%'";
            $res = $conn->query($sql);
            if( $res ){echo "ok";}else{echo "error";}
            $row = mysqli_fetch_array($res);
            $left_balance = 0;
            $still_have_balance = array();
            $their_balance = array();
            $count = mysqli_num_rows($res);
                if($count > 0){
                    $i = 0;
                    while($i < $count){
                        if($row['balance'] > 0){
                            array_push($still_have_balance,$row['id']);
                            array_push($their_balance,$row['balance']);
                            $left_balance+= $row['balance'];
                        }
                        $i++;
                    }
                    $action_taken = 'something-lefted';
                    $_SESSION['report'] = 'Lefted Balance';
                    $_SESSION['their_balance'] = $their_balance;
                    $_SESSION['still_have_balance'] = $still_have_balance;
                    $_SESSION['left_balance'] = $left_balance;
                    echo $left_balance;
                }else{
                    $action_taken = 'all-ok';
                }
            $sql = "DELETE FROM `student` WHERE `id` LIKE '$additional%' AND `balance`=0";
            $res = $conn->query($sql);
            if( $res ){echo "ok";}else{echo '<br>'.$conn->error;}
            $count = mysqli_affected_rows($conn);
            echo $count;
            $action_taken = $action_taken.'-'.$count;
        }
        header("Location: index.php?action=$action_taken");
        exit();
    }else{
        header("Location: index.php?warning=no-args");
        exit();
    }