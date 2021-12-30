<?php
error_reporting(0);
$response = array();
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");

if( isset($_POST['key']) && isset($_POST['param']) ){
    if( $_POST['key']=="kT2K78fKXsSA6BPh" ){
        $dir_list = scandir("logs");
        $fixed_dir = array();
        $need_deletion = array();
    
        //sanitize
        for( $i=0;$i<count($dir_list);$i++ ){
            if( preg_match("/(\w+\.txt)/",$dir_list[$i]) ){
                $dir_list[$i] = preg_replace("/(\.txt)/","",$dir_list[$i]);
            }else{
                array_push($need_deletion,$i);
            }
        }
        foreach( $need_deletion as $delete ){
            unset($dir_list[$delete]);
        }
        foreach( $dir_list as $new_dir ){
            array_push($fixed_dir,$new_dir);
        }

        $final_link = array();
        $new_index = array();
        if( $_POST['param']=="search" ){
            foreach($fixed_dir as $per_dir){
                $index = preg_replace("/(veritrans\-bot\-logs\-)/","",$per_dir);
                $index = preg_replace("/(\-\d\d\-\d\d\-\d\d)/","",$index);
                if( !in_array($index,$new_index) ){
                    $final_link[$index] = array();
                    array_push($new_index,$index);
                }
            }
            foreach($new_index as $per_dir_f){
                foreach($fixed_dir as $per_dir){
                    if( preg_match("/($per_dir_f)/",$per_dir) ){
                        array_push($final_link[$per_dir_f],$per_dir);
                    }
                }
            }

        }else{
            $final_link = $fixed_dir;
        }
    
        sendMessage($final_link,true);
    }else{
        sendMessage("denied",false);
    }
}else{
    sendMessage("error",false);
}

function sendMessage($message,$status){
    global $response;
    $response["success"] = $status;
    $response["message"] = $message;
    $response = json_encode($response);
    exit($response);
}
?>