<?php
    require '../include/config.php'; 
    require '../include/server.php';
    if(isset($_SESSION['user_id'])){
       if($_SESSION['pin_verified']==true){
        header("Location: ../home?login=pin-ok");
        exit();
       }
    }else if(isset($_COOKIE['member_login'])){
        require '../include/backend/cookie_detector.php';
    }else{
       header("Location: ../login");
       exit();
    }
    require '../include/backend/getuserdata.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Enter PIN<?php echo $main_title; ?></title>
    <style>
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/pin.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    $(document).ready(function(){
        disableEnter();
    });
    cancelPin = ()=>{
        href('../include/backend/logout.php');
    }
    pinCallback = ()=>{
        pinCallbackState(true);
        loader_display(true);
        $.ajax({
            url: "../include/backend/verify_main_pin.php",
            method: "POST",
            dataType: "text",
            data: {
                pin: getPinValue()
            },
            success: function(response) {
                if (response == true){
                    href('../home');
                }else{  
                    setPinInfo("PIN Mismatch", true);
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                }
            },
            error: function(response) {
                setPinInfo("Error", true);
                resetPinValue();
                pinCallbackState(false);
                loader_display(false);
            }
        });
    }
</script>
</html>