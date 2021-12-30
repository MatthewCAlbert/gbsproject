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
        if( apiValidation($api_username,$api_key,4,'device') ){
            //authorize the access
            $receiver_id = $_POST['v_id'];
            $sender_id = $_POST['c_id'];
            $api_username = $_POST['username'];
            $value = (int)$_POST['money_value'];
            $response["balance"] = 'null';
            $sender_status = null;
            $desc = "";

            $sender_id = edcCardInterpreter($sender_id);
                    
            checkWho('student');
            checkWho('teacher');
            checkWho('vendor');

            if($sender_status == null){
                sendMessage('Unidentified ID',FALSE);
            }else{
                $sql="SELECT `id`,`name` FROM `$sender_status` WHERE `card_id`='$sender_id'";
                $result = $conn->query($sql);
                if($result){
                    if($result->num_rows > 0){
                        $row = mysqli_fetch_assoc($result);
                        $sender_id = $row['id'];
                        $response['name'] = substr($row['name'],0,20);
                    }else{
                        sendMessage('Error',FALSE);
                    }
                }else{
                    sendMessage('Error',FALSE);
                }
            }

            $verified_count = 0;

            if( $sender_id == $receiver_id ){
                sendMessage("Error",FALSE);
            }

            //fetch sender balance
            $sql="SELECT `balance`,`status` FROM `$sender_status` WHERE `id`='$sender_id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    if( $row['status'] != 'active' ){
                        sendMessage('Card is Banned!',FALSE);
                    }
                    if( $row['balance'] >= $value ){
                        //enough balance
                        $sender_balance = $row['balance'];
                        $verified_count++;
                    }else{
                        sendMessage('Not Enough Balance!',FALSE);
                    }
                }else{
                    sendMessage('Error',FALSE);
                }
            }

            //fetch receiver balance
            $sql="SELECT `balance`,`status` FROM `vendor` WHERE `id`='$receiver_id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    if( $row['status'] != 'active' ){
                        sendMessage('Vendor is Banned!',FALSE);
                    }
                    $receiver_balance = $row['balance'];
                    $verified_count++;
                }else{
                    sendMessage('Error',FALSE);
                }
            }

            $sender_balance-= $value;
            $receiver_balance+= $value;
            $admin_username = 'EDC-'.$api_username.'-'.$receiver_id;

            if( $verified_count == 2 ){

                //updating sender balance
                $request_res = 'success';
                $sql="UPDATE `$sender_status` SET `balance`='$sender_balance' WHERE `id`='$sender_id'";
                $result = $conn->query($sql);
                if($result){
                    $response["balance"] = number_format($sender_balance,0,',','.');
                }else{
                    $desc .= 'Sender Balance Update Failed! ';
                    $request_res = 'failed';
                }

                //updating receiver balance
                $sql="UPDATE `vendor` SET `balance`='$receiver_balance' WHERE `id`='$receiver_id'";
                $result = $conn->query($sql);
                if($result){
                }else{
                    $desc .= 'Receiver Balance Update Failed!';
                    $request_res = 'failed';
                }
                
                //UPDATING BALANCE HISTORY
                $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('$sender_id','$sender_balance')";
                $res11 = $conn->query($sql);
                $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('$receiver_id','$receiver_balance')";
                $res22 = $conn->query($sql);

                //adding receipt
                $sql = "INSERT INTO `transaction`(`type`,`sender`,`receiver`,`value`,`description`,`status`,`machine_id`) VALUES 
                ('Pay','$sender_id','$receiver_id','$value','$desc','$request_res','$admin_username') ";
                $result = $conn->query($sql);
                if($result){
                }else{
                    $desc .= 'Receipt Failed!';
                }
                $response["details"] = $desc;
                if( $request_res == "failed" ){
                    sendMessage('Fatal Error!',FALSE);
                }
                sendMessage('Transaction Success',true);

            }
            
        }else{
            sendMessage("Access Denied",false);
        }
    }else{
        sendMessage("Access Denied",false);
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