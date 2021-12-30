<?php
$response = array();

header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");

require '../../server.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$str_cut = 10;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if( isset($_POST['key']) && isset($_POST['id']) && isset($_POST['number']) && isset($_POST['status']) ){
    $key = mysqli_real_escape_string($conn,$_POST['key']);
    $id = mysqli_real_escape_string($conn,$_POST['id']);
    $num = mysqli_real_escape_string($conn,$_POST['number']);
    $who = mysqli_real_escape_string($conn,$_POST['status']);
    $list = array();
    if( $key == "0000" ){
        $sql = "SELECT * FROM `transaction` WHERE `sender`='$id' OR `receiver`='$id' ORDER BY `id` DESC LIMIT $num";
        $res = $conn->query($sql);
        if($res){
            if( $res->num_rows > 0 ){
                while( $row = mysqli_fetch_array($res) ){
                    if( $row['sender'] == $id ){
                        $as = "sender";
                    }else{
                        $as = "receiver";
                    }
                    if( $row['type'] == "Top Up" ){
                        array_push($list,array("id"=>$row['id'],"name"=>substr($row['receiver'],0,$str_cut),"date"=>$row['time'],"value"=>$row['value'],"desc"=>$row['description'],"status"=>$row['status'],"type"=>$row['type'],"aswhat"=>$as));
                    }
                    else if( $row['type'] == "Withdraw" ){
                        array_push($list,array("id"=>$row['id'],"name"=>substr($row['sender'],0,$str_cut),"date"=>$row['time'],"value"=>$row['value'],"desc"=>$row['description'],"status"=>$row['status'],"type"=>$row['type'],"aswhat"=>$as));
                    }
                    else if( $row['type'] == "Pay" || $row['type'] == "Transfer" ){
                        if( $row['receiver'] == $id ){
                            $recipient = $row['sender'];
                        }else{
                            $recipient = $row['receiver'];
                        }
                        $who = checkWho($recipient);
                        if($who != null){
                            $sql2 = "SELECT `name` FROM `$who` WHERE `id`='$recipient'";
                            $res2 = $conn->query($sql2);
                            if($res2){
                                if( $res2->num_rows > 0 ){
                                    $row2 = mysqli_fetch_assoc($res2);
                                    $final_name = $row2['name'].' ('.$recipient.')';
                                    array_push($list,array("id"=>$row['id'],"name"=>$final_name,"date"=>$row['time'],"value"=>$row['value'],"desc"=>$row['description'],"status"=>$row['status'],"type"=>$row['type'],"aswhat"=>$as));
                                }
                            }
                        }
                    }
                }
            }
            sendMessage($list,true);
        }else{
            sendMessage("error",false);
        }

    }else{
        sendMessage("unauthorized",false);
    }
}else{
    sendMessage("error",false);
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