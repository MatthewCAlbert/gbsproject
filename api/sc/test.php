<?php
    require_once(dirname(__FILE__) . '/server.php');
//$url = 'http://192.168.100.14:8080/gbs-api/sc/status_test.php';
$url = "http://api.gbsproject.ga/sc/tracker.php";
$data = array('order_id' => "SANDBOX-G564672569-548",'id'=>"161616",'value'=>"1000");
/*
$options = array(
    'http' => array(
        'method'  => 'GET',
        'header'  => "Content-type: application/json",
        'content' => http_build_query($data),
        'timeout' => 60
    ),
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

print_r($result);
echo '<br>';
//$response = array();
$response = json_decode($result);
print_r($response);
echo $response->success;
*/
      
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch,CURLOPT_POST, count($data));
curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$head = curl_exec($ch); 
curl_close($ch); 
$json = array();
$json = json_decode($head);
print_r($json);
echo $json->success;


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