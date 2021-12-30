<?php
    require '../config.php'; 
    require '../server.php';  
    require 'session.checker.php'; 
    require 'getuserdata.php'; 

    if( isset($_POST['pin']) ){
        $id = $user_row['card_id'];
        $pin = mysqli_real_escape_string($conn,$_POST['pin']);
        if( password_verify($pin,$user_row['pin']) ){
            $_SESSION['change_pin_steps'] = 1;
            $_SESSION['change_pin_verify'] = true;
            http_response_code(200);
            exit(json_encode([true,1]));
        }else{
            http_response_code(200);
            exit(json_encode([false,0]));
        }
    }else{
        http_response_code(403);
        exit();
    }