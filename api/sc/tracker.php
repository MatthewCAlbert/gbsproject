<?php
    require_once(dirname(__FILE__) . '/server.php');
    $response = array();

    header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    
    if( isset($_POST['order_id']) && isset($_POST['id']) && isset($_POST['value']) ){
        $order_id = mysqli_escape_string($conn,$_POST['order_id']);
        $id = mysqli_escape_string($conn,$_POST['id']);
        $value = mysqli_escape_string($conn,$_POST['value']);
        if( $value >= 10000 && $value <= 500000 ){
            $sql = "INSERT INTO `veritrans`(`id`,`type`,`user_id`,`value`,`status`) VALUES ('$order_id','Top Up','$id','$value','unspecified')";
            $res = $conn->query($sql);
            if( $res ){
                sendMessage('success',true);
            }else{
                sendMessage('server error',false);
            }
        }else{
            sendMessage('invalid value',false);
        }
    }else{
        sendMessage('failed',false);
    }

    function sendMessage($message,$status){
        global $response;
        $response["success"] = $status;
        $response["message"] = $message;
        $response = json_encode($response);
        exit($response);
    }