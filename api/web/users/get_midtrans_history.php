<?php
    header("Access-Control-Allow-Origin: *");

    require '../../server.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    if(isset($_POST['getData']) && isset($_POST['id']) && isset($_POST['start']) && isset($_POST['limit']) && isset($_POST['key'])){
        http_response_code(200);
        $id = mysqli_real_escape_string($conn,$_POST['id']);
        $start = mysqli_real_escape_string($conn,$_POST['start']);
        $limit = mysqli_real_escape_string($conn,$_POST['limit']);
        $key = mysqli_real_escape_string($conn,$_POST['key']);
        //$start = 0;
        //$limit = 30;
        
        $sql = "SELECT * FROM `veritrans` WHERE `user_id`='$id' ORDER BY `id` DESC LIMIT $start,$limit";
        $res = $conn->query($sql);
        if( $res->num_rows > 0 ){
            $response = "";

            while($row = mysqli_fetch_array($res)){
                $value = number_format($row['value'],0,",",".");
                $status = $row["status"];
                if( $status == "finished" ){
                    switch($row['type']){
                        case "Withdraw": $plusmin = '<span class="text-danger">- Rp '.$value.'</span>';break;
                        case "Top Up": $plusmin = '<span class="text-success">+ Rp '.$value.'</span>';break;
                        default: $plusmin = '<span class="text-primary"> Rp '.$value.'</span>';break;
                    }
                }else if( $status == "settlement" || $status == "pending" ){
                    $plusmin = '<span class="text-primary"> Rp '.$value.'</span>';
                }else{
                    $plusmin = '<span class="text-secondary"> Rp '.$value.'</span>';
                }
                $time = $row['id'];
                $time = preg_replace("/[\-\D]+/","",$time);
                $time = jsTimeToDate($time,true);
                switch ($row["status"]) {
                    case "finished":
                      $r_status = "green";
                      $r_message =
                        "Transaction has been finished and the funds has been added into your account.";
                      break;
                    case "settlement":
                      $r_status = "green";
                      $r_message = "Your payment has been confirmed and waiting to be processed.";
                      break;
                    case "error":
                      $r_status = "orange";
                      $r_message =
                        "Oops! There's something error, please contact admin for more info.";
                      break;
                    case "deny":
                      $r_status = "red";
                      $r_message = "Your purchase has been canceled due to invalid payment.";
                      break;
                    case "expire":
                      $r_status = "red";
                      $r_message = "Transaction has been cancelled due to payment time limit.";
                      break;
                    case "unspecified":
                      $r_status = "grey";
                      $r_message =
                        "Unable to determine payment status, if something wrong happened with this transaction in a couple ten minutes, please contact admin.";
                      break;
                    case "pending":
                      $r_status = "grey";
                      $r_message = "Waiting for your payment.";
                      break;
                    case "marked":
                      $r_status = "orange";
                      $r_message = "Something odd with this transaction.";
                      break;
                    case "unverified":
                      $r_status = "red";
                      $r_message =
                        "This happened due to payment cancellation, if you think that this payment ID wasn't cancelled, please contact admin immediately!";
                      break;
                    default:
                      $r_status = "violet";
                      $r_message = "If you found this status, please contact admin.";
                      break;
                }
                $response .= '
                <div class="scroll-list row" onclick="getDetail('."'".$row['id']."'".');">
                <div class="col-6">
                    <p>'.$row['id'].'</p>
                    <p style="font-size:0.85em;">'.$row['type'].' - <span style="color:'.$r_status.';" title="'.$r_message.'">'.$row['status'].'</span></p>
                </div>
                <div class="col-6">
                    <p>'.$plusmin.'</p>
                    <p style="font-size:0.8em;font-family:'."'Open Sans'".';">'.$time.' WIB</p>
                </div>
                </div>';
            }

            exit($response);
        }else{
            exit('reachedMax');
        }
    }else{
        http_response_code(406);
        exit();
    }

    function jsTimeToDate($timestamp,$simple=false,$mili_on=false){
      $locale = 0;
      $js_timestamp = $timestamp;
      $php_timestamp = (float)(($js_timestamp+$locale)/1000);
      $milis = ceil(($php_timestamp-floor($php_timestamp))*1000); // 0~1 * 1000 ms
      $php_timestamp = (int)$php_timestamp;
      if( $mili_on == true ){
          return date("d M y | H:i:s:",$php_timestamp).($milis);
      }else if( $simple == false ){
          return date("d M y | H:i:s",$php_timestamp);
      }else{
          return date("d M y | H:i",$php_timestamp);
      }
    }