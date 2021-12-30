<?php
if(isset($_SESSION["user_id"])){
    $uid = $_SESSION["user_id"];
    $status = $_SESSION["status"];
    //$token = $_SESSION["token"];
    $sql = "SELECT * FROM `$status` WHERE `id`='$uid'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        header('Location: '.$main_directory.'login');
        exit();
    }
    $user_row = mysqli_fetch_assoc($result);
    if( $user_row['status'] != 'active' ){
        header('Location: '.$main_directory.'include/backend/logout.php');
        exit();
    }
    /*
    if( $user_row['token'] == "" ){
        $_SESSION["token"] = getNewToken();
        $retry = 0;
        while( $_SESSION["token"] == null && $retry < 3 ){
            $_SESSION["token"] = getNewToken();
            $retry++;
        }
        if( $_SESSION["token"] == null ){
            http_response_code(500);
            exit();
        }
    }else if( $token != $user_row['token'] ){
        if( $user_row['pin'] != "" ){
            $_SESSION['pin_verified'] = false;
            header('Location: '.$main_directory.'verify');
            exit();
        }
    }
    */
}else{
    exit();
}

function getNewToken(){
    global $conn,$user_row,$status,$uid;
    if( isset($user_row) ){
        $new_token =  bin2hex(random_bytes(32)) ;
        $sql = "UPDATE `$status` SET `token`='$new_token' WHERE `id`='$uid'";
        $res = $conn->query($sql);
        if($res){
            return $new_token;
        }else{
            return null;
        }
    }else{
        return null;
    }
}