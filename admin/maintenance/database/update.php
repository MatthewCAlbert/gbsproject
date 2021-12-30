<?php
session_start();
require '../../include/server.php';
    if(isset($_POST['submit'])){
        $status = mysqli_real_escape_string($conn,$_POST['status']);
        $req = mysqli_real_escape_string($conn,$_POST['req']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $action_taken = 'none';
        if($req == 'nopassword'){
            $hashedpw = password_hash("$password",PASSWORD_BCRYPT);
            $sql = "UPDATE `$status` SET `password`='$hashedpw' WHERE `password`=''";
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            $action_taken = "password-changed ".$count." from ".$status;
        }
        if($req == 'nopassword' && isset($_POST['all'])){
            for($i = 0;  $i<count($status_list); $i++){
                $status = $status_list[$i];
                $hashedpw = password_hash("$password",PASSWORD_BCRYPT);
                $sql = "UPDATE `$status` SET `password`='$hashedpw' WHERE `password`=''";
                $res = mysqli_query($conn,$sql);
                $count = mysqli_num_rows($res);
                $action_taken = $action_taken.";password-changed ".$count." from ".$status;
            }
        }
        header("Location: index.php?action=$action_taken");
        exit();
    }else{
        header("Location: index.php?warning=no-args");
        exit();
    }