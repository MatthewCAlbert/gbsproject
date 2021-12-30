<?php
    require '../config.php'; 
    require '../server.php';  
    require 'session.checker.php'; 
    require 'getuserdata.php'; 

    if( isset($_POST['pin']) ){
        $id = $user_row['card_id'];
        $pin = mysqli_real_escape_string($conn,$_POST['pin']);
        if( password_verify($pin,$user_row['pin']) ){
            $_SESSION['verified_transfer_pin'] = true;
            http_response_code(200);
            exit(true);
        }else{
            http_response_code(200);
            exit(false);
        }
    }else{
        http_response_code(403);
        exit();
    }