<?php
    require_once(dirname(__FILE__) . '/server.php');
    if( isset($_GET['order_id']) && isset($_GET['transaction_status']) ){
        $order_id = mysqli_escape_string($conn,$_POST['order_id']);
        $status = mysqli_escape_string($conn,$_POST['transaction_status']);
        $sql = $sql="DELETE FROM `veritrans` WHERE `id`='$order_id' AND `status`='unspecified'";
        $res = $conn->query($sql);
        if( $res ){
            header("Location: http://gbsproject.ga/userarea/topup?success");
        }else{
            header("Location: http://gbsproject.ga/userarea/topup?error");
        }
    }else{
        header("Location: http://gbsproject.ga/userarea");
    }