<?php
    require '../../server.php';
    require '../../api_checker.php';
    header("Access-Control-Allow-Origin: *");
    http_response_code(200);
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        sendMessage('DB Error',FALSE);
    } 
    $response = array();
    if(isset($_POST['key'])){
        $api_key = mysqli_escape_string($conn,$_POST['key']);
        $api_username = mysqli_escape_string($conn,$_POST['username']);
        if( apiValidation($api_username,$api_key,1,'device') ){
            //authorize the access
            $v_id = $_POST['v_id'];
            $api_username = $_POST['username'];
            $sql = "SELECT `name`,`status` FROM `vendor` WHERE `id`='$v_id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    $response['name'] = substr($row['name'],0,12);
                    $response['details'] = $row['status'];
                    sendMessage("Success",TRUE);
                }else{
                    sendMessage('Data Not Found',FALSE);
                }
            }else{
                sendMessage('Error',FALSE);
            }
        }else{
            sendMessage("Access Denied 2",false);
        }
    }else{
        sendMessage("Access Denied 1",false);
    }
    function sendMessage($message,$status){
        global $response;
        if( !isset($response['details']) || empty($response['details']) ){
            $response['details'] = "";
        }
        if( !isset($response['name']) || empty($response['name']) ){
            $response['name'] = "";
        }
        $response["success"] = $status;
        $response["message"] = $message;
        $response = json_encode($response);
        exit($response);
    }