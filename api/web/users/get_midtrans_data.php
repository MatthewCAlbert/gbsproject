<?php
$response = array();

header("Access-Control-Allow-Origin: *");

require '../../server.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if( isset($_POST['key']) && isset($_POST['id']) ){
    $key = mysqli_real_escape_string($conn,$_POST['key']);
    $id = mysqli_real_escape_string($conn,$_POST['id']);
    if( $key == "0000" ){
        $sql = "SELECT * FROM `veritrans` WHERE `id`='$id'";
        $res = $conn->query($sql);
        if($res){
            if( $res->num_rows > 0 ){
                http_response_code(200);
                $row = mysqli_fetch_assoc($res);
                $sender_id = $row['user_id'];
                $sender_status = checkWho($sender_id);
                $sender_name = "";
                $sql =  "SELECT `name` FROM `$sender_status` WHERE `id`='$sender_id'";
                $res2 = $conn->query($sql);
                if( $res2 ){
                    if( $res2->num_rows > 0 ){
                        $row2 = mysqli_fetch_assoc($res2);
                        $sender_name = $row2['name'];
                    }
                }
                $value = number_format($row['value'],0,",",".");
                $time = $row['id'];
                $time = preg_replace("/[\-\D]+/","",$time);
                //$time = date("d F Y | H:i",(int)$time);
                $time = jsTimeToDate($time);
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
                $status = '<span style="color:'.$r_status.';">'.ucfirst($row['status']).'</span>';
                $list = array("id"=>$row['id'],"type"=>$row['type'],"status"=>$status,"value"=>$value,"user_id"=>$row['user_id'],"name"=>$sender_name,"message"=>$r_message,"time"=>$time);
                sendMessage($list,true);
            }else{
                http_response_code(404);
                exit();
            }
        }else{
            http_response_code(500);
            exit();
        }
    }else{
        http_response_code(403);
        exit();
    }
}else{
    http_response_code(406);
    exit();
}

function sendMessage($message,$status){
    global $response;
    $response["success"] = $status;
    $response["message"] = $message;
    $response = json_encode($response);
    exit($response);
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
    return null;
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