<?php
    header("Access-Control-Allow-Origin: *");
    http_response_code(200);

    if(isset($_POST['key'])||isset($_GET['key'])){
        sendMessage($_POST['key'],true);
    }else{
        sendMessage("Access Denied 1",false);
    }
    function sendMessage($message,$status){
        global $response;
        $response["success"] = $status;
        $response["message"] = $message;
        $response = json_encode($response);
        exit($response);
    }