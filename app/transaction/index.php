<?php
    require '../include/config.php'; 
    require '../include/server.php';
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php';
    if(isset($_GET['id'])){
        $transaction_id = mysqli_real_escape_string($conn,$_GET['id']);
        $sql = "SELECT * FROM `transaction` WHERE `id`='$transaction_id'";
        $res = $conn->query($sql);
        if($res){
            if($res->num_rows>0){
                $row = mysqli_fetch_assoc($res);
                $status = ucfirst($row['status']);
                $sender = ""; $receiver = "";
                switch($status){
                    case 'Success': $status='<span class="text-success">'.$status.'</span>';break;
                    case 'Failed': $status='<span class="text-danger">'.$status.'</span>';break;
                    case 'Error': $status='<span class="text-warning">'.$status.'</span>';break;
                }
                if( $row['type'] == 'Top Up' ){
                    $who = checkWho($row['sender']);
                    $id = $row['sender'];
                    $sql = "SELECT `name` FROM `$who` WHERE `id`='$id'";
                    $res2 = $conn->query($sql);
                    if( $res2 ){
                        if( $res2->num_rows > 0 ){
                            $row2 = mysqli_fetch_assoc($res2);
                            $sender = $row2['name'];
                        }
                    }
                    $sender = $sender.' ('.$row['sender'].')';
                    $receiver = $row['receiver'];
                }else if( $row['type'] == 'Withdraw' ){
                    $who = checkWho($row['receiver']);
                    $id = $row['receiver'];
                    $sql = "SELECT `name` FROM `$who` WHERE `id`='$id'";
                    $res2 = $conn->query($sql);
                    if( $res2 ){
                        if( $res2->num_rows > 0 ){
                            $row2 = mysqli_fetch_assoc($res2);
                            $receiver = $row2['name'];
                        }
                    }
                    $receiver = $receiver.' ('.$row['receiver'].')';
                    $sender = $row['sender'];
                }else if( $row['type'] == 'Transfer' || $row['type'] == 'Pay' ){
                    $who = checkWho($row['sender']);
                    $id = $row['sender'];
                    $sql = "SELECT `name` FROM `$who` WHERE `id`='$id'";
                    $res2 = $conn->query($sql);
                    if( $res2 ){
                        if( $res2->num_rows > 0 ){
                            $row2 = mysqli_fetch_assoc($res2);
                            $sender = $row2['name'];
                        }
                    }
                    $sender = $sender.' ('.$row['sender'].')';
                    $who = checkWho($row['receiver']);
                    $id = $row['receiver'];
                    $sql = "SELECT `name` FROM `$who` WHERE `id`='$id'";
                    $res2 = $conn->query($sql);
                    if( $res2 ){
                        if( $res2->num_rows > 0 ){
                            $row2 = mysqli_fetch_assoc($res2);
                            $receiver = $row2['name'];
                        }
                    }
                    $receiver = $receiver.' ('.$row['receiver'].')';
                }
            }else{
            http_response_code(404);
            exit();
            }
        }else{
        http_response_code(500);
        exit();
        }
    }else{
        header('Location: ../home');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Transaction #<?php echo $transaction_id.$main_title; ?></title>
    <style>
    body{
        background-color: #006db3;
    }
    .section{
        color:white;
    }
    .text-success{
        color: #8bc34a !important;
    }
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <div class="section" style="padding:10% 10%; 5% 10%">
            <h5><?php echo date("d F Y H:i",strtotime($row['time'])); ?></h5>
            <h3>Transaction ID <b>#<?php echo $transaction_id; ?></b></h3>
            <h5><?php echo $row['type'].' - '.$status; ?></h5>
            <div class="hr hr-invert" style="margin:20px 0;"></div>
            <h5>Sender : <b><?php echo $sender; ?></b></h5>
            <h5>Recipient : <b><?php echo $receiver; ?></b></h5>
            <h5>Amount : <b>Rp <?php echo number_format($row['value'],0,",","."); ?></b></h5>
            <h5>Description : <?php echo $row['description']; ?></h5>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
</script>
</html>