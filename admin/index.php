<?php
    require "include/server.php";
    require "include/structure.php";
    $login = '';
    if(isset($_GET['login'])){
        $get_login = mysqli_escape_string($conn,$_GET['login']);
        $login = '?login='.$get_login;
    }
    if(isset($_SESSION['useradmin_id'])){
        header("Location: dashboard".$login);
        exit();
    }else if(isset($_COOKIE['admin_login'])){
        $_SESSION["user_id"] = $_COOKIE['admin_login'];
        header("Location: dashboard".$login);
        exit();
    }else{
        header("Location: login");
        exit();
    }