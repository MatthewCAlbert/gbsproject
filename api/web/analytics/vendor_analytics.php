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
        $api_key = mysqli_escape_string($conn,$_POST['key']); //pw2nbm9mKie8pW2O
        $api_username = mysqli_escape_string($conn,$_POST['username']);
        if( apiValidation($api_username,$api_key,1,'web') ){
            date_default_timezone_set('Asia/Jakarta');
            $id = mysqli_escape_string($conn,$_POST['id']);
            $range = mysqli_real_escape_string($conn,$_POST['range']);
            $month = mysqli_real_escape_string($conn,$_POST['month']);
            $year = mysqli_real_escape_string($conn,$_POST['year']);

            /*
                Reference
                AVG | SUM
                (Daily,Weekly,Months,Annually)

                Calculate T/day Money/day(avg) - weekly
                + Per week(avg) -  monthly 

            */
            $date = $year.'-'.$month;
            switch($range){
                case 'all': 
                    $start_date = '1970-01-01 00:00:00';
                    $last_date = date('Y-m-d').' 23:59:59';
                break;
                case 'daily':
                    $start_date = date('Y-m-d').' 00:00:00';
                    $last_date = date('Y-m-d').' 23:59:59';
                break;
                case 'last week':
                    $start_date = date('Y-m-d',strtotime('-2week Mon')).' 00:00:00';
                    $last_date = date('Y-m-d',strtotime('-1week Sun')).' 23:59:59';
                break;
                case 'weekly': 
                    if( date('d') == date("d",strtotime("Mon"))  ){
                        $start_date = date('Y-m-d').' 00:00:00';
                        $last_date = date('Y-m-d',strtotime("Sun")).' 23:59:59';
                    }else if( date('d') == date("d",strtotime("Sun")) ){
                        $start_date = date('Y-m-d',strtotime('Last Mon')).' 00:00:00';
                        $last_date = date('Y-m-d').' 23:59:59';
                    }else{
                        $start_date = date('Y-m-d',strtotime('Last Mon')).' 00:00:00';
                        $last_date = date('Y-m-d',strtotime('Sun')).' 23:59:59';
                    }
                break;
                case 'past 6 months': 
                    $start_date = date("Y-m",strtotime("-6 month")).'-01 00:00:00';
                    $last_date = date('Y-m-d',strtotime('last day of this month')).' 23:59:59';
                break;
                case 'past 3 months': 
                    $start_date = date("Y-m",strtotime("-3 month")).'-01 00:00:00';
                    $last_date = date('Y-m-d',strtotime('last day of this month')).' 23:59:59';
                break;
                case 'monthly': 
                    // date and year must be filled
                    $start_date = $date.'-01 00:00:00';
                    $string_date = date('F Y',strtotime($date));
                    $last_date = strtotime('last day of '.$string_date,time());
                    $last_date = date('Y-m-d',$last_date).' 23:59:59';
                break;
                case 'annually': 
                    // year must be filled
                    $start_date = $year.'-01-01 00:00:00';
                    $last_date = $year.'-12-31 23:59:59';
                break;
            }

            $sql = "SELECT `value` FROM `transaction` WHERE `type`='Pay' AND `status`='success' AND `time`>='$start_date' AND `time`<='$last_date' AND `receiver`='$id'" ;
            $res= $conn->query($sql);
            if($res){
                if( $res->num_rows > 0 ){
                    $data_length = $res->num_rows;
                    $sum = 0;
                    while( $row = mysqli_fetch_array($res) ){
                        $sum += $row['value'];
                    }
                    $average = (float)($sum/$data_length);
                    sendMessage(array("sum"=>number_format($sum,0,",","."),"average"=>number_format($average,0,",","."),"length"=>$data_length),TRUE);
                }else{
                    sendMessage(array("sum"=>0,"average"=>0,"length"=>0),TRUE);
                }
            }else{
                sendMessage('Error',FALSE);
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