<?php
    /* 
        1//    Retrieve User Data
        2//    Retrieve Admin Data
        3//    Top Up
        4//    Transaction 
    */
    function apiValidation($username,$api_key,$asked_access=0,$access_type){
        global $conn;
        $result = false;
        $sql = "SELECT * FROM `api` WHERE `username`='$username'";
        $res = $conn->query($sql);
        if($res){
            if($res->num_rows>0){
                $row = mysqli_fetch_assoc($res);
                if($row['status']=='active'){
                    //if( password_verify($api_key,$row['api_key']) ) //for encrypted ready api key
                    if($api_key == $row['api_key']){
                        $result = true;
                    }
                }
                if($row['type']!=$access_type){
                    $result = false;
                }
                $access = explode(",",$row['access']);
                if( !in_array((string)$asked_access,$access) ){
                    $result = false;
                }
            }
        }
        return $result;
    }