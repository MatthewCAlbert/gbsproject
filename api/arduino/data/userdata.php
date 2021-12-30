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
    $sender_status = null;
    $sender_id = "";
    $response["balance"] = 'null';
    $response['status'] = 'null';

    if(isset($_POST['key'])){
        $api_key = mysqli_escape_string($conn,$_POST['key']);
        $api_username = mysqli_escape_string($conn,$_POST['username']);
        if( apiValidation($api_username,$api_key,1,'device') ){
            //authorize the access
            //$v_id = $_POST['v_id'];
            //$api_username = $_POST['username'];
            $sender_id = edcCardInterpreter($_POST['c_id']);

            checkWho('student');
            checkWho('teacher');
            checkWho('vendor');

            if( $sender_status != null ){
                $sql = "SELECT `name`,`status`,`balance` FROM `$sender_status` WHERE `card_id`='$sender_id'";
                $result = $conn->query($sql);
                if($result){
                    if($result->num_rows > 0){
                        $row = mysqli_fetch_assoc($result);
                        $response['name'] = substr($row['name'],0,20);
                        $response['details'] = "User Found!";
                        $response['status'] = ucfirst($row['status']);
                        $response["balance"] = number_format($row['balance'],0,',','.');
                        sendMessage("Success",TRUE);
                    }else{
                        sendMessage('Data Not Found',FALSE);
                    }
                }else{
                    sendMessage('Error',FALSE);
                }
            }else{
                //if user cannot be identified
                $response['name'] = "";
                $response['balance'] = "null";
                $response['details'] = "Cannot find user info.";
                sendMessage('Unidentified',FALSE);
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
    function checkWho($who){
        global $conn, $sender_status, $sender_id;
        $sql = "SELECT * FROM `$who` WHERE `card_id`='$sender_id'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            $sender_status = $who;
        }
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