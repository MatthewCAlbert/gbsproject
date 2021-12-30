<?php
    require '../include/config.php'; 
    require '../include/server.php';  
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 

    if(isset($_POST['submit'])){
        $id = $user_row['card_id'];
        if(isset($_POST['email'])){
            $email = mysqli_escape_string($conn,$_POST['email']);
            $phone = mysqli_escape_string($conn,$_POST['phone']);
            $phone = preg_replace("/[^0-9]/", '', $phone);
            if( strlen($phone) > 15 || ( strlen($phone) > 0 && strlen($phone) < 7 ) ){
                header('Location: ../edit?failed=invalid-phone-number');
                exit();
            }
            $sql = "UPDATE `$status` SET `email`='$email',`phone`='$phone' WHERE `card_id`='$id' ";
            $res = $conn->query($sql);
            if($res){
                http_response_code(200);
                header('Location: ../edit?success');
                exit();
            }else{
                http_response_code(500);
                header('Location: ../edit?failed');
                exit();
            }
        }else if(isset($_POST['old-password'])){
            $old = mysqli_escape_string($conn,$_POST['old-password']);
            $new = mysqli_escape_string($conn,$_POST['new-password']);
            $re = mysqli_escape_string($conn,$_POST['re-password']);
            if( strlen($new) > 32 || strlen($new) < 8 ){
                http_response_code(503);
                header('Location: ../edit?failed');
                exit();
            }
            filter_var($old,FILTER_VALIDATE_REGEXP,array("options"=> array( "regexp" => "/.{8,32}/")));
            filter_var($new,FILTER_VALIDATE_REGEXP,array("options"=> array( "regexp" => "/.{8,32}/")));
            filter_var($re,FILTER_VALIDATE_REGEXP,array("options"=> array( "regexp" => "/.{8,32}/")));
            //verify old password
            if( password_verify("$old",$user_row['password']) ){
                //allow change
                if( $new == $re ){
                    $hashedPw = password_hash("$new",PASSWORD_BCRYPT);
                    $sql = "UPDATE `$status` SET `password`='$hashedPw' WHERE `card_id`='$id'";
                    $res = $conn->query($sql);
                    if($res){
                        http_response_code(200);
                        header('Location: ../edit?success=password');
                        exit();
                    }else{
                        http_response_code(400);
                        header('Location: ../edit?failed=password');
                        exit();
                    }
                }else{
                    http_response_code(503);
                    header('Location: ../edit?failed=password-doesnt-match');
                    exit();
                }
            }else{
                http_response_code(403);
                header('Location: ../edit?failed=incorrect-password');
                exit();
            }
        }else{
            header('Location: ../edit');
            exit();
        }
    }else{
        header('Location: ../edit');
        exit();
    }