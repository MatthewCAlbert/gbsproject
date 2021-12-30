<?php
    require '../config.php'; 
    require '../server.php';  
    if(isset($_SESSION['user_id'])){
        if($_SESSION['pin_verified']==true){
         header("Location: ".$main_directory);
         exit();
        }
    }else if(isset($_COOKIE['member_login'])){
        require 'cookie_detector.php';
    }else{
       header("Location: ../login");
       exit();
    }
    require 'getuserdata.php'; 

    if( isset($_POST['pin']) ){
        $id = $user_row['card_id'];
        $pin = mysqli_real_escape_string($conn,$_POST['pin']);
        if( password_verify($pin,$user_row['pin']) ){
            $_SESSION['pin_verified']=true;
            http_response_code(200);
            exit(true);
        }else{
            $_SESSION['pin_verified']=false;
            http_response_code(200);
            exit(false);
        }
    }else{
        http_response_code(403);
        exit();
    }