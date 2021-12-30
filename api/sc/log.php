<?php
    if(isset($_POST['data'])&&isset($_POST['key'])){
        if( $_POST['key']="wRK8Gf[G2scj?:Gnnz+cz#" ){
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Ymd-H-i-s');
            $dir = "logs/veritrans-bot-logs-".$date.".txt";
            
            $final_out = $_POST['data'];
            $myfile = fopen($dir, "w");
            echo fwrite($myfile,$final_out);
        
            fclose($myfile);
        }
    }else{
        exit();
    }