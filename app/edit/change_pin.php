<?php
    require '../include/config.php'; 
    require '../include/server.php';  
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 
    if( $user_row['pin'] == "" ){
        header('Location: ../account');
        exit();
    }

    if( isset($_SESSION['change_pin_verify']) && isset($_SESSION['change_pin_steps']) && isset($_SESSION['new_pin']) && isset($_SESSION['re_pin']) ){
        $verified = $_SESSION['change_pin_verify'];
        $id = $user_row['card_id'];
        $steps = $_SESSION['change_pin_steps'];
        $new_pin = $_SESSION['new_pin'];
        $re_pin = $_SESSION['re_pin'];
        //clear session
        unset($_SESSION['change_pin_verify'],$_SESSION['change_pin_steps'],$_SESSION['new_pin'],$_SESSION['re_pin']);
        if( $steps == 3 && $verified && strlen($new_pin) == 6 ){
            if( $new_pin == $re_pin ){
                $hashedPin = password_hash($new_pin,PASSWORD_BCRYPT);
                $sql = "UPDATE `$status` SET `pin`='$hashedPin' WHERE `card_id`='$id'";
                $res = $conn->query($sql);
                if( $res ){
                    header('Location: ../account?success');
                    exit();
                }else{
                    header('Location: ../account?error');
                    exit();
                }
            }else{
                header('Location: ../edit/pin.php');
                exit();
            }
        }else{
            header('Location: ../edit/pin.php');
            exit();
        }
    }else{
        header('Location: ../edit/pin.php');
        exit();
    }