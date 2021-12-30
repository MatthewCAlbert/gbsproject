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
            $user_pin = $_POST['user_pin'];
            
            $sql = "SELECT `name`,`status`,`pin` FROM `vendor` WHERE `id`='$v_id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    if( password_verify($user_pin,$row['pin']) ){
                        sendMessage("Success",TRUE);
                    }else{
                        sendMessage("Wrong PIN!",FALSE);
                    }
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
    function edcCardInterpreter($raw_id){
        //converter
        $raw_arr = array();
        $raw_arr = explode(" ",$raw_id);
        $newhex = "";
        for( $i = count($raw_arr)-1 ; $i >= 0 ; $i-- ){
            $newhex .= dechex($raw_arr[$i]); 
        }
        $store = hexdec($newhex);
        //0 adder
        if( strlen($store) < 10 ){
            $length = 10 - strlen($store);
            for($i = 0 ; $i < $length ; $i++){
                $store = "0".$store;
            }
        }
        return $store;
    }