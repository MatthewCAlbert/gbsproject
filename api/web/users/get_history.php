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
        
        $sql = "SELECT * FROM `transaction` WHERE `receiver`='$id' OR `sender`='$id' ORDER BY `id` DESC LIMIT $start,$limit";
        $res = $conn->query($sql);
        if( $res->num_rows > 0 ){
            $response = "";

            while($row = mysqli_fetch_array($res)){
                if( $row['sender'] == $id ){
                    $as = "sender";
                }else{
                    $as = "receiver";
                }
                if( $row['type'] == "Top Up" ){
                    $name = $row['receiver'];
                }
                else if( $row['type'] == "Withdraw" ){
                    $name = $row['sender'];
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
                                $name = $row2['name'].' ('.$recipient.')';
                            }
                        }
                    }
                }
                $value = number_format($row['value'],0,",",".");
                if( $row['status'] == "success" ){
                    switch($row['type']){
                        case "Withdraw": $plusmin = '<span class="text-danger">- Rp '.$value.'</span>';break;
                        case "Top Up": $plusmin = '<span class="text-success">+ Rp '.$value.'</span>';break;
                        default: if( $as == "sender" ){
                            $plusmin = '<span class="text-danger">- Rp '.$value.'</span>';
                        }else{
                            $plusmin = '<span class="text-success">+ Rp '.$value.'</span>';
                        } break;
                    }
                }else{
                    $plusmin = '<span class="text-secondary"> Rp '.$value.'</span>';
                }
                $status = "";
                switch($row['status']){
                    case 'success': $status='<span class="text-success">'.ucfirst($row['status']).'</span>';break;
                    case 'failed': $status='<span class="text-danger">'.ucfirst($row['status']).'</span>';break;
                    case 'error': $status='<span class="text-warning">'.ucfirst($row['status']).'</span>';break;
                }
                $response .= '
                <div class="scroll-list row" onclick="href('."'../transaction?id=".$row['id']."'".')">
                <div class="col-6">
                    <p>'.ucfirst($name).'</p>
                    <p style="font-size:0.85em;opacity:.6;">'.$row['type'].' - '.$status.'</p>
                </div>
                <div class="col-6">
                    <p>'.$plusmin.'</p>
                    <p style="font-size:0.8em;font-family:'."'Open Sans'".';opacity:.6;">'.date("d M y | H:i",strtotime($row['time'])).' WIB</p>
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