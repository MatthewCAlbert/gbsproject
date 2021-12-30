<?php
    require 'key.php';
    $res = array();
    $desc = '';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        if($obj['secret']===$secret_key){
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
        
            // Check connection
            if ($conn->connect_error) {
                sendMessage('Database is appear to be on maintenance or broken.',FALSE);
            } 

            $sender_id = $obj['sender_id'];
            $sender_status = $obj['sender_status'];
            $receiver_id = $obj['receiver_id'];
            $receiver_status = null;
            $value = $obj['value'];

            
            checkWho('student');
            checkWho('teacher');
            checkWho('vendor');

            if($receiver_status == null){
                sendMessage('Receiver doesn\'t exist!',FALSE);
            }

            $verified_count = 0;

            //fetch sender balance
            $sql="SELECT `balance` FROM `$sender_status` WHERE `id`='$sender_id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
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
            $sql="SELECT `balance` FROM `$receiver_status` WHERE `id`='$receiver_id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    $receiver_balance = $row['balance'];
                    $verified_count++;
                }else{
                    sendMessage('Error',FALSE);
                }
            }

            $sender_balance-= $value;
            $receiver_balance+= $value;
            $admin_username = 'Mobile Apps-'.$sender_id;

            if( $verified_count == 2 ){

                //updating sender balance
                $request_res = 'success';
                $sql="UPDATE `$sender_status` SET `balance`='$sender_balance' WHERE `id`='$sender_id'";
                $result = $conn->query($sql);
                if($result){
                }else{
                    $desc .= 'Sender Balance Update Failed! ';
                    $request_res = 'failed';
                }

                //updating receiver balance
                $sql="UPDATE `$receiver_status` SET `balance`='$receiver_balance' WHERE `id`='$receiver_id'";
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
                ('Transfer','$sender_id','$receiver_id','$value','$desc','$request_res','$admin_username') ";
                $result = $conn->query($sql);
                if($result){
                }else{
                    $desc .= 'Receipt Failed!';
                }
                sendMessage($desc,TRUE);

            }

        }else{
            sendMessage('Unauthorized Access - False Identification',FALSE);
        }
    }else{
        sendMessage('Unauthorized Access 403',FALSE);
    }

    
function checkWho($who){
    global $conn, $receiver_status, $receiver_id;
    $sql = "SELECT * FROM `$who` WHERE `id`='$receiver_id'";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){   
        $receiver_status = $who;
    }
}