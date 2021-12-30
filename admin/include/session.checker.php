<?php
 if(isset($_SESSION['useradmin_id'])){
 }else if(isset($_COOKIE['admin_login'])){
    $_SESSION["user_id"] = $_COOKIE['admin_login'];
    header("Location: $main_directory/index.php?login=remember-success");
    exit();
 }else{
    header("Location: $main_directory/login");
    exit();
 }