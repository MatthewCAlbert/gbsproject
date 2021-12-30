<?php
session_start();
require '../../include/server.php';
    if(isset($_POST['submit'])){
        $status = mysqli_real_escape_string($conn,$_POST['status']);
        $req = mysqli_real_escape_string($conn,$_POST['req']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $action_taken = 'none';
        header("Location: index.php?action=$action_taken");
        exit();
    }else{
        header("Location: index.php?warning=no-args");
        exit();
    }