<?php
session_start();
if(isset($_SESSION['export'])){
    $export = $_SESSION['export'];
    $filename = $_SESSION['filename'];
    header("Content-Type:application/csv"); 
    header("Content-Disposition:attachment;filename=$filename"); 
    $output = fopen("php://output","w");
    $header = array_keys($export[0]);
    fputcsv($output, array('Name','Password')); //set header
    foreach($export as $row){
        fputcsv($output, $row);
    }
    fclose($output);
    $_SESSION['export'] = null;
    exit();
}else{
    header("Location: ..");
    exit();
}