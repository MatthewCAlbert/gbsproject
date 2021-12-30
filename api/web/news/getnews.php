<?php
$response = array();

header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");

$dir = "news.json";
if($myfile = fopen($dir, "r")){
    $result = fread($myfile,filesize($dir));
    fclose($myfile);
    sendMessage(json_decode($result),true);
}else{
    sendMessage("404",false);
}

function sendMessage($message,$status){
    global $response;
    $response["success"] = $status;
    $response["message"] = $message;
    $response = json_encode($response);
    exit($response);
}