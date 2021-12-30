<?php
    require "include/server.php";
    require "include/config.php";
    $login = '';
    if(isset($_GET['login'])){
        $get_login = mysqli_escape_string($conn,$_GET['login']);
        $login = '?login='.$get_login;
    }
    if(isset($_SESSION['user_id'])){
        header("Location: home".$login);
        exit();
    }else if(isset($_COOKIE['member_login'])){
        $_SESSION["user_id"] = $_COOKIE['member_login'];
        $_SESSION["status"] = $_COOKIE['status'];
        header("Location: home".$login);
        exit();
    }else{
        header("Location: login");
        exit();
    }