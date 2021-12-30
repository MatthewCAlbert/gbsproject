<?php
    require "../config.php";
    $_SESSION = array();
    if(isset($_COOKIE['member_login'])){
        unset($_COOKIE['member_login']);
        setcookie("member_login", '', time()-3600,"$cookie_dir","$main_domain",$secure_https,$http_only);
    }
    session_destroy();
    header("Location: ../../index.php?logout=true");
    exit();