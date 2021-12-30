<?php
    require '../include/config.php'; 
    require '../include/server.php';  
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 

    if( $user_row['pin'] == "" ){
        $id = $user_row['card_id'];
        if( isset($_POST['create_pin']) && isset($_POST['create_re_pin']) ){
            $create_pin = mysqli_real_escape_string($conn,$_POST['create_pin']);
            $create_re_pin = mysqli_real_escape_string($conn,$_POST['create_re_pin']);
            if( strlen($create_pin) == 6 ){
                if( $create_pin == $create_re_pin ){
                    $hashedPin = password_hash($create_pin,PASSWORD_BCRYPT);
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
                    http_response_code(500);
                    header('Location: ../edit/create-pin.php');
                    exit();
                }
            }else{
                http_response_code(500);
                header('Location: ../edit/create-pin.php');
                exit();
            }
        }else{
            http_response_code(500);
            header('Location: ../edit/create-pin.php');
            exit();
        }
    }else{
        http_response_code(403);
        header('Location: ../account');
        exit();
    }