<?php
error_reporting(0);
$response = array();
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");

if( isset($_POST['key']) && isset($_POST['param']) ){
    if( $_POST['key']=="kT2K78fKXsSA6BPh" ){
        $dir = 'logs/'.$_POST['param'].'.txt';
        // $dir = 'logs/'.$_POST['param'].'.json'; //JSON Format Log
        if($myfile = fopen($dir, "r")){
            $result = fread($myfile,filesize($dir));
            fclose($myfile);
            sendMessage($result,true);
        }else{
            sendMessage("not found",false);
        }
    }else{
        sendMessage("denied",false);
    }
}else{
    sendMessage("error",false);
}

function sendMessage($message,$status){
    global $response;
    $response["success"] = $status;
    $response["message"] = $message;
    $response = json_encode($response);
    exit($response);
}
?>