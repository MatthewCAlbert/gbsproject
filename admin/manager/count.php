<?php
    //Admin Count
    $sql = "SELECT `level` FROM `admin`";
    $res = $conn->query($sql);
    $total_admin = mysqli_num_rows($res);
    $level_count = array();
    $level_count[1] = 0;
    $level_count[2] = 0;
    $level_count[3] = 0;
    $level_count[4] = 0;
    $level_count[5] = 0;
    
    if( $total_admin > 0 ){
        while( $row = mysqli_fetch_array($res) ){
            $level_count[$row['level']]++;
        }
    }
    
    $sql = "SELECT `type` FROM `api`";
    $res1 = $conn->query($sql);
    $type_count = array();
    $type_count['device']=0;
    $type_count['app']=0;
    $type_count['web']=0;
    $type_count['unidentified']=0;
    if( $res1 ){
        $api_count = $res1->num_rows; 
        if( $api_count > 0 ){
            while( $row = mysqli_fetch_array($res1) ){
                $type_count[$row['type']]++;
            }
        }
    }