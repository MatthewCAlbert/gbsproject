<?php
include_once('../veritrans/Veritrans.php'); //include PHP library
require_once('../veritrans/key.php');

error_reporting(0);
$response = array();

$response = json_decode($json, TRUE);
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");

if( isset($_POST['id']) ){
    $order = $_POST['id'];
    Veritrans_Config::$serverKey = $veritrans_server_key;
    Veritrans_Config::$isProduction = false;   // false = sandbox
    $order_status_obj = Veritrans_Transaction::status($order);
    $status = $order_status_obj->transaction_status;
    sendMessage($status,true);
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