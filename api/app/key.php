<?php
    error_reporting(0);
    $secret_key = "000x000";
    
    require '../server.php';
    
    function sendMessage($message,$status){
        global $res;
        $res["success"] = $status;
        $res["message"] = $message;
        $res = json_encode($res);
        exit($res);
    }