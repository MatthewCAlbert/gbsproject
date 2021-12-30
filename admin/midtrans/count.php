<?php
    $api_password = "K&7pfg4UD6-&NKunG3=zgte&+=YL7FfR";
    $total_api_hit = 0;
    $total_api_value = 0;
    $unpaid_transaction = 0;
    $unpaid_value = 0;
    $paid_transaction = 0;
    $paid_value = 0;
    $success_transaction = 0;
    $success_value = 0;
    $failed_transaction = 0;
    $unknown_transaction = 0;
    $error_transaction = 0;
    $marked_transaction = 0;
    //count total
    $sql = "SELECT `id` FROM `veritrans`";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $total_api_hit = $resss->num_rows;
        }
    }
    //count finished
    $sql = "SELECT `value` FROM `veritrans` WHERE `status`='finished'";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $success_transaction = $resss->num_rows;
            while( $t_row = mysqli_fetch_array($resss) ){
                $success_value+= $t_row['value']; 
            }
        }
    }
    //count pending
    $sql = "SELECT `value` FROM `veritrans` WHERE `status`='pending'";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $unpaid_transaction = $resss->num_rows;
            while( $t_row = mysqli_fetch_array($resss) ){
                $unpaid_value+= $t_row['value']; 
            }
        }
    }
    //count settled payment but not processed yet
    $sql = "SELECT `value` FROM `veritrans` WHERE `status`='settlement'";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $paid_transaction = $resss->num_rows;
            while( $t_row = mysqli_fetch_array($resss) ){
                $paid_value+= $t_row['value']; 
            }
        }
    }
    //count failed
    $sql = "SELECT `id` FROM `veritrans` WHERE `status`='expire' OR `status`='deny'";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $failed_transaction = $resss->num_rows;
        }
    }
    //count unspecified
    $sql = "SELECT `id` FROM `veritrans` WHERE `status`='unspecified'";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $unknown_transaction = $resss->num_rows;
        }
    }
    //count error
    $sql = "SELECT `id` FROM `veritrans` WHERE `status`='error'";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $error_transaction = $resss->num_rows;
        }
    }
    //count marked
    $sql = "SELECT `id` FROM `veritrans` WHERE `status`='marked'";
    $resss = $conn->query($sql);
    if( $resss ){
        if ( $resss->num_rows > 0 ){
            $marked_transaction = $resss->num_rows;
        }
    }

    $total_api_value = $paid_value+$unpaid_value+$success_value;