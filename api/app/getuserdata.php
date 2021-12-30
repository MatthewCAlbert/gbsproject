<?php
    require 'key.php';
    $res = array();
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

            $id = $obj['id'];
            $status = $obj['status'];

            $sql="SELECT * FROM `$status` WHERE `id`='$id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    $data = array();
                    $data = $row;
                    $data = json_encode($data);
                    sendMessage($data,TRUE);
                }
            }

        }else{
            sendMessage('Unauthorized Access - False Identification',FALSE);
        }
    }else{
        sendMessage('Unauthorized Access 403',FALSE);
    }