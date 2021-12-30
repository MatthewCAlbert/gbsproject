<?php
 if(isset($_SESSION['user_id'])){
    if($_SESSION['pin_verified']==false){
      header("Location: ".$main_directory.'verify');
      exit();
    }
 }else if(isset($_COOKIE['member_login'])){
   $_SESSION["user_id"] = $_COOKIE['member_login'];
   $_SESSION["status"] = $_COOKIE['status'];
     if( $user_row['pin'] != "" ){
        $_SESSION['pin_verified'] = false;
        header("Location: ".$main_directory."verify?login=cookie");
     }else{
        $_SESSION['pin_verified'] = true;
        header("Location: index.php?login=no-pin-cookie");
     }
   exit();
 }else{
    header("Location: ../login");
    exit();
 }