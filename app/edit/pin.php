<?php
    require '../include/config.php'; 
    require '../include/server.php';
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 
    if( $user_row['pin'] == "" ){
        header('Location: ../account');
        exit();
    }
    $_SESSION['change_pin_verify'] = false;
    $_SESSION['change_pin_steps'] = 0;
    $_SESSION['new_pin'] = "";
    $_SESSION['re_pin'] = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Change PIN<?php echo $main_title; ?></title>
    <style>
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/pin.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    var current_steps = 0;
    function changeSteps(x){
        current_steps = x;
    } 
    $(document).ready(function(){
        disableEnter();
        changePinHeader("Enter Your Old PIN");
    });
    cancelPin = ()=>{
        href('../account');
    }
    pinCallback = ()=>{
        pinCallbackState(true);
        loader_display(true);
        switch(current_steps){
            case 0 : 
            $.ajax({
                url: '../include/backend/verify_pin.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    pin: getPinValue(),
                },
                success: function(res){
                    let response = JSON.parse(res);
                    if( response[0] == true ){
                        setPinInfo("",false);
                        changeSteps(response[1]);
                        changePinHeader("Enter Your New PIN",false);
                    }else{
                        setPinInfo("PIN Mismatch",true);
                    }
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                },
                error: function(res){
                    setPinInfo("Error",true);
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                }
            });
            break;
            case 1 : 
            $.ajax({
                url: '../include/backend/add_pin.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    new_pin: getPinValue(),
                },
                success: function(res){
                    let response = JSON.parse(res);
                    if( response[0] == true ){
                        setPinInfo("",false);
                        changeSteps(response[1]);
                        changePinHeader("Re-Enter Your New PIN",false);
                    }
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                },
                error: function(res){
                    setPinInfo("Error",true);
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                }
            });
            break;
            case 2 : 
            $.ajax({
                url: '../include/backend/add_pin.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    re_pin: getPinValue(),
                },
                success: function(res){
                    let response = JSON.parse(res);
                    if( response[0] == true ){
                        changeSteps(response[1]);
                        href('change_pin.php');
                        loader_display(false);
                    }else{
                        changeSteps(res[1]);
                        changePinHeader("Enter Your New PIN",false);
                        setPinInfo("New PIN Mismatch",true);
                        resetPinValue();
                        pinCallbackState(false);
                        setTimeout(() => {
                            href('pin.php');
                        }, 1000);
                    }
                },
                error: function(res){
                    setPinInfo("Error",true);
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                }
            });
            break;
        }
    }
</script>
</html>