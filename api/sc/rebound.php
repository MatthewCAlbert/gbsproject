<?php
    require_once(dirname(__FILE__) . '/server.php');
    if( isset($_GET['order_id']) && isset($_GET['transaction_status']) ){
        $order_id = mysqli_escape_string($conn,$_GET['order_id']);
        $status = mysqli_escape_string($conn,$_GET['transaction_status']);
        if( $status != "pending" ){
            $status = "pending";
        }
        $sql = $sql="UPDATE `veritrans` SET `status`='$status' WHERE `id`='$order_id' AND `status`='unspecified'";
        $res = $conn->query($sql);
        if( $res ){
            header("Location: http://gbsproject.ga/userarea/topup?success");
        }else{
            header("Location: http://gbsproject.ga/userarea/topup?error");
        }
    }else{
        header("Location: http://gbsproject.ga/userarea");
    }