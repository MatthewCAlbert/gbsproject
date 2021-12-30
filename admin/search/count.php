<?php
    //Count Users
    $sql = "SELECT `id` FROM `student`";
    $res = $conn->query($sql);
    $student_count = mysqli_num_rows($res);

    $sql = "SELECT `id` FROM `teacher`";
    $res = $conn->query($sql);
    $teacher_count = mysqli_num_rows($res);
    
    $sql = "SELECT `id` FROM `vendor`";
    $res = $conn->query($sql);
    $vendor_count = mysqli_num_rows($res);

    $total_user = $student_count + $teacher_count + $vendor_count;

    //Session Count
    $sql = "SELECT `type`,`value` FROM `transaction`";
    $res = $conn->query($sql);
    $total_transaction = mysqli_num_rows($res);
    $top_up_count = 0;
    $withdraw_count = 0;
    $pay_count = 0;
    $transfer_count = 0;
    
    if( $total_transaction > 0 ){
        while( $row = mysqli_fetch_array($res) ){
            switch($row['type']){
                case 'Top Up': $top_up_count++;break;
                case 'Withdraw': $withdraw_count++;break;
                case 'Pay': $pay_count++;break;
                case 'Transfer': $transfer_count++;break;
            }
        }
    }