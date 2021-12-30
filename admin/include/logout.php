<?php
    require 'structure.php';
    $_SESSION = array();
    if(isset($_COOKIE['admin_login'])){
        unset($_COOKIE['admin_login']);
        setcookie("admin_login", '', time()-3600,"$cookie_dir");
    }
    session_destroy();
    header("Location: $main_directory/index.php?logout=true");
    exit();