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
            $sql = "SELECT * FROM `$who` WHERE `id`='$id'";
            $res = $conn->query($sql);
            if($res){
                if( $res->num_rows > 0 ){
                    http_response_code(200);
                    $row = mysqli_fetch_assoc($res);
                    $list = array("id"=>$row['id'],"name"=>$row['name'],"status"=>$row['status'],"balance"=>$row['balance'],"email"=>$row['email'],"phone"=>$row['phone']);
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