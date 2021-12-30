<?php
if(isset($_SESSION["useradmin_id"])){
    $uid = $_SESSION["useradmin_id"];
    $sql = "SELECT * FROM `admin` WHERE `username`='$uid'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        header('Location: '.$main_directory.'/login');
        exit();
    }
    $user_row = mysqli_fetch_assoc($result);
    if( $user_row['status'] != 'active' ){
        header('Location: '.$main_directory.'/login/index.php?banned');
        exit();
    }
}else{
    exit();
}