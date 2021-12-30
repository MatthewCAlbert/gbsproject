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

            $sql="SELECT * FROM `transaction` WHERE `sender`='$id' OR `receiver`='$id'";
            $result = $conn->query($sql);
            if($result){
                if($result->num_rows > 0){
                    $data = array();
                    $i = 0;
                    while($row = mysqli_fetch_array($result)){
                        $data[$i] = array();
                        $data[$i] = $row;
                        $i++;
                    }
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