<?php
    require '../include/config.php'; 
    require '../include/server.php';
    if(isset($_SESSION['user_id'])){
    }else if(isset($_COOKIE['member_login'])){
        require '../include/backend/cookie_detector.php';
    }else{
       header("Location: ../login");
       exit();
    }
    require '../include/backend/getuserdata.php'; 

    if(isset($_POST['submit'])){
        require '../include/backend/captcha.php';
        if( isset($_POST['title']) && isset($_POST['message']) && isset($_POST['email']) )
        $id= $user_row['id'];
        $title= mysqli_escape_string($conn,$_POST['title']);
        $msg= mysqli_escape_string($conn,$_POST['message']);
        $email= mysqli_escape_string($conn,$_POST['email']);
        $type = mysqli_escape_string($conn,$_POST['type']);

        if( $captcha_verify == true ){
            if( strlen($msg) >  500 ){
                header('Location: ../cs?warning=message-too-long');
                exit();
            }
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                if( !empty($type) && !empty($title) && !empty($msg) ){
                    $sql = "INSERT INTO `help`(`type`,`title`,`description`,`account_id`,`email`,`status`) 
                    VALUES ('$type','$title','$msg','$id','$email','unread')";
                    $res = $conn->query($sql);
                    if($res){
                        http_response_code(200);
                        header('Location: ../cs?result=ok');
                        exit();
                    }else{
                        http_response_code(500);
                        header('Location: ../cs?result=failed');
                        exit();
                    }
                }else{
                    http_response_code(400);
                    header('Location: ../cs?warning=field-empty');
                    exit();
                }
            }else{
                http_response_code(400);
                header('Location: ../cs?warning=invalid-email');
                exit();
            }
        }else{
            http_response_code(403);
            header('Location: ../cs?warning=wrong-captcha');
            exit();
        }
    }else{
        http_response_code(500);
        header('Location: ../cs');
        exit();
    }