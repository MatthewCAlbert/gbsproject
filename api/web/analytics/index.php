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
    if(isset($_POST['key'])){
        $api_key = mysqli_escape_string($conn,$_POST['key']);
        $api_username = mysqli_escape_string($conn,$_POST['username']);
        if( apiValidation($api_username,$api_key,1,'web') ){
            date_default_timezone_set('Asia/Jakarta');
            $type = mysqli_escape_string($conn,$_POST['type']);
            $range = mysqli_real_escape_string($conn,$_POST['range']);
            $month = mysqli_real_escape_string($conn,$_POST['month']);
            $year = mysqli_real_escape_string($conn,$_POST['year']);

            $date = $year.'-'.$month;
            if( $range != "all" ){
                $start_date = $date.'-01 00:00:00';
                $string_date = date('F Y',strtotime($date));
                $last_date = strtotime('last day of '.$string_date,time());
                $last_date = date('Y-m-d',$last_date).' 23:59:59';
            }else{
                $start_date = '2018-01-01 00:00:00';
                $last_date = date('Y-m-d').' 23:59:59';
            }

            switch($type){
                case 'topup' :
                $sql = "SELECT `value` FROM `transaction` WHERE `type`='Top Up' AND `status`='success' AND `time`>='$start_date' AND `time`<='$last_date'";
                $res = $conn->query($sql);
                $topup_counter = 0;
                if($res){
                    if( $res->num_rows > 0 ){
                        while( $row = mysqli_fetch_array($res) ){
                            $topup_counter += (int)$row['value'];
                        }
                    }
                    sendMessage(number_format($topup_counter,0,",","."),TRUE);
                }
                break;
                case 'withdraw' :
                $sql = "SELECT `value` FROM `transaction` WHERE `type`='Withdraw' AND `status`='success' AND `time`>='$start_date' AND `time`<='$last_date'";
                $res = $conn->query($sql);
                $withdrawal_count = 0;
                if($res){
                    if( $res->num_rows > 0 ){
                        while( $row = mysqli_fetch_array($res) ){
                            $withdrawal_count += (int)$row['value'];
                        }
                    }
                    sendMessage(number_format($withdrawal_count,0,",","."),TRUE);
                }
                break;
                case 'payment' :
                $sql = "SELECT `value` FROM `transaction` WHERE `type`='Pay' AND `status`='success' AND `time`>='$start_date' AND `time`<='$last_date'";
                $res = $conn->query($sql);
                $pay_count = 0;
                if($res){
                    if( $res->num_rows > 0 ){
                        while( $row = mysqli_fetch_array($res) ){
                            $pay_count += (int)$row['value'];
                        }
                    }
                    sendMessage(number_format($pay_count,0,",","."),TRUE);
                }
                break;
            }

        }else{
            sendMessage('Access Denied',FALSE);
        }
    }else{
        sendMessage('Error',FALSE);
    }
    
    function sendMessage($message,$status){
        $res=array();
        $res["success"] = $status;
        $res["message"] = $message;
        $res = json_encode($res);
        exit($res);
    }