<?php
    /*
        GUIDELINES
        >>From Midtrans
        'pending'       : waiting to be paid
        'settlement'    : success payment
        'expire'        : failed to meet payment deadlines
        'deny'          : denied credit card

        >>Handling
        'unspecified'   : unconfirmed/unknown order
        'finished'      : finished processing the funds
        'error'         : error
        'marked'        : indication of fraud / under investigation

    */
    //viritrans
    require_once(dirname(__FILE__) . '/../veritrans/Veritrans.php');
    require_once(dirname(__FILE__) . '/../veritrans/key.php');
    //Set Your server key
    Veritrans_Config::$serverKey = "$veritrans_server_key";
    
    // Uncomment for production environment
    // Veritrans_Config::$isProduction = true;
    
    // Uncomment to enable sanitization
    // Veritrans_Config::$isSanitized = true;
    
    // Uncomment to enable 3D-Secure
    // Veritrans_Config::$is3ds = true;

    require_once(dirname(__FILE__) . '/server.php');
    header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");

    $log_text = array();
    $json_format_log = array("t-id"=>"","u-id"=>"");
    $json_format = array("count"=>0,"log"=>array(),"res"=>"");
    $json_file = array("delete-junk"=>$json_format,"confirming"=>array("confirmed"=>$json_format,"error"=>$json_format,"count"=>0),"settle-check"=>$json_format,"process-funds"=>$json_format,"tag-junk"=>$json_format);

    // deleting junk
    array_push($log_text,'===== Deleting Junk =====');
    $sql = "SELECT * FROM `veritrans` WHERE `type`='Top Up' AND `status`='unverified'";
    $res = $conn->query($sql);
    if($res){
        if($res->num_rows>0){
            while($row=mysqli_fetch_array($res)){
                $id = $row['id'];
                $sql="DELETE FROM `veritrans` WHERE `id`='$id'";
                $res2 = $conn->query($sql);
                if($res2){
                    array_push($log_text,'deleted (id:'.$id.')');
                    array_push($json_file["delete-junk"]["log"],array("t-id"=>$id,"u-id"=>$row["user_id"]));
                    $json_file["delete-junk"]["count"]++;
                }
            }
        }else{
            array_push($log_text,'Nothing to be queued. No task left.');
            $json_file["delete-junk"]["res"] = "No Task";
        }
    }else{
        array_push($log_text,'Error.');
        $json_file["delete-junk"]["res"] = "Error";
    }

    // confirming
    array_push($log_text,'===== Confirming and Checking =====');
    $sql = "SELECT * FROM `veritrans` WHERE `type`='Top Up' AND `status`='unspecified'";
    $res = $conn->query($sql);
    if($res){
        if($res->num_rows>0){
            while($row=mysqli_fetch_array($res)){
                $id = $row['id'];
                //veritrans methods
                $response = getStatus($id);
                if( $response != "" ){
                    if($response->success == 1 && $response->message != ""){
                        $message = $response->message;
                        $sql="UPDATE `veritrans` SET `status`='$message' WHERE `id`='$id'";
                        $res2 = $conn->query($sql);
                        if($res2){
                            array_push($log_text,'confirmed (id:'.$id.')');
                            array_push($json_file["confirming"]["confirmed"]["log"],array("t-id"=>$id,"u-id"=>$row["user_id"]));
                            $json_file["confirming"]["confirmed"]["count"]++;
                        }
                    }
                }
                /*
                else{
                    $message = "error";
                    $sql="UPDATE `veritrans` SET `status`='$message' WHERE `id`='$id'";
                    $res2 = $conn->query($sql);
                    if($res2){
                        array_push($log_text,'error confirmed (id:'.$id.')');
                        array_push($json_file["confirming"]["error"]["log"],array("t-id"=>$id,"u-id"=>$row["user_id"]));
                        $json_file["confirming"]["error"]["count"]++;
                    }
                }
                */
            }
            $json_file["confirming"]["count"] = $json_file["confirming"]["error"]["count"]+$json_file["confirming"]["confirmed"]["count"];
        }else{
            array_push($log_text,'Nothing to be queued. No task left.');
            $json_file["confirming"]["res"] = "No Task";
        }
    }else{
        array_push($log_text,'Error.');
        $json_file["confirming"]["res"] = "Error";
    }

    //  rechecking settlements
    array_push($log_text,'===== Checking for settlements =====');
    $sql = "SELECT * FROM `veritrans` WHERE `type`='Top Up' AND `status`='pending'";
    $res = $conn->query($sql);
    if($res){
        if($res->num_rows>0){
            while($row=mysqli_fetch_array($res)){
                $id = $row['id'];
                //veritrans methods
                $response = getStatus($id); 
                if( $response != "" ){
                    if($response->success == 1 && $response->message != ""){
                        $message = $response->message;
                        $sql="UPDATE `veritrans` SET `status`='$message' WHERE `id`='$id'";
                        $res2 = $conn->query($sql);
                        if($res2){
                            array_push($log_text,'pending status check (id:'.$id.')');
                            array_push($json_file["settle-check"]["log"],array("t-id"=>$id,"u-id"=>$row["user_id"]));
                            $json_file["settle-check"]["count"]++;
                        }
                    }
                }
            }
        }else{
            array_push($log_text,'Nothing to be queued. No task left.');
            $json_file["settle-check"]["res"] = "No Task";
        }
    }else{
        array_push($log_text,'Error.');
        $json_file["settle-check"]["res"] = "Error";
    }

    // accepting and finishing
    array_push($log_text,'===== Accepting whose settled and Processing the funds =====');
    $admin_username = "veritrans_bot";
    $sql = "SELECT * FROM `veritrans` WHERE `type`='Top Up' AND `status`='settlement'";
    $res = $conn->query($sql);
    if($res){
        if($res->num_rows>0){
            while($row=mysqli_fetch_array($res)){
                $id = $row['id'];
                $user_id = $row['user_id'];
                $user_status = checkWho($user_id);
                $trans_value = $row['value'];

                if( $user_status != "" ){
                    $sql="SELECT `balance` FROM `$user_status` WHERE `id`='$user_id'";
                    $res3 = $conn->query($sql);
                    if($res3){
                        if($res3->num_rows>0){
                            $stat = "";
                            $user_row=mysqli_fetch_assoc($res3);
                            $old_balance = $user_row['balance'];
                            $new_balance = $old_balance + $trans_value;
                            $desc = 'Top Up via Midtrans Pay';
    
                            $sql="UPDATE `$user_status` SET `balance`='$new_balance' WHERE `id`='$user_id'";
                            $res2 = $conn->query($sql);
                            if($res2){
                                //if success
                                array_push($log_text,'top up success (id:'.$id.' for '.$user_id.')');
                                $stat.= "t-OK ";
    
                                //ADDITONAL DATA
    
                                //adding receipt
                                $sql = "INSERT INTO `transaction`(`type`,`sender`,`receiver`,`value`,`description`,`status`,`machine_id`) VALUES 
                                ('Top Up','$user_id','Veritrans Pay','$trans_value','$desc','success','$admin_username') ";
                                $result = $conn->query($sql);
                                if($result){
                                    array_push($log_text,'receipt OK (id:'.$id.')');
                                    $stat.= "r-OK ";
                                }else{
                                    array_push($log_text,'receipt BAD (id:'.$id.')');
                                    $stat.= "r-BAD ";
                                }
    
                                //adding balance history
                                $sql = "INSERT INTO `balance_history`(`id`,`balance`) VALUES ('$user_id','$trans_value')";
                                $res11 = $conn->query($sql);
    
                                //FINSHING
                                $sql="UPDATE `veritrans` SET `status`='finished' WHERE `id`='$id'";
                                $res4 = $conn->query($sql);
                                if($res4){
                                    array_push($log_text,'finished (id:'.$id.')');
                                    $stat.= "f-OK";
                                }else{
                                    array_push($log_text,'fail to finish (id:'.$id.')');
                                    $stat.= "f-FAIL";
                                }
                            }else{
                                //if failed
                                //adding receipt
                                $sql = "INSERT INTO `transaction`(`type`,`sender`,`receiver`,`value`,`description`,`status`,`machine_id`) VALUES 
                                ('Top Up','$user_id','Veritrans Pay','$trans_value','$desc','failed','$admin_username') ";
                                $result = $conn->query($sql);
                                if($result){
                                    array_push($log_text,'receipt BAD (id:'.$id.')');
                                    $stat.= "rb-OK";
                                }else{
                                    $stat.= "rb-FAIL";
                                }
                            }
                            array_push($json_file["process-funds"]["log"],array("t-id"=>$id,"u-id"=>$row["user_id"],"status"=>$stat));
                            $json_file["process-funds"]["count"]++;
                        }
                    }
                }
            }
        }else{
            array_push($log_text,'Nothing to be queued. No task left.');
            $json_file["process-funds"]["res"] = "No Task";
        }
    }else{
        array_push($log_text,'Error.');
        $json_file["process-funds"]["res"] = "Error";
    }
    
    // pushing unsettleable data
    array_push($log_text,'===== Tagging Junk =====');
    $sql = "SELECT * FROM `veritrans` WHERE `type`='Top Up' AND `status`='unspecified'";
    $res = $conn->query($sql);
    if($res){
        if($res->num_rows>0){
            while($row=mysqli_fetch_array($res)){
                $id = $row['id'];
                $sql="UPDATE `veritrans` SET `status`='unverified' WHERE `id`='$id'";
                $res2 = $conn->query($sql);
                if($res2){
                    array_push($log_text,'added to junk (id:'.$id.')');
                    array_push($json_file["tag-junk"]["log"],array("t-id"=>$id,"u-id"=>$row["user_id"]));
                }
            }
        }else{
            array_push($log_text,'Nothing to be queued. No task left.');
            $json_file["tag-junk"]["res"] = "No Task";
        }
    }else{
        array_push($log_text,'Error.');
        $json_file["tag-junk"]["res"] = "Error";
    }

    $log_text = implode("\n",$log_text);
    $json_file = json_encode($json_file);
    //print_r($json_file);

    sendMessage($log_text,true);
    //echo '<pre>'.$log_text.'</pre>';

    //logText(); //logging to text // HTTP-POST METHOD
    //logJson(); //logging to json

    function getStatus($id){

        $url = 'http://192.168.100.14:8080/gbs-api/sc/status.php';
        //$url = 'http://api.gbsproject.ga/sc/status.php';
        $data = array('id' => "$id");
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch,CURLOPT_POST, count($data));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $head = curl_exec($ch); 
        curl_close($ch); 
        $json = array();
        $json = json_decode($head);
        return $json;
    }
    function checkWho($sender_id){
        global $conn;
        $who = "teacher";
        $sql = "SELECT * FROM `$who` WHERE `id`='$sender_id'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            return $who;
        }
        $who = "student";
        $sql = "SELECT * FROM `$who` WHERE `id`='$sender_id'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            return $who;
        }
        $who = "vendor";
        $sql = "SELECT * FROM `$who` WHERE `id`='$sender_id'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){   
            return $who;
        }
    }

    function logText(){
        global $log_text;
        //$log_text = implode("\n",$log_text);
        $data = array('data' => "$log_text",'key'=>"wRK8Gf[G2scj?:Gnnz+cz#");
        
        $url = 'http://192.168.100.14:8080/gbs-api/sc/log.php';
        //$url = 'http://api.gbsproject.ga/sc/log.php';
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch,CURLOPT_POST, count($data));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $head = curl_exec($ch); 
        curl_close($ch); 
    }

    function logJson(){
        global $json_file;
        //$log_text = implode("\n",$log_text);
        $data = array('data' => $json_file,'key'=>"wRK8Gf[G2scj?:Gnnz+cz#");
        
        $url = 'http://192.168.100.14:8080/gbs-api/sc/log_json.php';
        //$url = 'http://api.gbsproject.ga/sc/log.php';
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch,CURLOPT_POST, count($data));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $head = curl_exec($ch); 
        curl_close($ch); 
    }
    
    function sendMessage($message,$status){
        $response = array();
        $response["success"] = $status;
        $response["message"] = $message;
        $response = json_encode($response);
        exit($response);
    }