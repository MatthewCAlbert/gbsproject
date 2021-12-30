<?php
    //Count Users
    $sql = "SELECT * FROM `help`";
    $res = $conn->query($sql);
    $total_support = mysqli_num_rows($res);

    $replied_count = 0;
    $unread_count = 0;
    $solved_count = 0;

    if( $total_support > 0 ){
        while($row=mysqli_fetch_array($res)){
            switch($row['status']){
                case 'replied': $replied_count++;break;
                case 'unread': $unread_count++;break;
                case 'solved': $solved_count++;break;
            }
        }
    }