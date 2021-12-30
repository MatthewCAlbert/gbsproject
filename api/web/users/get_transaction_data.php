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
        $who = checkWho($id);
        if( $who != null ){
            $sql = "SELECT * FROM `transaction` WHERE `id`='$id'";
            $res = $conn->query($sql);
            if($res){
                if( $res->num_rows > 0 ){
                    http_response_code(200);
                    $row = mysqli_fetch_assoc($res);
                    $sender_id = $row['sender'];
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
                    $receiver_id = $row['receiver'];
                    $receiver_name = "";
                    $receiver_status = checkWho($receiver_id);
                    $sql =  "SELECT `name` FROM `$receiver_status` WHERE `id`='$receiver_id'";
                    $res2 = $conn->query($sql);
                    if( $res2 ){
                        if( $res2->num_rows > 0 ){
                            $row2 = mysqli_fetch_assoc($res2);
                            $sender_name = $row2['name'];
                        }
                    }
                    $list = array("id"=>$row['id'],"type"=>$row['type'],"time"=>$row['time'],"status"=>$row['status'],"description"=>$row['description'],"machine_id"=>$row['machine_id'],"sender_id"=>$row['sender'],"receiver"=>$row['receiver'],"sender_name"=>$sender_name,"receiver_name"=>$receiver_name,"value"=>$row['value']);
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
            http_response_code(404);
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