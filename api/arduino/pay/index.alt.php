<?php
    require '../../server.php';
    // Create connection
    $dbname = 'chatdb';
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        sendMessage('DB Error',FALSE);
    } 
    $response = array();
    if(isset($_POST['key'])){
        $api_key = $_POST['key'];
        if( $api_key == "iYazfICM9FUF74Yx" ){
            if(!empty($_POST['c_id'])){
                //authorize the access
                $raw_cos_id = $_POST['c_id']; //recieve buffer decimal type
                $raw_arr = array();
                $raw_arr = explode(" ",$raw_cos_id);
                $newhex = "";
                for( $i = count($raw_arr)-1 ; $i >= 0 ; $i-- ){
                    $newhex .= dechex($raw_arr[$i]); 
                }
                $sender_id = hexdec($newhex);
                /*
                //add remaining zero
                if( strlen($sender_id) < 10 ){
                    $length = 10 - strlen($sender_id);
                    for($i = 0 ; $i < $length ; $i++){
                        $sender_id = "0".$sender_id;
                    }
                }
                */
                $title = $newhex;
                $content = $sender_id;
                //add remaining zero
                if( strlen($content) < 10 ){
                    $length = 10 - strlen($content);
                    for($i = 0 ; $i < $length ; $i++){
                        $content = "0".$content;
                    }
                }
                $sql = "INSERT INTO `data`(`title`,`content`) VALUES ('$title','$content')";
                if ($res=$conn->query($sql)){
                    sendMessage('Transaction Success',true);
                }else{
                    sendMessage('Transaction Failed',false);
                }
            }else{
                sendMessage("Invalid Data",false);
            }
        }else{
            sendMessage("Access Denied",false);
        }
    }else{
        sendMessage("Access Denied",false);
    }
    function sendMessage($message,$status){
        global $response;
        $response["success"] = $status;
        $response["message"] = $message;
        $response = json_encode($response);
        exit($response);
    }