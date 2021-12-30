<?php
    require '../config.php'; 
    require '../server.php';  
    require 'session.checker.php'; 
    require 'getuserdata.php'; 

    if( isset($_SESSION['change_pin_verify']) ){
        $verified = $_SESSION['change_pin_verify'];
        if( isset($_POST['new_pin']) && $verified ){
            $new_pin = mysqli_real_escape_string($conn,$_POST['new_pin']);
            $_SESSION['new_pin'] = $new_pin;
            $_SESSION['change_pin_steps'] = 2;
            http_response_code(200);
            exit(json_encode([true,2]));
        }else if( isset($_POST['re_pin']) && $verified ){
            $re_pin = mysqli_real_escape_string($conn,$_POST['re_pin']);
            if( $re_pin == $_SESSION['new_pin'] ){
                $_SESSION['re_pin'] = $re_pin;
                $_SESSION['change_pin_steps'] = 3;
                http_response_code(200);
                exit(json_encode([true,3]));
            }else{
                http_response_code(200);
                exit(json_encode([false,1]));
            }
        }else{
            http_response_code(403);
            exit();
        }
    }else{
        http_response_code(403);
        exit();
    }