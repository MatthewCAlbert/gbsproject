<?php
    require 'key.php';
    $res = array();
    $res["info"] = '';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        if($obj['secret']===$secret_key){

            $id = $obj['username'];
            $pwd = $obj['password'];
            
            $status = null; $resultCheck = null; $login_method = 'id';
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
        
            // Check connection
            if ($conn->connect_error) {
                sendMessage('Database is appear to be on maintenance or broken.',FALSE);
            } 

            checkWho('student');
            checkWho('teacher');
            checkWho('vendor');
            
            if($status == null){
                //no user found
                sendMessage('Wrong ID or Password!',FALSE);
            }else{
                //user found
                $sql = "SELECT * FROM `$status` WHERE `$login_method`='$id'";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
                if( $resultCheck > 0){
                    $row = mysqli_fetch_assoc($result);
                    //De-hashing password
                    $hashedPwdCheck = password_verify($pwd, $row['password']);
                    if( $hashedPwdCheck == false ){
                        //wrong pass
                        sendMessage('Wrong ID or Password!',FALSE);
                    }elseif( $hashedPwdCheck == true ){
                        //success logging in
                        $res["success"] = TRUE;
                        $res["message"] = 'Success! Welcome '.$row['name'];
                        $res["user"] = $row['name'];
                        $res["id"] =  $row['id'];
                        $res["who"] = $status; 
                        $res = json_encode($res);
                        exit($res);
                    }else{
                        //no idea error
                        sendMessage('Oops Something Went Wrong! Please contact admin.',FALSE);
                    }
                }
            }
        }else{
            sendMessage('Unauthorized Access - False Identification',FALSE);
        }
    }else{
        sendMessage('Unauthorized Access 403',FALSE);
    }

    
function checkWho($who){
    global $conn, $status, $resultCheck, $id;
    $sql = "SELECT * FROM `$who` WHERE `id`='$id'";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){   
        $status = $who;
    }
}